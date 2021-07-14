<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Image;
use App\Models\Maquina;
use App\Models\Container;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Traits\PostgresContainer;
use App\Http\Requests\Container\StoreContainer;
use App\Models\Volume;

class ContainersController extends Controller
{
    use PostgresContainer;

    public function playStop($container_id)
    {
        $instancia = Container::where('docker_id', $container_id)->first();
        $url = env('DOCKER_HOST');

        if ($instancia->dataHora_finalizado) {
            $host = "$url/containers/$container_id/start";
            $dataHora_fim = null;
        } else {
            $host = "$url/containers/$container_id/stop";
            $dataHora_fim = now();
        }

        try {
            $response = Http::post($host);

            $instancia->dataHora_finalizado = $dataHora_fim;
            $instancia->save();
            
            $message = isset($dataHora_fim) ? 'Container has be stoped!' : 'Container has be started!';

            if($response->getStatusCode() == 204 || $response->getStatusCode() == 304){
                return back()->with('success', $message);
            } else {
                return back()->with('error', $response->json()['message']);
            }
        } catch (Exception $e) {
            return back()->with('error', "Fail to stop the container! $e");
        }
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        if(!isset($user)){ return redirect()->route('login'); }
        
        $containers = Container::where('user_id', Auth::user()->id)->paginate(10);
        $this->checkActiveStatus($containers);

        $params = [
            'mycontainers' => $containers,
            'containerIp' => $this->getIp($containers, $request->getHost()),
            'dockerHost' => env('DOCKER_HOST'),
            'dockerHostWs' => env('DOCKER_HOST_WS'),
            'title' => 'My Containers',
            'images' => Image::all(),
            'container_template' => json_decode(DB::table('default_templates')->where('name', 'container')->first()->template, true),
            'volumes' => Volume::where('user_id', $user->id)->get(),
        ];

        return view('pages/containers/index', $params);
    }

    private function getIp($containers, string $host)
    {
        $array = [];
        $url = env('DOCKER_HOST');

        foreach($containers as $container) {
            $info = Http::get("$url/containers/{$container->docker_id}/json");
            if($info->getStatusCode() == 200) {
                $infoArray = $info->json();
                $portKey = array_keys($infoArray['NetworkSettings']['Ports'])[0];
                $port = $infoArray['NetworkSettings']['Ports'][$portKey][0]['HostPort'];
                $array[$container->docker_id] = [$infoArray['NetworkSettings']['IPAddress'], "$host:$port"];
            }
        }

        return $array;
    }

    private function checkActiveStatus($containers)
    {
        $url = env('DOCKER_HOST');

        foreach($containers as $container){
            $details = Http::get("$url/containers/$container->docker_id/json");

            $container->dataHora_finalizado = $details->getStatusCode() == 200 && $details->json()['State']['Running'] ? null : now();
            $container->save();
        }
    }

    public function terminal($id)
    {
        $container = Container::firstWhere('docker_id', $id);
        
        $params = [
            'mycontainer' => $container,
            'dockerHost' => env('DOCKER_HOST_WS'),
            'containerId' => $id,
        ];

        return view('pages/containers/terminal', $params);
    }

    public function show($id)
    {
        $url = env('DOCKER_HOST');
        $processes = Http::get("$url/containers/$id/top");
        $details = Http::get("$url/containers/$id/json");

        $params = [
            'mycontainer' => Container::firstWhere('docker_id', $id),
            'processes' => ($processes->getStatusCode() == 200 ? $processes->json() : []),
            'details' => $details->getStatusCode() == 200 ? $details->json() : [],
        ];

        return view('pages/containers/show', $params);
    }

    public function configureContainer(Request $request)
    {
        $image = Image::find($request->image_id);
        $user = Auth::user();

        $params = [
            'requiredImage' => $image,
            'images' => Image::all(),
            'user' => Auth::user()->name,
            'user_id' => Auth::user()->id,
            'container_template' => $image->imageTemplate->template,
            'volumes' => Volume::where('user_id', $user->id)->get(),
        ];

        return view('pages/containers/config', $params);
    }

    public function store(StoreContainer $request)
    {
        try{
            $url = env('DOCKER_HOST');
            $user = Auth::user();
            
            return \App\Http\Controllers\Traits\DockerContainer::create($request, $user, $url);
        } catch(Exception $e){
            return redirect()->route('containers.index')->with('error', $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        return view('pages/containers/edit', ['container' => Container::firstWhere('docker_id', $id)]);
    }

    public function update(Request $request, $id)
    {
        if ($request->nickname) {
            $instancia = Container::firstWhere('docker_id', $id);
            $instancia->update($request->all());

            return redirect()->route('containers.index')->with('success', 'Container updated!!!');
        } else {
            return redirect()->route('containers.index')->with('error', "Nickname can't be blank!!!");
        }
    }

    public function deleteContainer(Request $request,$docker_id)
    {
        $url = env('DOCKER_HOST');

        $responseDelete = Http::delete("$url/containers/$docker_id?force=1");
        $container = Container::firstWhere('docker_id', $docker_id);
        $vol_name = $container->volume_name;

        if($responseDelete->getStatusCode() == 204 || $responseDelete->getStatusCode() == 404) {
            isset($container) ? $container->delete() : '';
        } else {
            return back()->with('error', $responseDelete->json()['message']);
        }

        if(isset($request->delete_volume)){

            $delete_vol = Http::delete("$url/volumes/$vol_name");

            if($delete_vol->getStatusCode() == 204){
                $volume = Volume::firstWhere('name', $vol_name);
                isset($volume) ? $volume->delete() : '';
            } else {
                return back()->with('error', $delete_vol->json()['message']);
            }
        }

        return back()->with('success', 'Container deleted with sucess!');
    }

    public function destroy($id)
    {
        $url = env('DOCKER_HOST');
        $responseDelete = Http::delete("$url/containers/$id?force=1");
        if($responseDelete->getStatusCode() == 204 || $responseDelete->getStatusCode() == 404) {
            $instancia = Container::firstWhere('docker_id', $id);
            isset($instancia) ? $instancia->delete() : '';

            return back()->with('success', 'Container deleted with sucess!');
        } else {
            return back()->with('error', $responseDelete->json()['message']);
        }
    }

    public function loading($id)
    {
        $params = [
            'dockerHost' => env('DOCKER_HOST_WS'),
            'containerId' => $id,
        ];

        return view('pages.containers.loading', $params);
    }
}
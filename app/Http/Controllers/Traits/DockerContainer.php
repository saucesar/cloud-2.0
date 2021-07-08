<?php

namespace App\Http\Controllers\Traits;

use App\Models\Container;
use App\Models\Image;
use App\Models\Maquina;
use App\Models\User;
use App\Models\Volume;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

trait DockerContainer {

    public static function create(Request $request, User $user, string $dockerUrl)
    {
        $data = $request->all();

        DockerContainer::pullImage($dockerUrl, Image::find($data['image_id']));

        $data = DockerContainer::setDefaultDockerParams($request);

        $data['gitrep'] = $request->gitrep;
        $data['database'] = $request->database;
        $volume_name = $data['nickname'].'-volume';
        $volumeExists = Volume::where('name', $volume_name)->where('user_id', $user->id)->exists();

        if($request->volume == 'new' && !$volumeExists){
            $create_volume = DockerVolume::create($user, $dockerUrl, $volume_name, $data['nickname']);
            $data['volume_name'] = $volume_name;
            
            if($create_volume->getStatusCode() == 201){
                $user->volumes()->create(['user_id' => $user->id, 'name' => $volume_name]);
            } else {
                return back()->withInput()->with('error', $create_volume->json()['message']);
            }
        } else {
            $data['volume_name'] = $request->volume;
        }

        return DockerContainer::createContainer($dockerUrl, $data, $request);
    }

    public static function setDefaultDockerParams($request)
    {
        $template = json_decode(DB::table('default_templates')->where('name', 'container')->first()->template, true);
        //$template = \App\Models\Image::find($request->image_id)->imageTemplate->template;
        
        $template['nickname'] = $request->nickname;
        $template['Hostname'] = $request->nickname;
        $template['image_id'] = $request->image_id;
        $template['Image'] = Image::find($request->image_id)->fromImage;
        $template['user_id'] = Auth::user()->id;

        $template['HostConfig']['Memory'] = Auth::user()->category->ram_limit * 1024 * 1024;//Converte de MB para bytes

        $template['Domainname'] = str_replace(' ', '', $request->Domainname);
        $template['Labels'] =  ArrayTrait::extractLabels($request);
        $template['Dns'] = [$request->dns];
        $template['DnsOptions'] = ArrayTrait::removeNull($request->dnsOptions);
        $template['IPAddress'] = $request->IPAddress;
        $template['IPPrefixLen'] = intval($request->IPPrefixLen);
        $template['Env'] = ArrayTrait::getEnvVariables($request->EnvKeys, $request->EnvValues);
        $template['AttachStdin'] = isset($request->AttachStdin);
        $template['AttachStdout'] = isset($request->AttachStdout);
        $template['AttachStderr'] = isset($request->AttachStderr);
        $template['OpenStdin'] = isset($request->OpenStdin);
        $template['StdinOnce'] = isset($request->StdinOnce);
        $template['Tty'] = isset($request->Tty);
        $template['HostConfig']['PublishAllPorts'] = isset($request->PublishAllPorts);
        $template['HostConfig']['Privileged'] = isset($request->Privileged);
        $template['NetworkMode'] = $request->NetworkMode;
        $template['Entrypoint'] = "/bin/bash";
        //$template['Cmd'] = ["/usr/sbin/sshd", "-D"];
       // $template['Cmd'] = "/bin/bash";
        $template['HostConfig']['RestartPolicy']['name'] = $request->RestartPolicy;
        //$template['HostConfig']['Binds'] = $this->extractArray($request->BindSrc, $request->BindDest, ':');
        $template['HostConfig']['NetworkMode'] = $request->NetworkMode;

        return $template;
    }

    public static function pullImage($url, Image $image)
    {
        $uri = "images/create?fromImage=$image->fromImage&tag=$image->tag";
        $image->fromSrc ? $uri .= "&fromSrc=$image->fromSrc" : $uri;
        $image->repo ? $uri .= "&repo=$image->repo" : $uri;
        $image->message ? $uri .= "&message=$image->message" : $uri;

        $response = Http::post("$url/$uri");

        if ($response->getStatusCode() != 200) {
            dd($response->json());
        }
    }

    public static function createContainer(string $url, Array $data, Request $request)
    {
        $containerTemplate = json_decode(DB::table('default_templates')->where('name', 'container')->first()->template, true);
        
        $data['HostConfig']['Binds'][] = $data['volume_name'].':'.$request->storage_path;

        if($data['database'] == 'postgres') {
            $dbName = "db_{$data['nickname']}";
            $dbUser = strtolower(str_replace(' ','',auth()->user()->name));
            $dbPassword = 'secret';
    
            $dbContainer = PostgresContainer::createDataBase($dbName, $dbUser, $dbPassword, $containerTemplate);
            
            $data['Env'][] = "GITREP={$data['gitrep']}";
            $data['Env'][] = "DB_HOST={$dbContainer['NetworkSettings']['IPAddress']}";
            $data['Env'][] = "DB_PORT=".(explode('/',array_keys($dbContainer['NetworkSettings']['Ports'])[0])[0]);
            $data['Env'][] = "DB_NAME=$dbName";
            $data['Env'][] = "DB_USER=$dbUser";
            $data['Env'][] = "DB_PASSWORD=$dbPassword";
        }

        $createContainer = Http::asJson()->post("$url/containers/create", $data);

        if ($createContainer->getStatusCode() == 201) {
            $container_id = $createContainer->json()['Id'];
            $startContainer = Http::asJson()->post("$url/containers/$container_id/start");

            $data['hashcode_maquina'] = Maquina::first()->hashcode;
            $data['docker_id'] = $container_id;
            $data['dataHora_instanciado'] = now();
            $data['dataHora_finalizado'] = $startContainer->getStatusCode() == 204 ? null : now();

            Container::create($data);

            if(isset($data['gitrep'])) {
                return redirect()->route('container.loading', ['id' => $container_id]);
            } else {
                return redirect()->route('containers.index')->with('success', 'Container creation is running!');
            }
        } else {
            return back()->with('error', $createContainer->json()['message']);
        }
    }
}
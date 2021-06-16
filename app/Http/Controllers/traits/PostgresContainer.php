<?php

namespace App\Http\Controllers\traits;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

trait PostgresContainer {
    public function createPostgresDataBase(string $dbName, string $dbUser, string $dbPassword, Array $containerTemplate)
    {
        $url = env('DOCKER_HOST');
        $uri = "images/create?fromImage=postgres&tag=latest";
        
        $pullImage = Http::post("$url/$uri");

        if ($pullImage->getStatusCode() != 200) { dd($pullImage->json()); }
        
        $containerTemplate['nickname'] = $dbName;
        $containerTemplate['Image'] = "postgres:latest";

        $containerTemplate['Env'] = [
            'DB_CONNECTION=pgsql',
            "POSTGRES_USER=$dbUser",
            "POSTGRES_DB=$dbName",
            "POSTGRES_PASSWORD=$dbPassword",
        ];

        $createContainer = Http::asJson()->post("$url/containers/create", $containerTemplate);
        if($createContainer->getStatusCode() != 200 && $createContainer->getStatusCode() != 201) { throw new \Exception($createContainer->json()['message']); }
        
        $containerId = $createContainer->json()['Id'];

        $startContainer = Http::asJson()->post("$url/containers/$containerId/start");
        if($startContainer->getStatusCode() != 200 && $startContainer->getStatusCode() != 204) { throw new \Exception('Falha ao iniciar PostgresDB!'); }
        
        $container = Http::get("$url/containers/$containerId/json");
        if($container->getStatusCode() != 200) { throw new \Exception("Falha ao pegar dados do DataBase {$containerTemplate['nickname']}!"); }

        $containerTemplate['user_id'] = auth()->user()->id;
        $containerTemplate['docker_id'] = $containerId;
        $containerTemplate['dataHora_instanciado'] = now();
            
        \App\Models\Container::create($containerTemplate);

        return $container->json();
    }
}
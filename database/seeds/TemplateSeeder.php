<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TemplateSeeder extends Seeder
{
    public function run()
    {
        $templateService = [
            'Name' => 'SERVICE_NAME',
            'TaskTemplate' => [
                'ContainerSpec' => [
                    'Image' => 'IMAGE_NAME',
                    'Env' => [],
                    'DNSConfig' => ['Nameservers' => ['8.8.8.8'], 'Search' =>  [], 'Options' => ["timeout:10"], ],
                    'TTY' => true,
                    'OpenStdin' => true,
                ],
                'Resources' => [ 'Limits' => [ 'MemoryBytes' => 104857600, ], ],//equivale a 100MB
                'RestartPolicy' => [ "Condition" => "any", "Delay" => 50000000000, "MaxAttempts" => 0, ],
                'ForceUpdate' => 0,
                'Runtime' => 'container',
            ],
            'Mode' => [ 'Replicated' => [ 'Replicas' => 2,],],
            'UpdateConfig' => [ 'Parallelism' => 1, 'FailureAction' => 'pause', 'Monitor' => 5000000000, 'MaxFailureRatio' => 0, "Order" => "stop-first", ],
            'EndpointSpec' => [ 'Ports' => [ [ 'Protocol' => 'tcp', 'PublishedPort' => 1111, 'TargetPort' => 80], ], ],
            'Labels' => [],
        ];

        $templateImage = [
            "nickname" => "NICKNAME",
            "Labels" => [ 'app.name' => 'cloud-project', ],
            "Hostname"=> null,
            "Domainname" => "cloud",
            "Dns" => [],
            "DnsOptions" => [],
            "DnsSearch"=> [],
            "IPAddress" => '',
            "IPPrefixLen" => 0,
            "MacAddress" => "",
            "Memory" => 0,
            "NetworkMode" => "bridge",
            "Image" => "IMAGE_NAME",
            "Env" => [],
            "AttachStdin" =>true,
            "AttachStdout" => true,
            "AttachStderr" => true,
            "OpenStdin" => true,
            "StdinOnce" => false,
            "Tty" =>true,
            "HostConfig" => [
                "PublishAllPorts" => true, "Privileged" => true, "RestartPolicy" => ["name" => "always",], "NetworkMode" => "bridge",
                "Binds" => [
                    "/var/run/docker.sock:/var/run/docker.sock",
                    "/tmp:/tmp",
                ],
            ],
        ];

        DB::table('default_templates')->insert([
            'name' => 'service',
            'template' => json_encode($templateService),
        ]);

        DB::table('default_templates')->insert([
            'name' => 'container',
            'template' => json_encode($templateImage),
        ]);

        DB::table('default_templates')->insert([
            'name' => 'volume_driver',
            'template' => json_encode([
                "Name"=> 'VOLUME_NAME',
                "Labels"=> [
                    'container.name' => 'CONTAINER_NAME',
                ],
                "Driver" => "local",
                "DriverOpts" => [],
                /*"Driver" => "lvm",
                "DriverOpts" => [
                    'size' => 'VOLUME_SIZE',
                    'keyfile' => 'PATH_TO_KEY',
                ],*/
            ])
        ]);
    }
}

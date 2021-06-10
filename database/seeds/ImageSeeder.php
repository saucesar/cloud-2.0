<?php

use Illuminate\Database\Seeder;

class ImageSeeder extends Seeder
{
    public function run()
    {
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

        $image = \App\Models\Image::create([
            'name' => 'Nginx:latest',
            'description' => 'Nginx (pronounced "engine-x") is an open source
                              reverse proxy server for HTTP, HTTPS, SMTP, POP3, and IMAP
                              protocols, as well as a load balancer, HTTP cache, and a web
                              server (origin server).',
            'fromImage' => 'nginx',
            'tag' => 'latest',
        ]);

        $image->imageTemplate()->create([ 'template' => $templateImage ]);

        $image = \App\Models\Image::create([
            'name' => 'Nginx-ssh:latest',
            'description' => 'Nginx-ssh (pronounced "engine-x") is an open source
                              reverse proxy server for HTTP, HTTPS, SMTP, POP3, and IMAP
                              protocols, as well as a load balancer, HTTP cache, and a web
                              server (origin server). Is include a ssh container access.',
            'fromImage' => 'saucesar/nginx-ssh',
            'tag' => 'latest',
        ]);

        $image->imageTemplate()->create([ 'template' => $templateImage ]);

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
            "Env" => [
                'GITREP=',
                'DB_HOST=',
                'DB_PORT=',
                'DB_NAME=',
                'DB_USER=',
                'DB_PASSWORD=',
            ],
            "Cmd" => ["apache2-foreground"],
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

        $image = \App\Models\Image::create([
            'name' => 'Apache-PHP:latest',
            'description' => 'server for HTTP, HTTPS, SMTP, POP3, and IMAP
                              protocols, as well as a load balancer, HTTP cache, and a web
                              server (origin server).',
            'fromImage' => 'saucesar/apache',
            'tag' => 'latest',
        ]);

        $image->imageTemplate()->create([ 'template' => $templateImage ]);
    }
}

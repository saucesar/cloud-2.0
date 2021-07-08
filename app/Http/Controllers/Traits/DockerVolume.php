<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

trait DockerVolume {
    public static function create(\App\Models\User $user, string $dockerUrl, string $volumeName, string $containerName)
    {
        $volume_size = ($user->category->storage_limit/1024).'G';
        $volume_template = json_decode(DB::table('default_templates')->where('name', 'volume_driver')->first()->template, true);
        $volume_template['Name'] = $volumeName;
        $volume_template['Labels']['container.name'] = $containerName;
        
        if($volume_template['Driver'] != 'local'){
            $volume_template['DriverOpts']['size'] = $volume_size;
        }

        if(count($volume_template['DriverOpts']) == 0){
            $volume_template['DriverOpts'] = null;
        }

        $create_volume = Http::asJson()->post("$dockerUrl/volumes/create", $volume_template);
        
        return $create_volume;
    }
}
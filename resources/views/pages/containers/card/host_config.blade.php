<div class="card shadow bg-secondary">
    <div class="card-header">
        <h2>HostConfig</h2>
    </div>
    <div class="card-body">
        <p><b> RestartPolicy: </b>{{$details['HostConfig']['RestartPolicy']['Name']}}</p>
        <p>
            <b>Binds: </b>
            <br>
            @if(isset($details['HostConfig']['Binds']))
            @foreach($details['HostConfig']['Binds'] as $bind)
            {{$bind}} <br>
            @endforeach
            @endif
        </p>
        <p><b> NetworkMode: </b>{{$details['HostConfig']['NetworkMode']}}</p>
        <p><b> VolumeDriver: </b>{{$details['HostConfig']['VolumeDriver']}}</p>
        <p>
            <b> Dns: </b>
            @if($details['HostConfig']['Dns'])
            @foreach($details['HostConfig']['Dns'] as $dns)
            {{$dns}} <br>
            @endforeach
            @endif
        </p>
        <p>
            <b> DnsOptions: </b>
            @if($details['HostConfig']['DnsOptions'])

            @foreach($details['HostConfig']['DnsOptions'] as $dns)
            {{$dns}} <br>
            @endforeach
            @endif
        </p>
        <p>
            <b> DnsSearch: </b>
            @if($details['HostConfig']['DnsSearch'])
            @foreach($details['HostConfig']['DnsSearch'] as $dns)
            {{$dns}} <br>
            @endforeach
            @endif
        </p>
        <p><b> ExtraHosts: </b>{{$details['HostConfig']['ExtraHosts']}}</p>
        <p><b> Privileged: </b>{{$details['HostConfig']['Privileged'] ? 'True' : 'False'}}</p>
        <p><b> PublishAllPorts: </b>{{$details['HostConfig']['PublishAllPorts'] ? 'True' : 'False'}}</p>
        <p><b> UTSMode: </b>{{$details['HostConfig']['UTSMode']}}</p>
    </div>
</div>
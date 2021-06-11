<div class="card shadow bg-secondary">
    <div class="card-header">
        <h2>Config</h2>
    </div>
    <div class="card-body">
        <p><b>Hostname: </b>{{ $details['Config']['Hostname'] }}</p>
        <p><b>Domainname: </b>{{ $details['Config']['Domainname'] }}</p>
        <p><b>AttachStdin: </b>{{ $details['Config']['AttachStdin'] ? 'True' : 'False' }}</p>
        <p><b>AttachStdout: </b>{{ $details['Config']['AttachStdout'] ? 'True' : 'False' }}</p>
        <p><b>AttachStderr: </b>{{ $details['Config']['AttachStderr'] ? 'True' : 'False' }}</p>
        <p><b>Tty: </b>{{ $details['Config']['Tty'] ? 'True' : 'False' }}</p>
        <p><b>OpenStdin: </b>{{ $details['Config']['OpenStdin'] ? 'True' : 'False' }}</p>
        <p><b>StdinOnce: </b>{{ $details['Config']['StdinOnce'] ? 'True' : 'False' }}</p>
        <p>
            <b>Env:</b><br>
            @foreach($details['Config']['Env'] as $env)
            {{$env}} <br>
            @endforeach
        </p>
        <p>
            <b>Cmd: </b><br>
            @if($details['Config']['Cmd'])
            @foreach($details['Config']['Cmd'] as $cmd)
            {{$cmd}} <br>
            @endforeach
            @endif
        </p>
        <p><b>Image: </b>{{ $details['Config']['Image'] }}</p>
        <p><b>WorkingDir: </b>{{ $details['Config']['WorkingDir'] }}</p>
        <p>
            <b>Entrypoint:</b><br>
            @if(isset($details['Config']['Entrypoint']))
            @foreach($details['Config']['Entrypoint'] as $entry)
            {{$entry}} <br>
            @endforeach
            @endif
        </p>
        <p>
            <b>Labels:</b><br>
            @foreach($details['Config']['Labels'] as $label)
            {{ array_search($label, $details['Config']['Labels']) }}
            {{ " : $label"}}
            @endforeach
        </p>
        <p><b>StopSignal: </b>{{ $details['Config']['StopSignal'] }}</p>

    </div>
</div>
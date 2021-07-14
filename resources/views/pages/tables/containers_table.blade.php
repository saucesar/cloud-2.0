    <table class='table'>
    <thead>
        <th>#</th>
        <th>Container Id</th>
        <th>Nickname</th>
        <th>IP</th>
        @if($isAdminArea ?? false)
        <th>User Email</th>
        @endif
        <th>Running</th>
        <th>Options</th>
        <th>
            Git <i class="fab fa-git-alt"></i>
        </th>
    </thead>
    <tbody>
        @foreach ($mycontainers as $container)
        <tr>
            <td><i class="fas fa-server"></i></td>
            <td>{{ substr($container->docker_id, 0, 12) }}</td>
            <td>{{ $container->nickname }}</td>
            <td>
                @foreach($containerIp[$container->docker_id] as $link)
                <a href="http://{{ $link }}" target="_blank">{{ $link }}</a> |
                @endforeach
            </td>
            @if($isAdminArea)
            <td>{{ $container->user()->email }}</td>
            @endif
            <td class="td-actions text-center">
                @if ($container->dataHora_finalizado)
                <a href="#" class="btn btn-danger" data-original-title="" title="">
                    <i class=" material-icons">stop</i>
                </a>
                @else
                <div class="spinner-grow text-success" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                @endif
            </td>
            <td class="td-actions text-right">
                <div class='row'>
                    @if($container->dataHora_finalizado)
                    <a href="{{ route('containers.playStop', $container->docker_id) }}" class="btn btn-link btn-success"
                        data-original-title="" title="Play/Pause the container.">
                        <i class=" material-icons">play_circle_outline</i>
                    </a>
                    @else
                    <a href="{{ route('containers.playStop', $container->docker_id) }}" class="btn btn-link btn-warning"
                        data-original-title="" title="Play/Pause the container.">
                        <i class=" material-icons">pause_circle_outline</i>
                    </a>
                    @endif
                    <a href="{{ route('container.terminalTab', $container->docker_id) }}" class="btn btn-info btn-link"
                        target="_black" title="Open terminal.">
                        <i class="fas fa-terminal"></i>
                    </a>
                    <a href="{{$dockerHost}}/containers/{{$container->docker_id}}/export" class="btn btn-info btn-link"
                        title="Download.">
                        <i class=" material-icons">get_app</i>
                    </a>
                    <a href="{{$dockerHost}}/containers/{{$container->docker_id}}/logs?timestamps=1&stdout=1&stderr=1"
                        class="btn btn-info btn-link" target="_blank" title="Logs.">
                        <i class="fas fa-file-alt"></i>
                    </a>
                    <a href="{{ route('containers.show' , [$container->docker_id]) }}" class="btn btn-link"
                        title="Details.">
                        <i class="material-icons">visibility</i>
                    </a>
                    <a href="{{ route('containers.edit' , [$container->docker_id]) }}" class="btn btn-warning btn-link"
                        title="Edit nickname.">
                        <i class="material-icons">edit</i>
                    </a>
                    <button class="btn btn-danger btn-link" data-toggle="modal"
                        data-target="#modalDeleteContainer{{ $container->docker_id }}" title="Delete a containers">
                        <i class="material-icons">delete</i>
                    </button>

                    @include('pages/containers/modal/delete_container')
                </div>
            </td>
            <td class="td-actions text-left">
                <button class="btn btn-info btn-link" type="button" onclick="gitPull();"
                    title="{{ isset($container->gitrep ) ?'Git pull.' : 'To enable set git project path' }}"
                    {{ isset($container->gitrep ) ? : 'disabled' }}>
                    <i class="fas fa-sync"></i>
                </button>
            </td>
        </tr>
        <script>
            function gitPull() {
                connectWsAndPull("<?= $container->docker_id ?>");
            }
        </script>
        @endforeach
    </tbody>
</table>
{!! $mycontainers->links() !!}
@push('head_scripts')
<script>

function connectWsAndPull(containerId) {
    const host = "<?= $dockerHostWs ?>";
    const endpoint = "/attach/ws?logs=0&stream=1&stdout=1&stderr=1";
    const url = host + '/containers/' + containerId + endpoint;

    const webSocket = new WebSocket(url);
    webSocket.onopen = function(e) { 
        webSocket.send('\n');
        webSocket.send("cd /var/www/html/project/ && cd $(ls) && git pull\n");
        console.log('Connection open');
        alert('Project updated!');
    }

    return webSocket;
}
</script>
@endpush
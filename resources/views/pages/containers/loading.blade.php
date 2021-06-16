@extends('layouts.app', ['activePage' => 'my-containers', 'title' => 'Container Terminal','titlePage' => __("Container loading")])

@section('content')

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div id="terminal"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
const host = "<?= $dockerHost ?>";
const containerId = "<?= $containerId ?>";
const endpoint = "/attach/ws?logs=0&stream=1&stdout=1&stderr=1";
const url = host+'/containers/'+containerId+endpoint;

const webSocket = new WebSocket(url);
webSocket.onopen = function (e) {
    webSocket.send("\n");
    webSocket.send("bash -c /clone-and-install.sh &\n");
}
webSocket.onclose = function(e) {
    alert("Terminal disconnected");
    window.location.href = "<?= route('containers.index'); ?>";
}

const attachAddon = new AttachAddon.AttachAddon(webSocket);
const fitAddon = new FitAddon.FitAddon();
const webLinksAddon = new WebLinksAddon.WebLinksAddon();
const term = new Terminal({cursorBlink: true});

term.loadAddon(attachAddon);
term.loadAddon(fitAddon);
term.loadAddon(webLinksAddon);

term.open(document.getElementById('terminal'));
fitAddon.fit();
term.reset();
term.focus();
</script>
@endpush

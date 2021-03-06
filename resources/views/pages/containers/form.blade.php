<div class="row">
    <div class="col-sm-5">
        @include('pages.components.input_text', ['name' => 'nickname', 'label' => 'NickName', 'placeholder' => "Nickname to container"])
    </div>
    <div class="col">
        <label for="Domainname">Domainname</label>
        <input type="text" name="Domainname" value="{{ old('Domainname') ?? $container_template['Domainname'] ?? ''}}" class="form-control">
    </div>
</div>
<br>
@if(isset($images))
<div class="row">
    <div class="col">
        <label for="image_id">Image</label>
        <select name="image_id" class='form-control' required>
            <option value="">Select a Image</option>
            @foreach($images as $image)
            <option value="{{ $image->id }}" {{ old('image_id') == $image->id || isset($requiredImage) && $requiredImage->id == $image->id ? 'selected' : '' }}>{{ $image->name }}</option>
            @endforeach
        </select>
        @error('image_id')
        <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>
    <div class="col">
        <label for="database">Database</label>
        <select name="database" class="form-control">
            <option value="">Select a database</option>
            <option value="postgres">Postgres</option>
            <option value="mysql">Mysql</option>
        </select>
    </div>
</div>
@endif
<br>
<div class="text-left">
    <div class="row">
        <div class="col">
            <label for="gitrep">Github (Must be public)</label>
            <input class="form-control" type="text" name="gitrep" placeholder="Github repository URL"
                value="{{ old('gitrep') }}">
        </div>
    </div>
    @include('pages.components.input_labels', ['labels' => $container_template['Labels']])
</div>
<!--
<div class="row">
    <div class="col">
        <h3>Network</h3>
    </div>
</div>
<div class="row">
    <div class="col-2">
        <label for="NetworkMode">NetworkMode</label>
        <select name="NetworkMode" class="form-control">
            <option value="bridge" {{ $container_template['NetworkMode'] == 'bridge' ? 'selected' : '' }}>Bridge
            </option>
            <option value="host" {{ $container_template['NetworkMode'] == 'host' ? 'selected' : '' }}>Host</option>
            <option value="none" {{ $container_template['NetworkMode'] == 'none' ? 'selected' : '' }}>None</option>
        </select>
    </div>
    <div class="col-4">
        <label for="IPAddress">IP Address</label>
        <input type="text" name="IPAddress" value="{{ old('IPAddress') ?? $container_template['IPAddress'] }}"
            class="form-control">
    </div>
    <div class="col-4">
        <label for="IPPrefixLen">IP Prefix Len</label>
        <input type="text" name="IPPrefixLen" value="{{ old('IPPrefixLen') ?? $container_template['IPPrefixLen'] }}"
            class="form-control">
    </div>
</div>
<br>
<div class="row">
    <div class="col-6">
        <label for="dns">DNS (Ex: 0.0.0.0)</label>
    </div>
</div>
<div class="row">
    <div class="col-4" id="dns-values">
        <input type="text" name="dns" class="form-control" value="{{ implode(';', $container_template['Dns']) }}">
    </div>
</div>
<br><br>
<div class="row">
    <div class="col-4">
        <label for="dnsOptions">DNS Options (Ex: timeout:20)</label>
    </div>
</div>
<div class="row">
    <div class="col-4" id="dnsOpt-values">
        <div class="row">
            <div class="col-10">
                <input type="text" name="dnsOptions[]" class="form-control">
            </div>
            <div class="col-2" id="colBtnRemoveDnsOpt1">
            </div>
        </div>
        @foreach($container_template['DnsOptions'] as $dns)
        <div class="row">
            <div class="col-10">
                <input type="text" name="dnsOptions[]" class="form-control" value="{{ $dns }}">
            </div>
            <div class="col-2">
                <button type="button" class="btn btn-sm btn-link btn-danger"
                    onclick='deleteElement(this, 2);'>X</button>
            </div>
        </div>
        @endforeach
    </div>
    <div class="col-2">
        <button class="btn btn-sm btn-success" id="buttonAddDnsOpt" onclick="addDnsOpt();" type="button">Add</button>
    </div>
    <script type="text/javascript">
    var countDnsOpt = 1;

    function addDnsOpt() {
        var field = '<div class="row"><div class="col-10"><input type="text" name="dnsOptions[]" class="form-control">';
        field += '</div><div class="col-2" id="colBtnRemoveDnsOpt' + (++countDnsOpt) + '"></div></div>';

        addAtFirst("#dnsOpt-values", field);
        addAtFirst("#colBtnRemoveDnsOpt" + (countDnsOpt - 1),
            '<button type="button" class="btn btn-sm btn-link btn-danger"onclick="deleteElement(this, 2);">X</button>'
        );
    }

    function checkDnsOpt() {
        var button = document.getElementById('buttonAddDnsOpt');
        button.disabled = !checkInputArray('dnsOptions[]');
    }

    setInterval(checkDnsOpt, 100);
    </script>
</div>-->
@include('pages.components.input_env', ['envVariables' => $container_template['Env']])
<div class="row">
    <div class="col">
        <h3>Resources</h3>
    </div>
</div>
<div class="row">
    <div class="col">
        <label for="Memory" title="Select where your storage folder will be.">Storage path</label>
        <select name="storage_path" class="form-control" required>
            <option value="/bin">/bin</option>
            <option value="/home">/home</option>
            <option value="/mnt">/mnt</option>
            <option value="/dev">/dev</option>
            <option value="/opt">/opt</option>
            <option value="/var" selected>/var</option>
        </select>
    </div>
    <div class="col">
        @if(isset($volumes))
        <label for="volume" title="Select where your volume.">Volume</label>
        <select name="volume" class="form-control" required>
            <option value="new">Create new volume</option>
            @foreach($volumes as $volume)
            <option value="{{ $volume->name }}">{{ $volume->name }}</option>
            @endforeach
        </select>
        @endif
    </div>
</div>
<br><br>
<div class="row">
    <div class="col">
        <input type="checkbox" name="AttachStdin" {{ $container_template['AttachStdin'] ? 'checked' : '' }}>
        <label for="AttachStdin">AttachStdin</label>
    </div>
    <div class="col">
        <input type="checkbox" name="AttachStdout" {{ $container_template['AttachStdout'] ? 'checked' : '' }}>
        <label for="AttachStdout">AttachStdout</label>
    </div>
    <div class="col">
        <input type="checkbox" name="AttachStderr" {{ $container_template['AttachStderr'] ? 'checked' : '' }}>
        <label for="AttachStderr">AttachStderr</label>
    </div>
</div>
<div class="row">
    <div class="col">
        <input type="checkbox" name="OpenStdin" {{ $container_template['OpenStdin'] ? 'checked' : '' }}>
        <label for="OpenStdin">OpenStdin</label>
    </div>
    <div class="col">
        <input type="checkbox" name="StdinOnce" {{ $container_template['StdinOnce'] ? 'checked' : '' }}>
        <label for="StdinOnce">StdinOnce</label>
    </div>
    <div class="col">
        <input type="checkbox" name="Tty" {{ $container_template['Tty'] ? 'checked' : '' }}>
        <label for="Tty">Tty</label>
    </div>
</div>
<div class="row">
    <div class="col">
        <input type="checkbox" name="PublishAllPorts"
            {{ $container_template['HostConfig']['PublishAllPorts'] ? 'checked' : '' }}>
        <label for="PublishAllPorts">PublishAllPorts</label>
    </div>
    <div class="col">
        <input type="checkbox" name="Privileged" {{ $container_template['HostConfig']['Privileged'] ? 'checked' : '' }}>
        <label for="Privileged">Privileged</label>
    </div>
    <div class="col"></div>
</div>
<div class="row">
    <!--
    <div class="col-5">
        <h3>Entrypoint</h3>
    </div>-->
    <div class="col-2"></div>
    <div class="col-5">
        <h3>RestartPolicy</h3>
    </div>
</div>
<div class="row">
    <!--
    <div class="col-5">
        @if(isset($container_template['Entrypoint']))
        <div class="row">
            <div class="col-10">
                <input type="text" name="Entrypoint" class="form-control"
                    value="{{ implode(';', $container_template['Entrypoint']) }}">
            </div>
            <div class="col-2" id="colBtnRemoveEntryPoint1"></div>
        </div>
        @endif
    </div>-->
    <div class="col-5">
        <select name="RestartPolicy" class="form-control">
            <option value="" {{  $container_template['HostConfig']['RestartPolicy']['name'] == '' ? 'selected' : '' }}>
                Never</option>
            <option value="always"
                {{  $container_template['HostConfig']['RestartPolicy']['name'] == 'always' ? 'selected' : '' }}>
                Always</option>
            <option value="unless-stopped"
                {{ $container_template['HostConfig']['RestartPolicy']['name'] == 'unless-stopped' ? 'selected' : '' }}>
                Unless-Stopped</option>
            <option value="on-failure"
                {{ $container_template['HostConfig']['RestartPolicy']['name'] == 'on-failure' ? 'selected' : '' }}>
                On-Failure</option>
        </select>
    </div>
</div>
<!--
<div class="row">
    <div class="col">
        <h3>Binds</h3>
    </div>
</div>
<div class="row">
    <div class="col-5">
        <label for="BindSrc[]">Volume-Name</label>
    </div>
    <div class="col-5">
        <label for="BindDest[]">Container-Destiny</label>
    </div>
    <div class="col-2">
    </div>
</div>
<div class="row">
    <div class="col-10" id="colBind">
        <div class="row">
            <div class="col-5">
                <input type="text" name="BindSrc[]" class="form-control">
            </div>
            <div class="col-5">
                <input type="text" name="BindDest[]" class="form-control">
            </div>
            <div class="col-2" id="colBtnRemoveBind1"></div>
        </div>
        @foreach($container_template['HostConfig']['Binds'] as $bind)
        <div class="row">
            <div class="col-5">
                <input type="text" name="BindSrc[]" class="form-control" value="{{ explode(':', $bind)[0] }}">
            </div>
            <div class="col-5">
                <input type="text" name="BindDest[]" class="form-control" value="{{ explode(':', $bind)[1] }}">
            </div>
            <div class="col-2">
                <button type="button" class="btn btn-sm btn-link btn-danger"
                    onclick="deleteElement(this, 2);">X</button>
            </div>
        </div>
        @endforeach
    </div>
    <div class="col-2">
        <button class="btn btn-sm btn-success" id="buttonAddBind" onclick="addBind();" type="button">Add</button>
    </div>
    <script type="text/javascript">
    var countBind = 1;

    function addBind() {
        var field = '<div class="row"><div class="col-5"><input type="text" name="BindSrc[]" class="form-control">';
        field += '</div><div class="col-5"><input type="text" name="BindDest[]" class="form-control"></div>';
        field += '<div class="col-2" id="colBtnRemoveBind' + (++countBind) + '"></div></div>';
        addAtFirst("#colBind", field);
        addAtFirst("#colBtnRemoveBind" + (countBind - 1),
            '<button type="button" class="btn btn-sm btn-link btn-danger"onclick="deleteElement(this, 2);">X</button>'
            );
    }

    function checkBinds() {
        var button = document.getElementById('buttonAddBind');
        button.disabled = !(checkInputArray("BindSrc[]") && checkInputArray("BindDest[]"));
    }

    setInterval(checkBinds, 100);
    </script>
</div>
 -->
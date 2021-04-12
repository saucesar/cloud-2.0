<div class="row">
    <div class="col">
        <h3>Env Variables</h3>
    </div>
</div>
<div class="row">
    <div class="col-5">
        <label for="EnvKeys[]">KEY</label>
    </div>
    <div class="col-5">
        <label for="EnvValues[]">VALUE</label>
    </div>
    <div class="col-2">
    </div>
</div>
<div class="row">
    <div class="col-10" id="colEnv">
        <div class="row">
            <div class="col-5">
                <input type="text" name="EnvKeys[]" class="form-control">
            </div>
            <div class="col-5">
                <input type="text" name="EnvValues[]" class="form-control">
            </div>
            <div class="col-2" id="colBtnRemoveEnv1">
            </div>
        </div>
        @foreach($container_template['Env'] as $env)
        <div class="row">
            <div class="col-5">
                <input type="text" name="EnvKeys[]" class="form-control" value="{{ explode('=', $env)[0] }}">
            </div>
            <div class="col-5">
                <input type="text" name="EnvValues[]" class="form-control" value="{{ explode('=', $env)[1] }}">
            </div>
            <div class="col-2">
                <button type="button" class="btn btn-sm btn-link btn-danger"
                    onclick='deleteElement(this, 2);'>X</button>
            </div>
        </div>
        @endforeach
    </div>
    <div class="col-2">
        <button class="btn btn-sm btn-success" id="buttonAddEnv" onclick="addEnv();" type="button">Add</button>
    </div>
    <script type="text/javascript">
    var countEnv = 1;

    function addEnv() {
        var field = '<div class="row"><div class="col-5"><input type="text" name="EnvKeys[]" class="form-control">';
        field += '</div><div class="col-5"><input type="text" name="EnvValues[]" class="form-control"></div>';
        field += '<div class="col-2" id="colBtnRemoveEnv' + (++countEnv) + '"></div></div>';
        addAtFirst("#colEnv", field);
        addAtFirst("#colBtnRemoveEnv" + (countEnv - 1),
            '<button type="button" class="btn btn-sm btn-link btn-danger" onclick="deleteElement(this, 2);">X</button>'
        );
    }

    function checkEnvs() {
        var button = document.getElementById('buttonAddEnv');
        button.disabled = !(checkInputArray("EnvKeys[]") && checkInputArray("EnvValues[]"));
    }

    setInterval(checkEnvs, 100);
    </script>
</div>
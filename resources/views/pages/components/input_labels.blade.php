<div class="row">
    <div class="col">
        <h3>Labels</h3>
    </div>
</div>
<div class="row">
    <div class="col-5">
        <label for="LabelKeys[]">KEY</label>
    </div>
    <div class="col-5">
        <label for="">VALUE</label>
    </div>
    <div class="col-2">
    </div>
</div>
<div class="row">
    <div class="col-10" id="labels">
        <div class="row">
            <div class="col-5">
                <input type="text" name="LabelKeys[]" class="form-control">
            </div>
            <div class="col-5" id="label-values">
                <div class="row">
                    <div class="col-10">
                        <input type="text" name="LabelValues[]" class="form-control">
                    </div>
                    <div class="col-2" id="colBtnRemoveLabel1"></div>
                </div>
            </div>
        </div>
        @php( $labelKeys = array_keys($labels) )
        @for($i = 0; $i < count($labels); $i++) <div class="row">
            <div class="col-5">
                <input type="text" name="LabelKeys[]" value="{{ $labelKeys[$i] }}" class="form-control">
            </div>
            <div class="col-5" id="label-values">
                <div class="row">
                    <div class="col-10">
                        <input type="text" name="LabelValues[]" class="form-control"
                            value="{{ $labels[$labelKeys[$i]] }}">
                    </div>
                    <div class="col-2">
                        <button type="button" class="btn btn-sm btn-link btn-danger" title="Delete the label"
                            onclick="deleteElement(this, 4);">X</button>
                    </div>
                </div>
            </div>
    </div>
    @endfor
    <script type="text/javascript">
    var countLabel = 1;

    function addLabel() {
        var field = '<div class="row"><div class="col-5"><input type="text" name="LabelKeys[]" class="form-control">';
        field += '</div><div class="col-5" id="label-values"><div class="row"><div class="col-10">';
        field += '<input type="text" name="LabelValues[]"class="form-control">';
        field += '</div><div class="col-2" id="colBtnRemoveLabel' + (++countLabel) + '"></div></div></div></div>';
        addAtFirst("#labels", field);
        addAtFirst("#colBtnRemoveLabel" + (countLabel - 1),
            '<button type="button" class="btn btn-sm btn-link btn-danger" title="Delete the label"onclick="deleteElement(this, 4);">X</button>'
        );
    }

    function checkLabels() {
        var button = document.getElementById('buttonAddLabel');
        button.disabled = !(checkInputArray("LabelKeys[]") && checkInputArray("LabelValues[]"));
    }

    setInterval(checkLabels, 100);
    </script>
</div>
<div class="col-2">
    <button type="button" class="btn btn-sm btn-success" id="buttonAddLabel" onclick="addLabel()">Add</button>
</div>
</div>
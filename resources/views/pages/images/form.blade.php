<div class="row">
    <div class="col">
        @include('pages.components.input_text', ['name' => 'name', 'label' => 'Name', 'required' => true, 'value' => $image->name ?? old('name'), 'placeholder' => 'Image name'])
    </div>
</div>
<br>
<div class="row">
    <div class="col">
        @include('pages.components.input_text', ['name' => 'description', 'label' => 'Description', 'required' => true, 'value' => $image->description ?? old('description'), 'placeholder' => 'Enter a description.'])
    </div>
</div>
<br>
<div class="row">
    <div class="col">
    @include('pages.components.input_text', [
            'name' => 'fromImage', 'label' => 'From Image', 'required' => true, 'value' => $image->name ?? old('fromImage'),
            'placeholder' => "Name of the image to pull.", 'title' => "Name of the image to pull. The name may include a tag or digest. ".
                                                                       "This parameter may only be used when pulling an image. ".
                                                                       "The pull is cancelled if the HTTP connection is closed."])
    </div>
    <div class="col">
    @include('pages.components.input_text', ['name' => 'fromSrc', 'label' => 'From Source', 'value' => $image->fromSrc ?? old('fromSrc'),
                                             'placeholder' => "Source to import.", 'title' => "Source to import.".
                                                                                              "The value may be a URL from which the image can be retrieved ".
                                                                                              "or - to read the image from the request body. ".
                                                                                              "This parameter may only be used when importing an image.",])
    </div>
</div>
<br>
<div class="row">
    <div class="col">
    @include('pages.components.input_text', ['name' => 'repo', 'label' => 'Repository', 'value' => $image->repo ?? old('repo'),
                                                'placeholder' => "Repository name given to an image when it is imported.",
                                                'title' => "Repository name given to an image when it is imported. ".
                                                           "The repo may include a tag."])
    </div>
    <div class="col">
    @include('pages.components.input_text', [
                'name' => 'tag', 'label' => 'Tag', 'required' => true, 'value' => $image->tag ?? old('tag'),
                'placeholder' => "Tag or digest.", 'title' => "Tag or digest. If empty when pulling an image, ".
                                 "this causes all tags for the given image to be pulled.",])
    </div>
</div>
<br>
<div class="row">
    <div class="col">
    @include('pages.components.input_text', ['name' => 'message', 'label' => 'Message', 'value' => $image->tag ?? old('tag'),
                                             'placeholder' => "Set commit message for imported image.",
                                             'title' => "Set commit message for imported image",])
    </div>
</div>
<br>
<div class="row">
    <div class="col-sm">
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
</div>
<br>

@extends('layouts.app', ['activePage' => 'user-container', 'titlePage' => __("Containers")])

@push('js')
@endpush

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title ">Edit your container</h4>
                        <p class="card-category">Update the nickname</p>
                    </div>
                    <div class="card-body">
                        <div class="">
                            @include('pages.components.messages')

                            <div class="row">
                                <div class="col-sm-10">
                                    {!! Form::open(['route' => ['containers.update', $container->docker_id], 'method' => 'put']) !!}
                                        <label for="nickname">Nickname</label>
                                        {!! Form::text('nickname',$container->nickname, ['class'=>"form-control", 'placeholder' =>"Nickname to container", 'required'=>"true"]) !!}
                                        <br>
                                        <label for="gitrep">Github project URL</label>
                                        <input class="form-control" type="text" name="gitrep" placeholder="project path" value="{{ $container->gitrep }}">
                                        <br>
                                        <div class="row">
                                            <div class="col-sm">
                                                <button type="submit" class="btn btn-primary">Save</button>
                                            </div>
                                        </div>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

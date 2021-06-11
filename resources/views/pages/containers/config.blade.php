@extends('layouts.app', ['activePage' => 'images', 'titlePage' => __("Containers")])

@push('js')
@endpush

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title ">Configure Your Container</h4>
                        <p class="card-category">Add parameters before initializing your container</p>
                    </div>
                    <div class="card-body">
                        <div class="">
                            @include('pages.components.messages')
                            
                            {!! Form::open(['route' => 'containers.store', 'method' => 'post']) !!}
                            <input type="hidden" value="{{ $requiredImage->id }}" name='image_id'>
                            <input type="hidden" value="{{ $user_id }}" name='user_id'>
                            <h4 class="card-title">Image Selected : {{ $requiredImage->name }}</h4>
                            <br>

                            @include('pages/containers/form')
                            <br>
                            <button type="submit" class="btn btn-success">
                                <i class="material-icons">archive</i>
                                Confirme
                            </button>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

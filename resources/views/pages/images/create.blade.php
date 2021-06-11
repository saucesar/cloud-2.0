@extends('layouts.app', ['activePage' => 'images', 'titlePage' => __("Avaiable Container")])

@push('js')
@endpush

@section('content')
<div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title ">Images Table</h4>
              <p class="card-category">Create New Container Image</p>
            </div>
            <div class="card-body">
              <form action="{{ route('images.store') }}" method="POST">
                @csrf
                @include('pages/images/form')
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

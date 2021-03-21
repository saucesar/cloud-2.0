@extends('layouts.app', ['activePage' => 'my-containers', 'title' => 'Container Details', 'titlePage' => __("Container name: $mycontainer->nickname")])

@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-primary">
                        <h4 class="card-title ">Container Details</h4>
                        <p class="card-category"> {{ $mycontainer->nickname }}</p>
                    </div>
                    <div class="card-body">
                        <h4 class="card-title ">Processes running in {{ $mycontainer->nickname }}</h4>
                    </div>
                    <div class="card-body">
                        @if($processes)
                        <table class='table'>
                            <thead>
                                @foreach($processes['Titles'] as $title)
                                <th>{{$title}}</th>
                                @endforeach
                            </thead>
                            <tbody>
                                @if(isset($processes['Processes']))
                                @foreach($processes['Processes'] as $process)
                                <tr>
                                    @foreach($process as $componente)
                                    <td>{{$componente}}</td>
                                    @endforeach
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                        @else
                        <div class="alert alert-danger">Container not Running</div>
                        @endif
                    </div>
                    <div class="card-body">
                        <h4 class="card-title ">Details of {{ $mycontainer->nickname }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            @if($details)
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <a class="nav-item nav-link active" id="nav-status-tab" data-toggle="tab" href="#nav-status" role="tab" aria-controls="nav-status" aria-selected="true">Status</a>
                                    <a class="nav-item nav-link" id="nav-host-config-tab" data-toggle="tab" href="#nav-host-config" role="tab" aria-controls="nav-host-config" aria-selected="false">Host Config</a>
                                    <a class="nav-item nav-link" id="nav-config-tab" data-toggle="tab" href="#nav-config" role="tab" aria-controls="nav-config" aria-selected="false">Config</a>
                                    <a class="nav-item nav-link" id="nav-network-tab" data-toggle="tab" href="#nav-network" role="tab" aria-controls="nav-network" aria-selected="false">Network</a>
                                </div>
                            </nav>
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane show active" id="nav-status" role="tabpanel" aria-labelledby="nav-status-tab">
                                    @include('pages.my-containers.status_card')
                                </div>
                                <div class="tab-pane" id="nav-host-config" role="tabpanel" aria-labelledby="nav-host-config-tab">
                                    @include('pages.my-containers.host_config_card')
                                </div>
                                <div class="tab-pane" id="nav-config" role="tabpanel" aria-labelledby="nav-config-tab">
                                    @include('pages.my-containers.config_card')
                                </div>
                                <div class="tab-pane" id="nav-network" role="tabpanel" aria-labelledby="nav-network-tab">
                                    @include('pages.my-containers.network_card')
                                </div>
                            </div>
                            @else
                            <div class="alert alert-danger">Error to get details</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

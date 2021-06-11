<script type="text/javascript" src="{{ asset('js') }}/cloud.js"></script>

<div class="modal" id="modalContainers" tabindex="-1" role="dialog" aria-labelledby="modalContainersLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalContainersLabel">Create a Container</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {!! Form::open(['route' => 'containers.store', 'method' => 'post']) !!}
            <div class="modal-body">
                <div class="text-left">
                    @include('pages/containers/form')
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">
                    Close
                </button>
                <button type="submit" class="btn btn-success">
                    Create
                </button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

@push('head_scripts')
    @if($errors->any())
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js" type="text/javascript"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#modalContainers').modal('show');
        });
    </script>
    @endif
@endpush
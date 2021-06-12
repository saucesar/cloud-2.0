<table class='table table-responsive'>
    <thead class="text-center">
        <th>#</th>
        <th>Name</th>
        <th>Description</th>
        <th>Options</th>
    </thead>
    <tbody>
        @foreach ($images as $image)
        <tr>
            <td><i class="fab fa-docker card-header-info ml-auto"></i></td>
            <td>{{ $image->name }}</td>
            <td>{{ $image->description }}</td>
            <td class="d-inline-flex">
                    <a class="btn btn-sm btn-success btn-link" href="{{ route('containers.configure') }}?image_id={{ $image->id }}" title="Iniciar container com esta imagem.">
                        <i class="fas fa-play"></i>
                    </a>
                    @if (auth()->user()->isAdmin())
                    <a rel="tooltip" class="btn btn-sm btn-info btn-link" data-toggle="collapse"
                        data-target="#{{ $image->id }}" aria-expanded="false" aria-controls="collapseExample">
                        <i class="material-icons">details</i>
                        <div class="ripple-container"></div>
                    </a>
                    <a href="{{ route('images.edit', $image) }}" class="btn btn-sm btn-warning btn-link">
                        <i class="material-icons">edit</i>
                    </a>
                    {!! Form::open(['route' => ['images.destroy', $image], 'method' => 'delete']) !!}
                    <button onclick="return confirm('Are you sure?')" type="submit" class="btn btn-sm btn-danger btn-link">
                        <i class="material-icons">delete_sweep</i>
                    </button>
                    {!! Form::close() !!}
                    @endif
            </td>
        </tr>
        <tr>
            <td></td>
            <td colspan="3">
                <div class="collapse" id="{{ $image->id }}">
                    @include('pages.images.images_show_form', ['image' => $image, 'isAdmin' => auth()->user()->isAdmin()])
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{!! $images->links() !!}

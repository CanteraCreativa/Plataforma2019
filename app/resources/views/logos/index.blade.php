@extends('adminlte::page')

@section('title', 'Cantera Creativa - Admin')

@section('content_header')
    <h1 class="text-center">
        Logos
    </h1>
    @include('admin/_breadcrumbs', [
        'crumbs' => [
            [
                'text' => 'Piezas',
                'active' => true
            ]
        ]
    ])
@stop

@section('content')

@include('admin/_messages')

<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-body">
                <div class="table-responsive">
                    <table class="table" id="submissionsTable">
                        <thead>
                            <tr>
                                <th scope="col">Orden</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Enlace</th>
                                <th scope="col">Imagen</th>
                                <th scope="col" class="no-sort">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($logos as $logo)
                            <tr>
                                <td> {{ $logo->order }} </td>
                                <td> {{ $logo->name }} </td>
                                <td> {{ $logo->url }} </td>
                                <td>
                                    <img src="{{ asset($logo->filepath) }}" alt="Thumbnail logo" style="max-height:200px;width:auto;" />
                                </td>
                                <td>
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.logos.edit', ['id' => $logo->id ]) }}" title="Editar"><i class="fas fa-edit"></i></a>
                                    <a class="btn btn-danger btn-xs btn-delete" title="Eliminar" data-id="{{ $logo->id }}" data-title="{{ $logo->name }}"><i class="fas fa-trash"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="box-footer bg-gray text-center"><a href="{{ route('admin.logos.create') }}" class="btn btn-sm btn-success" title="Agregar logo"><i class="fas fa-plus margin-r-5"></i> Agregar</a></div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Eliminar convocatoria</h4>
            </div>
            <div class="modal-body">
                ¿Desea eliminar el logo "<span id="delete-logos-title"></span>"?
            </div>
            <div class="modal-footer">
                <form id="delete-form" action="" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <a type="button" class="btn btn-default" data-dismiss="modal">Cancelar</a>
                    <button type="submit" class="btn btn-danger" title="Eliminar">
                        <i class="fas fa-trash"></i> Aceptar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection

@push('js')
    @include('admin._datatables', [
        'tableId' => '#submissionsTable',
        'orderIndex' => 0, // The 'Id' column index
    ])

    <script>
        $(".btn-delete").on('click', function(e) {
            e.preventDefault();
            var url = "{{ url('/admin/logos') }}/" + $(this).data('id');
            $("#delete-logos-title").text($(this).data('title'));
            $("#delete-form").attr('action', url);
            $("#myModal").modal('show');
        });
    </script>
@endpush


@extends('adminlte::page')

@section('title', 'Cantera Creativa - Admin')

@section('content_header')
    <a href="{{ route('admin.inscriptions.export') }}" target="_blank" class="btn btn-info pull-left">Exportar Inscripciones</a>

    <h1 class="text-center">
        Convocatorias
    </h1>
    @include('admin/_breadcrumbs', [
        'crumbs' => [
            [
                'text' => 'Convocatorias',
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
                    <table class="table" id="announcementsTable">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Empresa</th>
                                <th scope="col">Título</th>
                                <th scope="col">Premio total</th>
                                <th scope="col">Fecha inicio</th>
                                <th scope="col">Fecha cierre</th>
                                <th scope="col">Fecha resultados</th>
                                <th scope="col" class="no-sort">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($announcements as $announcement)
                            <tr>
                                <td> {{ $announcement->id }} </td>
                                <td> {{ $announcement->company }} </td>
                                <td> {{ $announcement->title }} </td>
                                <td> {{ $announcement->total_prize }} </td>
                                <td> {{ $announcement->start_date }} </td>
                                <td> {{ $announcement->end_date }} </td>
                                <td> {{ $announcement->results_date }} </td>
                                <td>
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.announcements.show', $announcement) }}" title="Ver"><i class="fas fa-eye"></i></a>
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.announcements.edit', $announcement) }}" title="Editar"><i class="fas fa-edit"></i></a>
                                    <a class="btn btn-xs btn-primary confirm-btn"
                                       href="{{ route('admin.announcements.activate', $announcement) }}"
                                       title="Cambiar estado"
                                       data-title="¿Desea @if($announcement->active)
                                           ocultar
                                        @else
                                           reactivar
                                        @endif
                                           la convocatoria {{ $announcement->title }}?">
                                        @if($announcement->active)
                                            <i class="far fa-times-circle"></i>
                                        @else
                                            <i class="far fa-check-square"></i>
                                        @endif
                                    </a>
                                    <a class="btn btn-danger btn-xs btn-delete" title="Eliminar" data-id="{{ $announcement->id }}" data-title="{{ $announcement->title }}"><i class="fas fa-trash"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="box-footer bg-gray text-center"><a href="{{ route('admin.announcements.create') }}" class="btn btn-sm btn-success" title="Crear nueva convocatoria"><i class="fas fa-plus margin-r-5"></i> Agregar</a></div>
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
                ¿Desea eliminar la convocatoria "<span id="delete-announcement-title"></span>"?
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

@include('admin._confirm')

@endsection

@push('js')
    @include('admin._datatables', [
        'tableId' => '#announcementsTable',
        'orderIndex' => 0, // The 'Id' column index
    ])

    <script>
        $(".btn-delete").on('click', function(e) {
            e.preventDefault();
            var url = "{{ url('/admin/announcements') }}/" + $(this).data('id');
            $("#delete-announcement-title").text($(this).data('title'));
            $("#delete-form").attr('action', url);
            $("#myModal").modal('show');
        });

        $(".confirm-btn").on('click', function(e) {
            e.preventDefault();
            $("#confirmationModal .modal-body").text($(this).data('title'));
            $("#confirmationModal .accept-button").attr('href', $(this).attr('href'));
            $("#confirmationModal").modal('show');
        });
    </script>
@endpush


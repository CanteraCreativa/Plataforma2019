@extends('adminlte::page')

@section('title', 'Cantera Creativa - Admin')

@section('content_header')
    <a href="{{ url('/admin/submissions/export') }}" target="_blank" class="btn btn-info pull-left">Exportar</a>

    <h1 class="text-center">
        Piezas
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
                                <th scope="col">ID</th>
                                <th scope="col">Estado</th>
                                <th scope="col">Fecha</th>
                                <th scope="col">Convocatoria</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Creativo</th>
                                <th scope="col">Imagen</th>
                                <th scope="col" class="no-sort">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($submissions as $submission)
                            <tr>
                                <td> {{ $submission->id }} </td>
                                <td>
                                    @switch($submission->state)
                                        @case(\App\Enums\SubmissionState::Pending())
                                            <span class="label label-warning">
                                            @break
                                        @case(\App\Enums\SubmissionState::Accepted())
                                            <span class="label label-success">
                                            @break
                                        @case(\App\Enums\SubmissionState::Rejected())
                                            <span class="label label-danger">
                                            @break
                                        @deafult
                                            <span class="label label-default">
                                    @endswitch
                                        {{ __($submission->state->description) }}
                                    </span>
                                </td>
                                <td> {{ $submission->created_at }} </td>
                                <td>
                                    {{ $submission->announcement->title }} ({{ $submission->announcement->id }})
                                    <a href="{{ route('admin.announcements.show', $submission->announcement) }}"><i class="fa fa-eye"></i></a>
                                </td>
                                <td> {{ $submission->name }} </td>
                                <td>
                                    {{ $submission->creativeData->full_name }} ({{ $submission->creativeData->id }})
                                    <a href="{{ route('admin.creatives.show', $submission->creativeData) }}"><i class="fa fa-eye"></i></a>
                                </td>
                                <td>
                                    <img class="w-100" src="{{ asset($submission->image_file) }}" alt="Thumbnail Pieza" style="max-height:200px;width:auto;max-width: 100%" />
                                </td>
                                <td>
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.submissions.show', $submission) }}" title="Ver"><i class="fas fa-eye"></i></a>
                                    <a class="btn btn-xs btn-primary confirm-btn"
                                       href="{{ route('admin.submissions.activate', $submission) }}"
                                       title="Cambiar estado"
                                       data-title="¿Desea @if($submission->active)
                                           ocultar
                                        @else
                                           reactivar
                                        @endif
                                           la convocatoria {{ $submission->name }}?">
                                        @if($submission->active)
                                            <i class="far fa-times-circle"></i>
                                        @else
                                            <i class="far fa-check-square"></i>
                                        @endif
                                    </a>
                                    <a class="btn btn-danger btn-xs btn-delete" title="Eliminar" data-id="{{ $submission->id }}" data-title="{{ $submission->name }}"><i class="fas fa-trash"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
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
                ¿Desea eliminar la idea "<span id="delete-announcement-title"></span>"?
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
        'tableId' => '#submissionsTable',
        'orderIndex' => 0, // The 'Id' column index
    ])

    <script>
        $(".btn-delete").on('click', function(e) {
            e.preventDefault();
            var url = "{{ url('/admin/submissions') }}/" + $(this).data('id');
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


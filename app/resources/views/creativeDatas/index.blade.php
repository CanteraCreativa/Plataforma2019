@extends('adminlte::page')

@section('title', 'Cantera Creativa - Admin')

@section('content_header')
    <a href="{{ url('/admin/users/export') }}" target="_blank" class="btn btn-info pull-left">Exportar</a>
    <h1 class="text-center">Creativos</h1>
    @include('admin/_breadcrumbs', [
        'crumbs' => [
            [
                'active' => true,
                'text' => 'Usuarios',
                'icon' => 'fa fa-user'
            ]
        ]
    ])
@stop

@section('content')
<div class="row">
    @if (\Session::has('message'))
        <div class="alert alert-success">
            <p>{!! \Session::get('message') !!}</p>
        </div>
    @endif
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table" id="creativesTable">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Usuario</th>
                                <th scope="col">Nombre y apellido</th>
                                <th scope="col">Género</th>
                                <th scope="col">Edad</th>
                                <th scope="col">Email validado</th>
                                <th scope="col">Habilidades</th>
                                <th scope="col">Intereses</th>
                                <th scope="col" class="no-sort">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($creativeDatas as $creative)
                            <tr>
                                <td> {{ $creative->id }} </td>
                                <td> {{ optional($creative->account->user)->name }} </td>
                                <td> {{ $creative->first_name ?:'-' }} {{ $creative->last_name ?:'-'}}</td>
                                <td> {{ __(($creative->gender)? $creative->gender->key : '-') }} </td>
                                <td> {{ $creative->age ?:'-'}} </td>
                                <td> {{ is_null(optional($creative->account->user)->email_verified_at) ? 'No' : 'Sí' }} </td>
                                <td> @include('admin._badge_list', [ 'list' => $creative->skills, 'field' => 'name', 'detail' => ['pivot', 'level'] ])</td>
                                <td> @include('admin._badge_list', [ 'list' => $creative->interests, 'field' => 'name' ])</td>
                                <td>
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.creatives.show', $creative) }}" title="Ver"><i class="fas fa-eye"></i></a>
                                    <a class="btn btn-xs btn-primary confirm-btn"
                                       href="{{ route('admin.creatives.resend_verification', $creative) }}"
                                       title="Renviar mail de validación"
                                       data-title="¿Renviar mail de validación?">
                                        <i class="far fa-envelope"></i></a>
                                    <a class="btn btn-xs btn-primary confirm-btn"
                                       href="{{ route('admin.creatives.activate', $creative) }}"
                                       title="Cambiar estado"
                                       data-title="¿Desea @if($creative->account->user->active)
                                                suspender
                                            @else
                                                activar
                                            @endif
                                           al usuario {{ $creative->email }}?">
                                        @if($creative->account->user->active)
                                            <i class="far fa-times-circle"></i>
                                        @else
                                            <i class="far fa-check-square"></i>
                                        @endif
                                    </a>
                                    <a class="btn btn-danger btn-xs btn-delete" title="Eliminar" data-id="{{ $creative->id }}" data-title="{{ $creative->account->user->name }}"><i class="fas fa-trash"></i></a>
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
                ¿Desea eliminar el usuario "<span id="delete-announcement-title"></span>"?
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
        'tableId' => '#creativesTable',
        'orderIndex' => 0, // The 'Id' column index
    ])

    <script>
        $(".btn-delete").on('click', function(e) {
            e.preventDefault();
            var url = "{{ url('/admin/creatives') }}/" + $(this).data('id');
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


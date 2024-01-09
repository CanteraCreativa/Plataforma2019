@extends('adminlte::page')

@section('title', 'Cantera Creativa - Admin')

@section('content_header')
    <h1 class="text-center">Mensajes</h1>
    @include('admin/_breadcrumbs', [
        'crumbs' => [
            [
                'text' => 'Mensajes',
                'active' => true
            ]
        ]
    ])
@stop

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table" id="messagesTable">
                        <thead>
                            <tr>
                                <th scope="col">Estado</th>
                                <th scope="col">#</th>
                                <th scope="col">Fecha</th>
                                <th scope="col">Email</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Marca</th>
                                <th scope="col" class="no-sort">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($contactMessages as $message)
                            <tr class="{{ !$message->read ? 'success' : ''}}">
                                <td>
                                    @if(!$message->read)
                                    <span class="label label-success">Nuevo!</span>
                                    @else
                                    <span class="label label-default">Leído</span>
                                    @endif
                                </td>
                                <th scope="row">
                                    {{ $message->id }}
                                </th>
                                <td>{{ $message->created_at->format('d/m/Y H:i:s') }}</td>
                                <td>{{ $message->email }}</td>
                                <td>{{ $message->first_name }} {{ $message->last_name }}</td>
                                <td>{{ $message->brand }}</td>

                                <td>
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.contact-messages.show', $message) }}" title="Ver mensaje"><i class="fas fa-eye"></i></a>
                                    <form id="change-state-{{ $message->id }}" action="{{ route('admin.contact-messages.update', $message) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PUT')
                                        @if( $message->read )
                                        <input type="hidden" name="read" id="read" value="0" />
                                        <button type="submit" class="btn btn-success btn-xs confirm-btn" title="Marcar como 'No leído'" data-title="¿Marcar como 'No leído'?" data-id="{{ $message->id }}">
                                            <i class="fas fa-envelope"></i>
                                        </button>
                                        @else
                                        <input type="hidden" name="read" id="read" value="1" />
                                        <button type="submit" class="btn btn-default btn-xs confirm-btn" title="Marcar como 'Leído'" data-title="¿Marcar como 'Leído'?" data-id="{{ $message->id }}">
                                            <i class="fas fa-envelope-open"></i>
                                        </button>
                                        @endif
                                    </form>
                                    <a class="btn btn-danger btn-xs btn-delete" title="Eliminar" data-id="{{ $message->id }}" data-title="{{ $message->email }}"><i class="fas fa-trash"></i></a>
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
                <h4 class="modal-title" id="myModalLabel">Eliminar mensaje</h4>
            </div>
            <div class="modal-body">
                ¿Desea eliminar el mensaje de <strong id="delete-contact-title"></strong>?
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
        'tableId' => '#messagesTable',
        'orderIndex' => 2, // The 'created_at' column index
    ])

    <script>
        $(".btn-delete").on('click', function(e) {
            e.preventDefault();
            var url = "{{ url('/admin/contact-messages') }}/" + $(this).data('id');
            $("#delete-contact-title").text($(this).data('title'));
            $("#delete-form").attr('action', url);
            $("#myModal").modal('show');
        });

        $(".confirm-btn").on('click', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            $("#confirmationModal .modal-body").text($(this).data('title'));
            $("#confirmationModal .accept-button").attr('data-id', id);
            $("#confirmationModal").modal('show');
        });

        $("#confirmationModal").on('click', '.accept-button', function (e) {
            var id = $(this).data('id');
            $("#change-state-"+id).submit();
        });
    </script>
@endpush

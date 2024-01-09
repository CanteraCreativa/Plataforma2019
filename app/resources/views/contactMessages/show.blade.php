@extends('adminlte::page')

@section('title', 'Cantera Creativa - Admin')

@section('content_header')
    <h1 class="text-center">Mensaje #{{$contactMessage->id}}</h1>
    @include('admin/_breadcrumbs', [
        'crumbs' => [
            [
                'text' => 'Mensajes',
                'link' => 'admin.contact-messages.index'
            ],
            [
                'text' => $contactMessage->id,
                'active' => true
            ]
        ]
    ])
@stop

@section('content')
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-default">
                <div class="box-header bg-gray text-right">
                    <label class="margin-r-5">Acciones</label>
                    <form action="{{ route('admin.contact-messages.update', $contactMessage) }}" method="POST" class="inline">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="read" id="read" value="0" />
                        <button type="submit" class="btn btn-success btn-sm" title="Marcar como 'No leído'">
                            <i class="fas fa-envelope"></i>
                        </button>
                    </form>
                    <form action="{{ route('admin.contact-messages.destroy', $contactMessage) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" title="Eliminar">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
                <!-- /.box-header -->
                <div class="box-body no-padding">
                    <div class="mailbox-read-info">
                        <h3>Mensaje de contacto MARCAS</h3>
                        <h5>De: {{ $contactMessage->email }}
                            <span class="mailbox-read-time pull-right">{{ $contactMessage->created_at->format('H:i:s d/m/Y') }}</span></h5>
                    </div>
                    <!-- /.mailbox-read-info -->
                    <!-- /.mailbox-controls -->
                    <div class="col-md-4 mailbox-read-info with-border">
                        <!-- Widget: user widget style 1 -->
                        <div class="box box-widget widget-user">
                            <!-- Add the bg color to the header using any of the bg-* classes -->
                            <div class="widget-user-header bg-teal">
                                <h3 class="widget-user-username">{{ $contactMessage->first_name }} {{ $contactMessage->last_name }}</h3>
                                <h5 class="widget-user-desc">{{ $contactMessage->email }}</h5>
                            </div>
                            <div class="box-footer no-padding">
                                <ul class="nav nav-stacked">
                                    <li style="padding: 10px 15px;">Nombre y apellido: <span class="pull-right">{{ $contactMessage->first_name }} {{ $contactMessage->last_name }}</span></li>
                                    <li style="padding: 10px 15px;">Email: <span class="pull-right">{{ $contactMessage->email }}</span></li>
                                    <li style="padding: 10px 15px;">Marca: <span class="pull-right">{{ $contactMessage->brand }}</span></li>
                                    <li style="padding: 10px 15px;">Recibir actualizaciones: <span class="pull-right badge {{ $contactMessage->receive_updates ? 'bg-green' : 'bg-gray' }}">{{ $contactMessage->receive_updates ? 'Sí' : 'No' }}</span></li>
                                </ul>
                            </div>
                        </div>
                        <!-- /.widget-user -->
                    </div>
                    <div class="col-md-8 mailbox-read-message">
                        <div class="bg-gray box-footer">
                            <p>{{ $contactMessage->message }}
                        </div>
                    </div>
                    <!-- /.mailbox-read-message -->
                </div>
            </div>
            <!-- /. box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</section>

@endsection

@push('js')
@endpush


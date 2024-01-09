@extends('adminlte::page')

@section('title', 'Cantera Creativa - Admin')


@section('content_header')
    <h1 class="text-center">Nueva convocatoria</h1>
    @include('admin/_breadcrumbs', [
        'crumbs' => [
            [
                'text' => 'Convocatorias',
                'link' => 'admin.announcements.index'
            ],
            [
                'text' => 'Crear',
                'active' => true,
            ]
        ]
    ])
@stop


@section('content')

    @include('admin/_errors')

    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Información de la página</h3>
                </div>
                <form class="form-horizontal" action="{{ route('admin.logos.update', ['logo' => $logo]) }}" method="POST" enctype='multipart/form-data'>
                    @csrf()
                    @method('PUT')
                    <div class="box-body">
                        <div class="form-group">
                            <label for="title" class="col-sm-2 control-label">Nombre</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="name" id="name" placeholder="Nombre identificativo" value="{{ old('name', $logo->name) }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="url" class="col-sm-2 control-label">URL</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="url" id="url" placeholder="URL" value="{{ old('url', $logo->url) }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="url" class="col-sm-2 control-label">Orden</label>
                            <div class="col-sm-10">
                                <input type="number" min="0" step="1" class="form-control" name="order" id="order" placeholder="Orden" value="{{ old('order', $logo->order) }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="file" class="col-sm-2 control-label">Archivo</label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control" name="filepath" id="filepath">
                                <small>Las imágenes deben ser cuadradas (800x800px), en blanco y negro y con espacio en blanco alrededor</small>
                            </div>
                        </div>

                        @if(!is_null($logo->filepath))
                            <div class="form-group">
                                <label for="url" class="col-sm-2 control-label">Imagen actual:</label>
                                <div class="col-sm-10">
                                        <img src="{{ asset($logo->filepath) }}" alt="Thumbnail logo" style="max-height:200px;width:auto;" />
                                </div>
                            </div>
                        @endif

                    </div>

                    <div class="box-footer bg-gray">
                        <a href="{{ route('admin.logos.index') }}" class="btn btn-default cancel" data-title="Los cambios que hayas hecho se van a perder, ¿continuar?">Cancelar</a>
                        <button type="submit" class="btn btn-success pull-right create" data-title="¿Guardar los cambios realizados?">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@include('admin._confirm')

@endsection

@push('js')
    <script>
        $(".cancel").on('click', function(e) {
            e.preventDefault();
            $("#confirmationModal .modal-body").text($(this).data('title'));
            $("#confirmationModal .accept-button").attr('href', $(this).attr('href'));
            $("#confirmationModal").modal('show');
        });

        $(".create").on('click', function(e) {
            e.preventDefault();
            $("#confirmationModal .modal-body").text($(this).data('title'));
            $("#confirmationModal .accept-button").attr('href', $(this).attr('href'));
            $("#confirmationModal .accept-button").addClass('save-announcement');
            $("#confirmationModal").modal('show');
        });

        $("#confirmationModal").on('click', '.save-announcement', function(e) {
            $('.form-horizontal').submit();
        });

        $("#confirmationModal").on('click', '.cancel-button', function(e) {
            $("#confirmationModal .accept-button").removeClass('save-announcement');
        });
    </script>
@endpush

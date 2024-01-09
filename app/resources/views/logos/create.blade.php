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
                <form class="form-horizontal" action="{{ route('admin.logos.store') }}" method="POST" enctype='multipart/form-data'>
                    @csrf()
                    @method('POST')
                    <div class="box-body">
                        <div class="form-group">
                            <label for="title" class="col-sm-2 control-label">Nombre</label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="name" id="name" placeholder="Nombre identificativo" value="{{ old('name', '') }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="url" class="col-sm-2 control-label">URL</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="url" id="url" placeholder="URL" value="{{ old('url', '') }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="url" class="col-sm-2 control-label">Orden</label>
                            <div class="col-sm-10">
                                <input type="number" min="0" step="1" class="form-control" name="order" id="order" placeholder="Orden" value="{{ old('order', '') }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="file" class="col-sm-2 control-label">Archivo</label>
                            <div class="col-sm-10">
                                <input type="file" class="form-control" name="filepath" id="filepath">
                                <small>Las imágenes deben ser cuadradas (800x800px), en blanco y negro y con espacio en blanco alrededor</small>
                            </div>
                        </div>
                    </div>

                    <div class="box-footer bg-gray">
                        <a href="{{ route('admin.logos.index') }}" class="btn btn-default">Cancelar</a>
                        <button type="submit" class="btn btn-success pull-right">Agregar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

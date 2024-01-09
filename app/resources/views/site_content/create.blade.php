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
            <form class="form-horizontal" action="{{ route('admin.site_content.store') }}" method="POST" enctype='multipart/form-data'>
                @csrf()
                @method('POST')
                <div class="box-body">
                    <div class="form-group">
                        <label for="title" class="col-sm-2 control-label">Título</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="title" id="title" placeholder="Título de la página" value="{{ old('title', '') }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="alignments" class="col-sm-2 control-label">Lineamientos</label>
                        <div class="col-sm-10">
                            <textarea name="content" class="form-control wysihtml5" id="alignments" placeholder="Contenido de la página" rows="5">{{ old('content', '') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="box-footer bg-gray">
                    <a href="{{ route('admin.site_content.index') }}" class="btn btn-default">Cancelar</a>
                    <button type="submit" class="btn btn-success pull-right">Crear</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('js')
    @include('admin/_wysiwyg')
@endpush


@push('css')
    <link rel="stylesheet" href="/vendor/wysihtml5/bootstrap3-wysihtml5.min.css" />
@endpush


@extends('adminlte::page')

@section('title', 'Cantera Creativa - Admin')


@section('content_header')
    <h1 class="text-center">Editar página #{{ $content->id }}: {{ $content->title }}</h1>

    @include('admin/_breadcrumbs', [
        'crumbs' => [
            [
                'text' => 'Contenido de sitio',
                'link' => 'admin.site_content.index'
            ],
            [
                'text' => 'Editar',
                'active' => true
            ]
        ]
    ])
@stop


@section('content')

@include('admin/_errors')
@include('admin/_messages')

<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Información de la página</h3>
            </div>
            <form class="form-horizontal" action="{{ route('admin.site_content.update', $content) }}" method="POST" enctype='multipart/form-data'>
                @csrf()
                @method('PUT')
                <div class="box-body">
                    <div class="form-group">
                        <label for="title" class="col-sm-2 control-label">Título</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="title" id="title" placeholder="Título de la página" value="{{ old('title', $content->title) }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="alignments" class="col-sm-2 control-label">Lineamientos</label>
                        <div class="col-sm-10">
                            <textarea name="content" class="form-control wysihtml5" id="alignments" placeholder="Contenido de la página" rows="5">{{ old('content', $content->content) }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="box-footer bg-gray">
                    <a href="{{ route('admin.site_content.index') }}" class="btn btn-default cancel" data-title="Los cambios que hayas hecho se van a perder, ¿continuar?">Cancelar</a>
                    <button type="submit" class="btn btn-success pull-right confirm-btn" data-title="¿Guardar los cambios realizados?">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>

@include('admin._confirm')

@endsection


@push('js')
    @include('admin/_wysiwyg')


    <script>
        $(".confirm-btn").on('click', function(e) {
            e.preventDefault();
            $("#confirmationModal .modal-body").text($(this).data('title'));
            $("#confirmationModal .accept-button").addClass('save-announcement');
            $("#confirmationModal").modal('show');
        });

        $(".cancel").on('click', function(e) {
            e.preventDefault();
            $("#confirmationModal .modal-body").text($(this).data('title'));
            $("#confirmationModal .accept-button").attr('href', $(this).attr('href'));
            $("#confirmationModal").modal('show');
        });

        $("#confirmationModal").on('click', '.save-announcement', function (e) {
            $(".form-horizontal").submit();
        });

        $("#confirmationModal").on('click', '.cancel-button', function(e) {
            $("#confirmationModal .accept-button").removeClass('save-announcement');
        });
    </script>
@endpush


@push('css')
    <link rel="stylesheet" href="/vendor/wysihtml5/bootstrap3-wysihtml5.min.css" />

@endpush


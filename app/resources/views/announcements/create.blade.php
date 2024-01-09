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
                <h3 class="box-title">Información de la convocatoria</h3>
            </div>
            <form class="form-horizontal" action="{{ route('admin.announcements.store') }}" method="POST" enctype='multipart/form-data'>
                @csrf()
                @method('POST')
                <div class="box-body">
                    <div class="form-group">
                        <label for="title" class="col-sm-2 control-label">Título</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control check-length" data-rel="#title-length" name="title" id="title" placeholder="Título de la convocatoria" value="{{ old('title', '') }}" maxlength="95">
                            <p class="text-right"><small><span id="title-length"></span> / 95</small></p>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="company" class="col-sm-2 control-label">Empresa</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" name="company" id="company" placeholder="Empresa" value="{{ old('company', '') }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="total_prize" class="col-sm-2 control-label">Premio total</label>
                        <div class="col-sm-2">
                            <div class="input-group">
                                <span class="input-group-addon">$</span>
                                <input type="number" class="form-control" name="total_prize" id="total_prize" min="0" placeholder="6000" value="{{ old('total_prize', null) }}">
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="start_date" class="col-sm-2 control-label">Fecha inicio</label>
                        <div class="col-sm-2">
                            <input type="date" class="form-control" name="start_date" id="start_date" value="{{ old('start_date', null) }}">
                        </div>
                        <label for="end_date" class="col-sm-2 control-label">Fecha cierre</label>
                        <div class="col-sm-2">
                            <input type="date" class="form-control" name="end_date" id="end_date" value="{{ old('end_date', null) }}">
                        </div>
                        <label for="results_date" class="col-sm-2 control-label">Fecha resultados</label>
                        <div class="col-sm-2">
                            <input type="date" class="form-control" name="results_date" id="results_date" value="{{ old('results_date', null) }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="short_description" class="col-sm-2 control-label">Descripción corta</label>
                        <div class="col-sm-10">
                            <textarea name="short_description" class="form-control check-length" data-rel="#short_description-length" id="short_description" placeholder="Descripción corta de la convocatoria" rows="3" maxlength="220">{{ old('short_description', '') }}</textarea>
                            <p class="text-right"><small><span id="short_description-length"></span> / 220</small></p>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Documentos</h3>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label for="brief_file" class="col-sm-2 control-label">
                                    Archivo Brief
                                </label>
                                <div class="col-sm-2">
                                    <i class="fa fa-file margin-r-5" style="font-size: 45px"></i>
                                </div>
                                <div class="col-sm-8">
                                    <input type="file" accept=".pdf" id="brief_file" name="brief_file">
                                    <p class="help-block">Formatos permitidos: .pdf</p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="rules_file" class="col-sm-2 control-label">Archivo reglas</label>
                                <div class="col-sm-2">
                                    <i class="fa fa-file margin-r-5" style="font-size: 45px"></i>
                                </div>
                                <div class="col-sm-8">
                                    <input type="file" accept=".pdf" id="rules_file" name="rules_file">
                                    <p class="help-block">Formatos permitidos: .pdf</p>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Imágenes</h3>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label for="image_thumbnail" class="col-sm-2 control-label">Imagen thumbnail</label>
                                <div class="col-sm-10">
                                    <input type="file" accept=".jpg,.jpeg,.png,.gif" id="image_thumbnail" name="image_thumbnail">
                                    <p class="help-block">Formatos permitidos: .jpg, .jpeg, .png, .gif</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Información de la marca</h3>
                        </div>
                        <div class="panel-body">
                            {{--
                            <div class="form-group">
                                <label for="first_prize" class="col-sm-2 control-label">1er premio</label>
                                <div class="col-sm-2">
                                    <div class="input-group">
                                        <span class="input-group-addon">$</span>
                                        <input type="number" class="form-control" name="first_prize" id="first_prize" min="0" placeholder="3000" value="{{ old('first_prize', null) }}">
                                    </div>
                                </div>
                                <label for="second_prize" class="col-sm-2 control-label">2do premio</label>
                                <div class="col-sm-2">
                                    <div class="input-group">
                                        <span class="input-group-addon">$</span>
                                        <input type="number" class="form-control" name="second_prize" id="second_prize" min="0" placeholder="2000" value="{{ old('second_prize', null) }}">
                                    </div>
                                </div>
                                <label for="third_prize" class="col-sm-2 control-label">3er premio</label>
                                <div class="col-sm-2">
                                    <div class="input-group">
                                        <span class="input-group-addon">$</span>
                                        <input type="number" class="form-control" name="third_prize" id="third_prize" min="0" placeholder="1000" value="{{ old('third_prize', null) }}">
                                    </div>
                                </div>
                            </div>
                            --}}
                            <div class="form-group">
                                <label for="context" class="col-sm-2 control-label">Marca</label>
                                <div class="col-sm-10">
                                    <textarea name="context" class="form-control wysihtml5" id="context" placeholder="Explicación del contexto" rows="15">{{ old('context', '') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Detalles de la Convocatoria</h3>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label for="challenge" class="col-sm-2 control-label">Desafío</label>
                                <div class="col-sm-10">
                                    <textarea name="challenge" class="form-control wysihtml5" id="challenge" placeholder="Explicación del desafío creativo" rows="15">{{ old('challenge', '') }}</textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="alignments" class="col-sm-2 control-label">Materiales</label>
                                <div class="col-sm-10">
                                    <textarea name="alignments" class="form-control wysihtml5" id="alignments" placeholder="Detalles de los lineamientos de la convocatoria" rows="15">{{ old('alignments', '') }}</textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="rules_summary" class="col-sm-2 control-label">Reglas</label>
                                <div class="col-sm-10">
                                    <textarea name="rules_summary" class="form-control wysihtml5" id="rules_summary" placeholder="Detalles de las reglas de la convocatoria" rows="15">{{ old('rules_summary', '') }}</textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="winners" class="col-sm-2 control-label">Ganadores</label>
                                <div class="col-sm-10">
                                    <textarea name="winners" class="form-control wysihtml5" id="winners" placeholder="Detalles de las reglas de la convocatoria" rows="15">{{ old('winners', '') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="box-footer bg-gray">
                    <a href="{{ route('admin.announcements.index') }}" class="btn btn-default cancel" data-title="Los cambios que hayas hecho se van a perder, ¿continuar?">Cancelar</a>
                    <button type="submit" class="btn btn-success pull-right create" data-title="¿Guardar los cambios realizados?">Crear</button>
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

        $(".cancel").on('click', function(e) {
            e.preventDefault();
            $("#confirmationModal .modal-body").text($(this).data('title'));
            $("#confirmationModal .accept-button").attr('href', $(this).attr('href'));
            $("#confirmationModal").modal('show');
        });

        $(document).ready(function(){
            $(".check-length").on('keyup change', function() {
                var rel = $(this).data('rel');
                $(rel).text($(this).val().length);
            })

            $(".check-length").each(function(item){
                var rel = $(this).data('rel');
                $(rel).text($(this).val().length);
            })
        });
    </script>
@endpush


@push('css')
    <link rel="stylesheet" href="/vendor/wysihtml5/bootstrap3-wysihtml5.min.css" />
    <style>
        .wysihtml5 {
            line-height: 1.1!important;
        }
    </style>
@endpush


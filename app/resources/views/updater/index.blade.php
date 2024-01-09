@extends('adminlte::page')

@section('title', 'Cantera Creativa - Admin')

@section('content_header')
    <h1 class="text-center">Actualizar</h1>
    @include('admin._breadcrumbs')
@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-warning">
                    <div class="box-header">
                        <div class="box-title">Escribí los comandos para actualizar</div>
                    </div>
                    <div class="box-body">
                        <form action="{{ url('/admin/update') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label>Comandos</label><br>
                                <textarea name="commands" class="form-control"></textarea>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-default">Aceptar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

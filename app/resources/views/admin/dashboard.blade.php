@extends('adminlte::page')

@section('title', 'Cantera Creativa - Admin')

@section('content_header')
    <h1 class="text-center">Dashboard</h1>
    @include('admin/_breadcrumbs')
@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-warning">
                    <div class="box-header">
                        <div class="box-title">Listado de Piezas pendientes de revisión</div>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table" id="submissionsTable">
                                <thead>
                                <tr>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Convocatoria</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Creativo</th>
                                    <th scope="col" class="no-sort">Acciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($submissions as $submission)
                                    <tr>
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
                                            <a class="btn btn-xs btn-primary" href="{{ route('admin.submissions.show', $submission) }}" title="Ver"><i class="fas fa-eye"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="box-footer text-center">
                        <a href="{{ route('admin.submissions.index') }}" class="btn btn-primary">Ver todas las piezas</a>
                    </div>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="box box-warning">
                    <div class="box-header">
                        <div class="box-title">Listado de Convocatorias pendientes de resolución</div>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table" id="announcementsTable">
                                <thead>
                                <tr>
                                    <th scope="col">Empresa</th>
                                    <th scope="col">Título</th>
                                    <th scope="col">Fecha cierre</th>
                                    <th scope="col">Fecha resultados</th>
                                    <th scope="col" class="no-sort">Acciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($announcements as $announcement)
                                    <tr>
                                        <td> {{ $announcement->company }} </td>
                                        <td> {{ $announcement->title }} </td>
                                        <td> {{ $announcement->end_date }} </td>
                                        <td> {{ $announcement->results_date }} </td>
                                        <td>
                                            <a class="btn btn-xs btn-primary" href="{{ route('admin.announcements.show', $announcement) }}" title="Ver"><i class="fas fa-eye"></i></a>
                                            <a class="btn btn-xs btn-info" href="{{ route('admin.announcements.edit', $announcement) }}" title="Editar"><i class="fas fa-edit"></i></a>
                                            <form action="{{ route('admin.announcements.destroy', $announcement) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-xs" title="Eliminar">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="box-footer text-center">
                        <a href="{{ route('admin.announcements.index') }}" class="btn btn-primary">Ver todas las convocatorias</a>
                    </div>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="box box-warning">
                    <div class="box-header">
                        <div class="box-title">Últimos usuarios Creativos registrados</div>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table" id="creativesTable">
                                <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Usuario</th>
                                    <th scope="col">Nombre y apellido</th>
                                    <th scope="col">Género</th>
                                    <th scope="col">Edad</th>
                                    <th scope="col">Habilidades</th>
                                    <th scope="col">Intereses</th>
                                    <th scope="col" class="no-sort">Acciones</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($creativeDatas as $creative)
                                    <tr>
                                        <td> {{ $creative->id }} </td>
                                        <td> {{ optional($creative->account->user)->email }} </td>
                                        <td> {{ $creative->first_name ?:'-' }} {{ $creative->last_name ?:'-'}}</td>
                                        <td> {{ __(($creative->gender)? $creative->gender->key : '-') }} </td>
                                        <td> {{ $creative->age ?:'-'}} </td>
                                        <td> @include('admin._badge_list', [ 'list' => $creative->skills, 'field' => 'name', 'detail' => ['pivot', 'level'] ])</td>
                                        <td> @include('admin._badge_list', [ 'list' => $creative->interests, 'field' => 'name' ])</td>
                                        <td>
                                            <a class="btn btn-xs btn-primary" href="{{ route('admin.creatives.show', $creative) }}" title="Ver"><i class="fas fa-eye"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="box-footer text-center">
                        <a href="{{ route('admin.creatives.index') }}" class="btn btn-primary">Ver todos</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    @include('admin._datatables', [
        'tableId' => '#submissionsTable',
        'orderIndex' => 0,
        'orderDirection' => 'asc'
    ])
    @include('admin._datatables', [
        'tableId' => '#announcementsTable',
        'orderIndex' => 3, // The results_date column
        'orderDirection' => 'asc'
    ])
@endpush

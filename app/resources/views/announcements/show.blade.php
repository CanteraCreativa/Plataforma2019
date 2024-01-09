@extends('adminlte::page')

@section('title', 'Cantera Creativa - Admin')

@section('content_header')
    <h1 class="text-center">
        Convocatoria #{{$announcement->id}}: {{ $announcement->title }}
        <br><small>Última vez actualizado: {{ $announcement->updated_at }}</small>
    </h1>
    @include('admin/_breadcrumbs', [
        'crumbs' => [
            [
                'text' => 'Convocatorias',
                'link' => 'admin.announcements.index'
            ],
            [
                'text' => $announcement->id,
                'active' => true,
            ]
        ]
    ])
@stop

@section('content')

@include('admin._messages')
@include('admin._errors')
@include('announcements._winners', ['announcement' => $announcement])

<div class="row">
    <div class="col-md-12">
        <div class="box box-default">
            <div class="box-header text-right bg-gray">
                <label class="margin-r-5">Acciones</label>
                <span class="margin-r-5"><a href="{{ route('admin.announcements.edit', $announcement) }}" class="btn btn-sm btn-info" title="Editar"><i class="fas fa-edit"></i></a></span>
                <form action="{{ route('admin.announcements.destroy', $announcement) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" title="Eliminar">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
            </div>
            <div class="box-body">
                <img class="img-responsive" src="{{ $announcement->image_banner }}" alt="Banner image" style="margin: auto;" />
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="box box-primary">
            <div class="box-body box-profile">
                <img class="profile-user-img img-responsive" src="{{ $announcement->image_thumbnail }}" alt="User profile picture">

                <h3 class="profile-username text-center">{{ $announcement->title }}</h3>

                <p class="text-muted text-center">{{ $announcement->company }}</p>

                <ul class="list-group list-group-unbordered">
                    <li class="list-group-item">
                        <b>Fecha inicio</b> <span class="pull-right">{{ $announcement->start_date }}</span>
                    </li>
                    <li class="list-group-item">
                        <b>Fecha fin</b> <span class="pull-right">{{ $announcement->end_date }}</span>
                    </li>
                    <li class="list-group-item">
                        <b>Fecha resultados</b> <span class="pull-right">{{ $announcement->results_date }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-md-9">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Detalles</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="small-box bg-aqua">
                            <div class="inner">
                                <h3>$ {{ $announcement->total_prize }}</h3>

                                <p>PREMIO TOTAL</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-trophy"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <ul class="list-group list-group-unbordered">
                            <li class="list-group-item">
                                <b>1er Premio</b> <span class="pull-right">$ {{ $announcement->first_prize }}</span>
                            </li>
                            <li class="list-group-item">
                                <b>2do Premio</b> <span class="pull-right">$ {{ $announcement->second_prize }}</span>
                            </li>
                            <li class="list-group-item">
                                <b>3er Premio</b> <span class="pull-right">$ {{ $announcement->third_prize }}</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <strong><i class="fa fa-book margin-r-5"></i> Descripción corta</strong>
                <p class="text-muted">{{ $announcement->short_description }}</p>

                <hr>

                <strong class="margin-r-5"><i class="fa fa-link margin-r-5"></i> Reglas</strong>
                <span class="text-muted"><a href="{{ $announcement->rules_file }}" target="_blank">Ver PDF</a></span>
                <div style="margin-top:20px;">
                    <strong class="margin-r-5">Resumen del reglamento</strong>
                    <div style="background:#EAEAEA;padding:20px;border-radius:10px;">{!! $announcement->rules_summary??'-' !!}</div>
                </div>

                <hr>

                <strong><i class="fa fa-pencil margin-r-5"></i> Tipo de consignas</strong>

                <p>
                    @include('admin/_badge_list', [ 'list' => $announcement->guidelines, 'field' => 'name' ])
                </p>

                <hr>

                <strong><i class="fa fa-pencil margin-r-5"></i> Habilidades</strong>

                <p>
                    @include('admin/_badge_list', [ 'list' => $announcement->skills, 'field' => 'name' ])
                </p>

                <hr>

                <strong><i class="fa fa-pencil margin-r-5"></i> Intereses</strong>

                <p>
                    @include('admin/_badge_list', [ 'list' => $announcement->interests, 'field' => 'name' ])
                </p>

            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Información de la convocatoria</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body">
                <dl class="dl-horizontal">
                    <dt>Contexto</dt>
                    <dd>{!! $announcement->context??'-' !!}</dd>
                    <hr>
                    <dt>Desafío creativo</dt>
                    <dd>{!! $announcement->challenge??'-' !!}</dd>
                    <hr>
                    <dt>Tips</dt>
                    <dd>{!! $announcement->tips??'-' !!}</dd>
                    <hr>
                    <dt>Formato</dt>
                    <dd>{!! $announcement->format??'-' !!}</dd>
                    <hr>
                    <dt>Criterios de elección</dt>
                    <dd>{!! $announcement->criteria??'-' !!}</dd>
                    <hr>
                    <dt>Lineamientos</dt>
                    <dd>{!! $announcement->alignments??'-' !!}</dd>
                </dl>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Suscriptos a la convocatoria</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <th>Creativo ID</th>
                            <th>Nombre</th>
                            <th>Piezas</th>
                        </tr>
                        @foreach ($announcement->subscribers as $sub)
                        <tr>
                            <td>{{ $sub->id }} <a href="{{ route('admin.creatives.show', $sub->id) }}"><i class="fa fa-eye"></i></a></td>
                            <td>{{ $sub->first_name??'-' }} {{ $sub->last_name??'-' }}</td>
                            <td>
                                @forelse(\App\Models\Inscription::where('announcement_id', $announcement->id)->where('creative_data_id', $sub->id)->first()->submissions as $submission)
                                    <div>
                                        @switch($submission->state)
                                            @case(\App\Enums\SubmissionState::Pending())
                                                <span class="label label-warning" title="{{ __($submission->state->description) }}">
                                                    <i class="fa fa-clock"></i>
                                                @break
                                            @case(\App\Enums\SubmissionState::Accepted())
                                                <span class="label label-success" title="{{ __($submission->state->description) }}">
                                                    <i class="fa fa-check"></i>
                                                @break
                                            @case(\App\Enums\SubmissionState::Rejected())
                                                <span class="label label-danger" title="{{ __($submission->state->description) }}">
                                                    <i class="fa fa-times"></i>
                                                @break
                                            @deafult
                                                <span class="label label-default">
                                                    {{ __($submission->state->description) }}
                                        @endswitch
                                        </span>

                                        &nbsp;{{ $submission->name }} ({{ $submission->id }})
                                        <a href="{{ route('admin.submissions.show', $submission) }}"><i class="fa fa-eye"></i></a>
                                    </div>
                                @empty
                                    -
                                @endforelse
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
        </div>
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->


@endsection

@push('js')
@endpush


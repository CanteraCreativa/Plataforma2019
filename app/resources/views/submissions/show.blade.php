@extends('adminlte::page')

@section('title', 'Cantera Creativa - Admin')

@section('content_header')
    <h1 class="text-center">
        Pieza #{{$submission->id}}: {{ $submission->title }}
        <br><small>Fecha de carga: {{ $submission->created_at }}</small>
    </h1>
    @include('admin/_breadcrumbs', [
        'crumbs' => [
            [
                'text' => 'Piezas',
                'link' => 'admin.submissions.index'
            ],
            [
                'text' => $submission->id,
                'active' => true,
            ]
        ]
    ])
@stop

@section('content')

@include('admin._errors')
@include('admin._messages')

<div class="row">
    <div class="col-md-3">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header text-center">
                        <h3 class="box-title">Estado</h3>
                    </div>
                    <div class="box-body box-profile">
                        @switch ($submission->state)
                            @case (\App\Enums\SubmissionState::Pending())
                                <div class="text-center bg-warning text-yellow" style="padding:20px;">
                                    <i class="fa fa-exclamation-triangle" style="font-size:30px;"></i>
                                @break
                            @case (\App\Enums\SubmissionState::Accepted())
                                <div class="text-center bg-success text-green" style="padding:20px;">
                                    <i class="fa fa-check" style="font-size:30px;"></i>
                                @break
                            @case (\App\Enums\SubmissionState::Rejected())
                                <div class="text-center bg-danger text-red" style="padding:20px;">
                                    <i class="fa fa-times" style="font-size:30px;"></i>
                                @break
                        @endswitch
                                    <h3 class="profile-username text-center">{{ __($submission->state->description) }}</h3>
                                </div>

                        <p class="text-muted text-center">{{ $submission->review_observation }}</p>

                        <div class="text-center" style="margin-top:20px;">
                            <hr>
                            <p style="font-weight:bold;">
                                Cambiar estado de la pieza
                            </p>
                            <form id="idea-form" action="{{ route('admin.submissions.review', $submission) }}" method="post">
                                @method('PUT')
                                @csrf
                                <input id="action-field" type="hidden" name="action" />
                                <div class="form-group">
                                    <textarea name="review_observation" class="form-control" id="review_observation" placeholder="Observación de la revisión" rows="3">{{ old('review_observation', '') }}</textarea>
                                </div>
                                <div style="display:flex;justify-content:space-between;">
                                    <button type="submit" data-action="reject" class="btn btn-danger confirm-btn btn-rechazar">Rechazar</button>
                                    <button type="submit" data-action="accept" class="btn btn-success confirm-btn btn-aceptar">Aceptar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="box box-primary">
                    <div class="box-header text-center">
                        <h3 class="box-title">Convocatoria</h3>
                    </div>
                    <div class="box-body box-profile">
                        <img class="profile-user-img img-responsive" src="{{ $submission->announcement->image_thumbnail }}" alt="Imagen de la convocatoria">

                        <h3 class="profile-username text-center">{{ $submission->announcement->title }}</h3>

                        <p class="text-muted text-center">{{ $submission->announcement->company }}</p>

                        <div class="text-center">
                            <a href="{{ route('admin.announcements.show', $submission->announcement) }}" class="btn btn-primary">Ver</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header text-center">
                        <h3 class="box-title">Autor</h3>
                    </div>
                    <div class="box-body box-profile">
                        <!-- TOOD: get user's profile avatar -->
                        <div style="height:90px;width:90px;position:relative;margin:auto;" class="text-center">
                            <img class="img-circle" style="height:100%;width:100%;object-fit:cover;" src="{{ $submission->creativeData->profile_image ?? '/images/profile_avatar.png' }}" alt="User Avatar">
                        </div>

                        <h3 class="profile-username text-center">{{ $submission->creativeData->full_name }}</h3>

                        <p class="text-muted text-center">{{ $submission->creativeData->account->user->email }}</p>

                        <div class="text-center">
                            <a href="{{ route('admin.creatives.show', $submission->creativeData) }}" class="btn btn-primary">Ver</a>
                        </div>
                    </div>
                </div>
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
                        <div class="text-center" style="margin-bottom:10px;">
                            <!-- TODO: check this image -->
                            <img class="img-responsive" src="{{ $submission->image_file }}" alt="Imagen de la Pieza">
                        </div>
                        <!-- TODO: check this link to download file -->
                        <a href="{{ $submission->image_file }}" alt="Archivo de la pieza" target="_blank">
                            <div class="small-box bg-aqua">
                                <div class="inner">
                                    <h3>Descargar</h3>
                                    <p>Click aquí para descargar la imagen original</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-download"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6">
                        <ul class="list-group list-group-unbordered">
                            <li class="list-group-item">
                                <b>Título</b> <span class="pull-right">{{ $submission->name }}</span>
                            </li>
                            <li class="list-group-item">
                                <b>Fecha de carga</b> <span class="pull-right">{{ $submission->created_at->format('Y-m-d') }}</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <strong><i class="fa fa-book margin-r-5"></i> Descripción corta</strong>
                <p class="text-muted">{!! nl2br($submission->description)  !!} </p>
                <hr>
                <strong><i class="fa fa-pencil margin-r-5"></i> Habilidades empleadas</strong>
                <p>
                    @include('admin/_badge_list', [ 'list' => $submission->skills, 'field' => 'name' ])
                </p>

                <hr>
                <strong><i class="fa fa-pencil margin-r-5"></i> Incluye elementos que no son de su autoría?</strong>: {{ $submission->legal_external ? 'Sí' : 'No' }}
                @if ($submission->legal_external)
                    <br>
                    <strong><i class="fa fa-pencil margin-r-5"></i> Detalles</strong>: {{ $submission->legal_external_details }}
                @endif
                <hr>
                <strong><i class="fa fa-pencil margin-r-5"></i> Es el autor de todos los elementos de la pieza?</strong>: {{ $submission->legal_author ? 'Sí' : 'No' }}
                <hr>
                <strong><i class="fa fa-pencil margin-r-5"></i> Contiene figuras humanas y tiene el consentimiento?</strong>: {{ $submission->legal_human_figures ? 'Sí' : 'No' }}
                <hr>
                <strong><i class="fa fa-pencil margin-r-5"></i> {{ config('cantera.submission_questions.1') }}</strong>
                <p>
                    {{ $submission->answer_question_1 }}
                </p>
                <br>
                <strong><i class="fa fa-pencil margin-r-5"></i> {{ config('cantera.submission_questions.2') }}</strong>
                <p>
                    {{ $submission->answer_question_2 }}
                </p>
                <br>
                <strong><i class="fa fa-pencil margin-r-5"></i> {{ config('cantera.submission_questions.3') }}</strong>
                <p>
                    {{ $submission->answer_question_3 }}
                </p>
            </div>
        </div>
    </div>
</div>
    </div>
</div>

@include('admin._confirm')

@endsection

@push('js')
    <script>
        $(".confirm-btn").on('click', function(e) {
            e.preventDefault();
            $("#action-field").val($(this).data('action'));
            var estado = 'aceptada';
            if($(this).data('action') == 'reject') {
                estado = 'rechazada';
            }
            $("#confirmationModal .modal-body").text('¿Desea cambiar el estado de la idea a '+estado+'?');
            $("#confirmationModal").modal('show');
        });

        $("#confirmationModal").on('click', '.accept-button', function (e) {
            $("#idea-form").submit();
        });
    </script>
@endpush



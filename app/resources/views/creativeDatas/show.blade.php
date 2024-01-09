@extends('adminlte::page')

@section('title', 'Cantera Creativa - Admin')

@section('content_header')
    <h1 class="text-center">Creativo #{{$creativeDatum->id}}</h1>
    @include('admin/_breadcrumbs', [
        'crumbs' => [
            [
                'text' => 'Usuarios',
                'icon' => 'fa fa-user',
                'link' => 'admin.creatives.index',
            ],
            [
                'text' => $creativeDatum->id,
                'active' => true
            ]
        ]
    ])
@stop

@section('content')
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-widget widget-user">
                <div class="widget-user-header bg-aqua-active">
                    <h3 class="widget-user-username">{{ $creativeDatum->first_name ?:'-' }} {{ $creativeDatum->last_name?:'-' }}</h3>
                    <h5 class="widget-user-desc">{{ $creativeDatum->account->user->email }}</h5>
                </div>
                <div class="widget-user-image">
                    <!-- TODO: Use user's image -->
                    <div style="height:90px;width:90px;position:relative;">
                        <img class="img-circle" style="height:100%;width:100%;object-fit:cover;" src="{{ $creativeDatum->profile_image ?? '/images/profile_avatar.png' }}" alt="User Avatar">
                    </div>
                </div>
                <div class="box-footer">
                    <div class="row">
                        <div class="col-sm-4 border-right">
                            <div class="description-block">
                                <h5 class="description-header">{{ __($creativeDatum->gender ? $creativeDatum->gender->key : '-') }}</h5>
                                <span class="description-text">GÉNERO</span>
                            </div>
                        </div>
                        <div class="col-sm-4 border-right">
                            <div class="description-block">
                                <h5 class="description-header">{{ $creativeDatum->age?:'-' }} años</h5>
                                <span class="description-text">EDAD</span>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="description-block">
                                <h5 class="description-header">{{ $creativeDatum->nationality?:'-' }}</h5>
                                <span class="description-text">NACIONALIDAD</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-footer no-padding">
                    <ul class="nav nav-stacked">
                        <li style="padding: 10px 15px;">Estudios: <span class="pull-right">{{ $creativeDatum->studies?:'-' }}</span></li>
                        <li style="padding: 10px 15px;">Centro de estudios: <span class="pull-right">{{ $creativeDatum->studies_where?:'-' }}</span></li>
                        <li style="padding: 10px 15px;">País: <span class="pull-right">{{ $creativeDatum->country?:'-' }}</span></li>
                        <li style="padding: 10px 15px;">Cuenta MercadoPago: <span class="pull-right"> {{ $creativeDatum->mercadopago_account?:'-' }}</span></li>

                        <li style="padding: 10px 15px;">Habilidades: @include('admin._badge_list', [ 'list' => $creativeDatum->skills, 'field' => 'name', 'detail' => ['pivot', 'level'], 'classes' => 'pull-right' ])</li>
                        <li style="padding: 10px 15px;">Intereses: @include('admin._badge_list', [ 'list' => $creativeDatum->interests, 'field' => 'name', 'classes' => 'pull-right' ])</li>
                        <li style="padding: 10px 15px;">
                            Redes sociales:
                            <div class="text-right">
                                <ul class="nav">
                                  @if($creativeDatum->links)
                                    @foreach ($creativeDatum->links as $link)
                                    <li>
                                        {{ $link }}
                                    </li>
                                    @endforeach
                                  @endif
                                </ul>
                            </div>
                        </li>

                        <li style="padding: 10px 15px;">Descripción: <br><br><span>{{ $creativeDatum->description }}</span></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Suscripciones a Convocatorias</h3>
                </div>
                <div class="box-body no-padding table-responsive">
                    <table class="table table-striped">
                        <tbody>
                            <tr>
                                <th>Convocatoria #</th>
                                <th>Nombre</th>
                                <th>Fecha cierre</th>
                                <th>Piezas</th>
                            </tr>
                            @foreach ($creativeDatum->subscriptions as $subscription)
                            <tr>
                                <td>{{ $subscription->id }} <a href="{{ route('admin.announcements.show', $subscription->id) }}"><i class="fa fa-eye"></i></a></td>
                                <td>{{ $subscription->title }}</td>
                                <td>{{ $subscription->inscription->announcement->end_date }}</td>
                                <td>
                                    @forelse($subscription->inscription->submissions as $submission)
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
            </div>
        </div>
    </div>
</section>

@endsection

@push('js')
@endpush


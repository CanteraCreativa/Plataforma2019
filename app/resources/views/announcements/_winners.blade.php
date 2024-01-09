@if ($announcement->pick_winners_period)
<div class="box box-default">
    <div class="box-header">
        <h3>Elegir Ganadores</h3>
    </div>
    <form action="{{ route('admin.announcements.pick_winners', $announcement) }}" method="POST">
        @csrf
        <div class="box-body">
            <div class="alert alert-success text-center">
                <p>Se podrán modificar los ganadores hasta la fecha de anuncio de resultados <b>{{$announcement->results_date}}</b>.</p>
            </div>
            <div class="row">
                <div class="col-xs-12 col-md-4">
                    <div class="box box-default">
                        <div class="box-header">
                            <h1 class="box-title">1er premio</h1>
                        </div>
                        <div class="box-body">
                            <select name="winner_first" class="form-control">
                                <option value="">-- Elegir ganador --</option>
                                @foreach ($announcement->submissions()->accepted()->get() as $submission)
                                <option value={{$submission->id}} {{ ($announcement->winner_first == $submission->id) ? 'selected' : '' }}>
                                        ({{$submission->id}}) {{$submission->name}} - Por: {{$submission->creativeData->full_name}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-md-4">
                    <div class="box box-default">
                        <div class="box-header">
                            <h1 class="box-title">2do premio</h1>
                        </div>
                        <div class="box-body">
                            <select name="winner_second" class="form-control">
                                <option value="">-- Elegir ganador --</option>
                                @foreach ($announcement->submissions()->accepted()->get() as $submission)
                                    <option value={{$submission->id}} {{ ($announcement->winner_second == $submission->id) ? 'selected' : '' }}>
                                        ({{$submission->id}}) {{$submission->name}} - Por: {{$submission->creativeData->full_name}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-md-4">
                    <div class="box box-default">
                        <div class="box-header">
                            <h1 class="box-title">3er premio</h1>
                        </div>
                        <div class="box-body">
                            <select name="winner_third" class="form-control">
                                <option value="">-- Elegir ganador --</option>
                                @foreach ($announcement->submissions()->accepted()->get() as $submission)
                                    <option value={{$submission->id}} {{ ($announcement->winner_third == $submission->id) ? 'selected' : '' }}>
                                        ({{$submission->id}}) {{$submission->name}} - Por: {{$submission->creativeData->full_name}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="box-footer text-center">
            <button class="btn btn-success" type="submit">Guardar</button>
        </div>
    </form>
</div>
@else
    <div class="alert alert-warning text-center">
        <p>Se podrán seleccionar los ganadores entre la fecha de cierre <b>{{$announcement->end_date}}</b> y la fecha de anuncio de resultados <b>{{$announcement->results_date}}</b>.</p>
    </div>
@endif

<div class="box box-default">
    <div class="box-header">
        <h3>Ganadores</h3>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-xs-12 col-md-4">
                <div class="box box-default">
                    <div class="box-header">
                        <h1 class="box-title">1er premio</h1>
                    </div>
                    <div class="box-body">
                        @if($winnerFirst = $announcement->winnerFirst)
                        <div class="text-center">
                            <img src="{{ $winnerFirst->image_file }}" class="img-responsive" alt="Imagen Pieza 1er premio" />
                            <h3>({{$winnerFirst->id}}) {{ $winnerFirst->name }}</h3>
                            <div class="text-center" style="margin:20px 0;">
                                <a href="{{ route('admin.submissions.show', $winnerFirst) }}" class="btn btn-primary">Ver Pieza</a>
                            </div>
                            <div class="box box-primary">
                                <div class="box-header text-center">
                                    <h3 class="box-title">autor</h3>
                                </div>
                                <div class="box-body box-profile">
                                    <!-- tood: get user's profile avatar -->
                                    <img class="profile-user-img img-responsive img-circle" src="/images/profile_avatar.png" alt="user profile picture">

                                    <h3 class="profile-username text-center">{{ $winnerFirst->creativedata->full_name }}</h3>

                                    <p class="text-muted text-center">{{ $winnerFirst->creativedata->user->email }}</p>

                                    <div class="text-center">
                                        <a href="{{ route('admin.creatives.show', $winnerFirst->creativedata) }}" class="btn btn-primary">ver autor</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="alert alert-warning">No se eligió un 1er ganador</div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-md-4">
                <div class="box box-default">
                    <div class="box-header">
                        <h1 class="box-title">2do premio</h1>
                    </div>
                    <div class="box-body">
                        @if($winnerSecond = $announcement->winnerSecond)
                        <div class="text-center">
                            <img src="{{ $winnerSecond->image_file }}" class="img-responsive" alt="Imagen Pieza 2do premio" />
                            <h3>({{$winnerSecond->id}}) {{ $winnerSecond->name }}</h3>
                            <div class="text-center" style="margin:20px 0;">
                                <a href="{{ route('admin.submissions.show', $winnerSecond) }}" class="btn btn-primary">Ver Pieza</a>
                            </div>
                            <div class="box box-primary">
                                <div class="box-header text-center">
                                    <h3 class="box-title">autor</h3>
                                </div>
                                <div class="box-body box-profile">
                                    <!-- tood: get user's profile avatar -->
                                    <img class="profile-user-img img-responsive img-circle" src="/images/profile_avatar.png" alt="user profile picture">

                                    <h3 class="profile-username text-center">{{ $winnerSecond->creativedata->full_name }}</h3>

                                    <p class="text-muted text-center">{{ $winnerSecond->creativedata->user->email }}</p>

                                    <div class="text-center">
                                        <a href="{{ route('admin.creatives.show', $winnerSecond->creativedata) }}" class="btn btn-primary">ver autor</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="alert alert-warning">No se eligió un 2do ganador</div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-md-4">
                <div class="box box-default">
                    <div class="box-header">
                        <h1 class="box-title">3er premio</h1>
                    </div>
                    <div class="box-body">
                        @if($winnerThird = $announcement->winnerThird)
                        <div class="text-center">
                            <img src="{{ $winnerThird->image_file }}" class="img-responsive" alt="Imagen Pieza 3er premio" />
                            <h3>({{$winnerThird->id}}) {{ $winnerThird->name }}</h3>
                            <div class="text-center" style="margin:20px 0;">
                                <a href="{{ route('admin.submissions.show', $winnerThird) }}" class="btn btn-primary">Ver Pieza</a>
                            </div>
                            <div class="box box-primary">
                                <div class="box-header text-center">
                                    <h3 class="box-title">autor</h3>
                                </div>
                                <div class="box-body box-profile">
                                    <!-- tood: get user's profile avatar -->
                                    <img class="profile-user-img img-responsive img-circle" src="/images/profile_avatar.png" alt="user profile picture">

                                    <h3 class="profile-username text-center">{{ $winnerThird->creativedata->full_name }}</h3>

                                    <p class="text-muted text-center">{{ $winnerThird->creativedata->user->email }}</p>

                                    <div class="text-center">
                                        <a href="{{ route('admin.creatives.show', $winnerThird->creativedata) }}" class="btn btn-primary">ver autor</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="alert alert-warning">No se eligió un 3er ganador</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

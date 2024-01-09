@if (\Session::has('message'))
    <div class="callout callout-success">
        {{ \Session::get('message') }}
    </div>
@endif


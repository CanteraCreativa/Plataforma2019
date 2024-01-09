@foreach($list as $item)
    @isset($detail)
        <?php $detail_text = $item; ?>
        @foreach($detail as $prop)
            <?php $detail_text = $detail_text->{$prop}; ?>
        @endforeach
        <span class="badge badge-default {{ $classes ?? '' }}"> {{ $item->{$field} }} ({{$detail_text}})</span>
    @else
        <span class="badge badge-default {{ $classes ?? '' }}"> {{ $item->{$field} }}</span>
    @endisset
@endforeach

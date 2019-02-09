@foreach (explode("\n", $value) as $line)
    @if (!$loop->first)
        <br/>
    @endif
    {{ $line }}
@endforeach

@foreach ($mapper->getScripts() as $src)
    <script type="text/javascript" src="{{ $src }}"></script>
@endforeach

{{ $mapper->getMap()->render() }}











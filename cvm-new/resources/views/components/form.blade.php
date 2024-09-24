<form method="{{ $method }}" action="{{ $action }}" id="{{ $id }}" name="{{ $name }}">
    @csrf
    {!! $slot !!}
</form>

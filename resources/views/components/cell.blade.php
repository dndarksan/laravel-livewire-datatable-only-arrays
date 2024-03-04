@props([
    'class'=> null,
])
<td @if(!empty($class)) class="{{ $class }}" @endif>
    {{ $slot }}
</td>

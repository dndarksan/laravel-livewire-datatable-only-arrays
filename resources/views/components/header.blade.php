<th @if($attributes->has('wclick')) wire:click="{!! $attributes->get('wclick') !!}" @endif>
    @if($attributes->has('sorteable') && $attributes->get('sorteable') == false)
        {{ $slot }}
    @else
        {{ $slot }}
        <span class="text-nowrap">
            @if($attributes->has('direccion') && $attributes->get('direccion') == 'asc')
                <i class="fas fa-angle-up"></i>
            @elseif($attributes->has('direccion') && $attributes->get('direccion') == 'desc')
                <i class="fas fa-angle-down"></i>
            @else
                <i class="fas fa-angle-down text-muted"></i><i class="fas fa-angle-up text-muted"></i></span>
            @endif
        </span>
    @endif
</th>

<div wire:init='initFunc'>
    <div class="form-inline mb-2">
        {!! Form::text('Buscar', null, ['class'=>'form-control mr-2','placeholder'=>'Buscar','wire:model.debounce.500ms'=>'buscar']) !!}
        {!! Form::select('PorPagina',$aPorPagina,null,['class'=>'form-control ml-auto','wire:model'=>'porPagina']) !!}
    </div>
    <x-livewire-dt-tables::table>
        <x-slot name="head">
            @foreach($encabezados as $encabezado)
                @php
                    if((isset($encabezado['sorteable']) && isset($encabezado['campo']))){
                        $campo = $encabezado['campo'];
                        if(isset($encabezado['campo']) && $campoSort == $encabezado['campo']){
                            $direccion = ($dirSort == 'asc')? 'desc':'asc';
                            $iconDir = $direccion;
                        }else{
                            $direccion = 'asc';
                            $iconDir = "";
                        }
                        $attrSorteable = true;
                        $attrSorteableAction = "sorterBy('$campo','$direccion')";
                    }else{
                        $attrSorteable = false;
                        $attrSorteableAction = false;
                        $direccion = "";
                    }
                @endphp
                <x-livewire-dt-tables::header :sorteable="$attrSorteable" :wclick="$attrSorteableAction" :direccion="$iconDir">{{ $encabezado[0] }}</x-livewire-dt-tables::header>
            @endforeach
        </x-slot>
        @if(collect($encabezados)->filter(function($v,$k){
            return isset($v['searchable']) && $v['searchable'];
        })->count() > 0)
        <x-slot name="searchInputs">
            @foreach ($encabezados as $encabezado)
                @if(isset($encabezado['searchable']) && $encabezado['searchable'])
                <x-livewire-dt-tables::input-header :placeholder="'Buscar en '.$encabezado[0]" :wmodel="$encabezado['campo']" :searchsInputs="$searchsInputs"></x-livewire-dt-tables::input-header>
                @else
                    <td>&nbsp;</td>
                @endif
            @endforeach
        </x-slot>
        @endif
        <x-slot name="body">
            @if($totalRegistros > 0 && $totalRegistrosFiltrados > 0)
                @if($porPagina == 0 || $totalRegistros <= $porPagina)
                    @foreach($registros as $registro)
                        <x-livewire-dt-tables::row>
                            @foreach($columnas as $columna)
                                <x-livewire-dt-tables::cell>{{ $registro[$columna[0]] ?? '' }}</x-livewire-dt-tables::cell>
                            @endforeach
                        </x-livewire-dt-tables::row>
                    @endforeach
                @else
                    @foreach($registros[$pagina] as $registro)
                        <x-livewire-dt-tables::row>
                            @foreach($columnas as $columna)
                                <x-livewire-dt-tables::cell :class="$columna['class'] ?? null">{{ $registro[$columna[0]] ?? '' }}</x-livewire-dt-tables::cell>
                            @endforeach
                        </x-livewire-dt-tables::row>
                    @endforeach
                @endif
            @else
                <tr><td colspan="{{ count($encabezados) }}" class="text-center">No se encontraron registros</td></tr>
            @endif
        </x-slot>
    </x-livewire-dt-tables::table>
    @if($porPagina == 0 || $totalRegistros <= $porPagina)
        <div class="col-12 d-flex justify-content-between">
            @if($totalRegistrosFiltrados > 0)
                <span>Mostrando {{ $totalRegistrosFiltrados }} de {{ $totalRegistros }} registros en Total</span>
            @else
                <span>Mostrando {{ $totalRegistros }} Registros</span>
            @endif
        </div>
    @else
        <div class="col-12 d-flex justify-content-between">
            @if($totalRegistrosFiltrados > 0)
                @if(count($registros) > 4)
                    <div class="btn-group">
                        <button class="btn btn-outline-secondary" wire:click='setPagina({{ $pagina-1 }})' @if($pagina == 0) disabled="disabled" @endif>Anterior</button>
                        <button class="btn btn-outline-secondary" wire:click='setPagina(0)' @if($pagina == 0) disabled="disabled" @endif>1</button>
                        @if($pagina != 0 && $pagina != (count($registros)-1))
                        <button class="btn btn-outline-secondary" disabled="disabled">{{ $pagina+1 }}</button>
                        @endif
                        <button class="btn btn-outline-secondary" wire:click='setPagina({{ count($registros)-1 }})' @if(count($registros) == ($pagina+1)) disabled="disabled" @endif>{{ count($registros) }}</button>
                        <button class="btn btn-outline-secondary" wire:click='setPagina({{ $pagina+1 }})' @if(count($registros) == ($pagina+1)) disabled="disabled" @endif>Siguiente</button>
                    </div>
                @else
                    <div class="btn-group">
                        <button class="btn btn-outline-secondary" wire:click='setPagina({{ $pagina-1 }})' @if($pagina == 0) disabled="disabled" @endif>Anterior</button>

                        <button class="btn btn-outline-secondary" wire:click='setPagina({{ $pagina+1 }})' @if(count($registros) == ($pagina+1)) disabled="disabled" @endif>Siguiente</button>
                    </div>
                @endif
            @endif
            @if($totalRegistrosFiltrados == $totalRegistros)
            <span>Mostrando {{ $totalRegistros }} Registros en Total</span>
            @elseif($totalRegistrosFiltrados > 0 && $totalRegistros > 0)
                <span>Mostrando {{ $totalRegistrosFiltrados }} de {{ $totalRegistros }} registros en Total</span>
            @endif
        </div>
    @endif
</div>

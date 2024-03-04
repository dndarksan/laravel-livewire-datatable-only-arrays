<?php

namespace Dndarksan\LaravelLivewireDatatables;

use Livewire\Component;

abstract class DTComponent extends Component
{
    public array $aPorPagina = [10=>'10',20=>'20',50=>'50',100=>'100',0=>'Todos'];
    public int $porPagina = 10;
    public int $pagina = 0;
    public string $buscar = "";
    public int $totalRegistros = 0;
    public int $totalRegistrosFiltrados = 0;
    public string $campoSort = '';
    public string $dirSort = 'asc';
    public array $searchsInputs = [];

    public array $columnas = [];
    public array $encabezados = [];

    abstract public function encabezados(): array;
    abstract public function columnas(): array;
    abstract public function registros(): array;

    public function sorterBy($campo,$dir)
    {
        $this->campoSort = $campo;
        $this->dirSort = $dir;
    }
    public function setPagina($pagina)
    {
        $this->pagina = $pagina;
    }

    public function getColumnas()
    {
        $this->campoSort = ($this->campoSort == '') ? collect($this->columnas())->first()[0] : $this->campoSort;
        $searchsInputs = collect($this->encabezados())->filter(function($v,$k){
            return isset($v['searchable']) && $v['searchable'];
        });
        if($searchsInputs->count() > 0)
            $this->searchsInputs = $searchsInputs->mapWithKeys(function ($item, $key) {
                return [$item['campo'] => null];
            })->toArray();
        return $this->columnas();
    }
    public function getRegistros()
    {
        $filtrado = false;
        $this->totalRegistros = count($this->registros());
        $registros = collect($this->registros());
        if(!empty(trim($this->buscar))){
            $registros2 = [];
            foreach($this->searchsInputs as $campo => $search){
                $filtrado = true;
                foreach($registros->filter(function($v,$k) use ($campo){
                    return isset($v[$campo]) && strpos($v[$campo],trim($this->buscar)) !== false;
                })->toArray() as $k => $row){
                    $registros2[$k] = $row;
                }
            }
            $registros = collect($registros2);
        }


        if(collect($this->searchsInputs)->filter(function($v,$k){ return !empty($v); })->count() > 0){
            foreach($this->searchsInputs as $campo => $search){
                if(!empty(trim($search))){
                    $filtrado = true;
                    $registros = $registros->filter(function($v,$k) use ($campo,$search){
                        return isset($v[$campo]) && strpos($v[$campo],trim($search)) !== false;
                    });
                }
            }
        }

        $this->totalRegistrosFiltrados = $registros->count();

        if($this->campoSort != ''){
            if($this->dirSort == 'asc')
                $registros = $registros->sortBy($this->campoSort);
            else
                $registros = $registros->sortByDesc($this->campoSort);
        }

        if($this->porPagina == 0){
            return $registros;
        }else{
            if($this->porPagina > $this->totalRegistros)
                return $registros;

            return $registros->chunk($this->porPagina);
        }
    }

    public function initFunc(){
        $this->columnas = $this->getColumnas();
        $this->encabezados = $this->encabezados();
    }

    public function render()
    {
        return view('livewire-dt-tables::dt-table')
        ->with(['registros' => $this->getRegistros()]);
    }
}

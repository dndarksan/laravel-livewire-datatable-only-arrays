<?php

namespace Dndarksan\LaravelLivewireDatatables;

use Illuminate\Foundation\Console\AboutCommand;
use Illuminate\Support\ServiceProvider;
use Livewire\ComponentHookRegistry;
use Dndarksan\LaravelLivewireDatatables\Commands\MakeCommand;

class LaravelLivewireDatatablesServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        AboutCommand::add('Dndarksan Laravel Livewire Datatables', fn () => ['Version' => '0.1b']);
        $this->loadViewsFrom(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'resources'.DIRECTORY_SEPARATOR.'views', 'livewire-dt-tables');

        $this->consoleCommands();

    }

    public function consoleCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                MakeCommand::class,
            ]);
        }
    }
}

<?php

namespace Dndarksan\LaravelLivewireDatatables\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Livewire\Commands\ComponentParser;
use Livewire\Commands\MakeCommand as LivewireMakeCommand;
class MakeCommand extends Command
{
    protected ComponentParser $parser;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:dt-table
    {name : The name of your Livewire class}
    ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a Laravel Livewire Datatable class without model';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->parser = new ComponentParser(
            config('livewire.class_namespace'),
            config('livewire.view_path'),
            $this->argument('name')
        );
        $livewireMakeCommand = new LivewireMakeCommand();

        if ($livewireMakeCommand->isReservedClassName($name = $this->parser->className())) {
            $this->line("<fg=red;options=bold>Class is reserved:</> {$name}");
            return;
        }
        $classPath = $this->parser->classPath();

        if (File::exists($classPath)) {
            $this->line("<fg=red;options=bold>Class already exists:</> {$this->parser->relativeClassPath()}");

            return false;
        }

        if (! File::isDirectory(dirname($classPath))) {
            File::makeDirectory(dirname($classPath), 0777, true, true);
        }

        $dir = str_replace('app'.DIRECTORY_SEPARATOR.'Console'.DIRECTORY_SEPARATOR.'Commands','resources'.DIRECTORY_SEPARATOR.'stubs',__DIR__);
        
        $classContents = str_replace(
            ['[namespace]', '[class]'],
            [$this->parser->classNamespace(), $this->parser->className()],
            file_get_contents($dir.DIRECTORY_SEPARATOR.'dttable.stub')
        );

        File::put($classPath, $classContents);

        $this->info('Livewire Datatable Created: '.$this->parser->className());
    }
}

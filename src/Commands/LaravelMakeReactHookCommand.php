<?php

namespace UseTheFork\LaravelMakeReact\Commands;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;

class LaravelMakeReactHookCommand extends LaravelMakeReactCommand
{
    protected $name = 'make:react:hook';

    /**
     * The name of the console command.
     *
     * This name is used to identify the command during lazy loading.
     *
     * @var string|null
     *
     * @deprecated
     */
    protected static $defaultName = 'make:react:hook';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new react hook';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Hook';

    protected function getPath($name): array
    {
        $name = Str::ucFirst(
            Str::replaceFirst($this->rootNamespace(), '', $name)
        );
        $baseName = str_replace('\\', '/', $name);
        $basePath = App::resourcePath("js/hooks/use{$baseName}");

        return [
            'index' => "{$basePath}/index.ts",
            'hook' => "{$basePath}/use{$baseName}.ts",
        ];
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        $stubs = [
            'index' => $this->resolveStubPath('/stubs/react.hook.index.stub'),
            'hook' => $this->resolveStubPath('/stubs/react.hook.hook.stub'),
        ];

        return $stubs;
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [];
    }
}

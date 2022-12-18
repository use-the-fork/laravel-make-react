<?php

namespace UseTheFork\LaravelMakeReact\Commands;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

class LaravelMakeReactComponentCommand extends LaravelMakeReactCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:react:component';

    /**
     * The name of the console command.
     *
     * This name is used to identify the command during lazy loading.
     *
     * @var string|null
     *
     * @deprecated
     */
    protected static $defaultName = 'make:react:component';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new react component';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Component';

    protected function getPath($name): array
    {
        $name = Str::ucFirst(
            Str::replaceFirst($this->rootNamespace(), '', $name)
        );
        $baseName = str_replace('\\', '/', $name);
        $basePath = App::resourcePath("js/components/{$baseName}");

        $thePaths = [
            'index' => "{$basePath}/index.ts",
            'props' => "{$basePath}/{$baseName}Props.ts",
            'component' => "{$basePath}/{$baseName}.tsx",
        ];

        if ($this->option('lazy')) {
            $thePaths['lazy'] = "{$basePath}/{$baseName}Lazy.tsx";
        }

        return $thePaths;
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        $stubs = [
            'index' => $this->resolveStubPath(
                '/stubs/react.component.index.stub'
            ),
            'props' => $this->resolveStubPath(
                '/stubs/react.component.props.stub'
            ),
            'component' => $this->resolveStubPath(
                '/stubs/react.component.stub'
            ),
        ];

        if ($this->option('lazy')) {
            $stubs['index'] = $this->resolveStubPath(
                '/stubs/react.component.index.lazy.stub'
            );
            $stubs['lazy'] = $this->resolveStubPath(
                '/stubs/react.component.lazy.stub'
            );
        }

        return $stubs;
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            [
                'lazy',
                'l',
                InputOption::VALUE_NONE,
                'Make the component lazy load',
            ],
        ];
    }
}

<?php

namespace UseTheFork\LaravelMakeReact\Commands;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

class LaravelMakeReactContextCommand extends LaravelMakeReactCommand
{
    protected $name = 'make:react:context';

    /**
     * The name of the console command.
     *
     * This name is used to identify the command during lazy loading.
     *
     * @var string|null
     *
     * @deprecated
     */
    protected static $defaultName = 'make:react:context';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new react context';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Context';

    protected function getPath($name): array
    {
        $name = Str::ucFirst(
            Str::replaceFirst($this->rootNamespace(), '', $name)
        );
        $baseName = str_replace('\\', '/', $name);
        $basePath = App::resourcePath("js/contexts/{$baseName}Context");

        return [
            'index' => "{$basePath}/index.ts",
            'props' => "{$basePath}/{$baseName}Props.ts",
            'context' => "{$basePath}/{$baseName}Context.ts",
            'provider' => "{$basePath}/{$baseName}ContextProvider.tsx",
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
            'index' => $this->resolveStubPath(
                '/stubs/react.context.index.stub'
            ),
            'props' => $this->resolveStubPath(
                '/stubs/react.context.props.stub'
            ),
            'context' => $this->resolveStubPath(
                '/stubs/react.context.context.stub'
            ),
            'provider' => $this->resolveStubPath(
                '/stubs/react.context.provider.stub'
            ),
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
        return [
            [
                'provider',
                'p',
                InputOption::VALUE_OPTIONAL,
                'create a context provider with the context',
            ],
        ];
    }
}

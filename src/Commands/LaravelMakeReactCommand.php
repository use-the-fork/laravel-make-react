<?php

namespace UseTheFork\LaravelMakeReact\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\GeneratorCommand;

class LaravelMakeReactCommand extends GeneratorCommand
{
    protected function getStub()
    {
    }
    protected function resolveStubPath($stub)
    {
        //First check if this is a stub in our directory otherwise fallback on parent
        if ($stubPath = self::resolvePath($stub)) {
            return $stubPath;
        }

        return file_exists(
            $customPath = $this->laravel->basePath(trim($stub, "/"))
        )
            ? $customPath
            : __DIR__ . $stub;
    }

    public function handle()
    {
        // First we need to ensure that the given name is not a reserved word within the PHP
        // language and that the class name will actually be valid. If it is not valid we
        // can error now and prevent from polluting the filesystem using invalid files.
        // TODO: Change this to make sence
        if ($this->isReservedName($this->getNameInput())) {
            $this->components->error(
                'The name "' . $this->getNameInput() . '" is reserved by React.'
            );

            return false;
        }

        $name = $this->qualifyClass($this->getNameInput());

        //since frontend compnents have multiple paths we create a paths array instead.
        $paths = $this->getPath($name);

        // Next, We will check to see if the class already exists. If it does, we don't want
        // to create the class and overwrite the user's code. So, we will bail out so the
        // code is untouched. Otherwise, we will continue generating this class' files.

        if (
            (!$this->hasOption("force") || !$this->option("force")) &&
            collect($paths)
                ->reject(function ($value) {
                    return !$this->files->exists($value);
                })
                ->isNotEmpty()
        ) {
            $this->components->error($this->type . " already exists.");

            return false;
        }

        // Next, we will generate the path to the location where this class' file should get
        // written. Then, we will build the class and make the proper replacements on the
        // stub files so that it gets the correctly formatted namespace and class name.

        $theStubs = $this->getStub();

        foreach ($paths as $theType => $thePath) {
            if (isset($theStubs[$theType])) {
                $this->makeDirectory($thePath);

                $stub = $this->files->get($theStubs[$theType]);
                $this->files->put(
                    $thePath,
                    $this->replaceNamespace(
                        $stub,
                        $this->getFormatedName($name)
                    )
                );

                $info = $this->type;

                $this->components->info(
                    sprintf("%s [%s] created successfully.", $info, $thePath)
                );
            }
        }
    }

    protected function buildClass($name)
    {
        $stub = $this->files->get([]);

        return $this->replaceNamespace($stub, $name)->replaceClass(
            $stub,
            $name
        );
    }

    protected function getFormatedName($name)
    {
        return Str::ucFirst(
            Str::replaceFirst($this->rootNamespace(), "", $name)
        );
    }

    protected function getPath($name): array
    {
        return [];
    }

    protected function replaceNamespace(&$stub, $name)
    {
        $searches = [["DummyName"], ["{{ name }}"]];

        foreach ($searches as $search) {
            $stub = str_replace($search, [$name], $stub);
        }
        return $stub;
    }

    public static function resolvePath($stub)
    {
        return realpath(
            str(join(DIRECTORY_SEPARATOR, [__DIR__, "..", "..", $stub]))
                ->replace("//", "/")
                ->toString()
        );
    }
}

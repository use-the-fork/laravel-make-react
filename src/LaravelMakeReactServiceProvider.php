<?php

namespace UseTheFork\LaravelMakeReact;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use UseTheFork\LaravelMakeReact\Commands\LaravelMakeReactComponentCommand;
use UseTheFork\LaravelMakeReact\Commands\LaravelMakeReactContextCommand;
use UseTheFork\LaravelMakeReact\Commands\LaravelMakeReactHookCommand;

class LaravelMakeReactServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-make-react')
            ->hasConfigFile()
            ->hasCommand(LaravelMakeReactHookCommand::class)
            ->hasCommand(LaravelMakeReactComponentCommand::class)
            ->hasCommand(LaravelMakeReactContextCommand::class);
    }
}

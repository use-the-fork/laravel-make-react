<?php

namespace UseTheFork\LaravelMakeReact;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use UseTheFork\LaravelMakeReact\Commands\LaravelMakeReactCommand;

class LaravelMakeReactServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name("laravel-make-react")
            ->hasConfigFile()
            ->hasCommand(LaravelMakeReactCommand::class);
    }
}

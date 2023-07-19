<?php

namespace Saade\FilamentLaravelLog;

use Filament\PluginServiceProvider;
use Saade\FilamentLaravelLog\Commands\UpgradeFilamentLaravelLogCommand;
use Saade\FilamentLaravelLog\Pages\ViewLog;
use Spatie\LaravelPackageTools\Package;

class FilamentLaravelLogServiceProvider extends PluginServiceProvider
{
    public static string $name = 'filament-laravel-log';

    public function configurePackage(Package $package): void
    {
        $package
            ->name(self::$name)
            ->hasViews(self::$name)
            ->hasConfigFile(self::$name)
            ->hasTranslations(self::$name)
            ->hasCommands([
                UpgradeFilamentLaravelLogCommand::class,
            ]);
    }

    protected function getPages(): array
    {
        return [
            ViewLog::class,
        ];
    }

    protected function getStyles(): array
    {
        return [
            self::$name . '-styles' => __DIR__ . '/../dist/css/filament-laravel-log.css',
        ];
    }

    protected function getScripts(): array
    {
        return [
            self::$name . '-ace' => __DIR__ . '/../dist/js/ace.js',
        ];
    }
}

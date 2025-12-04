<?php

namespace App\Providers;

use Native\Desktop\Facades\Window;
// use Native\Laravel\Facades\Menu;
use Native\Desktop\Facades\Menu;
use Native\Desktop\Contracts\ProvidesPhpIni;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;


class NativeAppServiceProvider implements ProvidesPhpIni
{
    /**
     * Executed once the native application has been booted.
     * Use this method to open windows, register global shortcuts, etc.
     */
    public function boot(): void
    {


        // Window::webPreferences();

        //  native_app()->onLaunch(function () {

        //     $folder = native_app()->documentsPath() . '/IMS';
        //     $db = $folder . '/my_database.sqlite';

        //     // Create IMS folder
        //     if (! File::exists($folder)) {
        //         File::makeDirectory($folder, 0755, true);
        //     }

        //     // Create database file
        //     if (! File::exists($db)) {
        //         File::put($db, '');
        //     }

        //     // Override SQLite path AFTER NativePHP boots
        //     Config::set('database.connections.sqlite.database', $db);
        // });

        // Now you can safely run first-run migrations
        // native_app()->onFirstLaunch(function () {

        //     Artisan::call('migrate', ['--force' => true]);
        //     Artisan::call('db:seed', ['--force' => true]);
        // });

        // Menu::create(
        //     Menu::make(
        //         // Menu::route('home','Setup'),
        //         Menu::route('login','Login'),
        //         Menu::route('dashboard','Dashboard')
        //     )->label('Navigation')
        // );
        // Menu::create(
        //     Menu::make(
        //         Menu::item('back')->onClick(function () {
        //             Window::current()->goBack();
        //         })
        //     )->label('navigation'),
        // );

        // MenuBar::create();
        // Menu::create(
        //     Menu::make(
        //         Menu::route('home', 'Home')
        //     )->label('Navigation')
        // );
        Window::open();
    }


    /**
     * Return an array of php.ini directives to be set.
     */
    public function phpIni(): array
    {
        return [];
    }
}

<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Events\Dispatcher;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;

class MenuServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(Dispatcher $events)
    {
        $events->listen(BuildingMenu::class, function (BuildingMenu $event) {
            // The menu item for Messages
            $newMessagesCount = \App\Models\ContactMessage::where('read', false)->count();
            if ($newMessagesCount) {
                $event->menu->menu[3]['label'] = $newMessagesCount;
                $event->menu->menu[3]['label_color'] = 'success';
            }
        });
    }
}

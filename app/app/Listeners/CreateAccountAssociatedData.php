<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateAccountAssociatedData
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $user = $event->user;

        if($user->hasRole('creative') && $user->account && !$user->account->creativeData) {
            \App\Models\CreativeData::create([
                'account_id' => $user->account->id,
            ]);
            $user->account->load('creativeData');
        }

        /* if($user->hasRole('admin') && $user->account && !$user->account->adminData) { */
        /*     \App\Models\AdminData::create([ */
        /*         'account_id' => $user->account->id, */
        /*     ]); */
            /* $user->account->load('AdminData'); */
        /* } */
        /* if($user->hasRole('brand') && $user->account && !$user->account->brandData) { */
        /*     \App\Models\BrandData::create([ */
        /*         'account_id' => $user->account->id, */
        /*     ]); */
            /* $user->account->load('BrandData'); */
        /* } */
    }
}

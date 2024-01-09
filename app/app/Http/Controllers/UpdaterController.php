<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class UpdaterController extends Controller
{

    public function index()
    {
        return view('updater.index');
    }

    public function update(Request $request)
    {
        $run = '<ul>';
        if($request->input('commands', false)) {
            $commands = explode(';', $request->input('commands', false));
            foreach ($commands as $command) {
                @Artisan::call($command);
                $run .= '<li>Se corrió el comando: '.$command.'</li>';
            }
        }

        $run .= '</ul>';

        return redirect('/admin/updater')->with(['status' => $run]);

    }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use \App\Models\Announcement;


class PickAnnouncementWinnersController extends Controller
{
    public function __invoke(Request $request, Announcement $announcement)
    {
        if (! $announcement->pick_winners_period) {
            return redirect()->back()->with('error', 'No se pueden elegir ganadores en este momento');
        }

        $validSubmissions = $announcement->submissions()->accepted()->get()->pluck('id')->implode(',');

        $request->validate([
            'winner_first' => 'sometimes|nullable|integer|exists:submissions,id|in:'.$validSubmissions,
            'winner_second' => 'sometimes|nullable|integer|exists:submissions,id|in:'.$validSubmissions,
            'winner_third' => 'sometimes|nullable|integer|exists:submissions,id|in:'.$validSubmissions,
        ]);

        $announcement->update([
            'winner_first' => $request->input('winner_first'),
            'winner_second' => $request->input('winner_second'),
            'winner_third' => $request->input('winner_third'),
        ]);

        return redirect()->back()->with('message', 'Ganadores actualizados');
    }
}

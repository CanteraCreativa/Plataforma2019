<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use \App\Models\Announcement;
use \App\Models\CreativeData;
use \App\Models\Submission;


class StatisticsController extends Controller
{
    public function __invoke()
    {
        $awarded_prizes = Announcement::whereDate('results_date', '<', \Carbon\Carbon::today())->sum('total_prize');
        $submitted_ideas = Submission::count();
        $registered_creatives = CreativeData::count();

        return [
            'awarded_prizes' => $awarded_prizes,
            'submitted_ideas' => $submitted_ideas,
            'registered_creatives' => $registered_creatives,
        ];
    }
}

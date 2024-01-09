<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use \App\Models\Announcement;
use \App\Models\CreativeData;
use \App\Models\Submission;
use \App\Enums\SubmissionState;


class DashboardController extends Controller
{
    public function __invoke()
    {
        $pending_submissions = Submission::where('state', SubmissionState::Pending())->get();

        $pending_announcements = Announcement::whereDate('end_date', '<', \Carbon\Carbon::today())
            ->whereDate('results_date', '>=', \Carbon\Carbon::today())
            ->where(function($query){
                $query->whereNull('winner_first')
                      ->orWhereNull('winner_second')
                      ->orWhereNull('winner_third');
            })->get();

        $last_creatives = CreativeData::latest()->limit(10)->get();

        return view('admin.dashboard')->with([
            'submissions' => $pending_submissions,
            'announcements' => $pending_announcements,
            'creativeDatas' => $last_creatives,
        ]);
    }
}

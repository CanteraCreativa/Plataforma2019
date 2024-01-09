<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ResultsDateNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emails:results_date';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends an email to subscribed users for any Announcement whose results_date is today';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $announcements = \App\Models\Announcement::whereDate('results_date', \Carbon\Carbon::today())->get();
        $this->info("Announcements finishing today: " . $announcements->count());
        foreach ($announcements as $announcement) {
            foreach ($announcement->subscribers as $subscriber) {
                $this->info("Send email for Announcement {$announcement->title} to {$subscriber->user->email}");
                \Illuminate\Support\Facades\Mail::to($subscriber->user->email)
                    ->send(new \App\Mail\ResultsDateNotification($subscriber->user, $announcement));
            }
        }
    }
}

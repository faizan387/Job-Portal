<?php

namespace App\Console\Commands;

use App\Mail\TrialEndNotification;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

/**
 * created with following command
 * php artisan make:command TrialCheckScheduler
 */
class TrialCheckScheduler extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'trial:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to check user trial expiry date';

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
     * @return int
     */
    public function handle()
    {
        try {
            $users = User::whereNotNull('user_trial')->get();
            $today = Carbon::now()->toDateString();
            foreach ($users as $user) {
                $trialEnd = Carbon::parse($user->user_trial)->toDateString();
                if ($trialEnd === $today) {
                    Mail::to($user->email)->send(new TrialEndNotification($user->name));
                }
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }

}

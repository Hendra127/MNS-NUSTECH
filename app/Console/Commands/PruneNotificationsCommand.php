<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class PruneNotificationsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notifications:prune';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete notifications older than 30 days';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $count = \Illuminate\Support\Facades\DB::table('notifications')
            ->where('created_at', '<', now()->subDays(30))
            ->delete();

        $this->info("Deleted {$count} notifications older than 30 days.");
    }
}

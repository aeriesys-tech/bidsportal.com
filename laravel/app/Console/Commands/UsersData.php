<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\DatabaseController;

class UsersData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:users-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = new DatabaseController;  
        $users->transferUsersData();
    }
}

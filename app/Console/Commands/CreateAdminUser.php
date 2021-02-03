<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Console\Command;

class CreateAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:admin {login} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $repo = app(UserRepository::class);
        $repo->create([
            'login' => $this->argument('login'),
            'email' => $this->argument('login'),
            'password' => bcrypt($this->argument('password')),
        ]);

        return 0;
    }
}

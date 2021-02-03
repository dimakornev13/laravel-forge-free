<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CheckSystem extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:system';

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
        $this->checkDirectory('/etc/nginx/sites-available');
        $this->checkDirectory('/etc/nginx/sites-enabled');
        $this->checkDirectory('/etc/supervisor/conf.d');


        $command = "sudo service php7.4-fpm restart 2>&1";
        $result = shell_exec($command);
        if(empty($result))
            $this->info("Command is ok {$command}");
        else
            $this->error("Command ({$command}) produces next result ({$result})");


        $command = "sudo service nginx restart 2>&1";
        $result = shell_exec($command);
        if(empty($result))
            $this->info("Command is ok {$command}");
        else
            $this->error("Command ({$command}) produces next result ({$result})");


        $command = "sudo certbot 2>&1";
        $result = shell_exec($command);
        if(empty($result))
            $this->info("Command is ok {$command}");
        else
            $this->error("Command ({$command}) produces next result ({$result})");


        $user = getHostUser();
        $command = "crontab -u {$user} -l";
        $result = trim(shell_exec($command));
        if(!empty($result))
            $this->info("crontab produces next result {$result}");
        else
            $this->error("crontab is empty");



        return 0;
    }

    private function checkDirectory($path){
        $result = is_writable($path);

        if(!$result){
            $this->error("Directory is not writable {$path}");

            return;
        }

        $this->info("Directory {$path} is writable");
    }



}

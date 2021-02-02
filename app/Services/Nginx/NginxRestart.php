<?php


namespace App\Services\Nginx;


class NginxRestart extends ServerRestart
{

    function process(): void
    {
        shell_exec('sudo service nginx restart');

        $this->result = 'Nginx has been restarted ok';
    }
}

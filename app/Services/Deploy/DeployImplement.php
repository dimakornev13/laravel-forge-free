<?php


namespace App\Services\Deploy;


use App\Models\Site;

class DeployImplement extends Deploy
{

    function deploy(Site $site)
    {
        $user = getHostUser();

        file_put_contents("/home/{$user}/{$site->getUrl()}/.env", $site->getEnvironment());

        $this->result = shell_exec($site->getDeployScript());
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    use HasFactory;

    protected $table = 'sites';

    protected $fillable = [
        'url',
        'deploy_script',
        'repository',
        'environment',
    ];

    protected $guarded = ['*'];


    /**
     * @return mixed
     */
    function getUrl()
    {
        return $this->url;
    }


    /**
     * @return mixed
     */
    function getId()
    {
        return $this->id;
    }


    function getDeployScript()
    {
        return cleanFromR($this->deploy_script ?? '');
    }


    function getRepository()
    {
        return $this->repository;
    }


    function getEnvironment()
    {
        return cleanFromR($this->environment ?? getDefaultEnvironment());
    }


    function setDeployScript($value)
    {
        $this->deploy_script = $value;
    }


    function queues()
    {
        return $this->hasMany(Queue::class);
    }


    function getSiteDir()
    {
        $user = getHostUser();
        return "/home/{$user}/$this->url/www";
    }

    function getEnvDir(){
        $user = getHostUser();
        return "/home/{$user}/$this->url/.env";
    }
}

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


    function getCleanUrl()
    {
        return str_replace(['-', '.'], '', $this->getUrl());
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
        $key = strtolower($this->getUrl());
        $key = str_replace(['-', '.'], '_', $key);

        $default = str_replace('CACHE_PREFIX=panel', "CACHE_PREFIX={$key}", getDefaultEnvironment());
        return cleanFromR($this->environment ?? $default);
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


    function getEnvPath()
    {
        $user = getHostUser();
        return "/home/{$user}/$this->url/.env";
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    use HasFactory;

    protected $table = 'sites';

    protected $fillable = [
        'url'
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
}

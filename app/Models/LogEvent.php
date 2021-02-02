<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogEvent extends Model
{
    use HasFactory;

    const TYPE_ERROR = 1;
    const TYPE_WARNING = 2;
    const TYPE_NOTIFICATION = 3;
    const TYPE_SUCCESS = 4;

    protected $table = 'events';

    protected $fillable = [
        'type', 'content'
    ];

    protected $guarded = ['*'];


    function getMessage()
    {
        return $this->content;
    }


    function getId()
    {
        return $this->id;
    }


    function getDate()
    {
        return $this->created_at->toDateTimeString();
    }


    function getLabelColor()
    {
        switch ($this->type) {
            case self::TYPE_SUCCESS:
                return 'green';
                break;

            case self::TYPE_ERROR:
                return 'red';
                break;

            case self::TYPE_NOTIFICATION:
                return 'yellow';
                break;

            case self::TYPE_WARNING:
                return 'blue';
                break;
        }
    }
}

<?php

namespace App\Models\Backend\V1;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class SMTPModel extends Model
{
    use HasFactory;

    protected $table = 'smtp';

    public static function getSingleFirst()
    {
        return self::find(1);
    }
}

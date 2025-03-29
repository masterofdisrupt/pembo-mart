<?php

namespace App\Models\Backend\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventsModel extends Model
{
    use HasFactory;

    protected $table = 'events';

    protected $fillable = [
        'title',
        'start',
        'end'
    ];
    protected $dates = ['start', 'end'];
}

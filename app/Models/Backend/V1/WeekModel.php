<?php

namespace App\Models\Backend\V1;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Backend\V1\UserTimeModel;


class WeekModel extends Model
{
    use HasFactory;

    protected $table = 'week';

     protected $fillable = ['name'];

    /**
     * Get the user times for this week
     */
    public function userTimes()
    {
        return $this->hasMany(UserTimeModel::class, 'week_id');
    }
}

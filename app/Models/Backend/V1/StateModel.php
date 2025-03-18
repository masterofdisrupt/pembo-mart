<?php

namespace App\Models\Backend\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StateModel extends Model
{
    use HasFactory;

    protected $table = 'states';

    protected $fillable = ['country_id', 'state_name']; // Add 'name' to allow mass assignment
}

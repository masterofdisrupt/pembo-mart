<?php

namespace App\Models\Backend\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatesModel extends Model
{
    use HasFactory;

    protected $table = 'states';

    protected $fillable = ['countries_id', 'states_name']; // Add 'name' to allow mass assignment
}

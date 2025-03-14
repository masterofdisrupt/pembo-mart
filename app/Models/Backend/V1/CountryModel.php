<?php

namespace App\Models\Backend\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CountryModel extends Model
{
    use HasFactory;

    protected $table = 'countries';

    protected $fillable = ['name', 'code']; // Add 'name' to allow mass assignment

}

<?php

namespace App\Models\Backend\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductColoursModel extends Model
{
    use HasFactory;

    protected $table = 'product_colours';
    protected $fillable = [
        'product_id',
        'colour_id',
    ];
}

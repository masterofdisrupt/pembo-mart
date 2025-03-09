<?php

namespace App\Models\Backend\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdersDetailsModel extends Model
{
    use HasFactory;

    protected $table = 'orders_details';

    protected $fillable = ['orders_id', 'colour_id'];
    
}

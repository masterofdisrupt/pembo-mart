<?php

namespace App\Models\Backend\V1;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ComposeEmailModel extends Model
{
    use HasFactory;

    protected $table = 'compose_email';

    protected $fillable = ['is_delete'];

    static public function getSingleEmail($id)
    {
        return self::find($id);
    }
}

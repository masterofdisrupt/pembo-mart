<?php

namespace App\Models\Backend\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class SupportReplysModel extends Model
{
    use HasFactory;

    protected $table = 'support_replys';
    protected $fillable = [
        'support_id',
        'reply',
        'user_id',
        'is_delete',
    ];
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'support_id' => 'integer',
        'user_id' => 'integer',
        'is_delete' => 'integer',
        'reply' => 'string',
    ];
    /**
     * Get all support replies with filters
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */

     public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

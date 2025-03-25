<?php

namespace App\Models\Backend\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Request;

class TransactionsModel extends Model
{
    use HasFactory;

    protected $table = 'transactions';

     // Define the relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

   // Fetch transaction records for a specific user (agent) and paginate the results
    public static function getAgentRecord($user_id)
    {
        return self::with('user')
            ->where('user_id', $user_id)
            ->orderBy('id', 'desc')
            ->paginate(50);
    }
}



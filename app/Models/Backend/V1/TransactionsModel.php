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

    public static function getAgentRecord($user_id)
    {
        return self::select('transactions.*', 'users.name')
            ->join('users', 'users.id', '=', 'transactions.user_id')
            ->where('transactions.user_id', '=', $user_id)
            ->orderBy('transactions.id', 'desc')
            ->paginate(50);
    }
}



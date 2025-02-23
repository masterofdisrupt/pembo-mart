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

    public static function getAgentRecord($user_id)
    {
        return self::select('compose_email.*')
            ->where('compose_email.user_id', '=', $user_id)
            ->where('is_sent', 0)
            ->where('is_delete', 0)
            ->orderBy('created_at', 'desc')
            ->paginate(40);
    }
}

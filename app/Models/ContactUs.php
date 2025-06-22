<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Request;

class ContactUs extends Model
{
    use HasFactory;

    protected $table = 'contact_us';
    protected $fillable = [
        'name',
        'email',
        'subject',
        'message',
        'created_at',
        'updated_at'
    ];

    public static function getSingleRecord($id)
    {
        return self::find($id);
    }

    public static function getRecord()
    {
        $return = self::select('contact_us.*');

        if(!empty(Request::get('id')))
        {
            $return = $return->where('id', '=', Request::get('id'));
        }

        if(!empty(Request::get('name')))
        {
            $return = $return->where('name', 'like', '%'.Request::get('name'). '%');
        }

        if(!empty(Request::get('email')))
        {
            $return = $return->where('email', 'like', '%'.Request::get('email'). '%');
        }

        if(!empty(Request::get('phone')))
        {
            $return = $return->where('phone', 'like', '%'.Request::get('phone'). '%');
        }

        if(!empty(Request::get('subject')))
        {
            $return = $return->where('subject', 'like', '%'.Request::get('subject'). '%');
        }
            $return = $return->orderBy('contact_us.id', 'desc')
            ->paginate(20);
        return $return;
    }

    public function getUser()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

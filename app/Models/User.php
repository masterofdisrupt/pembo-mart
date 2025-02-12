<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Request;


class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'middle_name',
        'surname',
        'username',
        'email',
        'phone',
        'address',
        'about',
        'website',
        'photo',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    static public function getEmailSingle($email)
    {
        return User::where('email', '=', $email)->first();
    }

    static public function getTokenSingle($remember_token)
    {
        return User::where('remember_token', '=', $remember_token)->first();
    }

    static public function getRecord($request)
    {

        $return = self::select('users.*')
            ->where('is_delete', '=', 0)
            ->orderBy('id', 'desc');

        // Search start
        if (!empty($request->id)) {
            $return = $return->where('users.id', '=', $request->id);
        }

        if (!empty($request->name)) {
            $return = $return->where('users.name', 'like', '%' . $request->name . '%');
        }

        if (!empty($request->middle_name)) {
            $return = $return->where('users.middle_name', 'like', '%' . $request->middle_name . '%');
        }

        if (!empty($request->surname)) {
            $return = $return->where('users.surname', 'like', '%' . $request->surname . '%');
        }

        if (!empty($request->username)) {
            $return = $return->where('users.username', 'like', '%' . $request->username . '%');
        }

        if (!empty($request->email)) {
            $return = $return->where('users.email', 'like', '%' . $request->email . '%');
        }

        if (!empty($request->phone)) {
            $return = $return->where('users.phone', 'like', '%' . $request->phone . '%');
        }

        if (!empty($request->address)) {
            $return = $return->where('users.address', 'like', '%' . $request->address . '%');
        }

        if (!empty($request->role)) {
            $return = $return->where('users.role', 'like', '%' . $request->role . '%');
        }

        if (!empty($request->status)) {
            $return = $return->where('users.status', '=', $request->status);
        }


        if (!empty(Request::get('start_date')) && !empty(Request::get('end_date'))) {
            $return = $return->where('users.created_at', '>=', Request::get('start_date'))->where('users.created_at', '<=', Request::get('end_date'));
        }

        //search end

        $perPage = $request->get('per_page', 100); // Default pagination limit
        return $return->paginate($perPage);
    }

    public function getProfile()
    {
        if (!empty($this->photo) && file_exists('public/backend/upload/profile/' . $this->photo)) {
            return url('public/backend/upload/profile/' . $this->photo);
        } else {
            return url('public/backend/upload/profile/user.png');
        }
    }

}

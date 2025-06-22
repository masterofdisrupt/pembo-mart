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
        'password',
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
        'token',
        'password_reset_expires',
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
            'email_verification_sent_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    static public function getSingle($id) 
    {
        return User::where('id', '=', $id)->first();    
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
        ->where('is_delete', 0)
        ->orderBy('id', 'desc');

    $return->when($request->id, fn($query) => $query->where('users.id', $request->id));
    $return->when($request->name, fn($query) => $query->where('users.name', 'like', "%{$request->name}%"));
    $return->when($request->middle_name, fn($query) => $query->where('users.middle_name', 'like', "%{$request->middle_name}%"));
    $return->when($request->surname, fn($query) => $query->where('users.surname', 'like', "%{$request->surname}%"));
    $return->when($request->username, fn($query) => $query->where('users.username', 'like', "%{$request->username}%"));
    $return->when($request->email, fn($query) => $query->where('users.email', 'like', "%{$request->email}%"));
    $return->when($request->phone, fn($query) => $query->where('users.phone', 'like', "%{$request->phone}%"));
    $return->when($request->address, fn($query) => $query->where('users.address', 'like', "%{$request->address}%"));
    $return->when($request->role, fn($query) => $query->where('users.role', 'like', "%{$request->role}%"));
    $return->when($request->status, fn($query) => $query->where('users.status', $request->status));

    if (!empty($request->start_date) && !empty($request->end_date)) {
        $return->whereBetween('users.created_at', [$request->start_date, $request->end_date]);
    }

    $perPage = is_numeric($request->per_page) ? (int) $request->per_page : 10;
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

    /**
     * Check if the user is an admin
     *
     * @return bool
     */

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Get user's avatar URL
     *
     * @return string
     */

    public function getAvatarUrlAttribute(): string
    {
        return $this->avatar 
            ? asset('storage/' . $this->avatar)
            : 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&color=7F9CF5&background=EBF4FF';
    }

    static public function checkemail($email)
    {
        return User::where('email', '=', $email)->first();
    }

    public static function getCustomer()
    {
        $return = self::select('users.*')
            ->where('is_delete', 0)
            ->where('role', 'user')
            ->orderBy('id', 'desc');
        $return->when(Request::get('first_name'), fn($query) => $query->where('users.name', 'like', "%" . Request::get('name') . "%"));
        $return->when(Request::get('email'), fn($query) => $query->where('users.email', 'like', "%" . Request::get('email') . "%"));
        $return->when(Request::get('start_date') && Request::get('end_date'), function ($query) {
            $query->whereBetween('users.created_at', [Request::get('start_date'), Request::get('end_date')]);
        });
        $perPage = is_numeric(Request::get('per_page')) ? (int) Request::get('per_page') : 10;
        return $return->paginate($perPage);
    }

}


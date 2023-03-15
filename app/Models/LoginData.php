<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginData extends Model
{
    use HasFactory;

//    protected $table = 'login_data';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'access_token',
        'refresh_token',
        'expires_at',
        'refresh_expires_at',
        'last_active_date'
    ];

    /**
     * Get the user that owns the login data.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

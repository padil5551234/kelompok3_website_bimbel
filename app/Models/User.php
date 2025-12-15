<?php

namespace App\Models;

use App\Models\Ujian;
use App\Traits\Uuids;
use App\Models\Session;
use App\Models\Voucher;
use App\Models\Pembelian;
use App\Models\UjianUser;
use App\Models\UsersDetail;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Jetstream\HasProfilePhoto;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

// Email verification enabled
class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;
    use Uuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'google_id',
        'email_verified_at',
        'profile_photo_path',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Add a mutator to ensure hashed passwords
     */
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get all of the pembelian for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pembelian()
    {
        return $this->hasMany(Pembelian::class, 'user_id');
    }

    /**
     * Get all of the sessions for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sessions()
    {
        return $this->hasMany(Session::class, 'user_id', 'id');
    }

    /**
     * Get all of the ujianUser for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ujianUser()
    {
        return $this->hasMany(UjianUser::class, 'user_id', 'id');
    }

    /**
     * Get the usersDetail associated with the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function usersDetail()
    {
        return $this->hasOne(UsersDetail::class, 'id', 'id');
    }

    /**
     * Get all of the live classes for the User (tutor)
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function liveClasses()
    {
        return $this->hasMany(LiveClass::class, 'tutor_id', 'id');
    }

    /**
     * Get all of the materials for the User (tutor)
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function materials()
    {
        return $this->hasMany(Material::class, 'tutor_id', 'id');
    }

    /**
     * Check if user is a tutor
     *
     * @return bool
     */
    public function isTutor()
    {
        return $this->hasRole('tutor');
    }

    /**
     * Mark email as verified
     *
     * @return bool
     */
    public function markEmailAsVerified()
    {
        return $this->forceFill([
            'email_verified_at' => $this->freshTimestamp(),
        ])->save();
    }

    /**
     * Check if user email is verified
     *
     * @return bool
     */
    public function hasVerifiedEmail()
    {
        return ! is_null($this->email_verified_at);
    }

}

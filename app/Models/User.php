<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable //implements MustVerifyEmail
{



    use HasRoles;
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    // use HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    // Application relationships inferred from migrations
    public function salesCreated()
    {
        return $this->hasMany(Sale::class, 'created_by');
    }

    public function purchaseItemsCreated()
    {
        return $this->hasMany(PurchaseItem::class, 'created_by');
    }

    public function expensesCreated()
    {
        return $this->hasMany(Expense::class, 'created_by');
    }

    public function approvedReturns()
    {
        return $this->hasMany(Returns::class, 'approved_by');
    }

    public function auditLogs()
    {
        return $this->hasMany(AuditLog::class, 'user_id');
    }


    public function subject(){
        return $this->belongsTo(Subject::class,'subject_id');
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
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
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        // 'id'=>'string'
    ];

    public function setNameAttribute($value){
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    public function getIsAdminAttribute()
    {
        return $this->role === 'admin'; // Assuming 'admin' is the role for administrators
    }


    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
        // 'is_admin',
    ];




}

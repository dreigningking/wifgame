<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use PDO;
use App\Models\Business;
use App\Models\BusinessUser;
use Laravel\Sanctum\HasApiTokens;
use ALajusticia\Logins\Traits\HasLogins;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, HasLogins, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    

    protected $fillable = [
        'firstname','surname','email','password','role_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime','dob' => 'datetime',
    ];

    
    public function role(){
        return $this->belongsTo(Role::class);
    }
    
    public function password_histories(){
        return $this->hasMany(PasswordHistory::class);
    }

    

    public function getNameAttribute()
    {
        return ucwords($this->surname).' '.ucwords($this->firstname);
    }

    public function business(){
        return $this->belongsTo(Business::class);
    }

    public function businesses(){
        return $this->belongsToMany(Business::class,'business_users','user_id','business_id');
    }
  
    public function routeNotificationForNexmo($notification)
    {
        return $this->mobile;
    }
    public function receivesBroadcastNotificationsOn(){
        return 'users.'.$this->id;
    }
    public function isRole($role){
        return $this->role == $role;
    }
    

    public function subscription(): HasOne
    {
        return $this->hasOne(Subscription::class)->latest();
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }

    public function activePlan(): ?Plan
    {
        return $this->subscription?->isActive() ? $this->subscription->plan : null;
    }

    public function getCalculationCount(string $calculatorType): int
    {
        $className = "App\\Models\\Calculations\\{$calculatorType}Calculation";
        return $this->calculations()->where('calculator_type', $className)->count();
    }

    public function canUseCalculator(Calculator $calculator): bool
    {
        if ($calculator->status !== 'active') {
            return false;
        }

        // If calculator doesn't belong to any plan, it's free to use
        if (!$calculator->isPremium()) {
            return true;
        }

        $plan = $this->activePlan();
        if (!$plan) {
            return false;
        }

        if (!$plan->hasCalculatorAccess($calculator)) {
            return false;
        }

        $limit = $plan->getCalculatorLimit($calculator);
        if ($limit === null) {
            return true; // Unlimited access
        }

        $used = $this->getCalculatorUsage($calculator);
        return $used < $limit;
    }

    public function getCalculatorUsage(Calculator $calculator): int
    {
        $className = $calculator->getModelClass();
        
        return $this->calculations()
            ->where('calculator_type', $className)
            ->whereMonth('created_at', now()->month)
            ->count();
    }

    public function getCalculatorFeatures(Calculator $calculator): array
    {
        $plan = $this->activePlan();
        if (!$plan) {
            return [];
        }

        return $plan->getCalculatorFeatures($calculator);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Spatie\Activitylog\LogOptions;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens, HasFactory, Notifiable,
        HasRoles, SoftDeletes, LogsActivity;

    protected $fillable = [
        'name',
        'email',
        'is_active',
        'language',
        'preferred_currency_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    /**
     * Определяем, какие изменения логируются
     */
    protected static $logAttributes = ['*']; // Логируем ВСЕ поля
    protected static $logOnlyDirty = true; // Логируем только изменения
    protected static $logName = 'user'; // Имя логов

    /**
     * Определяет, какие события логировать
     */
    public function getDescriptionForEvent(string $eventName): string
    {
        return "Пользователь был {$eventName}";
    }


    /**
     * Связь с рабочим пространством, которым пользователь владеет
     */
    public function ownedTeam(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Team::class, 'owner_id');
    }

    /**
     * Связь с таблицей валют
     */
    public function preferredCurrency(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Currency::class, 'preferred_currency_id');
    }
    public function transactionCategories(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(TransactionCategory::class);
    }
    public function memberships(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Membership::class);
    }

    public function teams()
    {
        return $this->belongsToMany(Team::class, 'memberships')
            ->withPivot('role')
            ->withTimestamps();
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->map(fn (string $name) => Str::of($name)->substr(0, 1))
            ->implode('');
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll() // Логировать все изменения
            ->useLogName('users') // Имя лога
            ->logOnlyDirty(); // Логировать только изменённые поля
    }
}

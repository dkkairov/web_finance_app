<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Workspace extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    public const TYPE_PERSONAL = 'personal';
    public const TYPE_BUSINESS = 'business';

    protected $fillable = [
        'name',
        'slug',
        'owner_id',
        'is_active',
        'type', // Добавили 'type'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Определяем, какие изменения логируются
     */
    protected static $logAttributes = ['*']; // Логируем ВСЕ поля
    protected static $logOnlyDirty = true; // Логируем только изменения
    protected static $logName = 'workspace'; // Имя логов

    /**
     * Определяет, какие события логировать
     */
    public function getDescriptionForEvent(string $eventName): string
    {
        return "Рабочее пространство было {$eventName}";
    }

    /**
     * Связь с владельцем (User)
     */
    public function memberships(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Membership::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'memberships')
            ->withPivot('role')
            ->withTimestamps();
    }

    public function owner()
    {
        return $this->hasOne(Membership::class)->where('role', 'owner');
    }


    /**
     * Связь с аккаунтами (счета)
     */
    public function accounts()
    {
        return $this->hasMany(Account::class);
    }

    /**
     * Связь с операциями (транзакции)
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Связь с проектами
     */
    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    /**
     * Связь с лимитами
     */
    public function limits()
    {
        return $this->hasMany(Limit::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll() // Логировать все изменения
            ->useLogName('workspaces') // Имя лога
            ->logOnlyDirty(); // Логировать только изменённые поля
    }
}

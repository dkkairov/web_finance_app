<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Currency extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = [
        'code',
        'name',
        'symbol',
    ];

    /**
     * Определяем, какие изменения логируются
     */
    protected static $logAttributes = ['*']; // Логируем все изменения
    protected static $logOnlyDirty = true; // Логируем только измененные поля
    protected static $logName = 'currency'; // Имя логов

    /**
     * Описание логов
     */
    public function getDescriptionForEvent(string $eventName): string
    {
        return "Валюта была {$eventName}";
    }

    /**
     * Связь с пользователями, выбравшими эту валюту
     */
    public function users(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(User::class, 'preferred_currency_id');
    }

    public function accounts(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Account::class, 'currency_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll() // Логируем все изменения
            ->useLogName('currency');
    }
}

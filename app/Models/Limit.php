<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Limit extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = [
        'user_id',
        'transaction_category_id',
        'amount',
        'currency_id',
        'period', // Например, "monthly", "weekly", "daily"
        'is_active',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    /**
     * Конфигурация логирования
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->useLogName('limit');
    }

    /**
     * Связь с пользователем (кому принадлежит лимит)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Связь с категорией транзакции
     */
    public function transactionCategory()
    {
        return $this->belongsTo(TransactionCategory::class);
    }

    /**
     * Связь с валютой
     */
    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
}

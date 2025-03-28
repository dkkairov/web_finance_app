<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Transaction extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = [
        'user_id',
        'transaction_type',
        'amount',
        'transaction_category_id',
        'account_id',
        'project_id',
        'description',
        'date',
        'is_active',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'date' => 'datetime',
        'is_active' => 'boolean',
    ];

    /**
     * Логирование всех изменений
     */
    protected static $logAttributes = ['*'];
    protected static $logOnlyDirty = true;
    protected static $logName = 'transaction';

    /**
     * Описание логов
     */
    public function getDescriptionForEvent(string $eventName): string
    {
        return "Транзакция была {$eventName}";
    }

    /**
     * Связь с пользователем
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
     * Связь с проектом (если транзакция связана с проектом)
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->useLogName('transaction');
    }
}

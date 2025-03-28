<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class TransactionCategory extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = ['name', 'user_id'];

    /**
     * Конфигурация логирования
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->useLogName('transaction_category');
    }

    /**
     * Связь с пользователем (владелец категории)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Связь с транзакциями
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'transaction_category_id');
    }
}

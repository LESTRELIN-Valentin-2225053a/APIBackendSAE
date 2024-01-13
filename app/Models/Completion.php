<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Completion extends Model
{
    protected $table= 'completion';
    protected $primaryKey = ['user_id', 'investigation_id'];
    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'investigation_id',
        'completion',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function investigation(): BelongsTo
    {
        return $this->belongsTo(Investigation::class, 'investigation_id', 'investigation_id');
    }
}

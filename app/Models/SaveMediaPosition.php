<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class SaveMediaPosition extends Model
{
    protected $primaryKey = ['user_id', 'investigation_id', 'media_id'];
    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'investigation_id',
        'media_id',
        'posY',
        'posX',
    ];

    // Define relationships if needed
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function investigation(): BelongsTo
    {
        return $this->belongsTo(Investigation::class, 'investigation_id', 'investigation_id');
    }

    public function media(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'media_id', 'media_id');
    }
}

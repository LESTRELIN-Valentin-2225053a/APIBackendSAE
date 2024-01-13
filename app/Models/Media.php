<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;


class Media extends Model
{
    protected $table = 'media';
    protected $primaryKey = 'media_id';
    public $incrementing = true;

    protected $fillable = [
        'investigation_id',
        'link',
    ];

    // Define relationships if needed
    public function investigation(): BelongsTo
    {
        return $this->belongsTo(Investigation::class, 'investigation_id', 'investigation_id');
    }

    public function saveMediaPosition(): HasOne
    {
        return $this->hasOne(SaveMediaPosition::class, 'media_id', 'media_id');
    }
}

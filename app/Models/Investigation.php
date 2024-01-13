<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Investigation extends Model
{
    protected $table = 'investigations';
    protected $primaryKey = 'investigation_id';
    public $incrementing = true;

    protected $fillable = [
        'title',
    ];

    // Define relationships if needed
    public function saveMediaPosition(): HasMany
    {
        return $this->hasMany(SaveMediaPosition::class, 'investigation_id', 'investigation_id');
    }

    public function completion(): HasMany
    {
        return $this->hasMany(Completion::class, 'investigation_id', 'investigation_id');
    }

    public function media()
    {
        return $this->hasMany(Media::class, 'investigation_id', 'investigation_id');
    }
}

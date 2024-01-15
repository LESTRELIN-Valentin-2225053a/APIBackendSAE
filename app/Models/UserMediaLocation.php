<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class UserMediaLocation
 *
 * @property int $media_location_id
 * @property int $user_media_id
 *
 * @property MediaLocation $media_location
 * @property Media $medium
 *
 * @package App\Models
 */
class UserMediaLocation extends Model
{
	protected $table = 'user_media_location';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'media_location_id' => 'int',
		'user_media_id' => 'int'
	];

	public function media_location(): BelongsTo
    {
		return $this->belongsTo(MediaLocation::class);
	}

	public function media(): BelongsTo
    {
		return $this->belongsTo(Media::class, 'user_media_id');
	}
}

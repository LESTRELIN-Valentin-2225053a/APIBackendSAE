<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class UserMediaPosition
 *
 * @property int $user_id
 * @property int $investigation_id
 * @property int $media_id
 * @property float $posY
 * @property float $posX
 *
 * @property Investigation $investigation
 * @property Media $medium
 * @property User $user
 *
 * @package App\Models
 */
class UserMediaPosition extends Model
{
	protected $table = 'user_media_position';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'user_id' => 'int',
		'investigation_id' => 'int',
		'media_id' => 'int',
		'posY' => 'float',
		'posX' => 'float'
	];

	protected $fillable = [
		'posY',
		'posX'
	];

	public function investigation(): BelongsTo
    {
		return $this->belongsTo(Investigation::class);
	}

	public function media(): BelongsTo
    {
		return $this->belongsTo(Media::class, 'media_id');
	}

	public function user(): BelongsTo
    {
		return $this->belongsTo(User::class);
	}
}

<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class MediaLocation
 *
 * @property int $id
 * @property int $investigation_id
 * @property int $expected_media_id
 * @property string $description
 * @property float $x
 * @property float $y
 *
 * @property Investigation $investigation
 * @property Media $medium
 * @property Collection|UserMediaLocation[] $user_media_locations
 *
 * @package App\Models
 */
class MediaLocation extends Model
{
	protected $table = 'media_locations';
	public $timestamps = false;

	protected $casts = [
		'investigation_id' => 'int',
		'expected_media_id' => 'int',
		'x' => 'float',
		'y' => 'float'
	];

	protected $fillable = [
		'investigation_id',
		'expected_media_id',
		'description',
		'x',
		'y'
	];

	public function investigation(): BelongsTo
    {
		return $this->belongsTo(Investigation::class);
	}

	public function media() : BelongsTo
	{
		return $this->belongsTo(Media::class, 'expected_media_id');
	}

	public function user_media_locations(): HasMany
    {
		return $this->hasMany(UserMediaLocation::class);
	}
}

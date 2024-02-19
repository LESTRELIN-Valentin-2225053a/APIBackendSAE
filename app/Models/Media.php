<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Media
 *
 * @property int $media_id
 * @property string $description
 * @property bool $isTrustworthy
 * @property string $type
 * @property string $link
 * @property string $picture
 *
 * @property Collection|MediaLocation[] $media_locations
 * @property Collection|MediaUsedByInvestigation[] $media_used_by_investigations
 * @property Collection|UserMediaLocation[] $user_media_locations
 * @property Collection|UserMediaPosition[] $user_media_positions
 *
 * @package App\Models
 */
class Media extends Model
{
	protected $table = 'media';
	protected $primaryKey = 'media_id';
	public $timestamps = false;

	protected $casts = [
		'isTrustWorthy' => 'bool',
        'trustWorthy' => 'bool'
	];

	protected $fillable = [
		'description',
		'isTrustworthy',
		'type',
		'link',
		'picture'
	];

	public function media_locations(): HasMany
    {
		return $this->hasMany(MediaLocation::class, 'expected_media_id');
	}

	public function media_used_by_investigations(): HasMany
    {
		return $this->hasMany(MediaUsedByInvestigation::class, 'media_id');
	}

	public function user_media_locations(): HasMany
    {
		return $this->hasMany(UserMediaLocation::class, 'user_media_id');
	}

	public function user_media_positions(): HasMany
    {
		return $this->hasMany(UserMediaPosition::class, 'media_id');
	}
}

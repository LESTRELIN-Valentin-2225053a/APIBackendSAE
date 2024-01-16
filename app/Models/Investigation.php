<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Investigation
 *
 * @property int $investigation_id
 * @property string $title
 * @property string $description
 * @property string $board_type
 *
 * @property Collection|Completion[] $completions
 * @property Collection|MediaLocation[] $media_locations
 * @property Collection|MediaUsedByInvestigation[] $media_used_by_investigations
 * @property Collection|UserMediaPosition[] $user_media_positions
 * @property Collection|Website[] $websites
 *
 * @package App\Models
 */
class Investigation extends Model
{
	protected $table = 'investigations';
	protected $primaryKey = 'investigation_id';
	public $timestamps = false;

    protected $casts = [
        'completion' => 'bool'
    ];

	protected $fillable = [
		'title',
		'description',
		'board_type'
	];

	public function completions(): HasMany
    {
		return $this->hasMany(Completion::class);
	}

	public function media_locations(): HasMany
    {
		return $this->hasMany(MediaLocation::class);
	}

	public function media_used_by_investigations(): HasMany
    {
		return $this->hasMany(MediaUsedByInvestigation::class);
	}

	public function user_media_positions(): HasMany
    {
		return $this->hasMany(UserMediaPosition::class);
	}

	public function websites(): BelongsToMany
    {
		return $this->belongsToMany(Website::class, 'websites_used_by_investigation');
	}
}

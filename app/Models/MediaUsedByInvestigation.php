<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class MediaUsedByInvestigation
 *
 * @property int $investigation_id
 * @property int $media_id
 * @property float $defaultPosX
 * @property float $defaultPosY
 *
 * @property Investigation $investigation
 * @property Media $medium
 *
 * @package App\Models
 */
class MediaUsedByInvestigation extends Model
{
	protected $table = 'media_used_by_investigation';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'investigation_id' => 'int',
		'media_id' => 'int',
		'defaultPosX' => 'float',
		'defaultPosY' => 'float'
	];

	protected $fillable = [
        'investigation_id',
        'media_id',
		'defaultPosX',
		'defaultPosY'
	];

	public function investigation(): BelongsTo
    {
		return $this->belongsTo(Investigation::class);
	}

	public function media(): BelongsTo
    {
		return $this->belongsTo(Media::class, 'media_id');
	}
}

<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class WebsitesUsedByInvestigation
 *
 * @property int $investigation_id
 * @property int $website_id
 *
 * @property Investigation $investigation
 * @property Website $website
 *
 * @package App\Models
 */
class WebsitesUsedByInvestigation extends Model
{
	protected $table = 'websites_used_by_investigation';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'investigation_id' => 'int',
		'website_id' => 'int'
	];

	public function investigation(): BelongsTo
    {
		return $this->belongsTo(Investigation::class);
	}

	public function website(): BelongsTo
    {
		return $this->belongsTo(Website::class);
	}
}

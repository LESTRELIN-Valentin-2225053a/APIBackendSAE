<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Website
 *
 * @property int $id
 * @property string $title
 * @property string $link
 * @property string $icon
 *
 * @property Collection|Investigation[] $investigations
 *
 * @package App\Models
 */
class Website extends Model
{
	protected $table = 'websites';
	public $timestamps = false;

	protected $fillable = [
		'title',
		'link',
		'icon'
	];

	public function investigations(): BelongsToMany
    {
		return $this->belongsToMany(Investigation::class, 'websites_used_by_investigation');
	}
}

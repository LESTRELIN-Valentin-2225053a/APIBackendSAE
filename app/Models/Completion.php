<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Completion
 *
 * @property int $user_id
 * @property int $investigation_id
 * @property bool $completion
 *
 * @property Investigation $investigation
 * @property User $user
 *
 * @package App\Models
 */
class Completion extends Model
{
	protected $table = 'completion';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'user_id' => 'int',
		'investigation_id' => 'int',
		'completion' => 'bool'
	];

	protected $fillable = [
		'completion'
	];

    public function investigation(): BelongsTo
    {
		return $this->belongsTo(Investigation::class);
	}

	public function user(): BelongsTo
    {
		return $this->belongsTo(User::class);
	}
}

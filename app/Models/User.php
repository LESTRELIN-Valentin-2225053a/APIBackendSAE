<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class User
 *
 * @property int $user_id
 * @property string $name
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property Collection|Completion[] $completions
 * @property Collection|UserMediaPosition[] $user_media_positions
 *
 * @package App\Models
 */
class User extends Authenticatable
{
	protected $table = 'users';
	protected $primaryKey = 'user_id';

	protected $casts = [
		'email_verified_at' => 'datetime'
	];

	protected $hidden = [
		'password',
		'remember_token'
	];

	protected $fillable = [
		'name',
		'email',
		'email_verified_at',
		'password',
		'remember_token'
	];

	public function completions(): HasMany
    {
		return $this->hasMany(Completion::class);
	}

	public function user_media_positions(): HasMany
    {
		return $this->hasMany(UserMediaPosition::class);
	}
}

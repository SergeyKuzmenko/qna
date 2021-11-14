<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Profile extends Model
{
    use HasFactory;

    /**
     * @var array[]
     */
    protected $fillable = ['username', 'first_name', 'last_name', 'short_about', 'about', 'avatar'];
    /**
     * @var array[]
     */
    protected $appends = ['full_name'];
    /**
     * @var array[]
     */
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return string
     */
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * @return string
     */
    public function getAvatarAttribute()
    {
        return $this->attributes['avatar'] ? $this->attributes['avatar'] : asset('img/default.png');
    }

    /**
     * @return string
     */
    public function getLinkAttribute()
    {
        return route('user', ['username' => $this->username]);
    }


}

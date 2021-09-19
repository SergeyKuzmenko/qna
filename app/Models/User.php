<?php

namespace App\Models;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * @var array[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * @var array[]
     */
    protected $hidden = [
        'password',
        'remember_token',
        'created_at',
        'updated_at',
        'email_verified_at'
    ];

    /**
     * @var array[]
     */
    protected $with = ['profile'];

    /**
     * @var array[]
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @return HasOne
     */
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    /**
     * @return HasMany
     */
    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    /**
     * @return HasMany
     */
    public function answers()
    {
        return $this->hasMany(Answer::class, 'user_id', 'id');
    }

    /**
     * @return BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'user_tag');
    }


    /**
     * @return LengthAwarePaginator
     */
    public function getUsersByDefault()
    {
        return $this
            ->with('profile')
            ->withCount(['questions', 'answers'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);
    }

    /**
     * @return LengthAwarePaginator
     */
    public function getUsersByQuestions()
    {
        return $this
            ->with('profile')
            ->withCount(['questions', 'answers'])
            ->orderBy('questions_count', 'desc')
            ->paginate(20);
    }

    /**
     * @return LengthAwarePaginator
     */
    public function getUsersByAnswers()
    {
        return $this
            ->with('profile')
            ->withCount(['questions', 'answers'])
            ->orderBy('answers_count', 'desc')
            ->paginate(20);
    }

    /**
     * @return LengthAwarePaginator
     */
    public function getUsersByRating()
    {
        return $this
            ->with('profile')
            ->withCount(['questions', 'answers'])
            ->leftJoin('profiles', 'profiles.user_id', '=', 'users.id')
            ->orderBy('profiles.rating', 'desc')
            ->paginate(20);
    }

    /**
     * @param User $user
     * @return bool
     */
    public function isFollowing(User $user)
    {
        return !!$this->tags()->where('user_id', $user->id)->count();
    }

}

<?php

namespace App\Models;

use Conner\Likeable\Likeable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Traits\Conditionable;

class Answer extends Model
{
    use HasFactory, Likeable;

    /**
     * @var array[]
     */
    protected $fillable = ['body', 'user_id', 'question_id'];

    /**
     * @var array[]
     */
    protected $with = ['comments'];

    /**
     * @var bool
     */
    public $timestamps = true;


    /**
     * @return BelongsTo
     */
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return MorphMany
     */
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable')->when(auth()->user(), function ($query) {
            $query->withExists(['likes as is_liked' => function ($query) {
                $query->where('user_id', auth()->user()->id);
            }]);
        });
    }

    /**
     * @param int $id
     * @return Collection
     */
    public function getUserAnswers(int $id)
    {
        return $this->with('question', function ($query) {
            $query->select(['id', 'title', 'created_at'])->without(['tags', 'user', 'answers']);
        })->where('user_id', $id)->get();
    }

}

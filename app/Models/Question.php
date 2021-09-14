<?php

namespace App\Models;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Question extends Model
{
    use HasFactory;

    /**
     * @var array[]
     */
    protected $fillable = ['title', 'body', 'user_id', 'complexity'];

    public $timestamps = true;

    /**
     * @var array[]
     */
    protected $with = ['user.profile', 'tags', 'answers', 'comments', 'answers.user', 'solutions'];

    /**
     * @var array[]
     */
    protected $withCount = ['answers', 'subscribers'];

    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'question_tag');
    }

    /**
     * @return HasMany
     */
    public function answers()
    {
        return $this->hasMany(Answer::class)->when(auth()->user(), function ($query){
            $query->withExists(['likes as is_liked' => function ($query) {
                $query->where('user_id', auth()->user()->id);
            }]);
        });
    }

    /**
     * @return HasMany
     */
    public function solutions()
    {
        return $this->hasMany(Answer::class)->where('is_solution', true);
    }

    /**
     * @return MorphMany
     */
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    /**
     * @return BelongsToMany
     */
    public function subscribers()
    {
        return $this->belongsToMany(User::class, 'question_subscriber');
    }

    public function getAnswerIsWrittenAttribute()
    {
        return ($this->answers()->where('user_id', auth()->user()->id)->count()) ? true : false;
    }

    /**
     * @return LengthAwarePaginator
     */
    public function getAllQuestionsByNew()
    {
        return $this
            ->without(['answers', 'comments'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);
    }

    /**
     * @return LengthAwarePaginator
     */
    public function getAllQuestionsByInteresting()
    {
        // todo...
        return $this->getAllQuestionsByNew();
    }

    /**
     * @return LengthAwarePaginator
     */
    public function getAllQuestionsByWithoutAnswers()
    {
        return $this
            ->doesntHave('answers')
            ->orderBy('created_at', 'desc')
            ->paginate(20);
    }

    /**
     * @return LengthAwarePaginator
     */
    public function getAllQuestionsByDefault()
    {
        return $this->getAllQuestionsByNew();
    }

    /**
     * @return Builder|Model|object|null
     */
    public function getQuestionsByTag($tag, $by = 'new')
    {
        return $this
            ->whereHas('tags', function ($query) use ($tag) {
                $query->whereIn('tags.id', $tag);
            })
            ->withCount('answers')
            ->with(['user.profile', 'tags'])
            ->when($by == 'new', function ($query) {
                $query->orderBy('created_at');
            })
            ->when($by == 'interesting', function ($query) {
                $query->orderBy('created_at');
            })
            ->when($by == 'without_answers', function ($query) {
                $query->doesntHave('answers');
            })
            ->paginate(20);
    }

    /**
     * @param $request
     * @return $this
     */
    public function newQuestion($request)
    {
        $this->title = $request->title;
        $this->body = $request->body;
        $this->user_id = auth()->user()->id;
        $this->complexity = $request->complexity;
        $this->save();
        $this->tags()->attach($request->tags);
        $this->subscribe();
        return $this;
    }

    /**
     * @return array|false
     */
    public function subscribe()
    {
        if (auth()->guest()) {
            return false;
        } else {
            return $this->subscribers()->syncWithoutDetaching(auth()->user()->id);
        }
    }

    /**
     * @return false|int
     */
    public function unsubscribe()
    {
        if (auth()->guest()) {
            return false;
        } else {
            return $this->subscribers()->detach(auth()->user()->id);
        }
    }

    /**
     * @return bool
     */
    public function getIsSubscribedAttribute()
    {
        return $this->subscribers()->whereIn('user_id', [auth()->user()->id])->count() ? true : false;
    }

    /**
     * @return int
     */
    public function getCountSubscribersAttribute()
    {
        return $this->subscribers()->count();
    }
}

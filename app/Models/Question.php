<?php

namespace App\Models;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Question
 * @package App\Models
 */
class Question extends Model
{
    use HasFactory;

    /**
     * @var array[]
     */
    protected $fillable = ['title', 'body', 'user_id', 'complexity'];

    /**
     * @var array[]
     */
    protected $with = ['user.profile', 'tags', 'answers'];

    /**
     * @var array[]
     */
    protected $withCount = ['answers'];

    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
     */
    public function profile()
    {
        return $this->belongsTo(Profile::class);
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
        return $this->hasMany(Answer::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    /**
     * @return LengthAwarePaginator
     */
    public function getAllQuestionsByNew()
    {
        return $this
            ->with('answers')
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
            ->with('answers')
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
     * @return int
     */
    public function solutions()
    {
//        return $this
//            ->answers()
//            ->where('is_solution', true)
//            ->count();
    }

    /**
     * @return bool
     */
    public function getHasSolutionsAttribute()
    {
        return $this->solutions() ? true : false;
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
        return $this;
    }

    /**
     *
     */
    public function subscribe()
    {

    }

}

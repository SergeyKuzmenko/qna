<?php

namespace App\Models;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{

    use HasFactory;

    /**
     * @var array[]
     */
    protected $fillable = ['title', 'slug', 'description', 'icon'];

    /**
     * @return LengthAwarePaginator
     */
    public function getTagsByQuestions()
    {
        if (auth()->user()) {
            return $this->withExists(['followers as is_follow' => function ($query) {
                $query->where('user_id', auth()->id());
            }])
                ->withCount(['questions', 'followers'])
                ->orderBy('questions_count', 'desc')
                ->paginate(20);
        } else {
            return $this->withCount(['questions', 'followers'])
                ->orderBy('questions_count', 'desc')
                ->paginate(20);
        }
    }

    /**
     * @return LengthAwarePaginator
     */
    public function getTagsByDefault()
    {
        return $this->getTagsByFollowers();
    }

    /**
     * @return LengthAwarePaginator
     */
    public function getTagsByFollowers()
    {
        if (auth()->user()) {
            return $this->withExists(['followers as is_follow' => function ($query) {
                $query->where('user_id', auth()->user()->id);
            }])
                ->withCount(['questions', 'followers'])
                ->orderBy('followers_count', 'desc')
                ->paginate(20);
        } else {
            return $this->withCount(['questions', 'followers'])
                ->orderBy('followers_count', 'desc')
                ->paginate(20);
        }
    }

    /**
     * @param $tagId
     * @return Tag|Builder|Model|object|null
     */
    public function getTagInfo($tagId)
    {
        if (auth()->user()) {
            return $this->where('id', $tagId)
                ->withExists(['followers as is_follow' => function ($query) {
                    $query->where('user_id', auth()->user()->id);
                }])->withCount(['questions' => function ($query) {
                    $query->whereHas('tags');
                }, 'followers' => function ($query) {
                    $query->whereHas('tags');
                }])
                ->with(['questions' => function ($query) {
                    $query->whereHas('tags')->limit(3);
                }])
                ->with(['followers' => function ($query) {
                    $query->with('profile')->limit(3);
                }])->first();
        } else {
            return $this
                ->where('id', $tagId)
                ->withCount(['questions' => function ($query) {
                    $query->whereHas('tags');
                }, 'followers' => function ($query) {
                    $query->whereHas('tags');
                }])
                ->with(['questions' => function ($query) {
                    $query->limit(3);
                }])
                ->with(['followers' => function ($query) {
                    $query->with('profile')->limit(3);
                }])->first();
        }
    }

    /**
     * @return float
     */
    public function getSolutionAttribute()
    {
        if ($this->questions()->count() > 0 && $this->solvedQuestions()->count() > 0) {
            return $this->attributes['solution'] =
                floor(($this->solvedQuestions()->count() * 100) / $this->questions()->count());
        }
        return $this->attributes['solution'] = 0.0;
    }

    /**
     * @return BelongsToMany
     */
    public function questions()
    {
        return $this->belongsToMany(Question::class, 'question_tag');
    }

    /**
     * @return Collection
     */
    public function solvedQuestions()
    {
        return $this->questions()->whereRelation('answers', 'is_solution', 1)->get();
    }

    /**
     * @return array
     */
    public function subscribe()
    {
        return $this->followers()->syncWithoutDetaching(auth()->id());
    }

    /**
     * @return BelongsToMany
     */
    public function followers()
    {
        return $this->belongsToMany(User::class, 'user_tag')->withCount(['questions', 'answers']);
    }

    /**
     * @return int
     */
    public function unsubscribe()
    {
        return $this->followers()->detach(auth()->id());
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Answer
 * @package App\Models
 */
class Answer extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = ['body'];

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

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    /**
     * @param int $id
     * @return Builder[]|Collection
     */
    public function getUserAnswers(int $id)
    {
        return $this->with('question', function ($query) {
            $query->select(['id', 'title', 'created_at'])->without(['tags', 'user', 'answers']);
        })->where('user_id', $id)->get();
    }

}

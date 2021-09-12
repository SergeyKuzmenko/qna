<?php

namespace App\Models;

use Conner\Likeable\Likeable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Answer extends Model
{
    use HasFactory, Likeable;

    /**
     * @var string[]
     */
    protected $fillable = ['body'];

    protected $with = ['comments'];

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

    public function getUserAnswers(int $id)
    {
        return $this->with('question', function ($query) {
            $query->select(['id', 'title', 'created_at'])->without(['tags', 'user', 'answers']);
        })->where('user_id', $id)->get();
    }

}

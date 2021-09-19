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
    protected $fillable = ['body', 'user_id', 'question_id'];

    protected $with = ['comments'];

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

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable')->when(auth()->user(), function ($query){
            $query->withExists(['likes as is_liked' => function ($query) {
                $query->where('user_id', auth()->user()->id);
            }]);
        });
    }

    public function getUserAnswers(int $id)
    {
        return $this->with('question', function ($query) {
            $query->select(['id', 'title', 'created_at'])->without(['tags', 'user', 'answers']);
        })->where('user_id', $id)->get();
    }

}

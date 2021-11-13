<?php

namespace App\Models;

use Conner\Likeable\Likeable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

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
        return $this->morphMany(Comment::class, 'commentable')
            ->when(auth()->user(), function ($query) {
            $query->withExists(['likes as is_liked' => function ($query) {
                $query->where('user_id', auth()->user()->id);
            }]);
        });
    }

}

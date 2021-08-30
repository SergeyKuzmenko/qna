<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'created_at',
        'updated_at',
        'email_verified_at'
    ];

    protected $with = ['profile'];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function profile() {
        return $this->hasOne(Profile::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class, 'user_id', 'id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'user_tag');
    }


    public function getUsersByDefault()
    {
        return $this
            ->with('profile')
            ->withCount(['questions', 'answers'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);
    }

    public function getUsersByQuestions()
    {
        return $this
            ->with('profile')
            ->withCount(['questions', 'answers'])
            ->orderBy('questions_count', 'desc')
            ->paginate(20);
    }
    public function getUsersByAnswers()
    {
        return $this
            ->with('profile')
            ->withCount(['questions', 'answers'])
            ->orderBy('answers_count', 'desc')
            ->paginate(20);
    }
    public function getUsersByRating()
    {
        return $this
            ->with('profile')
            ->withCount(['questions', 'answers'])
            ->leftJoin('profiles', 'profiles.user_id', '=', 'users.id')
            ->orderBy('profiles.rating', 'desc')
            ->paginate(20);
    }

    public function isFollowing(User $user)
    {
        return !! $this->tags()->where('user_id', $user->id)->count();
    }

    public function getUserProfileData($id)
    {
        $data = collect();

        $profile = Profile::where('user_id', $id)->first();

        $questions = Question::where('user_id', $id)->withCount('answers')
            ->without(['answers', 'user'])
            ->latest()->take(3)
            ->get();

        $questions_count = Question::where('user_id', $id)->count();

        $answers = Answer::where('user_id', $id)->with('question', function ($query){
                $query->select(['id', 'title'])->without(['tags', 'answers']);
            })
            ->orderBy('created_at')
            ->limit(3)->get();

        $answers_count = Answer::where('user_id', $id)->count();

        $data->put('profile', $profile)->put('last_questions', $questions)->put('questions_count', $questions_count)->put('last_answers', $answers)->put('answers_count', $answers_count);

        return $data;
    }

}

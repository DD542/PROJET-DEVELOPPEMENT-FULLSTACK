<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Review extends Model
{
    use HasUuids;

    protected $fillable = [
        'user_id', 'content', 'sentiment', 'score', 'topics'
    ];

    protected $casts = [
        'topics' => 'array',
        'score'  => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
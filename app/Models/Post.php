<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model
{
    // Define the table name
    protected $table = 'posts';

    // Define the primary key
    protected $primaryKey = 'id';

    // Allow mass assignment for these fields
    protected $fillable = [
        'title',
        'content',
        'user_id',
    ];

    // Define the relationship between a Post and its User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}

<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'log_action', 'log_description', 'timestamp'
    ];

    // Optionally, define the relationship with the User model (if needed)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

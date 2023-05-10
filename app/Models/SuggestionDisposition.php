<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuggestionDisposition extends Model
{
    use HasFactory;

    public function suggestion() {
        return $this->belongsTo(Suggestion::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
    
    public function department() {
        return $this->belongsTo(Department::class);
    }

    protected $fillable = [
        'suggestion_id',
        'user_id',
        'department_id',
        'description',
        'is_all'
    ];
}

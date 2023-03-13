<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    use HasFactory;
    
    public function department() {
        return $this->belongsTo(Department::class);
    }
    
    public function category() {
        return $this->belongsTo(Category::class);
    }
    
    public function suggestion() {
        return $this->belongsTo(Suggestion::class);
    }
    
    public function disposition() {
        return $this->hasMany(Disposition::class);
    }

    protected $fillable = [
        'department_id',
        'category_id',
        'suggestion_id',
        'title',
        'date',
        'start_time',
        'end_time',
        'contents',
        'person_in_charge',
        'location',
        'attachment'
    ];
}

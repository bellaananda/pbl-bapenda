<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suggestion extends Model
{
    use HasFactory;

    public function user() {
        return $this->belongsTo(User::class);
    }
    
    public function department() {
        return $this->belongsTo(Department::class);
    }
    
    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function room() {
        return $this->belongsTo(Room::class);
    }
    
    public function agenda() {
        return $this->hasOne(Agenda::class);
    }

    protected $fillable = [
        'employee_id',
        'department_id',
        'category_id',
        'title',
        'date',
        'start_time',
        'end_time',
        'contents',
        'person_in_charge',
        'location',
        'attachment',
        'status'
    ];
}

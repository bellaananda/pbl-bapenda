<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    public function agenda() {
        return $this->hasMany(Agenda::class);
    }

    public function suggestion() {
        return $this->hasMany(Suggestion::class);
    }
    
    public function user() {
        return $this->hasMany(User::class);
    }

    public function disposition() {
        return $this->hasMany(Disposition::class);
    }

    protected $fillable = [
        'name'
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgendaDisposition extends Model
{
    use HasFactory;

    public function agenda() {
        return $this->belongsTo(Agenda::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
    
    public function department() {
        return $this->belongsTo(Department::class);
    }

    protected $fillable = [
        'agenda_id',
        'user_id',
        'department_id',
        'description',
        'is_all'
    ];
}

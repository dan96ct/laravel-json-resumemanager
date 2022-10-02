<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    use HasFactory;

    protected $fillable = [
        'theme'
    ];

    public function resumes(){
        return $this->hasMany(Resume::class);
    }

    public function publishes(){
        return $this->hasMany(Publish::class);
    }
}

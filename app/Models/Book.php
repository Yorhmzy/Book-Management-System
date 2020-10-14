<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;

class Book extends Model
{
    use HasFactory, softDeletes;

    protected $fillable = ['title', 'author'];

    // Book -> User Relation
    public function owner() {
        return $this->belongsTo(User::class);
    }
}

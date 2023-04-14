<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function genre(){
        return $this->belongsTo(Genre::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function photos(){
        return $this->hasMany(Photo::class);
    }

    public function keywords(){
        return $this->hasMany(Keyword::class);
    }

    public function nices(){
        return $this->belongsToMany(User::class,'nices')->withTimestamps();
    }
}

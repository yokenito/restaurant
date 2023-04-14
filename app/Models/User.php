<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function stores(){
        return $this->hasMany(Store::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function photos(){
        return $this->hasMany(Photo::class);
    }

    // お気に入り用
    public function nices(){
        return $this->belongsToMany(Store::class,'nices')->withTimestamps();
    }
    public function isNice($store_id){
        return $this->nices()->where('store_id',$store_id)->exists();
    }
    public function nice($store_id){
        if($this->isNice($store_id)){

        } else {
            $this->nices()->attach($store_id);
        }
    }
    public function deletenice($store_id){
        if($this->isNice($store_id)){
            $this->nices()->detach($store_id);
        }else{
            
        }
    }

}

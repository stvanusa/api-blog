<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    protected $table = 'produto';

    protected $fillable = ['nome','valor', 'descricao'];

    public function posts(){
        return $this->hasMany(Post::class);
    }

    // public function posts(){
    //     return $this->belonsToMany(Post::class);
    // }
}
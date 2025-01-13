<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 'categoria';

    protected $fillable = ['nome','descricao'];

    public function posts(){
        return $this->hasMany(Post::class);
    }

    // public function posts(){
    //     return $this->belonsToMany(Post::class);
    // }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'descripcion',
        'imagen',
        'user_id'
    ];

    // establecer relación posts-usuario.
    public function user()
    {
        return $this->belongsTo(User::class)->select(['name', 'username']);
    }

    // establecer relacion posts-comentarios.
    public function comentarios()
    {
        return $this->hasMany(Comentario::class);
    }

    // establecer relación posts-likes.
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    // revisar si usuario dio like.
    public function checkLike(User $user)
    {
        return $this->likes->contains('user_id', $user->id);
    }
}

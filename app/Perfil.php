<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    // relacion 1 a 1 de perfil con usuario
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id'); // el user id es para pasar toda la informacion del usuario con tal id
    }
}

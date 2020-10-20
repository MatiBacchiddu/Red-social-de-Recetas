<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Receta extends Model
{
    //campos que se agregaran
    protected $fillable = [
        'titulo', 'preparacion', 'ingredientes', 'imagen', 'categoria_id',
    ];




    //obtiene la categoria de la receta por clave foranea
    public function categoria()
    {
        return $this->belongsTo(CategoriaReceta::class); // dice que la categoria le pertenece a la tabla Categoria recetas
    }



    //obtiene la informacion del usuario via foranea
    public function autor()
    {
        return $this->belongsTo(User::class, 'user_id'); // user_id clave foranea de recetas
    }
}

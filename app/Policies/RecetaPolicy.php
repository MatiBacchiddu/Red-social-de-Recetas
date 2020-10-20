<?php

namespace App\Policies;

use App\Receta;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RecetaPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Receta  $receta
     * @return mixed
     */
    public function view(User $user, Receta $receta)
    {
        return $user->id === $receta->user_id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Receta  $receta
     * @return mixed
     */
    public function update(User $user, Receta $receta)
    {
        // Revisa si el usuario autenticado es el mismo que creo la receta
        return $user->id === $receta->user_id; // el user id es el que esta en las migraciones como clave foranea de la tabla de usuarios
        
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Receta  $receta
     * @return mixed
     */
    public function delete(User $user, Receta $receta)
    {
        return $user->id === $receta->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Receta  $receta
     * @return mixed
     */
    public function restore(User $user, Receta $receta)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Receta  $receta
     * @return mixed
     */
    public function forceDelete(User $user, Receta $receta)
    {
        //
    }
}

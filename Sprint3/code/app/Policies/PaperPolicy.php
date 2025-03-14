<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Paper;
use Illuminate\Auth\Access\HandlesAuthorization;

class PaperPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return $user->hasRole('teacher') || $user->hasRole('admin');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Paper  $paper
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Paper $paper)
    {
        return $user->hasRole('admin') || 
               $user->hasRole('teacher') || 
               $paper->teacher()->where('user_id', $user->id)->exists();
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->hasRole('teacher') || $user->hasRole('admin');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Paper  $paper
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Paper $paper)
    {
        // ให้สิทธิ์แก้ไขเฉพาะเจ้าของหรือ admin
        if ($user->hasRole('admin')) {
            return true;
        }

        $isOwner = $paper->teacher()->where('user_id', $user->id)->exists();
        if ($isOwner) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Paper  $paper
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Paper $paper)
    {
        // ให้สิทธิ์ลบเฉพาะเจ้าของหรือ admin
        if ($user->hasRole('admin')) {
            return true;
        }

        $isOwner = $paper->teacher()->where('user_id', $user->id)->exists();
        if ($isOwner) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Paper  $paper
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Paper $paper)
    {
        if ($user->hasRole('admin')) {
            return true;
        }

        $isOwner = $paper->teacher()->where('user_id', $user->id)->exists();
        if ($isOwner) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Paper  $paper
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Paper $paper)
    {
        if ($user->hasRole('admin')) {
            return true;
        }

        $isOwner = $paper->teacher()->where('user_id', $user->id)->exists();
        if ($isOwner) {
            return true;
        }

        return false;
    }
}

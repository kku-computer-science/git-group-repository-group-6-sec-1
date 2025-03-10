<?php

namespace App\Policies;

use App\Models\Academicwork;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AcademicworkPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, Academicwork $academicwork)
    {
        return $user->hasRole('admin') || 
               $user->hasRole('staff') || 
               $academicwork->user()->where('user_id', $user->id)->exists();
    }

    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, Academicwork $academicwork)
    {
        return $user->hasRole('admin') || 
               $user->hasRole('staff') || 
               $academicwork->user()->where('user_id', $user->id)->exists();
    }

    public function delete(User $user, Academicwork $academicwork)
    {
        return $user->hasRole('admin') || 
               $user->hasRole('staff') || 
               $academicwork->user()->where('user_id', $user->id)->exists();
    }

    public function restore(User $user, Academicwork $academicwork)
    {
        return $user->hasRole('admin');
    }

    public function forceDelete(User $user, Academicwork $academicwork)
    {
        return $user->hasRole('admin');
    }
}
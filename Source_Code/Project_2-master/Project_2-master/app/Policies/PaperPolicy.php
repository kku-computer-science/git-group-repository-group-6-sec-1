<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Paper;
use Illuminate\Auth\Access\HandlesAuthorization;

class PaperPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability)
    {
        if ($user->hasRole('admin') || $user->hasRole('staff')) {
            return true;
        }
    }

    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, Paper $paper)
    {
        return true;
    }

    public function create(User $user)
    {
        return $user->hasRole('teacher') || $user->hasRole('student');
    }

    public function update(User $user, Paper $paper)
    {
        return $paper->teacher()->where('user_id', $user->id)->exists();
    }

    public function delete(User $user, Paper $paper)
    {
        return $paper->teacher()->where('user_id', $user->id)->exists();
    }

    public function restore(User $user, Paper $paper)
    {
        return $user->hasRole('admin') || $user->hasRole('staff');
    }

    public function forceDelete(User $user, Paper $paper)
    {
        return $user->hasRole('admin') || $user->hasRole('staff');
    }
}
<?php

namespace App\Policies;

use App\Models\SchoolClass;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SchoolClassPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability)
    {
        if ($user->role->name === 'admin') {
            return true;
        }
    }

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, SchoolClass $schoolClass): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->role->name === 'admin' || $user->role->name === 'guru';
    }

    public function update(User $user, SchoolClass $schoolClass): bool
    {
        if ($user->role->name === 'admin') {
            return true;
        }
        return $user->teacher->id === $schoolClass->teacher_id;
    }

    public function delete(User $user, SchoolClass $schoolClass): bool
    {
        return $user->role->name === 'admin';
    }
}

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

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, SchoolClass $schoolClass): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false; // Only admin can create
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, SchoolClass $schoolClass): bool
    {
        return $user->teacher->id === $schoolClass->teacher_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, SchoolClass $schoolClass): bool
    {
        return false; // Only admin can delete
    }
}

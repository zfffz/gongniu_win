<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function update(User $currentUser, User $user)
    {
        return $currentUser->id === $user->id;
    }
    public function before($user, $ability)
    {
        // 如果用户拥有管理内容的权限的话，即授权通过
        if ($user->can('admin')) {
            return true;
        }
    }
}
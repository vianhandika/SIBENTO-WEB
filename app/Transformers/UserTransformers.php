<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\User;
use App\Employee;
use App\Role;
use App\Branch;


class UserTransformers extends TransformerAbstract
{
    /**
     * Transform User.
     *
     * @param User $user
     */
    public function transform(User $user)
    {
        return [
            'id'        => $user->id_user,
            'username'  => $user->username,
            'name'      => optional($user->employee)->name_employee,
            'role'      => optional(optional($user->employee)->role)->name_role,
            'branch'    => optional(optional($user->employee)->branch)->name_branch,
        ];
    }
}
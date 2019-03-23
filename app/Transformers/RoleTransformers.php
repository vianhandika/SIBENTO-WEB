<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Role;

class RoleTransformers extends TransformerAbstract
{
    /**
     * Transform role.
     *
     * @param Role $role
     */
    public function transform(Role $role)
    {
        return [
            'id'            => $role->id_role,
            'name'          => $role->name_role,
        ];
    }
}
<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Branch;

class BranchTransformers extends TransformerAbstract
{
    /**
     * Transform Branch.
     *
     * @param Branch $branch
     */
    public function transform(Branch $branch)
    {
        return [
            'id'            => $branch->id_branch,
            'name'          => $branch->name_branch,
            'address'       => $branch->address_branch,
        ];
    }
}
<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use App\Employee;

class EmployeeTransformers extends TransformerAbstract
{
    /**
     * Transform Employee.
     *
     * @param Employee $employee
     */
    public function transform(Employee $employee)
    {
        return [
            'id'            => $employee->id_employee,
            'name'          => $employee->name_employee,
            'phone_number'  => $employee->phone_number,
            'address'       => $employee->address,
            'salary'        => $employee->salary,
            'role'          => $employee->role->name_role,
            'branch'        => $employee->branch->name_branch,

        ];
    }
}
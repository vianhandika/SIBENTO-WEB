<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(BranchSeeder::class);
        $this->call(EmployeeSeeder::class);
        $this->call(MotorBrand::class);
        $this->call(MotorType::class);
        $this->call(CostumerSeeder::class);
        $this->call(MotorCostumer::class);
        $this->call(SparepartType::class);
        $this->call(Sparepart::class);
        $this->call(SupplierSeeder::class);
        $this->call(SalesSeeder::class);
        $this->call(ProcurementSeeder::class);
        $this->call(DetailProcurementSeeder::class);
        $this->call(TransactionSeeder::class);
        $this->call(ServiceSeeder::class);
        $this->call(EmployeeOnduty::class);
        // $this->call(MechanicOnduty::class);
        $this->call(SparepartCompatibilities::class);
        $this->call(DetailTransactionService::class);
        $this->call(DetailTransactionSparepart::class);
        $this->call(sessionseeder::class);




    }
    
}

<?php

use App\Company;
use App\User;
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
        //To insert the administrator,employees & companies
        $this->call([
            UserSeeder::class,
            CompanySeeder::class,
            EmployeeSeeder::class
        ]);
    }
}

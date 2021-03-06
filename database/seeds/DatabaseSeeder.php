<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(MenuTableSeeder::class);
        $this->call(ParametersGlobalTableSeeder::class);
        $this->call(ReportsTableSeeder::class);

        $this->call(PaisesTableSeeder::class);
        $this->call(DepartamentosTableSeeder::class);
        $this->call(CiudadesTableSeeder::class);
        $this->call(BarriosTableSeeder::class);

    }
}

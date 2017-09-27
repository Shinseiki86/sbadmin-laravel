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
        $this->call(MenuTableSeeder::class);
        $this->call(CnosTableSeeder::class);
        $this->call(CargosTableSeeder::class);
        $this->call(TiposContratosTableSeeder::class);
        $this->call(PaisesTableSeeder::class);
        $this->call(DepartamentosTableSeeder::class);
        $this->call(CiudadesTableSeeder::class);
        $this->call(ProspectosTableSeeder::class);
        $this->call(EmpleadoresTableSeeder::class);
        $this->call(TemporalesTableSeeder::class);
        $this->call(GruposTableSeeder::class);
        $this->call(TurnosTableSeeder::class);
        $this->call(MotivosRetirosTableSeeder::class);
        $this->call(ClasesContratosTableSeeder::class);
        $this->call(GerenciasTableSeeder::class);
        $this->call(ProcesosTableSeeder::class);
        $this->call(CentrosCostosTableSeeder::class);
        $this->call(TiposEmpleadoresTableSeeder::class);
        $this->call(RiesgosTableSeeder::class);
        $this->call(EstadosContratosTableSeeder::class);
        $this->call(EstadosTickectsTableSeeder::class);
        $this->call(PrioridadesTableSeeder::class);
        $this->call(CategoriasTableSeeder::class);
        $this->call(TiposIncidentesTableSeeder::class);
        $this->call(ContratosTableSeeder::class);
        $this->call(EstadosAprobacionesTableSeeder::class);
        $this->call(SancionesTableSeeder::class);         
        $this->call(TipoEntidadesTableSeeder::class);
        $this->call(EntidadTableSeeder::class);
        $this->call(DiagnosticosTableSeeder::class);
        $this->call(TipoAusentismosTableSeeder::class);
        $this->call(ConceptoAusenciasTableSeeder::class);
        $this->call(TicketsTableSeeder::class);
    }
}

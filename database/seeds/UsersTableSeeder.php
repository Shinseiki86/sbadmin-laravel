<?php
	
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;

	class UsersTableSeeder extends Seeder {

        private $rolOwner;
        private $rolAdmin;
        private $rolGestHum;


		public function run() {

            $pass = '123';
            $date = \Carbon\Carbon::now()->toDateTimeString();
            //$faker = Faker\Factory::create('es_ES');

            //*********************************************************************
           $this->command->info('--- Seeder Creación de Roles');

                $this->rolOwner = Role::create([
                    'name'         => 'owner',
                    'display_name' => 'Project Owner',
                    'description'  => 'User is the owner of a given project',
                ]);
                $this->rolAdmin = Role::create([
                    'name'         => 'admin',
                    'display_name' => 'Administrador',
                    'description'  => 'User is allowed to manage and edit other users',
                ]);
                $this->rolGestHum = Role::create([
                    'name'         => 'gesthum',
                    'display_name' => 'Gestión Humana',
                    //'description'  => 'Comentario',
                ]);
                $rolSuperOper = Role::create([
                    'name'         => 'superoper',
                    'display_name' => 'Supervisor Operaciones',
                    //'description'  => 'Comentario',
                ]);
                $rolCoorOper = Role::create([
                    'name'         => 'cooroper',
                    'display_name' => 'Coordinador Operaciones',
                    //'description'  => 'Comentario',
                ]);
                $rolEmpleado = Role::create([
                    'name'         => 'empleado',
                    'display_name' => 'Empleado',
                    //'description'  => 'Comentario',
                ]);
                $rolEjecutivo = Role::create([
                    'name'         => 'ejecutivo',
                    'display_name' => 'Ejecutivo de Cuenta',
                    //'description'  => 'Comentario',
                ]);



            //*********************************************************************
            $this->command->info('--- Seeder Creación de Permisos');

                $menu = Permission::create([
                    'name'         => 'app-menu',
                    'display_name' => 'Administrar menú',
                    'description'  => 'Permite crear, eliminar y ordenar el menú del sistema.',
                ]);
                $parameters = Permission::create([
                    'name'         => 'app-parameters',
                    'display_name' => 'Administrar parámetros',
                    'description'  => 'Permite crear, eliminar y ordenar los parámetros del sistema.',
                ]);
                $uploads = Permission::create([
                    'name'         => 'app-upload',
                    'display_name' => 'Cargas masivas',
                    'description'  => '¡CUIDADO! Permite realizar cargas masivas de datos en el sistema.',
                ]);
                $parametersg = Permission::create([
                    'name'         => 'app-parametersglobal',
                    'display_name' => 'Administrar parámetros generales del Sistema',
                    'description'  => 'Permite crear, eliminar y ordenar los parámetros generales del sistema.',
                ]);

                $this->rolOwner->attachPermissions([$menu, $parameters, $uploads]);
                $this->rolAdmin->attachPermission($menu);
                $this->rolAdmin->attachPermission($parametersg);

                $reportes = Permission::create([
                    'name'         => 'reportes',
                    'display_name' => 'Reportes',
                    'description'  => 'Permite ejecutar reportes y exportarlos.',
                ]);
                $this->rolOwner->attachPermission($reportes);
                $this->rolAdmin->attachPermissions([$reportes,$uploads]);
                $this->rolGestHum->attachPermission($reportes);
                $rolEjecutivo->attachPermission($reportes);
                $rolSuperOper->attachPermission($reportes);
                $rolCoorOper->attachPermission($reportes);

                $this->createPermissions(User::class, 'usuarios', null,  true, false);
                $this->createPermissions(Permission::class, 'permisos', null, true, false);
                $this->createPermissions(Role::class, 'roles', null, true, false);

                /*
                $this->createPermissions(Pais::class, 'países', null, true, false);
                $this->createPermissions(Departamento::class, 'departamentos', null, true, false);
                $this->createPermissions(Ciudad::class, 'ciudades', null, true, false);
                */

                //$this->createPermissions(Prospecto::class, 'hojas de vida');
                

            //*********************************************************************
            $this->command->info('--- Seeder Creación de Usuarios prueba');

                //Admin
                $admin = User::firstOrcreate( [
                    'name' => 'Administrador',
                    'cedula' => 1,
                    'username' => 'admin',
                    'email' => 'sghmasterpromo@gmail.com',
                    'password'  => \Hash::make($pass),
                ]);
                $admin->attachRole($this->rolAdmin);

                //Owner
                $owner = User::create( [
                    'name' => 'Owner',
                    'cedula' => 2,
                    'username' => 'owner',
                    'email' => 'owner@mail.com',
                    'password'  => \Hash::make($pass),
                ]);
                $owner->attachRole($this->rolOwner);

                //Editores
                $gesthum1 = User::create( [
                    'name' => 'Gestión humana 1 de prueba',
                    'cedula' => 444444444,
                    'username' => 'gesthum1',
                    'email' => 'kfrodriguez@misena.edu.co',
                    'password'  => \Hash::make($pass),
                    'USER_CREADOPOR'  => 'PRUEBAS'
                ]);
                $gesthum1->attachRole($this->rolGestHum);

                $super = User::create( [
                    'name' => 'Supervisor de prueba',
                    'cedula' => 555555555,
                    'username' => 'superoper',
                    'email' => 'coordinadornomin@aseoregional.com',
                    'password'  => \Hash::make($pass),
                    'USER_CREADOPOR'  => 'PRUEBAS'
                ]);
                $super->attachRole($rolSuperOper);

                $coordi = User::create( [
                    'name' => 'Coordinador de prueba',
                    'cedula' => 6666666666,
                    'username' => 'coordi',
                    'email' => 'coordi@outlook.com',
                    'password'  => \Hash::make($pass),
                    'USER_CREADOPOR'  => 'PRUEBAS'
                ]);
                $coordi->attachRole($rolCoorOper);

                $ejecutivo = User::create( [
                    'name' => 'Ejecutivo de prueba',
                    'cedula' => 7777777777,
                    'username' => 'ejecutivo',
                    'email' => 'ejecutivo@gmail.com',
                    'password'  => \Hash::make($pass),
                    'USER_CREADOPOR'  => 'PRUEBAS'
                ]);
                $ejecutivo->attachRole($rolEjecutivo);

                //5 usuarios faker
                //$users = factory(SGH\User::class)->times(5)->create();

		}

        private function createPermissions($name, $display_name, $description = null, $attachAdmin=true, $attachGestHum=true)
        {
            $name = strtolower(basename(get_model($name)));

            if($description == null)
                $description = $display_name;

            $create = Permission::create([
                'name'         => $name.'-create',
                'display_name' => 'Crear '.$display_name,
                'description'  => 'Crear '.$description,
            ]);
            $edit = Permission::create([
                'name'         => $name.'-edit',
                'display_name' => 'Editar '.$display_name,
                'description'  => 'Editar '.$description,
            ]);
            $index = Permission::create([
                'name'         => $name.'-index',
                'display_name' => 'Listar '.$display_name,
                'description'  => 'Listar '.$description,
            ]);
            $delete = Permission::create([
                'name'         => $name.'-delete',
                'display_name' => 'Borrar '.$display_name,
                'description'  => 'Borrar '.$description,
            ]);

            if($attachAdmin)
                $this->rolAdmin->attachPermissions([$index, $create, $edit, $delete]);

            if($attachGestHum)
                $this->rolGestHum->attachPermissions([$index, $create, $edit]);

            return compact('create', 'edit', 'index', 'delete');
        }

	}
<?php

use Illuminate\Database\Seeder;
use App\Models\Menu;
use App\Models\Permission;

class MenuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $orderMenuLeft = 0;
        $orderMenuTop = 0;


        $orderItem = 0;
        $parent = Menu::create([
            'MENU_LABEL' => 'Admin',
            'MENU_ICON' => 'fas fa-cogs',
            'MENU_ORDER' => $orderMenuLeft++,
        ]);
            Menu::create([
                'MENU_LABEL' => 'Menú',
                'MENU_URL' => 'app/menu',
                'MENU_ICON' => 'fas fa-bars',
                'MENU_PARENT' => $parent->MENU_ID,
                'MENU_ORDER' => $orderItem++,
                'MENU_ENABLED' => true,
                'PERM_ID' => $this->getPermission('app-menu'),
            ]);
            Menu::create([
                'MENU_LABEL' => 'Parametrizaciones generales',
                'MENU_URL' => 'app/parameters',
                'MENU_ICON' => 'fas fa-cog',
                'MENU_PARENT' => $parent->MENU_ID,
                'MENU_ORDER' => $orderItem++,
                'PERM_ID' => $this->getPermission('app-parameters'),
           ]);
            Menu::create([
                'MENU_LABEL' => 'Carga másiva',
                'MENU_URL' => 'app/upload',
                'MENU_ICON' => 'fas fa-cog',
                'MENU_PARENT' => $parent->MENU_ID,
                'MENU_ORDER' => $orderItem++,
                'PERM_ID' => $this->getPermission('app-upload'),
            ]);
            Menu::create([
                'MENU_LABEL' => 'Parametros del Sistema',
                'MENU_URL' => 'app/parametrosgenerales',
                'MENU_ICON' => 'fas fa-bolt',
                'MENU_PARENT' => $parent->MENU_ID,
                'MENU_ORDER' => $orderItem++,
                'PERM_ID' => $this->getPermission('app-parametrosgenerales'),
            ]);

        $orderItem = 0;
        $parent = Menu::create([
            'MENU_LABEL' => 'Usuarios y roles',
            'MENU_ICON' => 'fas fa-user-circle',
            'MENU_ORDER' => $orderMenuLeft++,
        ]);
            Menu::create([
                'MENU_LABEL' => 'Usuarios',
                'MENU_URL' => 'auth/usuarios',
                'MENU_ICON' => 'fas fa-user',
                'MENU_PARENT' => $parent->MENU_ID,
                'MENU_ORDER' => $orderItem++,
                'PERM_ID' => $this->getPermission('user-index'),
            ]);
            Menu::create([
                'MENU_LABEL' => 'Roles',
                'MENU_URL' => 'auth/roles',
                'MENU_ICON' => 'fas fa-male',
                'MENU_PARENT' => $parent->MENU_ID,
                'MENU_ORDER' => $orderItem++,
                'PERM_ID' => $this->getPermission('role-index'),
            ]);
            Menu::create([
                'MENU_LABEL' => 'Permisos',
                'MENU_URL' => 'auth/permisos',
                'MENU_ICON' => 'fas fa-address-card',
                'MENU_PARENT' => $parent->MENU_ID,
                'MENU_ORDER' => $orderItem++,
                'PERM_ID' => $this->getPermission('permission-index'),
            ]);

        $orderItem = 0;
        $parent = Menu::create([
            'MENU_LABEL' => 'Geográficos',
            'MENU_ICON' => 'fas fa-globe-americas',
            'MENU_ORDER' => $orderMenuLeft++,
        ]);
            Menu::create([
                'MENU_LABEL' => 'Países',
                'MENU_URL' => 'cnfg-geograficos/paises',
                'MENU_ICON' => 'fas fa-map-marker-alt',
                'MENU_PARENT' => $parent->MENU_ID,
                'MENU_ORDER' => $orderItem++,
                'PERM_ID' => $this->getPermission('pais-index'),
            ]);
            Menu::create([
                'MENU_LABEL' => 'Departamentos',
                'MENU_URL' => 'cnfg-geograficos/departamentos',
                'MENU_ICON' => 'fas fa-map-marker-alt',
                'MENU_PARENT' => $parent->MENU_ID,
                'MENU_ORDER' => $orderItem++,
                'PERM_ID' => $this->getPermission('departamento-index'),
            ]);
            Menu::create([
                'MENU_LABEL' => 'Ciudades',
                'MENU_URL' => 'cnfg-geograficos/ciudades',
                'MENU_ICON' => 'fas fa-map-marker-alt',
                'MENU_PARENT' => $parent->MENU_ID,
                'MENU_ORDER' => $orderItem++,
                'PERM_ID' => $this->getPermission('ciudad-index'),
            ]);

        //*********** AQUÍ SE AGREGAN LOS NUEVOS MENÚS ***********

        $orderItem = 0;
        $parent = Menu::create([
            'MENU_LABEL' => 'Menú 1',
            'MENU_ICON' => 'fas fa-new',
            'MENU_URL' => 'test/pruebas',
            'MENU_ORDER' => $orderMenuLeft++,
            'PERM_ID' => $this->getPermission('pruebas-index'),
        ]);
            Menu::create([
                'MENU_LABEL' => 'Submenú a',
                'MENU_URL' => 'test/pruebas',
                'MENU_ICON' => 'fas fa-map-marker-alt',
                'MENU_PARENT' => $parent->MENU_ID,
                'MENU_ORDER' => $orderItem++,
                'PERM_ID' => $this->getPermission('pruebas-index'),
            ]);
            Menu::create([
                'MENU_LABEL' => 'Submenú b',
                'MENU_URL' => 'test/pruebas',
                'MENU_ICON' => 'fas fa-map-marker-alt',
                'MENU_PARENT' => $parent->MENU_ID,
                'MENU_ORDER' => $orderItem++,
                'PERM_ID' => $this->getPermission('pruebas-index'),
            ]);



        //********************************************************
        $orderItem = 0;
        $parent = Menu::create([
            'MENU_LABEL' => 'Reportes',
            'MENU_ICON' => 'fas fa-filter',
            'MENU_URL' => 'reportes',
            'MENU_ORDER' => $orderMenuLeft++,
            'PERM_ID' => $this->getPermission('reportes'),
        ]);




        //TOP
        Menu::create([
            'MENU_LABEL' => 'Tickets',
            'MENU_URL' => 'cnfg-tickets/tickets',
            'MENU_ICON' => 'fas fa-id-badge',
            'MENU_ORDER' => $orderMenuTop++,
            'MENU_POSITION' => 'TOP',
            'PERM_ID' => $this->getPermission('ticket-index'),
        ]);

        $parent = Menu::create([
            'MENU_LABEL' => 'Certificados',
            'MENU_ICON' => 'fas fa-certificate',
            'MENU_URL' => 'gestion-humana/contratos/certificados',
            'MENU_ORDER' => $orderMenuTop++,
            'MENU_POSITION' => 'TOP',
            'PERM_ID' => $this->getPermission('certificadocontrato'),
        ]);

        $orderItem = 0;
        $parent = Menu::create([
            'MENU_LABEL' => 'Gestión Humana',
            'MENU_ICON' => 'fas fa-users',
            'MENU_ORDER' => $orderMenuTop++,
            'MENU_POSITION' => 'TOP',
        ]);
            Menu::create([
                'MENU_LABEL' => 'Contratos',
                'MENU_URL' => 'gestion-humana/contratos',
                'MENU_ICON' => 'fas fa-handshake',
                'MENU_PARENT' => $parent->MENU_ID,
                'MENU_ORDER' => $orderMenuTop++,
                'MENU_POSITION' => 'TOP',
                'PERM_ID' => $this->getPermission('contrato-index'),
            ]);
            Menu::create([
                'MENU_LABEL' => 'Hojas de Vida',
                'MENU_URL' => 'gestion-humana/prospectos',
                'MENU_ICON' => 'fas fa-id-card',
                'MENU_PARENT' => $parent->MENU_ID,
                'MENU_ORDER' => $orderMenuTop++,
                'MENU_POSITION' => 'TOP',
                'PERM_ID' => $this->getPermission('prospecto-index'),
            ]);
            Menu::create([
                'MENU_LABEL' => 'Novedades de Nómina',
                'MENU_URL' => 'cnfg-organizacionales/novedades',
                'MENU_ICON' => 'fas fa-clipboard',
                'MENU_PARENT' => $parent->MENU_ID,
                'MENU_ORDER' => $orderMenuTop++,
                'MENU_POSITION' => 'TOP',
                'PERM_ID' => $this->getPermission('novedad-index'),
            ]);
            /*
            Menu::create([
                'MENU_LABEL' => 'Validador de TNL',
                'MENU_URL' => 'gestion-humana/helpers/validadorTNL',
                'MENU_ICON' => 'fas fa-check-square-o',
                'MENU_PARENT' => $parent->MENU_ID,
                'MENU_ORDER' => $orderItem++,
                'MENU_POSITION' => 'TOP',
                'PERM_ID' => $this->getPermission('tnl'),
            ]);
            */

        $parent = Menu::create([
            'MENU_LABEL' => 'Gestión de Turnos',
            'MENU_ICON' => 'fas fa-hourglass',
            'MENU_ORDER' => $orderMenuTop++,
            'MENU_POSITION' => 'TOP',
        ]);

         Menu::create([
                'MENU_LABEL' => 'Programación de Turnos',
                'MENU_URL' => 'gestion-humana/movimientosempleados',
                'MENU_ICON' => 'fas fa-male',
                'MENU_PARENT' => $parent->MENU_ID,
                'MENU_ORDER' => $orderMenuTop++,
                'MENU_POSITION' => 'TOP',
                'PERM_ID' => $this->getPermission('movimientoempleado-index'),
            ]);

         Menu::create([
                'MENU_LABEL' => 'Toma de Asistencias',
                'MENU_URL' => 'gestion-humana/asistenciasempleados',
                'MENU_ICON' => 'fas fa-list',
                'MENU_PARENT' => $parent->MENU_ID,
                'MENU_ORDER' => $orderMenuTop++,
                'MENU_POSITION' => 'TOP',
                'PERM_ID' => $this->getPermission('asistenciasempleados'),
            ]);

         Menu::create([
                'MENU_LABEL' => 'Clasificación de Personal',
                'MENU_URL' => 'gestion-humana/listarContratos',
                'MENU_ICON' => 'fas fa-map',
                'MENU_PARENT' => $parent->MENU_ID,
                'MENU_ORDER' => $orderMenuTop++,
                'MENU_POSITION' => 'TOP',
                'PERM_ID' => $this->getPermission('listarContratos'),
            ]);

   
    }

    //??
    private function getPermission($namePermission)
    {
        $perm = Permission::where('name', $namePermission)->get()->first();
        if(isset($perm))
            return $perm->id;
        return null;
    }
}

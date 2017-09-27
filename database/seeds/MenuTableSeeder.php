<?php

use Illuminate\Database\Seeder;
use App\Models\Menu;

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


        Menu::create([
            'MENU_LABEL' => 'Menú',
            'MENU_URL' => 'auth/menu',
            'MENU_ICON' => 'fa-bars',
            'MENU_ORDER' => $orderMenuLeft++,
            'MENU_ENABLED' => true,
        ]);


        $orderItem = 0;
        $parent = Menu::create([
            'MENU_LABEL' => 'Usuarios y roles',
            'MENU_ICON' => 'fa-user-circle-o',
            'MENU_ORDER' => $orderMenuLeft++,
        ]);
            Menu::create([
                'MENU_LABEL' => 'Usuarios',
                'MENU_URL' => 'auth/usuarios',
                'MENU_ICON' => 'fa-user',
                'MENU_PARENT' => $parent->MENU_ID,
                'MENU_ORDER' => $orderItem++,
            ]);
            Menu::create([
                'MENU_LABEL' => 'Roles',
                'MENU_URL' => 'auth/roles',
                'MENU_ICON' => 'fa-male',
                'MENU_PARENT' => $parent->MENU_ID,
                'MENU_ORDER' => $orderItem++,
            ]);
            Menu::create([
                'MENU_LABEL' => 'Permisos',
                'MENU_URL' => 'auth/permisos',
                'MENU_ICON' => 'fa-address-card-o',
                'MENU_PARENT' => $parent->MENU_ID,
                'MENU_ORDER' => $orderItem++,
            ]);

        $orderItem = 0;
        $parent = Menu::create([
            'MENU_LABEL' => 'Geográficos',
            'MENU_ICON' => 'fa-globe',
            'MENU_ORDER' => $orderMenuLeft++,
        ]);
            Menu::create([
                'MENU_LABEL' => 'Países',
                'MENU_URL' => 'cnfg-geograficos/paises',
                'MENU_ICON' => 'fa-circle',
                'MENU_PARENT' => $parent->MENU_ID,
                'MENU_ORDER' => $orderItem++,
            ]);
            Menu::create([
                'MENU_LABEL' => 'Departamentos',
                'MENU_URL' => 'cnfg-geograficos/departamentos',
                'MENU_ICON' => 'fa-circle',
                'MENU_PARENT' => $parent->MENU_ID,
                'MENU_ORDER' => $orderItem++,
            ]);
            Menu::create([
                'MENU_LABEL' => 'Ciudades',
                'MENU_URL' => 'cnfg-geograficos/ciudades',
                'MENU_ICON' => 'fa-circle-o',
                'MENU_PARENT' => $parent->MENU_ID,
                'MENU_ORDER' => $orderItem++,
            ]);


        //TOP
        Menu::create([
            'MENU_LABEL' => 'Google',
            'MENU_URL' => 'http://www.google.com',
            'MENU_ICON' => 'fa-id-badge',
            'MENU_ORDER' => $orderMenuTop++,
            'MENU_POSITION' => 'TOP',
        ]);

        $orderItem = 0;
        $parent = Menu::create([
            'MENU_LABEL' => 'Gestión Humana',
            'MENU_ICON' => 'fa-users',
            'MENU_ORDER' => $orderMenuTop++,
            'MENU_POSITION' => 'TOP',
        ]);
            Menu::create([
                'MENU_LABEL' => 'Contratos',
                'MENU_URL' => 'gestion-humana/contratos',
                'MENU_ICON' => 'fa-handshake-o',
                'MENU_PARENT' => $parent->MENU_ID,
                'MENU_ORDER' => $orderMenuTop++,
                'MENU_POSITION' => 'TOP',
            ]);
            Menu::create([
                'MENU_LABEL' => 'Hojas de Vida',
                'MENU_URL' => 'gestion-humana/prospectos',
                'MENU_ICON' => 'fa-drivers-license-o',
                'MENU_PARENT' => $parent->MENU_ID,
                'MENU_ORDER' => $orderMenuTop++,
                'MENU_POSITION' => 'TOP',
            ]);
            Menu::create([
                'MENU_LABEL' => 'Validador de TNL',
                'MENU_URL' => 'gestion-humana/helpers/validadorTNL',
                'MENU_ICON' => 'fa-check-square-o',
                'MENU_PARENT' => $parent->MENU_ID,
                'MENU_ORDER' => $orderItem++,
                'MENU_POSITION' => 'TOP',
            ]);


/*                

            Tickets Disciplinarios
                @if(Entrust::can(['ticket-*', 'tkprioridad-*', 'tkestados-*', 'tksancion-*', 'tkaprobacion-*', 'tkcategoria-*', 'tktpincidente-*', ]))

                <!-- Ausentismo -->

                <!-- Geográficos -->
                @if(Entrust::can(['pais-*', 'depart-*', 'ciudad-*', ]))

                <!-- Contratos -->
                @if(Entrust::can(['contrato-*', 'prospecto-*', 'cnos-*', 'cargo-*', 'tipocontrato-*', 'emprtemp-*', 'clasecontrato-*', 'estadocontrato-*', 'motretiro-*']))

                <!-- Organizacionales -->
                @if(Entrust::can(['empleador-*', 'gerencia-*', 'proceso-*', 'ceco-*', 'tipoempleador-*', 'riesgo-*', 'grupo-*', 'turno-*' ]))


*/
        
    }
}

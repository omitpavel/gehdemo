<?php
/*
*   07.11.2019
*   MenusMenu.php
*/
namespace App\Http\Menus;

use App\MenuBuilder\MenuBuilder;
use Illuminate\Support\Facades\DB;
use App\Models\Common\Menus;
use App\MenuBuilder\RenderFromDatabaseData;

class GetSidebarMenu implements MenuInterface{

    private $mb; //menu builder
    private $menu;

    public function __construct(){
        $this->mb = new MenuBuilder();
    }

    private function getMenuFromDB($menuId, $menuName){
        $this->menu = Menus::join('ibox_menu_role', 'ibox_menus.id', '=', 'ibox_menu_role.menus_id')
            ->select('ibox_menus.*')
            ->where('ibox_menus.menu_id', '=', $menuId)
            ->where('ibox_menu_role.role_name', '=', $menuName)
            ->orderBy('ibox_menus.sequence', 'asc')->get();
    }

    private function getGuestMenu( $menuId ){
        $this->getMenuFromDB($menuId, 'guest');
    }

    private function getUserMenu( $menuId ){
        $this->getMenuFromDB($menuId, 'user');
    }

    private function getAdminMenu( $menuId ){
        $this->getMenuFromDB($menuId, 'admin');
    }

    public function get($role, $menuId=2){
        $this->getMenuFromDB($menuId, $role);
        $rfd = new RenderFromDatabaseData;
        return $rfd->render($this->menu);
    }

    public function getAll( $menuId=2 ){
        $this->menu = Menus::select('ibox_menus.*')
            ->where('ibox_menus.menu_id', '=', $menuId)
            ->orderBy('ibox_menus.sequence', 'asc')->get();
        $rfd = new RenderFromDatabaseData;
        return $rfd->render($this->menu);
    }
}

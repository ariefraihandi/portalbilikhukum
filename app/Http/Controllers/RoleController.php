<?php


namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\Menu;
use App\Models\MenuSub;
use App\Models\MenuSubChild;
use App\Models\AccessMenu;
use App\Models\AccessSub;
use App\Models\AccessSubChild;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    //View
        public function showRole(Request $request)
        {
            $accessMenus        = $request->get('accessMenus');
            $roles              = Role::where('id', '!=', 1)->with('users')->get();

            $data = [
                'title' => 'Role List',
                'subtitle' => 'Bilik Hukum',
                'roles' => $roles,
                'sidebar' => $accessMenus,
            ];

            return view('Portal.Role.roleIndex', $data);
        }
        
        public function showRoleAccess(Request $request)
        {
            $accessMenus        = $request->get('accessMenus');          
            $roles              = Role::where('id', '!=', 1)->with('users')->get();
            $menus              = Menu::all();
            $subMenus           = MenuSub::all();
            $childMenus         = MenuSubChild::all();

            $data = [
                'title'         => 'Role Access',
                'subtitle'      => 'Bilik Hukum',
                'roles'         => $roles,
                'sidebar'       => $accessMenus,
                'menus'         => $menus,
                'subMenus'      => $subMenus,
                'childMenus'    => $childMenus,
            ];

            return view('Portal.Role.roleAccess', $data);
        }
    //!View

    public function rolesStore(Request $request)
    {
        // Validasi data yang diterima dari formulir
        $request->validate([
            'modalRoleName' => 'required|string|max:255|unique:roles,name', // Pastikan nama peran unik dalam tabel roles
        ]);

        // Buat objek Role baru
        $role = new Role();
        $role->name = $request->input('modalRoleName');

        // Simpan data peran baru ke dalam database
        $role->save();
        return redirect()->route('role')->with([
            'response' => [
                'success' => true,
                'title' => 'Success',
                'message' => 'Role added successfully',
            ],
        ]);
        // Redirect ke halaman atau tindakan yang sesuai setelah penyimpanan berhasil        
    }

    public function changeAccess(Request $request)
    {
        // Ambil data dari permintaan
        $roleId = $request->input('roleId');
        $menuId = $request->input('menuId');        
        $type   = $request->input('type');     
        // Cari nama peran berdasarkan ID
        $roleName = Role::find($roleId)->name;
        
        if ($type == 'menu') { 
            $menuName           = Menu::find($menuId)->menu_name;
            $existingAccess     = AccessMenu::where('role_id', $roleId)->where('menu_id', $menuId)->first();           

            $response = '';

            if ($existingAccess) {             
                $existingAccess->delete();
                $response = 'delete';
            } else {
                // Jika akses menu belum ada, tambahkan
                $newAccess = new AccessMenu();
                $newAccess->role_id = $roleId;
                $newAccess->menu_id = $menuId;
                $newAccess->save();
                $response = 'adding';
            }
        
            return response()->json([
                'response' => $response,
                'roleName' => $roleName,
                'menuName' => $menuName
            ]);
        } elseif ($type === 'submenu') {
            $submenuName = MenuSub::find($menuId)->title;

            // Cek apakah akses menu sudah ada dalam database
            $existingAccess = AccessSub::where('role_id', $roleId)->where('submenu_id', $menuId)->first();

            $response = '';

            if ($existingAccess) {
                // Jika akses menu sudah ada, hapus
                $existingAccess->delete();
                $response = 'delete';
            } else {
                // Jika akses menu belum ada, tambahkan
                $newAccess = new AccessSub();
                $newAccess->role_id = $roleId;
                $newAccess->submenu_id = $menuId;
                $newAccess->save();
                $response = 'adding';
            }
        
            // Beri respons dalam bentuk JSON dengan respons dan informasi nama peran dan nama menu
            return response()->json([
                'response' => $response,
                'roleName' => $roleName,
                'menuName' => $submenuName
            ]);

        } elseif ($type === 'childsubmenu') {
            $childSubName = MenuSubChild::find($menuId)->title;
         
            $existingAccess = AccessSubChild::where('role_id', $roleId)->where('childsubmenu_id', $menuId)->first();

            $response = '';

            if ($existingAccess) {             
                $existingAccess->delete();
                $response = 'delete';
            } else {    
                $newAccess = new AccessSubChild();
                $newAccess->role_id = $roleId;
                $newAccess->childsubmenu_id = $menuId;
                $newAccess->save();
                $response = 'adding';
            }
        
            // Beri respons dalam bentuk JSON dengan respons dan informasi nama peran dan nama menu
            return response()->json([
                'response' => $response,
                'roleName' => $roleName,
                'menuName' => $childSubName
            ]);
        }
    }
}

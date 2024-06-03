<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Menu;
use App\Models\MenuSub;
use App\Models\MenuSubChild;
use App\Models\AccessMenu;
use App\Models\AccessSub;
use App\Models\AccessSubChild;
use DataTables;

class MenuController extends Controller
{
    // View Code
        public function showMenu(Request $request)
        {
            $accessMenus = $request->get('accessMenus');
            
            // Debug role
            // dd($accessMenus);
            $menus = Menu::all();
            $menuSubs = MenuSub::all();
            $menuSubChildren = MenuSubChild::all();

            $data = [
                'title' => 'Menu List',
                'subtitle' => 'Bilik Hukum',
                'menus' => $menus,
                'menuSubs' => $menuSubs,
                'menuSubChildren' => $menuSubChildren,
            ];

            return view('Portal.Menu.menu', $data);
        }
    
        public function showsubMenu(Request $request)
        {
            // $accessMenus = $request->get('accessMenus');
            
            // Debug role
            // dd($accessMenus);
            $menus = Menu::all();
            $menuSubs = MenuSub::all();
            $menuSubChildren = MenuSubChild::all();

            $data = [
                'title' => 'Submenu List',
                'subtitle' => 'Bilik Hukum',
                'menus' => $menus,
                'menuSubs' => $menuSubs,
                'menuSubChildren' => $menuSubChildren,
            ];

            return view('Portal.Menu.submenu', $data);
        }
    // View Code
    public function addMenu(Request $request)
    {
        try {
            // Validate the request data
            $request->validate([
                'menu_name' => 'required|string|max:255',
                // Add any other validation rules you may need
            ]);

            // Start a database transaction
            DB::beginTransaction();

            // Fetch the last order value from the database and increment it
            $lastOrder = Menu::max('order');
            $order = $lastOrder + 1;

            // Create a new menu
            $menu = new Menu([
                'menu_name' => $request->input('menu_name'),
                'order' => $order,
                'status' => $request->has('status') ? 1 : 0,
            ]);

            // Save the menu
            $menu->save();
        
            // Create a new user_menu record
            $userMenu = new AccessMenu([
                'role_id' => 1, // Assuming user_id 1 is the admin user
                'menu_id' => $menu->id, 
            ]);

            // Save the user_menu record
            $userMenu->save();

            // Commit the transaction
            DB::commit();

            // Flash success response to the session
            return redirect()->route('showMenu')->with([
                'response' => [
                    'success' => true,
                    'title' => 'Success',
                    'message' => 'Menu added successfully',
                ],
            ]);
        } catch (\Exception $e) {
            // Rollback the transaction
            DB::rollback();

            // Flash error response to the session
            return redirect()->route('showMenu')->with([
                'response' => [
                    'success' => false,
                    'title' => 'Error',
                    'message' => 'Failed to add menu. ' . $e->getMessage(),
                ],
            ]);
        }
    }
    
    public function addSubmenu(Request $request)
    {
        try {
            // Validate the request data for submenu
            $request->validate([
                'submenu_name' => 'required|string|max:255',
                'menu_id' => 'required|exists:menus,id', // Validate if the selected menu exists
                'url' => 'required|string',
                'icon' => 'required|string',
            ]);

              // Fetch the last order value from the database and increment it
              $lastOrder = MenuSub::max('order');
              $order = $lastOrder + 1;
    
            // Create a new submenu
            $submenu = new MenuSub([
                'menu_id' => $request->input('menu_id'),
                'title' => $request->input('submenu_name'),
                'order' => $order,
                'url' => $request->input('url'),
                'icon' => $request->input('icon'),
                'itemsub' => $request->has('itemsub') ? 1 : 0,
                'status' => $request->has('status') ? 1 : 0,
            ]);
    
            // Save the submenu
            $submenu->save();

            $userMenu = new AccessSub([
                'role_id' => 1,
                'submenu_id' => $submenu->id, 
            ]);

            // Save the user_menu record
            $userMenu->save();
    
            // Flash success response to the session
            return redirect()->route('showsubMenu')->with([
                'response' => [
                    'success' => true,
                    'title' => 'Success',
                    'message' => 'Submenu added successfully',
                ],
            ]);
        } catch (\Exception $e) {
            // Flash error response to the session
            return redirect()->route('showsubMenu')->with([
                'response' => [
                    'success' => false,
                    'title' => 'Error',
                    'message' => 'Failed to add submenu. ' . $e->getMessage(),
                ],
            ]);
        }
    }

    public function addChildSubmenu(Request $request)
    {
        DB::beginTransaction(); // Mulai transaksi database
    
        try {
            // Validate the request data for submenu
            $request->validate([
                'childsubmenu_name' => 'required|string|max:255',
                'submenu_id' => 'required', // Validate if the selected menu exists
                'url' => 'required|string',
            ]);
    
            // Fetch the last order value from the database and increment it
            $lastOrder = MenuSubChild::max('order');
            $order = $lastOrder + 1;
    
            // Create a new submenu
            $childsubmenu = new MenuSubChild([
                'id_submenu' => $request->input('submenu_id'),
                'title' => $request->input('childsubmenu_name'),
                'order' => $order,
                'url' => $request->input('url'),
                'is_active' => $request->has('childSubmenuStatus') ? 1 : 0,
            ]);
    
            // Save the submenu
            $childsubmenu->save();
    
            $userMenu = new AccessSubChild([
                'role_id' => 1,
                'childsubmenu_id' => $childsubmenu->id,
            ]);
    
            // Save the user_menu record
            $userMenu->save();
    
            DB::commit(); // Commit transaksi jika semua operasi berhasil
    
            // Flash success response to the session
            return redirect()->route('showMenu')->with([
                'response' => [
                    'success' => true,
                    'title' => 'Success',
                    'message' => 'Child Submenu added successfully',
                ],
            ]);
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback transaksi jika terjadi kesalahan
    
            // Flash error response to the session
            return redirect()->route('showMenu')->with([
                'response' => [
                    'success' => false,
                    'title' => 'Error',
                    'message' => 'Failed to add Child Submenu. ' . $e->getMessage(),
                ],
            ]);
        }
    }
    

    // Menambahkan menu baru
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Buat menu baru
        $menu = new Menu;
        $menu->name = $request->input('name');
        $menu->save();

        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Menu berhasil ditambahkan.');
    }

    // Menampilkan detail menu beserta submenu dan sub child menu
    public function show($id)
    {
        $menu = Menu::with('menuSubs.menuSubChilds')->find($id);
        return view('menu.show', compact('menu'));
    }

    // Mengupdate menu
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Cari menu berdasarkan ID
        $menu = Menu::find($id);
        if (!$menu) {
            return redirect()->back()->with('error', 'Menu tidak ditemukan.');
        }

        // Update nama menu
        $menu->name = $request->input('name');
        $menu->save();

        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Menu berhasil diperbarui.');
    }

    // Menghapus menu
    public function deleteMenu(Request $request)
    {        
        \DB::beginTransaction();
    
        try {
            // Retrieve the ID from the query parameters
            $id = $request->input('id');
    
            // Delete the menu with the specified ID
            Menu::where('id', $id)->delete();
    
            // Delete the associated access menu records
            AccessMenu::where('menu_id', $id)->delete();
    
            // Commit the transaction
            \DB::commit();
    
            $successMessage = 'Menu and associated access menu records deleted successfully';
    
            return redirect()->route('showMenu')->with([
                'response' => [
                    'success' => true,
                    'title' => 'Success',
                    'message' => $successMessage,
                ],
            ]);
        } catch (\Exception $e) {
            // Rollback the transaction
            \DB::rollBack();
    
            $errorMessage = 'Failed to delete menu and associated access menu records. ' . $e->getMessage();
    
            return redirect()->route('showMenu')->with([
                'response' => [
                    'success' => false,
                    'title' => 'Error',
                    'message' => $errorMessage,
                ],
            ]);
        }
    }
    

    //Get Data
        public function getDataMenu()
        {
            $menus = Menu::all();
            
            return DataTables::of($menus)
                ->addColumn('no', function () {
                    static $counter = 0;
                    $counter++;
                    return $counter;
                })
                ->addColumn('title', function ($menu) {
                    return $menu->menu_name;
                })
                ->addColumn('submenu', function ($menu) {
                    // Mengambil jumlah submenu terkait dengan menu ini
                    $submenuCount = MenuSub::where('menu_id', $menu->id)->count();
                    return '#' . $submenuCount;
                })
                ->addColumn('order', function ($menu) use ($menus) {
                    // Menghitung ulang nomor urut berdasarkan urutan yang sesuai dalam kolom 'order'
                    $index = $menus->search(function ($item) use ($menu) {
                        return $item->id === $menu->id;
                    });
        
                    // Mengembalikan nomor urut yang dihitung ulang
                    return '#' . ($index + 1);
                })
                ->addColumn('is_active', function ($menu) {
                    // Menyesuaikan badge is_active berdasarkan status menu
                    if ($menu->status == 1) {
                        return '<div class="text-center"><span class="badge bg-label-primary">Active</span></div>';
                    } else {
                        return '<div class="text-center"><span class="badge bg-label-danger">Inactive</span></div>';
                    }
                })
                ->addColumn('action', function ($menu) {
                    $id                 = $menu->id;                 
                    $menu_name          = $menu->menu_name;                 
                    $editModalTrigger = '<a href="/edit/menu?token=' . $id . '" class="text-body edit-menu-btn">' .
                                            '<i class="bx bxs-message-square-edit mx-1"></i>' .
                                        '</a>';
                    $deleteConfirmation = '<a href="#" class="text-body" onclick="showDeleteConfirmation(\'' . '/delete/menu?id=' . $id . '\', \'' . 'Hapus Menu: ' . $menu_name . ' ?\')">' .
                                        '<i class="bx bx-trash"></i>' .
                                        '</a>';
            
                    return '<div class="d-flex align-items-center">' .
                            $editModalTrigger .
                            $deleteConfirmation .
                        '</div>';
                })
                ->rawColumns(['is_active', 'action'])
                ->make(true);
        }
        

        public function getDatasubMenu()
        {
            // Load MenuSub with its related Menu and sort by menu_id and order
            $menuSubs = MenuSub::with('menu')->orderBy('menu_id')->orderBy('order')->get();
        
            // Generate colors similar to #e8c9ed for each menu_id
            $usedColors = [];
            $uniqueMenuIds = $menuSubs->pluck('menu_id')->unique();
            foreach ($uniqueMenuIds as $menuId) {
                $usedColors[$menuId] = $this->generateSimilarColor($usedColors);
            }
        
            return DataTables::of($menuSubs)
                ->addColumn('no', function ($menuSub) {
                    static $counter = 0;
                    $counter++;
                    return $counter;
                })
                ->addColumn('Submenu', function ($menuSub) {
                    return '<i class="' . $menuSub->icon . '"></i> ' . $menuSub->title;
                })                
                ->addColumn('Menu', function ($menuSub) {
                    return $menuSub->menu ? $menuSub->menu->menu_name : 'No Menu';
                })
                ->addColumn('order', function ($menuSub) use ($menuSubs) {
                    static $orderCounters = [];
                    $menuId = $menuSub->menu_id;
        
                    if (!isset($orderCounters[$menuId])) {
                        $orderCounters[$menuId] = 0;
                    }
        
                    $orderCounters[$menuId]++;
                    return '#' . $orderCounters[$menuId];
                })
                ->addColumn('url', function ($menuSub) {
                    return $menuSub->url;
                })
                ->addColumn('dropdown', function ($menuSub) {
                    if ($menuSub->itemsub == 1) {
                        return '<div class="text-center"><span class="badge bg-label-primary">True</span></div>';
                    } else {
                        return '<div class="text-center"><span class="badge bg-label-warning">False</span></div>';
                    }
                })                
                ->addColumn('status', function ($menuSub) {
                    if ($menuSub->is_active == 1) {
                        return '<div class="text-center"><span class="badge bg-label-success">Active</span></div>';
                    } else {
                        return '<div class="text-center"><span class="badge bg-label-danger">Inactive</span></div>';
                    }
                })                           
                ->addColumn('action', function ($menuSub) {
                    return '<button class="btn btn-primary">Action</button>';
                })
                ->setRowAttr([
                    'style' => function($menuSub) use ($usedColors) {
                        return 'background-color: ' . $usedColors[$menuSub->menu_id] . ';';
                    }
                ])
                ->rawColumns(['no', 'Submenu', 'Menu', 'dropdown', 'status','order', 'action'])
                ->make(true);
        }
        
        private function generateSimilarColor($usedColors)
        {
            // Daftar warna serupa
            $similarColors = [
                '#89a4f78a',
                '#b630e185',
                '#30e15685',
                '#e1303085',
                '#30e16185'
            ];
        
            // Filter warna yang belum digunakan
            $availableColors = array_diff($similarColors, $usedColors);
        
            // Jika semua warna sudah digunakan, kembalikan warna acak
            if (empty($availableColors)) {
                return $similarColors[array_rand($similarColors)];
            }
        
            // Pilih warna dari warna yang tersedia
            return $availableColors[array_rand($availableColors)];
        }
        
    //! Get Data

}

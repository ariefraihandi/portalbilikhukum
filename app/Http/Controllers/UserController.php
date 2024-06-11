<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Carbon\Carbon;
use DataTables;

class UserController extends Controller
{
    public function getDataUser()
    {
        $users = User::all();
        
        return DataTables::of($users)
            ->addColumn('no', function () {
                static $counter = 0;
                $counter++;
                return $counter;
            })
            ->addColumn('user', function ($user) {
                $name = $user ? $user->name : 'Nama tidak tersedia';
                $role = $user ? $user->role : 'Role tidak tersedia';
                $email = $user ? $user->email : 'Email tidak tersedia';
                $whatsapp = $user ? $user->whatsapp : 'Whatsapp tidak tersedia';
                $image = $user ? $user->image : 'default.webp'; // Gunakan default image jika tidak tersedia
    
                // Gunakan fungsi asset() untuk membangun jalur absolut ke gambar
                $imagePath = asset('assets/img/member/' . $image);
    
                $output = '<div class="d-flex justify-content-start align-items-center customer-name">' .
                    '<div class="avatar-wrapper">' .
                    '<div class="avatar me-2 position-relative">' .
                    '<img src="' . $imagePath . '" alt="Avatar" class="rounded-circle" onerror="this.onerror=null;this.src=\'' . asset('assets/img/member/default.png') . '\';">' .
                    '</div>' .
                    '</div>' .
                    '<div class="d-flex flex-column">' .
                    '<span class="fw-medium">' . $name . '</span>' .
                    '<small class="text-muted">' . $email . '</small>' .
                    '<small class="text-muted">' . $whatsapp . '</small>' .
                    '</div>' .
                    '</div>';
                return $output;
            })
            ->addColumn('role', function ($user) {
                $roleId = $user->role; // Ambil ID peran dari pengguna
                $role = Role::find($roleId); // Ambil nama peran dari model Role berdasarkan ID
                
                // Tentukan ikon berdasarkan ID peran
                $icon = '';
                switch ($roleId) {
                    case 1:
                        $icon = '<span class="badge badge-center rounded-pill bg-label-success w-px-30 h-px-30 me-2"><i class="bx bxs-castle"></i></span>'; // Admin
                        break;
                    case 2:
                        $icon = '<span class="badge badge-center rounded-pill bg-label-info w-px-30 h-px-30 me-2"><i class="bx bxs-message-square-edit"></i></span>'; // Member
                        break; 
                    case 3:
                        $icon = '<span class="badge badge-center rounded-pill bg-label-warning w-px-30 h-px-30 me-2"><i class="bx bx-user bx-xs"></i></span>'; // Member
                        break;
                    case 4:
                        $icon = '<span class="badge badge-center rounded-pill bg-label-primary w-px-30 h-px-30 me-2"><i class="bx bx-buildings"></i></span>'; // Member
                        break;
                    
                    default:
                        $icon = ''; // Jika tidak ada ikon yang sesuai
                }
                
                return $icon . ' ' . $role->name; // Kembalikan ikon dan nama peran
            })
            ->addColumn('since', function ($user) {
                $since = Carbon::parse($user->created_at)->format('d M Y H:i'); // Format tanggal sesuai permintaan
                return $since;
            })
            ->addColumn('status', function ($user) {
                $verified = $user->verified;
                $badge = ($verified == 1) ? '<span class="badge badge bg-label-success">Active</span>' : '<span class="badge badge bg-label-danger">Inactive</span>';
                return $badge;
            })
            ->addColumn('action', function ($user) {
                $editIcon = '<a href="#" class="text-body edit-menu-btn" data-toggle="modal" data-target="#editMenuModal_' . $user->id . '">' .
                            '<i class="bx bxs-message-square-edit mx-1"></i>' .
                            '</a>';
                $viewIcon = '<a href="#" class="text-body view-menu-btn" data-toggle="modal" data-target="#viewMenuModal_' . $user->id . '">' .
                            '<i class="bx bx-show mx-1"></i>' .
                            '</a>';
                $deleteIcon = '<a href="#" class="text-body" onclick="showDeleteConfirmation(\'/delete/submenu?id=' . $user->id . '\', \'Hapus Submenu: ' . $user->menuSubName . ' ?\')">' .
                            '<i class="bx bx-trash"></i>' .
                            '</a>';
            
                return $editIcon . $viewIcon . $deleteIcon;
            })
            
            ->rawColumns(['user', 'role', 'status', 'action'])
            ->make(true);
    }

}

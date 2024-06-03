<?php


namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function showRole()
    {
        $roles = Role::with('users')->get(); // Mengambil semua role beserta user terkait

        $data = [
            'title' => 'Role List',
            'subtitle' => 'Bilik Hukum',
            'roles' => $roles,
        ];

        return view('Portal.Role.roleIndex', $data);
    }

    public function create()
    {
        // Tampilkan formulir untuk membuat role baru
    }

    public function rolesStore(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'modalRoleName' => 'required|string|max:255',
        ]);

        try {
            // Buat role baru
            $role = new Role;
            $role->name = $request->input('modalRoleName');
            $role->save();

            // Buat pesan sukses
            $response = [
                'success' => true,
                'title' => 'Berhasil',
                'message' => 'Role berhasil ditambahkan.',
            ];

            // Redirect ke halaman sebelumnya dengan pesan sukses
            return redirect()->back()->with('response', $response);
        } catch (\Exception $e) {
            // Buat pesan kesalahan
            $response = [
                'success' => false,
                'title' => 'Gagal',
                'message' => 'Eror: ' . $e->getMessage(),
            ];

            // Redirect ke halaman sebelumnya dengan pesan kesalahan
            return redirect()->back()->with('response', $response);
        }
    }

    public function show(Role $role)
    {
        // Tampilkan detail role tertentu
    }

    public function edit(Role $role)
    {
        // Tampilkan formulir untuk mengedit role
    }

    public function update(Request $request, Role $role)
    {
        // Simpan perubahan pada role ke dalam database
    }

    public function destroy(Role $role)
    {
        // Hapus role dari database
    }
}

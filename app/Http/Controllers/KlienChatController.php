<?php

namespace App\Http\Controllers;

use App\Models\KlienChat;
use Illuminate\Http\Request;

class KlienChatController extends Controller
{
    
    public function klienChat(Request $request)
    {
        // Validasi data yang masuk
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'keperluan' => 'required|string',
            'office_id' => 'required|exists:offices,id', // Pastikan ID kantor ada
        ]);

        // Simpan data ke database
        KlienChat::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'keperluan' => $validatedData['keperluan'],
            'id_office' => $validatedData['office_id'],
            'status' => 0,
            'chat_history' => '',
            'last_contacted_at' => now(),
            'is_followed_up' => false,
        ]);

        // Redirect atau berikan respon
        return redirect()->back()->with('success', 'Pesan berhasil dikirim!');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\KlienChat;
use App\Models\Office;
use Illuminate\Support\Facades\Mail;
use App\Mail\KlienChatNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class KlienChatController extends Controller
{
    public function klienChat(Request $request)
    {
        // Validasi data yang masuk
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'whatsapp' => 'required|string|max:20',
            'keperluan' => 'required|string',
            'office_id' => 'required|exists:offices,id', // Pastikan ID kantor ada
        ]);
    
        // Format nomor WhatsApp
        $validatedData['whatsapp'] = $this->formatWhatsAppNumber($validatedData['whatsapp']);
    
        // Mulai transaksi
        DB::beginTransaction();
    
        try {
            // Simpan data ke tabel klien_chat
            $klienChat = KlienChat::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'whatsapp' => $validatedData['whatsapp'],
                'keperluan' => $validatedData['keperluan'],
                'id_office' => $validatedData['office_id'],
                'status' => 0,
                'chat_history' => '',
                'last_contacted_at' => now(),
                'is_followed_up' => false,
            ]);
    
            // Ambil email_kantor dari office dan kirim notifikasi
            $office = Office::find($validatedData['office_id']);
    
            if ($office) {
                Mail::to($office->email_kantor)->send(new KlienChatNotification($klienChat));
            }
    
            // Commit transaksi
            DB::commit();
    
            return redirect()->back()->with([
                'response' => [
                    'success' => true,
                    'title' => 'Berhasil',
                    'message' => 'Pesan berhasil dikirim! Lawyer akan merespons dalam 10-15 menit saat jam kerja.',
                ],
            ]);
    
        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi kesalahan
            DB::rollBack();
    
            // Log error
            Log::error('Kesalahan saat menyimpan klien chat: ' . $e->getMessage());
    
            return redirect()->back()->with([
                'response' => [
                    'success' => false,
                    'title' => 'Gagal!',
                    'message' => 'Terjadi kesalahan. Silakan coba lagi. Detail: ' . $e->getMessage(),
                ],
            ]);
        }
    }
    

    /**
     * Format nomor WhatsApp.
     *
     * @param  string  $number
     * @return string
     */
    private function formatWhatsAppNumber($number)
    {
        // Hapus semua karakter selain digit
        $number = preg_replace('/\D/', '', $number);

        // Tambahkan '62' di depan jika nomor dimulai dengan '0' atau '8'
        if (strpos($number, '0') === 0) {
            $number = '62' . substr($number, 1);
        } elseif (strpos($number, '8') === 0) {
            $number = '62' . $number;
        }

        // Kembalikan nomor yang telah diformat
        return $number;
    }
}

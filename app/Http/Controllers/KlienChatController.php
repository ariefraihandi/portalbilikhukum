<?php

namespace App\Http\Controllers;

use App\Models\KlienChat;
use App\Models\Office;
use App\Models\Tagihan;
use App\Models\Commission;
use Illuminate\Support\Facades\Mail;
use App\Mail\KlienChatNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Crypt;
use DataTables;
use Exception;

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

    public function getDataKlien(Request $request)
    {
        if ($request->ajax()) {
            $data = KlienChat::select(['id', 'name', 'whatsapp', 'budget', 'new_budget', 'last_contacted_at', 'nomor_perkara', 'keperluan', 'status']);

            return DataTables::of($data)
                ->addIndexColumn()              
                ->editColumn('name', function($row) {
                    // Tampilkan nama dan status dalam kolom yang sama
                    $statusBadge = '';
                    switch ($row->status) {
                        case 0:
                            $statusBadge = '<span class="badge bg-label-danger">Belum Diresponse</span>';
                            break;
                        case 1:
                            $statusBadge = '<span class="badge bg-label-primary">Sudah Diresponse</span>';
                            break;
                        case 2:
                            if (is_null($row->budget)) {
                                $statusBadge = '<span class="badge bg-label-primary">Sudah Ada Kesepakatan</span><br><span class="badge bg-label-danger">Budget belum ditentukan</span>';
                            } else {
                                $statusBadge = '<span class="badge bg-label-primary">Sudah Ada Kesepakatan</span>';
                            }
                            break;
                        case 3:
                            $statusBadge = '<span class="badge bg-label-info">Dalam Proses Persidangan</span>';
                            break;
                        case 4:
                            $statusBadge = '<span class="badge bg-label-success">Selesai</span>';
                            break;
                        case 5:
                            $statusBadge = '<span class="badge bg-label-secondary">Batal/Tidak Ada Kelanjutan</span>';
                            break;
                        default:
                            $statusBadge = '<span class="badge bg-label-warning">Status Tidak Diketahui</span>';
                    }
    
                    return $row->name . '<br>' . $statusBadge . '<br>' . $row->last_contacted_at->translatedFormat('d F Y');
                })
                ->addColumn('hubungi', function($row) {
                    return '<button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#waModal" data-id="'.$row->id.'" data-whatsapp="'.$row->whatsapp.'">
                                <i class="fab fa-whatsapp"></i>
                            </button>';
                })
                ->addColumn('budget', function($row) {
                    // Memeriksa apakah kedua budget null
                    if (is_null($row->budget) && is_null($row->new_budget)) {
                        return '<span class="badge bg-label-info">Belum Ditentukan</span>';
                    }
                    
                    // Format budget dan new_budget jika tidak null
                    $budget = is_null($row->budget) ? '' : 'Rp ' . number_format($row->budget, 0, ',', '.');
                    $newBudget = is_null($row->new_budget) ? '' : 'Rp ' . number_format($row->new_budget, 0, ',', '.');
                    
                    // Menentukan output berdasarkan kehadiran budget dan new_budget
                    if ($budget && $newBudget) {
                        return '<span class="badge bg-label-info">Budget Awal: ' . $budget . '<br>Budget Akhir: ' . $newBudget . '</span>';
                    } elseif ($budget) {
                        return '<span class="badge bg-label-info">Budget: ' . $budget . '</span>';
                    } else {
                        return '<span class="badge bg-label-info">Budget: ' . $newBudget . '</span>';
                    }
                })
                
               
               
                ->rawColumns(['name', 'status', 'budget', 'action'])
                ->make(true);
        }     
    }

    public function hubungi(Request $request)
    {
        try {
            // Ambil parameter ID dari URL
            $id = $request->query('id');

            // Ambil data klien dari database berdasarkan ID
            $klien = KlienChat::findOrFail($id);
            if ($klien->status == 0) {
                $klien->status = 1;
                $klien->save();
            }
            // Ambil nama kantor dari relasi Office
            $office = Office::findOrFail($klien->id_office);
            $namaKantor = $office->nama_kantor;

            // Siapkan data untuk pesan WhatsApp
            $name = $klien->name;
            $keperluan = $klien->keperluan;
            $whatsapp = $this->formatWhatsappNumber($klien->whatsapp);

            // Buat pesan WhatsApp
            $pesan = "Halo *$name*,\n\n";
            $pesan .= "Kami dari *$namaKantor* ingin mengucapkan terima kasih telah menghubungi kami.\n";
            $pesan .= "Kami telah membaca keperluan Anda:\n *$keperluan.*\n";
            $pesan .= "Kami siap membantu Bapak/Ibu *$name*, dalam permasalahan ini.\n\n";
            $pesan .= "Terima kasih.";

            // Encode pesan untuk URL WhatsApp
            $pesanEncoded = urlencode($pesan);
            $waUrl = "https://wa.me/$whatsapp?text=$pesanEncoded";

            // Redirect ke URL WhatsApp
            return redirect($waUrl);

        } catch (\Exception $e) {
            // Tangani jika ada kesalahan dalam pencarian data
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memproses data.');
        }
    }

    public function updateStatusKlien(Request $request)
    {
        // Validasi request
        $request->validate([
            'clientId' => 'required|exists:klien_chat,id',
            'status' => 'required|in:0,1,2,3,4,5'
        ]);
    
        try {
            // Mulai transaksi
            DB::beginTransaction();
    
            // Ambil data klien berdasarkan clientId
            $klien = KlienChat::findOrFail($request->clientId);
            $office = Office::findOrFail($klien->id_office);
            $userId = $office->user_id;
    
            // Cek apakah status saat ini >= 2 dan mencoba mengubah ke 0 atau 1
            if ($klien->status >= 2 && in_array($request->status, [0, 1])) {
                throw new Exception('Klien sudah ditangani, status tidak boleh diubah ke status sebelumnya.');
            }
            if ($klien->status >= 3 && in_array($request->status, [0, 1, 2])) {
                throw new Exception('Klien sudah ditangani, status tidak boleh diubah ke status sebelumnya.');
            }
    
            // Perbarui status berdasarkan input
            switch ($request->status) {
                case '0':
                    $klien->status = 0;
                    break;
    
                case '1':
                    $klien->status = 1;
                    break;
    
                case '2':
                    $klien->status = 2;
                    // Periksa apakah budget_check diaktifkan
                    if ($request->has('budget_check') && $request->budget_check === 'on') {
                        if (empty($request->budget)) {
                            throw new Exception('Jika budget sudah ditentukan, maka jumlah budget tidak boleh kosong.');
                        }
                        $budget = (int)str_replace([',', '.'], '', $request->budget);
                        $klien->budget = $budget;
                    } else {
                        $klien->budget = null;
                    }
                    break;
    
                case '3':
                    $klien->status = 3;
                    // Periksa apakah nomor_perkara diinput
                    if (empty($request->nomor_perkara)) {
                        throw new Exception('Nomor perkara tidak boleh kosong ketika status dalam proses persidangan.');
                    }
                    $klien->nomor_perkara = $request->nomor_perkara;
                    break;
    
                case '4':
                    // Periksa apakah budget_compare_check diaktifkan
                    if ($request->has('budget_compare_check') && $request->budget_compare_check === 'on') {
                        $budgetAmount = (int)str_replace([',', '.'], '', $klien->budget);
    
                        if ($budgetAmount) {
                            $klien->status = 4;
                            $bilikhukumShare = $budgetAmount * 0.10;
    
                            // Hitung referral share berdasarkan bilikhukumShare
                            $referralShare = $this->calculateReferralShare($bilikhukumShare);
    
                            $invoiceNumber = $this->generateInvoiceNumber();
    
                            // Insert into tagihan
                            Tagihan::create([
                                'user_id' => $userId,
                                'amount' => $bilikhukumShare,
                                'note' => 'Tagihan Pembagian Komisi Klien ID: ' . $klien->id,
                                'status' => 'unpaid',
                                'payment_method' => null,
                                'due_date' => now()->addDays(30),
                                'invoice_number' => $invoiceNumber,
                                'currency' => 'idr'
                            ]);
    
                            // Insert into commissions
                            Commission::create([
                                'referral_id' => $office->referedby,
                                'note' => 'Bagi Hasil Dari Penanganan Klien Oleh Kantor ' . $office->nama_kantor,
                                'type' => 1,
                                'commission_amount' => $referralShare
                            ]);
                        } else {
                            throw new Exception('Budget Klien Belum Diinput');
                        }
                    } else {
                        // Proses new_budget jika budget_compare_check tidak diaktifkan
                        if (empty($request->new_budget)) {
                            throw new Exception('Budget Baru Tidak Boleh Kosong.');
                        }
    
                        $budgetAmount = (int)str_replace([',', '.'], '', $request->new_budget);
                        $klien->status = 4;
                        $klien->new_budget = $budgetAmount;
                        $bilikhukumShare = $budgetAmount * 0.10;
    
                        // Hitung referral share berdasarkan bilikhukumShare
                        $referralShare = $this->calculateReferralShare($bilikhukumShare);
    
                        $invoiceNumber = $this->generateInvoiceNumber();
    
                        // Insert into tagihan
                        Tagihan::create([
                            'user_id' => $userId,
                            'amount' => $bilikhukumShare,
                            'note' => 'Tagihan Pembagian Komisi Klien ID: ' . $klien->id,
                            'status' => 'unpaid',
                            'payment_method' => null,
                            'due_date' => now()->addDays(30),
                            'invoice_number' => $invoiceNumber,
                            'currency' => 'idr',
                            'reference_id' => $klien->id
                        ]);
    
                        // Insert into commissions
                        Commission::create([
                            'referral_id' => $office->referedby,
                            'note' => 'Bagi Hasil Dari Penanganan Klien Oleh Kantor ' . $office->nama_kantor,
                            'type' => 1,
                            'commission_amount' => $referralShare,
                            'reference_id' => $klien->id
                        ]);
                    }
                    break;
    
                case '5':
                    $klien->status = 5;
                    break;
            }
    
            $klien->save();
    
            // Commit transaksi jika tidak ada kesalahan
            DB::commit();
    
            return redirect()->back()->with([
                'response' => [
                    'success' => true,
                    'title' => 'Berhasil',
                    'message' => 'Status berhasil diperbarui.',
                ],
            ]);
        } catch (Exception $e) {
            // Rollback transaksi jika terjadi kesalahan
            DB::rollBack();
    
            return redirect()->back()->with([
                'response' => [
                    'success' => false,
                    'title' => 'Gagal',
                    'message' => $e->getMessage(),
                ],
            ]);
        }
    }
    
    /**
     * Hitung referral share berdasarkan bilikhukumShare.
     *
     * @param float $bilikhukumShare
     * @return float
     */
    private function calculateReferralShare($bilikhukumShare)
    {
        if ($bilikhukumShare <= 10000000) {
            return $bilikhukumShare * 0.30;
        } elseif ($bilikhukumShare <= 50000000) {
            return $bilikhukumShare * 0.25;
        } elseif ($bilikhukumShare <= 100000000) {
            return $bilikhukumShare * 0.20;
        } else {
            return $bilikhukumShare * 0.10;
        }
    }
    
    /**
     * Menghasilkan nomor invoice baru.
     *
     * @return int
     */
    private function generateInvoiceNumber()
    {
        $lastInvoice = Tagihan::orderBy('id', 'desc')->first();
        return $lastInvoice ? $lastInvoice->invoice_number + 1 : 1000;
    }
    

    private function formatWhatsappNumber($number)
    {      
        $number = preg_replace('/\s|\(|\)|-/', '', $number);

        // Jika nomor diawali dengan 0, ubah menjadi 62
        if (substr($number, 0, 1) == '0') {
            $number = '62' . substr($number, 1);
        }

        // Jika nomor diawali dengan 8, tambahkan 62 di depan
        if (substr($number, 0, 1) == '8') {
            $number = '62' . $number;
        }

        // Jika nomor sudah diawali dengan 62, biarkan
        if (substr($number, 0, 2) == '62') {
            return $number;
        }

        // Jika nomor diawali dengan selain 0, 8, atau 62, mungkin nomor tidak valid
        // Kembalikan nomor apa adanya
        return $number;
    }
}

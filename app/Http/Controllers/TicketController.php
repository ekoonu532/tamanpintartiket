<?php

namespace App\Http\Controllers;



use Mpdf\Mpdf;
use App\Models\Tiket;
use Mpdf\MpdfException;
use App\Models\tiket_kuota;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\KategoriTiket;
use App\Models\PembelianTiket;
use App\Models\DetailPembelian;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


class TicketController extends Controller
{
    public function dashboard()
    {
        $wahanaKategoriId = KategoriTiket::where('nama', 'wahana')->value('kategori_tiket_id');
        $progKategoriId = KategoriTiket::where('nama', 'Program Kreativitas')->value('kategori_tiket_id');
        $eventKategoriId = KategoriTiket::where('nama', 'Event')->value('kategori_tiket_id');

        $wahanaTikets = Tiket::where('kategori_tiket_id', $wahanaKategoriId)
            ->where('status', 'aktif')
            ->get();
        $progTikets = Tiket::where('kategori_tiket_id', $progKategoriId)
            ->where('status', 'aktif')
            ->get();

        $today = now()->format('Y-m-d');
        $eventTikets = Tiket::where('kategori_tiket_id', $eventKategoriId)
            ->where('status', 'aktif')
            ->where('tanggal_mulai', '<=', $today)
            ->where('tanggal_selesai', '>=', $today)
            ->get();


        // Session::put('selected_ticket', $tiket);

        return view('home', compact('wahanaTikets', 'progTikets', 'eventTikets'));
    }


    public function index()
    {
        $user = Auth::user();
        $pembelianTikets = PembelianTiket::with('detailPembelianTikets.tiket')
            ->where('user_id', $user->id)
            ->where('status_pembayaran', 'success')
            ->orderBy('created_at', 'desc')
            ->get();

        $today = now()->format('Y-m-d');

        // Separate tickets based on visit date
        $unusedTickets = collect();
        $expiredTickets = collect();

        foreach ($pembelianTikets as $pembelian) {
            foreach ($pembelian->detailPembelianTikets as $detail) {
                $tanggal_kunjungan = $detail->tanggal_kunjungan; // Mengambil tanggal kunjungan dari detailPembelianTikets

                if ($tanggal_kunjungan >= $today) {
                    $unusedTickets->push($pembelian);
                    break;
                } else {
                    $expiredTickets->push($pembelian);
                    break;
                }
            }
        }

        return view('tiket', compact('unusedTickets', 'expiredTickets'));
    }


    public function indexharga()
    {
        $kategoriWahana = KategoriTiket::where('nama', 'Wahana')->with('tikets')->first();
        $kategoriKreativitas = KategoriTiket::where('nama', 'Program Kreativitas')->with('tikets')->first();

        return view('harga-tiket', compact('kategoriWahana', 'kategoriKreativitas'));
    }

    public function ticketDetail($id)
    {
        $pembelian = PembelianTiket::with('detailPembelianTikets.tiket')->findOrFail($id);
        $detailPembelian = $pembelian->detailPembelianTikets;

        return view('ticket.detail', compact('pembelian', 'detailPembelian'));
    }

    public function getTiket(Request $request): JsonResponse
    {
        $kategori = $request->query('kategori');
        $tikets = Tiket::where('jenis', $kategori)->get(['tiket_id', 'nama']);
        return response()->json(['tikets' => $tikets]);
    }

    public function wahanaDetail(Request $request, $slug)
    {
        $tiket = Tiket::where('slug', $slug)->firstOrFail();
        Session::put('selected_ticket', $tiket);
        return view('wahana.detail', compact('tiket'));
    }

    public function eventDetail(Request $request, $slug)
    {
        $tiket = Tiket::where('slug', $slug)->firstOrFail();
        Session::put('selected_ticket', $tiket);
        return view('event.detail', compact('tiket'));
    }

    // TiketController.php
    public function getKuota(Request $request): JsonResponse
    {
        $tanggal = $request->query('tanggal');
        $tiket_id = $request->query('tiket_id');

        // Ambil total kuota tiket dari entri tiket terkait
        $totalKuota = Tiket::where('tiket_id', $tiket_id)->value('kuota');

        // Hitung total tiket yang sudah terjual untuk tanggal dan tiket tertentu
        $terjual = DetailPembelian::whereHas('pembelianTiket', function ($query) use ($tanggal) {
            $query->where('status_pembayaran', 'success')
                ->where('tanggal_kunjungan', $tanggal);
        })->where('tiket_id', $tiket_id)
            ->sum('jumlah');

        // Hitung sisa kuota yang tersisa
        $kuotaTersisa = $totalKuota - $terjual;

        // Ambil nama tiket berdasarkan tiket_id
        $namaTiket = Tiket::where('tiket_id', $tiket_id)->value('nama');

        // Kemudian, kembalikan respons JSON dengan kuota dan nama tiket
        return response()->json(['kuota' => $kuotaTersisa, 'nama' => $namaTiket]);
    }





    public function progDetail(Request $request, $slug)
    {
        $tiket = Tiket::where('slug', $slug)->firstOrFail(); // Menggunakan $id untuk mencari tiket berdasarkan tiket_id

        // Session::put('selected_date', $request->input('selected_date'));
        Session::put('selected_ticket', $tiket);
        // Mengirim data tiket ke halaman detail wahana
        return view('programkreativitas.detail', compact('tiket'));
    }

    public function Order(Request $request)
    {
        $selectedDate = $request->input('hari_tanggal');
        $tiketId = $request->input('tiket_id');

        // Assume you have a method to get ticket by ID
        $selectedTicket = Tiket::find($tiketId);

        // Check if the ticket is found
        if (!$selectedTicket) {
            return redirect()->back()->withErrors(['error' => 'Ticket not found.']);
        }

        $request->session()->put('selected_ticket', $selectedTicket);
        $request->session()->put('selected_date', $selectedDate);

        $url = route('order.index', ['selected_date' => $selectedDate]);

        return redirect($url);
    }


    public function create()
    {
        // Ambil data kategori tiket dari model atau database
        $kategoriTiket = KategoriTiket::all();

        // Kemudian lemparkan data ke view 'admin.tiket.create'
        return view('admin.tiket.create', compact('kategoriTiket'));
    }

    public function show($id)
    {
        $pembelian = PembelianTiket::findOrFail($id);
        $detailPembelian = $pembelian->detailPembelianTikets;


        return view('detail-tiket', compact('pembelian', 'detailPembelian'));
    }

    public function download($id, $detailId)
    {
        ini_set('memory_limit', '256M');
        ini_set('max_execution_time', 300);

        $pembelian = PembelianTiket::findOrFail($id);
        $detailPembelian = DetailPembelian::findOrFail($detailId);

        // Generate QR code and remove XML declaration
        $qrCodeData = [
            'kode_pembelian' => $pembelian->kode_pembelian,
            'user_id' => $pembelian->user_id,
            'tanggal_kunjungan' => $detailPembelian->tanggal_kunjungan,
        ];
        $qrCodeSvg = QrCode::format('svg')->size(150)->generate(json_encode($qrCodeData));
        $qrCodeSvg = preg_replace('/<\?xml.*\?>/', '', $qrCodeSvg);

        // Render HTML
        $html = view('tiket-download', compact('pembelian', 'detailPembelian', 'qrCodeSvg'))->render();

        try {
            ob_end_clean(); // Clear any previous output
            $mpdf = new Mpdf(['mode' => 'utf-8', 'format' => 'A4']);
            $mpdf->SetCompression(true);
            $mpdf->WriteHTML($html);
            return response()->streamDownload(function() use ($mpdf) {
                echo $mpdf->Output('', 'S');
            }, 'tiket_' . $pembelian->kode_pembelian . '.pdf', [
                'Content-Type' => 'application/pdf',
            ]);
        } catch (MpdfException $e) {
            return response()->json(['error' => 'Failed to generate PDF.'], 500);
        }
    }




}

<?php

namespace App\Http\Controllers;

use Exception;
use Mpdf\Mpdf;
use App\Models\User;
use App\Models\Tiket;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\KategoriTiket;
use App\Models\PembelianTiket;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;



class AdminController extends Controller
{
    public function adminDashboard()
    {
        // Mendapatkan jumlah total pengguna
        $totalUsers = User::count();

        // Mendapatkan jumlah total tiket terjual
        $totalSoldTickets = PembelianTiket::where('status_pembayaran', 'success')->sum('jumlah_tiket');

        // Mendapatkan total pendapatan dari penjualan tiket dengan status pembayaran 'success'
        $totalRevenue = PembelianTiket::where('status_pembayaran', 'success')->sum('total_harga');


        $ticketsSoldData = $this->getMonthlyTicketsSoldData();

        // Data untuk grafik pendapatan berdasarkan bulan
        $revenueData = $this->getMonthlyRevenueData();

        $bestSellingTickets = DB::table('tikets')
            ->join('detail_pembelian', 'tikets.tiket_id', '=', 'detail_pembelian.tiket_id')
            ->join('pembelian_tikets', 'detail_pembelian.pembelian_id', '=', 'pembelian_tikets.id')
            ->select('tikets.nama', DB::raw('SUM(detail_pembelian.jumlah) as total_sold'))
            ->where('pembelian_tikets.status_pembayaran', 'success')
            ->groupBy('tikets.nama')
            ->orderBy('total_sold', 'desc')
            ->limit(5)
            ->get();

        $recentTransactions = PembelianTiket::with(['user'])->orderBy('created_at', 'desc')->limit(5)->get();
        return view('admin.admin_dashboard', compact('totalUsers', 'totalSoldTickets', 'totalRevenue', 'ticketsSoldData', 'revenueData', 'bestSellingTickets', 'recentTransactions'));
    }

   private function getMonthlyTicketsSoldData($year = null, $kategori = null, $namaTiket = null)
{
    $currentYear = Carbon::now()->year;
    $monthlySalesQuery = DB::table('tikets')
        ->join('detail_pembelian', 'tikets.tiket_id', '=', 'detail_pembelian.tiket_id')
        ->join('pembelian_tikets', 'detail_pembelian.pembelian_id', '=', 'pembelian_tikets.id')
        ->select(DB::raw('MONTH(pembelian_tikets.created_at) as month'), DB::raw('SUM(detail_pembelian.jumlah) as total_sold'))
        ->where('pembelian_tikets.status_pembayaran', 'success');

    if ($year) {
        $monthlySalesQuery->whereYear('pembelian_tikets.created_at', $year);
    } else {
        $monthlySalesQuery->whereYear('pembelian_tikets.created_at', $currentYear);
    }

    if ($kategori) {
        $monthlySalesQuery->where('tikets.kategori_tiket_id', $kategori);
    }

    if ($namaTiket) {
        $monthlySalesQuery->where('tikets.nama', 'like', "%$namaTiket%");
    }

    $monthlySales = $monthlySalesQuery->groupBy('month')->get();

    $labels = $monthlySales->pluck('month')->map(function ($month) {
        return Carbon::create()->month($month)->format('F');
    });
    $data = $monthlySales->pluck('total_sold');

    return [
        'labels' => $labels,
        'data' => $data
    ];
}

  private function getMonthlyRevenueData($month = null, $year = null, $kategori = null, $namaTiket = null)
{
    $query = PembelianTiket::selectRaw('MONTH(pembelian_tikets.created_at) as month, SUM(detail_pembelian.harga_satuan * detail_pembelian.jumlah) as total_revenue')
        ->join('detail_pembelian', 'pembelian_tikets.id', '=', 'detail_pembelian.pembelian_id')
        ->join('tikets', 'detail_pembelian.tiket_id', '=', 'tikets.tiket_id')
        ->when($month, function ($query) use ($month) {
            $query->whereMonth('pembelian_tikets.created_at', $month);
        })
        ->when($year, function ($query) use ($year) {
            $query->whereYear('pembelian_tikets.created_at', $year);
        })
        ->when($kategori, function ($query) use ($kategori) {
            $query->where('tikets.kategori_tiket_id', $kategori);
        })
        ->when($namaTiket, function ($query) use ($namaTiket) {
            $query->where('tikets.nama', 'like', "%$namaTiket%");
        })
        ->where('pembelian_tikets.status_pembayaran', 'success')
        ->groupBy('month')
        ->pluck('total_revenue', 'month');

    $labels = [];
    $data = [];
    for ($i = 1; $i <= 12; $i++) {
        $labels[] = Carbon::createFromFormat('m', $i)->format('F');
        $data[] = $query->get($i, 0);
    }

    return [
        'labels' => $labels,
        'data' => $data
    ];
}

    public function getUserDetails($id)
    {
        $user = User::find($id);

        if ($user) {
            return response()->json($user);
        } else {
            return response()->json(['error' => 'User not found'], 404);
        }
    }



    // , 'totalTickets', 'totalSales'));


    public function users()
    {
        $users = User::paginate(10); // Atur jumlah item per halaman sesuai kebutuhan
        return view('admin.users.index', compact('users'));
    }

    public function searchuser(Request $request)
    {
        $search = $request->input('search');
        // $query = User::query();

        $users = User::query()
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->orWhere('role', 'LIKE', "%{$search}%");
            })
            ->paginate(10);

        // return view('admin.tiket.index', compact('tickets'));

        // $users = $query->paginate(10)->appends(['search' => $search]); // Atur jumlah item per halaman sesuai kebutuhan

        return view('admin.users.index', compact('users', 'search'));
    }





    public function ticketCategories()
    {
        $kategori = KategoriTiket::all();
        return view('admin.tiket-kategori.index', compact('kategori'));
    }

    public function tikets()
    {
        $tickets = Tiket::paginate(10); // Sesuaikan sesuai kebutuhan
        $kategoriTiket = KategoriTiket::all();
        return view('admin.tiket.index', compact('tickets', 'kategoriTiket'));
    }

    public function searchtikets(Request $request)
    {
        $search = $request->input('search');

        $tickets = Tiket::query()
            ->when($search, function ($query, $search) {
                return $query->where('nama', 'like', "%{$search}%")
                    ->orWhere('deskripsi', 'like', "%{$search}%");
            })
            ->paginate(10);

        return view('admin.tiket.index', compact('tickets'));
    }

    public function show($id)
    {
        $ticket = Tiket::find($id);

        if ($ticket) {
            return response()->json($ticket);
        } else {
            return response()->json(['error' => 'Ticket not found'], 404);
        }
    }








   public function transactionReports()
{
    $transactions = PembelianTiket::with(['user', 'detailPembelianTikets.tiket'])
                                   ->orderBy('updated_at', 'desc')
                                   ->paginate(10);
    return view('admin.reports.transactions', compact('transactions'));
}


    public function filterTransactions(Request $request)
    {
        $month = $request->input('month');
        $year = $request->input('year');
        $week = $request->input('week'); // Ambil input minggu
        $status = $request->input('status');

        $transactions = PembelianTiket::with(['user', 'detailPembelianTikets.tiket'])
            ->when($month, function ($query) use ($month) {
                $query->whereMonth('created_at', $month);
            })
            ->when($year, function ($query) use ($year) {
                $query->whereYear('created_at', $year);
            })
        
        ->when($status, function ($query) use ($status) {
            $query->where('status_pembayaran', $status);
        })
            ->paginate(10);

        return view('admin.reports.transactions', compact('transactions'));
    }
    public function exportTransactionsPdf(Request $request)
    {
        $month = $request->input('month');
        $year = $request->input('year');
         $week = $request->input('week'); // Ambil input minggu
    $status = $request->input('status'); //

        $transactions = PembelianTiket::with(['user', 'detailPembelianTikets.tiket'])
->when($month, function ($query) use ($month) {
            $query->whereMonth('created_at', $month);
        })
        ->when($year, function ($query) use ($year) {
            $query->whereYear('created_at', $year);
        })
        ->when($status, function ($query) use ($status) {
            $query->where('status_pembayaran', $status);
        })
        ->get();

        // Create the PDF content
        $html = view('admin.reports.transactions_pdf', compact('transactions', 'year', 'status', 'month'))->render();


        $mpdf = new Mpdf();

        // Write the HTML content to the PDF
        $mpdf->WriteHTML($html);

        // Output the PDF as a download
        return $mpdf->Output('transactions_report.pdf', 'D');
    }

   public function exportSalesPdf(Request $request)
{
    $month = $request->input('month');
    $year = $request->input('year');
    $kategori = $request->input('kategori');
     $namaTiket = $request->input('nama_tiket');

    $salesData = DB::table('tikets')
        ->join('detail_pembelian', 'tikets.tiket_id', '=', 'detail_pembelian.tiket_id')
        ->join('pembelian_tikets', 'detail_pembelian.pembelian_id', '=', 'pembelian_tikets.id')
        ->join('kategori_tikets', 'tikets.kategori_tiket_id', '=', 'kategori_tikets.kategori_tiket_id')
        ->select('tikets.nama as nama_tiket', 'kategori_tikets.nama as nama_kategori', DB::raw('SUM(detail_pembelian.jumlah) as total_sold'))
        ->when($month, function ($query) use ($month) {
            $query->whereMonth('pembelian_tikets.created_at', $month);
        })
        ->when($year, function ($query) use ($year) {
            $query->whereYear('pembelian_tikets.created_at', $year);
        })
        ->when($kategori, function ($query) use ($kategori) {
            $query->where('kategori_tikets.nama', $kategori);
        })
         ->when($namaTiket, function ($query) use ($namaTiket) {
            $query->where('tikets.nama', 'like', "%$namaTiket%");
        })
        ->where('pembelian_tikets.status_pembayaran', 'success')
        ->groupBy('tikets.nama', 'kategori_tikets.nama')
        ->orderBy('total_sold', 'desc')
        ->get();

    $html = view('admin.reports.sales_pdf', compact('salesData', 'month', 'year', 'kategori', 'namaTiket'))->render();
    $mpdf = new Mpdf();
    $mpdf->WriteHTML($html);
    return $mpdf->Output('sales_report.pdf', 'D');
}


   public function exportRevenuePdf(Request $request)
{
    $month = $request->input('month');
    $year = $request->input('year');
    $kategori = $request->input('kategori');

    $revenueData = DB::table('pembelian_tikets')
        ->join('detail_pembelian', 'pembelian_tikets.id', '=', 'detail_pembelian.pembelian_id')
        ->join('tikets', 'detail_pembelian.tiket_id', '=', 'tikets.tiket_id')
        ->join('kategori_tikets', 'tikets.kategori_tiket_id', '=', 'kategori_tikets.kategori_tiket_id')
        ->select(
            DB::raw('DATE_FORMAT(pembelian_tikets.created_at, "%Y-%m") as month'),
            DB::raw('SUM(detail_pembelian.harga_satuan * detail_pembelian.jumlah) as total_revenue'),
            'kategori_tikets.nama as kategori',
            DB::raw('SUM(detail_pembelian.jumlah) as total_sold')
        )
        ->when($month, function ($query) use ($month) {
            $query->whereMonth('pembelian_tikets.created_at', $month);
        })
        ->when($year, function ($query) use ($year) {
            $query->whereYear('pembelian_tikets.created_at', $year);
        })
        ->when($kategori, function ($query) use ($kategori) {
            $query->where('kategori_tikets.nama', $kategori);
        })
        ->where('pembelian_tikets.status_pembayaran', 'success')
        ->groupBy('month', 'kategori')
        ->orderBy('month', 'desc')
        ->get();

    $html = view('admin.reports.revenue_pdf', compact('revenueData', 'month', 'year', 'kategori'))->render();
    $mpdf = new Mpdf();
    $mpdf->WriteHTML($html);
    return $mpdf->Output('revenue_report.pdf', 'D');
}



 

    // Ensure this method is defined only once
  private function getTicketSalesData($month = null, $year = null, $kategori = null, $namaTiket = null)
{
    $currentYear = Carbon::now()->year;
    $ticketSalesQuery = DB::table('tikets')
        ->join('detail_pembelian', 'tikets.tiket_id', '=', 'detail_pembelian.tiket_id')
        ->join('pembelian_tikets', 'detail_pembelian.pembelian_id', '=', 'pembelian_tikets.id')
        ->select('tikets.nama as ticket_name', DB::raw('SUM(detail_pembelian.jumlah) as total_sold'))
        ->where('pembelian_tikets.status_pembayaran', 'success');

    if ($month) {
        $ticketSalesQuery->whereMonth('pembelian_tikets.created_at', $month);
    }

    if ($year) {
        $ticketSalesQuery->whereYear('pembelian_tikets.created_at', $year);
    } else {
        $ticketSalesQuery->whereYear('pembelian_tikets.created_at', $currentYear);
    }

    if ($kategori) {
        $ticketSalesQuery->where('tikets.kategori_tiket_id', $kategori);
    }

    if ($namaTiket) {
        $ticketSalesQuery->where('tikets.nama', 'like', "%$namaTiket%");
    }

    $ticketSales = $ticketSalesQuery->groupBy('tikets.nama')->pluck('total_sold', 'ticket_name');

    $labels = $ticketSales->keys();
    $data = $ticketSales->values();

    return [
        'labels' => $labels,
        'data' => $data
    ];
}


   public function salesReports(Request $request)
{
    $month = $request->input('month');
    $year = $request->input('year');
    $kategori = $request->input('kategori');
    $namaTiket = $request->input('nama_tiket');

    $salesData = DB::table('tikets')
        ->join('detail_pembelian', 'tikets.tiket_id', '=', 'detail_pembelian.tiket_id')
        ->join('pembelian_tikets', 'detail_pembelian.pembelian_id', '=', 'pembelian_tikets.id')
        ->join('kategori_tikets', 'tikets.kategori_tiket_id', '=', 'kategori_tikets.kategori_tiket_id')
        ->select('tikets.nama as nama_tiket', 'kategori_tikets.nama as nama_kategori', DB::raw('SUM(detail_pembelian.jumlah) as total_sold'))
        ->when($month, function ($query) use ($month) {
            $query->whereMonth('pembelian_tikets.created_at', $month);
        })
        ->when($year, function ($query) use ($year) {
            $query->whereYear('pembelian_tikets.created_at', $year);
        })
        ->when($kategori, function ($query) use ($kategori) {
            $query->where('kategori_tikets.kategori_tiket_id', $kategori);
        })
        ->when($namaTiket, function ($query) use ($namaTiket) {
            $query->where('tikets.nama', 'like', "%$namaTiket%");
        })
        ->where('pembelian_tikets.status_pembayaran', 'success')
        ->groupBy('tikets.nama', 'kategori_tikets.nama')
        ->orderBy('total_sold', 'desc')
        ->paginate(10);

    $kategoriTiket = KategoriTiket::all();

    // Data for the monthly sales chart
    $monthlySalesData = $this->getMonthlyTicketsSoldData($year, $kategori, $namaTiket);

    // Data for the ticket sales chart based on ticket name
    $ticketSalesData = $this->getTicketSalesData($month, $year, $kategori, $namaTiket);

    return view('admin.reports.sales', compact('salesData', 'kategoriTiket', 'monthlySalesData', 'ticketSalesData'));
}






    public function filterSales(Request $request)
{
    $month = $request->input('month');
    $year = $request->input('year');
    $kategori = $request->input('kategori');
    $namaTiket = $request->input('nama_tiket');

    $salesData = DB::table('tikets')
        ->join('detail_pembelian', 'tikets.tiket_id', '=', 'detail_pembelian.tiket_id')
        ->join('pembelian_tikets', 'detail_pembelian.pembelian_id', '=', 'pembelian_tikets.id')
        ->join('kategori_tikets', 'tikets.kategori_tiket_id', '=', 'kategori_tikets.kategori_tiket_id')
        ->select('tikets.nama as nama_tiket', 'kategori_tikets.nama as nama_kategori', DB::raw('SUM(detail_pembelian.jumlah) as total_sold'))
        ->when($month, function ($query) use ($month) {
            $query->whereMonth('pembelian_tikets.created_at', $month);
        })
        ->when($year, function ($query) use ($year) {
            $query->whereYear('pembelian_tikets.created_at', $year);
        })
        ->when($kategori, function ($query) use ($kategori) {
            $query->where('kategori_tikets.kategori_tiket_id', $kategori);
        })
        ->when($namaTiket, function ($query) use ($namaTiket) {
            $query->where('tikets.nama', 'like', "%$namaTiket%");
        })
        ->where('pembelian_tikets.status_pembayaran', 'success')
        ->groupBy('tikets.nama', 'kategori_tikets.nama')
        ->orderBy('total_sold', 'desc')
        ->paginate(10);

    $kategoriTiket = KategoriTiket::all();

    // Data for the monthly sales chart
    $monthlySalesData = $this->getMonthlyTicketsSoldData();

    // Data for the ticket sales chart based on ticket nam
    $ticketSalesData = $this->getTicketSalesData();

    return view('admin.reports.sales', compact('salesData', 'kategoriTiket', 'monthlySalesData', 'ticketSalesData'));
}



public function revenueReports(Request $request)
{
    $month = $request->input('month');
    $year = $request->input('year');
    $kategori = $request->input('kategori');
    $namaTiket = $request->input('nama_tiket');

    $revenueData = DB::table('pembelian_tikets')
        ->join('detail_pembelian', 'pembelian_tikets.id', '=', 'detail_pembelian.pembelian_id')
        ->join('tikets', 'detail_pembelian.tiket_id', '=', 'tikets.tiket_id')
        ->join('kategori_tikets', 'tikets.kategori_tiket_id', '=', 'kategori_tikets.kategori_tiket_id')
        ->select(
            DB::raw('DATE_FORMAT(pembelian_tikets.created_at, "%Y-%m") as month'),
            DB::raw('SUM(detail_pembelian.harga_satuan * detail_pembelian.jumlah) as total_revenue'),
            'kategori_tikets.nama as kategori',
            DB::raw('SUM(detail_pembelian.jumlah) as total_sold')
        )
        ->when($month, function ($query) use ($month) {
            $query->whereMonth('pembelian_tikets.created_at', $month);
        })
        ->when($year, function ($query) use ($year) {
            $query->whereYear('pembelian_tikets.created_at', $year);
        })
        ->when($kategori, function ($query) use ($kategori) {
            $query->where('tikets.kategori_tiket_id', $kategori);
        })
        ->when($namaTiket, function ($query) use ($namaTiket) {
            $query->where('tikets.nama', 'like', "%$namaTiket%");
        })
        ->where('pembelian_tikets.status_pembayaran', 'success')
        ->groupBy('month', 'kategori')
        ->orderBy('month', 'desc')
        ->paginate(10);

    $kategoriTiket = KategoriTiket::all();

    // Data for the monthly revenue chart based on filters
    $monthlyRevenueData = $this->getMonthlyRevenueData($month, $year, $kategori, $namaTiket);

    return view('admin.reports.revenue', compact('revenueData', 'kategoriTiket', 'monthlyRevenueData'));
}


    public function filterRevenue(Request $request)
    {
        $month = $request->input('month');
        $year = $request->input('year');
        $kategori = $request->input('kategori');
        $namaTiket = $request->input('nama_tiket');

        $revenueData = DB::table('pembelian_tikets')
            ->join('detail_pembelian', 'pembelian_tikets.id', '=', 'detail_pembelian.pembelian_id')
            ->join('tikets', 'detail_pembelian.tiket_id', '=', 'tikets.tiket_id')
            ->join('kategori_tikets', 'tikets.kategori_tiket_id', '=', 'kategori_tikets.kategori_tiket_id')
            ->select(
                DB::raw('DATE_FORMAT(pembelian_tikets.created_at, "%Y-%m") as month'),
                DB::raw('SUM(detail_pembelian.harga_satuan * detail_pembelian.jumlah) as total_revenue'),
                'kategori_tikets.nama as kategori',
                DB::raw('SUM(detail_pembelian.jumlah) as total_sold')
            )
            ->when($month, function ($query) use ($month) {
                $query->whereMonth('pembelian_tikets.created_at', $month);
            })
            ->when($year, function ($query) use ($year) {
                $query->whereYear('pembelian_tikets.created_at', $year);
            })
            ->when($kategori, function ($query) use ($kategori) {
                $query->where('tikets.kategori_tiket_id', $kategori);
            })
            ->when($namaTiket, function ($query) use ($namaTiket) {
                $query->where('tikets.nama', 'like', "%$namaTiket%");
            })
            ->where('pembelian_tikets.status_pembayaran', 'success')
            ->groupBy('month', 'kategori')
            ->orderBy('month', 'desc')
            ->paginate(10);

        $kategoriTiket = KategoriTiket::all();
          $monthlyRevenueData = $this->getMonthlyRevenueData();

        return view('admin.reports.revenue', compact('revenueData', 'kategoriTiket', 'monthlyRevenueData'));
    }


    public function createTickets()
    {
        $kategoriTiket = KategoriTiket::all();
        return view('admin.tiket.create', compact('kategoriTiket'));
    }

  public function store(Request $request) {
        $request->validate([
            'nama' => 'required',
            'slug' => 'required|unique:tiket,slug',
            'deskripsi' => 'required',
            'kategori_tiket_id' => 'required',
            'harga_anak' => 'required|numeric',
            'harga_dewasa' => 'required|numeric',
            'kuota' => 'required|numeric',
            'usia_minimal' => 'required|numeric',
            'gambar' => 'image|nullable'
        ]);

        $gambarPath = $request->file('gambar') ? $request->file('gambar')->store('images/tiket', 'public') : null;

        Tiket::create([
            'tiket_id' => Str::uuid(),
            'nama' => $request->nama,
            'slug' => $request->slug,
            'deskripsi' => $request->deskripsi,
            'kategori_tiket_id' => $request->kategori_tiket_id,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'gambar' => $gambarPath,
            'harga_anak' => $request->harga_anak,
            'harga_dewasa' => $request->harga_dewasa,
            'kuota' => $request->kuota,
            'usia_minimal' => $request->usia_minimal,
        ]);
        
        return redirect()->route('admin.tickets.index')->with('success', 'Tiket berhasil ditambahkan.');
    }

    public function editTicket($id)
    {
        $ticket = Tiket::with('kategoriTiket')->findOrFail($id);
        $kategoriTiket = KategoriTiket::all();
        return view('admin.tiket.update', compact('ticket', 'kategoriTiket'));
    }

    public function editkategoriTicket($id)
    {
        // $ticket = Tiket::with('kategoriTiket')->findOrFail($id);
        $kategoriTiket = KategoriTiket::findOrFail($id);
        return view('admin.tiket-kategori.upadate', compact('kategoriTiket'));
    }


    public function updateTicketCategory(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $kategoriTiket = KategoriTiket::findOrFail($id);
        $kategoriTiket->nama = $request->input('nama');
        $kategoriTiket->deskripsi = $request->input('deskripsi');
        $kategoriTiket->save();

        return redirect()->route('admin.ticket-categories.index')->with('success', 'Category updated successfully.');
    }



    public function updateTicket(Request $request, $id)
    {
        $ticket = Tiket::findOrFail($id);

        $request->validate([
            'nama' => 'required',
            'slug' => 'required',
            'deskripsi' => 'required',
            'kategori_tiket_id' => 'required',
            'harga_anak' => 'required',
            'harga_dewasa' => 'required',
            'kuota' => 'required',
            'usia_minimal' => 'required',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date',
            'status' => 'required|in:aktif,tidak aktif'
        ]);

        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('images/tiket', 'public');
            $ticket->gambar = $gambarPath;
        }

        $ticket->nama = $request->nama;
        $ticket->slug = $request->slug;
        $ticket->deskripsi = $request->deskripsi;
        $ticket->kategori_tiket_id = $request->kategori_tiket_id;
        $ticket->harga_anak = $request->harga_anak;
        $ticket->harga_dewasa = $request->harga_dewasa;
        $ticket->kuota = $request->kuota;
        $ticket->usia_minimal = $request->usia_minimal;
        $ticket->tanggal_mulai = $request->tanggal_mulai;
        $ticket->tanggal_selesai = $request->tanggal_selesai;
        $ticket->status = $request->status;  //

        $ticket->save();

        return redirect()->route('admin.tickets.index')->with('success', 'Tiket berhasil diperbarui.');
    }
    public function updateStatus(Request $request, $id)
    {
        try {
            $ticket = Tiket::findOrFail($id);
            $ticket->status = $request->input('status');
            $ticket->save();

            return response()->json(['success' => true]);
        } catch (Exception $e) {
            Log::error('Error updating ticket status', ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
    
    public function showScanPage()
    {
        return view('admin.scan');
    }
    
public function processScan(Request $request)
{
    $qrCodeData = json_decode($request->input('qrCodeData'), true);
    $kodePembelian = $qrCodeData['kode_pembelian'] ?? null;

    if ($kodePembelian) {
        $pembelian = PembelianTiket::where('kode_pembelian', $kodePembelian)->first();

        if ($pembelian) {
            // Check if the ticket is already expired
            if ($pembelian->status == 'expired') {
                return redirect()->route('admin.scan')->with('error', 'Tiket sudah di-scan atau sudah expired.');
            }

            // Check if the current date is before the visit date
            $currentDate = Carbon::now();
            $visitDate = Carbon::parse($pembelian->tanggal_kunjungan);

            // If current date is after the visit date, mark the ticket as expired
            if ($currentDate->gte($visitDate)) {
                $pembelian->status = 'expired';
                $pembelian->expired_at = $currentDate;
                $pembelian->save();

                return redirect()->route('admin.scan')->with('success', 'Tiket berhasil di-scan.');
            } else {
                return redirect()->route('admin.scan')->with('error', 'Belum waktunya tanggal kunjungan.');
            }
        }
    }

    return redirect()->route('admin.scan')->with('error', 'QR code tidak valid atau tiket tidak ditemukan.');
}
    
}

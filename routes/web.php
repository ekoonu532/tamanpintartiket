<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WahanaController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\ProviderController;
use App\Http\Controllers\PaymentController;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Tiket;
use Filament\Facades\Filament;

use function Laravel\Prompts\progress;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::view('/', 'home')->name('home');
Route::view('/kontak-kami', 'kontak-kami')->name('kontakkami');
Route::get('/harga-tiket', [TicketController::class, 'indexharga'])->name('hargatiket');

Route::get('/', [TicketController::class, 'dashboard'])->name('dashboard');
Route::get('/api/tiket', [TicketController::class, 'getTiket']);

Route::get('/wahana/{slug}', [TicketController::class, 'wahanaDetail'])->name('wahana.detail');
Route::get('/tiket/kuota', [TicketController::class, 'getKuota']);
Route::get('/programkreativitas/{slug}', [TicketController::class, 'progDetail'])->name('programkreativitas.detail');
Route::get('/event/{slug}', [TicketController::class, 'eventDetail'])->name('event.detail');

Route::get('/auth/{provider}/redirect', [ProviderController::class, 'redirect']);

Route::get('/auth/{provider}/callback', [ProviderController::class, 'callback']);

Route::middleware('auth', 'role:pengunjung')->group(function () {
    Route::view('/tiket', 'tiket')->name('tiket');
    Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
    // Route::post('/checkout', [CheckoutController::class, 'halamancheckout'])->name('checkout');
    Route::post('/order', [TicketController::class, 'Order'])->name('order');
    Route::get('/tiket', [TicketController::class, 'index'])->name('tiket');
    Route::get('/tiket/{id}', [TicketController::class, 'ticketDetail'])->name('tiket.detail');
    Route::get('/order-tiket/{selected_date?}/{selected_ticket?}', [OrderController::class, 'index'])->name('order.index');

    Route::post('/store-order-tiket', [OrderController::class, 'store'])->name('order.store');
    Route::post('/process-order', [OrderController::class, 'processOrder'])->name('order.process');
    Route::get('/payment/{kode_pembelian}', [PaymentController::class, 'show'])->name('payment.page');
    Route::post('/payment/process', [PaymentController::class, 'processPayment'])->name('payment.process');
    Route::get('/payment/success/{kode_pembelian}', [PaymentController::class, 'success'])->name('payment.success');
    Route::get('/payment-failed', [PaymentController::class, 'paymentFailed'])->name('payment.failed');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile/pesanan-saya', [ProfileController::class, 'pesanan'])->name('profile.pesanan');
    Route::get('/ticket/{id}', [TicketController::class, 'show'])->name('ticket.show');
    Route::get('/ticket/download/{id}/{detailId}', [TicketController::class, 'download'])->name('ticket.download');
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
    Route::delete('/cart/remove/{tiket_id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/checkout', [OrderController::class, 'checkout'])->name('cart.checkout');
    Route::post('/cart/update/{id}', [CartController::class, 'updateCart'])->name('cart.update');

});
Route::get('/cart/count', [CartController::class, 'getCartCount'])->name('cart.count');

require __DIR__ . '/auth.php';

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('admin/dashboard', [AdminController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::get('admin/orders', [AdminController::class, 'manageOrders'])->name('admin.orders');
    Route::get('admin/users', [AdminController::class, 'manageUsers'])->name('admin.users');
    Route::get('/admin/users/{id}', [AdminController::class, 'getUserDetails']);
    Route::get('/admin/users', [AdminController::class, 'searchuser'])->name('admin.users.index');

    Route::get('admin/users', [AdminController::class, 'users'])->name('admin.users.index');
    Route::get('admin/users/create', [AdminController::class, 'createUser'])->name('admin.users.create');
    Route::post('admin/users', [AdminController::class, 'storeUser'])->name('admin.users.store');
    Route::get('admin/users/{id}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
    Route::put('admin/users/{id}', [AdminController::class, 'updateUser'])->name('admin.users.update');
    Route::delete('admin/users/{id}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');

    Route::get('admin/ticket-categories', [AdminController::class, 'ticketCategories'])->name('admin.ticket-categories.index');
    Route::get('admin/ticket-categories/create', [AdminController::class, 'createTicketCategory'])->name('admin.ticket-categories.create');
    Route::post('admin/ticket-categories', [AdminController::class, 'storeTicketCategory'])->name('admin.ticket-categories.store');
    Route::get('admin/ticket-categories/{id}/edit', [AdminController::class, 'editkategoriTicket'])->name('admin.ticket-categories.edit');
    Route::put('admin/ticket-categories/{id}', [AdminController::class, 'updateTicketCategory'])->name('admin.ticket-categories.update');
    Route::delete('admin/ticket-categories/{id}', [AdminController::class, 'destroyTicketCategory'])->name('admin.ticket-categories.destroy');

    Route::get('admin/tickets', [AdminController::class, 'tikets'])->name('admin.tickets.index');
    Route::get('tickets/search', [AdminController::class, 'searchtikets'])->name('admin.tickets.search');
    Route::get('admin/tickets/create', [AdminController::class, 'createTickets'])->name('admin.tickets.create');
    Route::post('admin/tickets', [AdminController::class, 'store'])->name('admin.tickets.store');
    Route::get('/admin/tickets/{id}', [AdminController::class, 'show']);
    Route::get('admin/tickets/{id}/edit', [AdminController::class, 'editTicket'])->name('admin.tickets.edit');
    Route::put('admin/tickets/{id}', [AdminController::class, 'updateTicket'])->name('admin.tickets.update');
    Route::put('/admin/tickets/{id}/status', [AdminController::class, 'updateStatus']);
    Route::delete('admin/tickets/{id}', [AdminController::class, 'destroyTicket'])->name('admin.tickets.destroy');

    Route::get('/admin/reports/transactions', [AdminController::class, 'transactionReports'])->name('admin.reports.transactions');
    Route::get('/admin/reports/sales', [AdminController::class, 'salesReports'])->name('admin.reports.sales');
    Route::get('/admin/reports/revenue', [AdminController::class, 'revenueReports'])->name('admin.reports.revenue');
    Route::get('/admin/transactions/filter', [AdminController::class, 'filterTransactions'])->name('admin.transactions.filter');
    Route::get('/admin/sales/filter', [AdminController::class, 'filterSales'])->name('sales');
    Route::get('/admin/revenue/filter', [AdminController::class, 'filterRevenue'])->name('admin.revenue.filter');
    // routes/web.php
Route::get('/admin/reports/transactions/export-pdf', [AdminController::class, 'exportTransactionsPdf'])->name('admin.reports.transactions.export-pdf');
Route::get('/admin/reports/sales/export-pdf', [AdminController::class, 'exportSalesPdf'])->name('admin.reports.sales.export-pdf');
Route::get('/admin/reports/revenue/export-pdf', [AdminController::class, 'exportRevenuePdf'])->name('admin.reports.revenue.export-pdf');
    Route::get('admin/scan', [AdminController::class, 'showScanPage'])->name('admin.scan');
Route::post('admin/scan/process', [AdminController::class, 'processScan'])->name('admin.scan.process');



});

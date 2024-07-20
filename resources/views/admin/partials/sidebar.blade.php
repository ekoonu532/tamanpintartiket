<aside id="sidebar" class="hidden lg:block fixed lg:relative top-0 left-0 w-full lg:w-64 h-full lg:h-screen bg-gray-800 z-50 lg:z-60">
    <div class="p-6">
        <h1 class="text-white text-2xl font-semibold">Admin Dashboard</h1>
        <nav class="mt-6">
            <a href="{{ route('admin.dashboard') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 hover:text-white text-gray-400">Dashboard</a>
            <a href="{{ route('admin.users.index') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 hover:text-white text-gray-400">Users</a>
            <a href="{{ route('admin.ticket-categories.index') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 hover:text-white text-gray-400">Ticket Categories</a>
            <a href="{{ route('admin.tickets.index') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 hover:text-white text-gray-400">Tickets</a>
            <a href="{{ route('admin.reports.transactions') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 hover:text-white text-gray-400">Transaction Reports</a>
            <a href="{{ route('admin.reports.orders') }}" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 hover:text-white text-gray-400">Order Reports</a>
        </nav>
    </div>
</aside>

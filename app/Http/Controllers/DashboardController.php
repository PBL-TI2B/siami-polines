<?php

namespace App\Http\Controllers;

use App\Models\Instrumen;
use App\Models\PeriodeAudit;
use App\Models\UnitKerja;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class DashboardController extends Controller
{
    
    public function index(Request $request)
{
    $data = collect([
        ['name' => 'John Doe', 'email' => 'johndoe123@gmail.com'],
        ['name' => 'Jane Doe', 'email' => 'janedoe456@gmail.com'],
        ['name' => 'Lionel Messi', 'email' => 'goat10@gmail.com'],
        ['name' => 'Cristiano Ronaldo', 'email' => 'cristiano7@gmail.com'],
        ['name' => 'Neymar Jr', 'email' => 'neymar11@gmail.com'],
        // tambahkan lebih banyak data untuk testing pagination
    ]);

    $perPage = 5;
    $currentPage = LengthAwarePaginator::resolveCurrentPage();
    $paginatedUsers = new LengthAwarePaginator(
        $data->slice(($currentPage - 1) * $perPage, $perPage)->values(),
        $data->count(),
        $perPage,
        $currentPage,
        ['path' => $request->url(), 'query' => $request->query()]
    );

    return view('admin.dashboard.index', [
        'users' => $paginatedUsers
    ]);
}
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Buyer;
use App\Models\Realty;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'moderator') {
            $pendingProperties = Realty::where('status', 'pending')->paginate(10);
            return view('admin.dashboard', compact('pendingProperties'));
        } else {
            $totalProperties = Realty::count();
            $pendingPropertiesCount = Realty::where('status', 'pending')->count();
            $totalUsers = User::count();
            $totalRequests = Buyer::count();
            return view('admin.dashboard', compact('totalProperties', 'pendingPropertiesCount', 'totalUsers', 'totalRequests'));
        }
    }
}

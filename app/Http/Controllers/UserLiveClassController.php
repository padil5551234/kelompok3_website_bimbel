<?php

namespace App\Http\Controllers;

use App\Models\LiveClass;
use App\Models\Pembelian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserLiveClassController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    /**
     * Display user's available live classes
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        
        $query = LiveClass::query();
        
        // Get user's verified purchased packages only
        $purchasedPackages = Pembelian::forUser($user->id)
            ->verified()
            ->with('paketUjian')
            ->get()
            ->pluck('paketUjian')
            ->filter();

        // Filter live classes by purchased packages
        if ($purchasedPackages->isNotEmpty()) {
            $packageIds = $purchasedPackages->pluck('id');
            $query->whereIn('batch_id', $packageIds);
        } else {
            // If user hasn't purchased any verified package, show empty result
            $query->whereRaw('1 = 0');
        }

        // Filter by status
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        } else {
            // By default, show scheduled and ongoing classes
            $query->whereIn('status', ['scheduled', 'ongoing']);
        }

        // Filter by package
        if ($request->has('package') && $request->package !== 'all') {
            $query->where('batch_id', $request->package);
        }

        // Search by title
        if ($request->has('search') && !empty($request->search)) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $liveClasses = $query->with(['tutor', 'batch'])
            ->orderBy('scheduled_at', 'asc')
            ->paginate(12);

        // Get purchased packages for display
        $purchasedPackages = Pembelian::forUser($user->id)
            ->verified()
            ->with('paketUjian')
            ->get()
            ->pluck('paketUjian')
            ->filter();

        return view('views_user.live_zoom.index', compact('liveClasses', 'purchasedPackages'));
    }

    /**
     * Display the specified live class
     */
    public function show(LiveClass $liveClass)
    {
        $user = Auth::user();
        
        // Check if user has verified purchase access
        $hasAccess = Pembelian::forUser($user->id)
            ->forPackage($liveClass->batch_id)
            ->verified()
            ->exists();
        
        if (!$hasAccess) {
            abort(403, 'Anda tidak memiliki akses ke kelas ini. Silakan beli paket terlebih dahulu dan pastikan pembayaran sudah diverifikasi.');
        }

        return view('views_user.live_zoom.show', compact('liveClass'));
    }
}
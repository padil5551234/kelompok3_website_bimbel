<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\User;
use App\Mail\Message;
use App\Models\Ujian;
use App\Models\Pembelian;
use App\Models\PaketUjian;
use App\Models\Article;
use App\Models\Material;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;

class DashboardController extends Controller
{
    public function index()
    {
        if (auth()->check()) {
            $user = auth()->user();

            if ($user->hasRole('tutor')) {
                return redirect()->route('tutor.dashboard');
            }

            if ($user->hasRole('admin')) {
                return redirect()->route('admin.dashboard');
            }
        }

        $data = $this->getPublicDashboardData();
        return view('views_user.dashboard', $data);
    }

    private function getPublicDashboardData()
    {
        $paketsQuery = PaketUjian::orderBy('created_at', 'asc');

        if (auth()->check()) {
            $paketsQuery->with(['pembelian' => function ($query) {
                $query->where('user_id', auth()->id())->where('status', "Sukses");
            }]);
        }

        $allPackages = $paketsQuery->get();
        
        // For authenticated users, separate purchased and available packages
        if (auth()->check()) {
            $purchasedPackages = $allPackages->filter(function($paket) {
                return $paket->pembelian->isNotEmpty();
            });
            
            $availablePackages = $allPackages->filter(function($paket) {
                return $paket->pembelian->isEmpty();
            });
            
            return [
                'pakets' => $allPackages, // Keep for backward compatibility
                'purchasedPackages' => $purchasedPackages,
                'availablePackages' => $availablePackages,
                'faqs' => Faq::orderBy('pinned', 'desc')->orderBy('created_at', 'desc')->get(),
                'featuredArticles' => Article::published()->featured()->orderBy('published_at', 'desc')->limit(3)->get(),
                'articles' => Article::published()->orderBy('published_at', 'desc')->limit(3)->get(),
            ];
        }

        return [
            'pakets' => $allPackages,
            'faqs' => Faq::orderBy('pinned', 'desc')->orderBy('created_at', 'desc')->get(),
            'featuredArticles' => Article::published()->featured()->orderBy('published_at', 'desc')->limit(3)->get(),
            'articles' => Article::published()->orderBy('published_at', 'desc')->limit(3)->get(),
        ];
    }


    public function adminIndex()
    {
        if (!(auth()->user()->hasRole('admin'))) {
            abort(403, 'Error!');
        }

        // Basic statistics
        $data['paketUjian'] = PaketUjian::count();
        $data['ujian'] = Ujian::count();
        $data['ujianActive'] = Ujian::where('waktu_mulai', '<=', now())
                                ->where('waktu_akhir', '>=', now())
                                ->where('isPublished', 1)
                                ->count();
        $data['pembelian'] = Pembelian::where('status', 'Sukses')
                                ->where('jenis_pembayaran', '!=', 'Bundling')
                                ->count();
        $data['user'] = User::role('user')->count();
        $data['revenue'] = Pembelian::where('status', 'Sukses')
                                ->where('jenis_pembayaran', '!=', 'Bundling')
                                ->sum('harga');

        // Integrated Course Statistics
        $data['courses'] = PaketUjian::withCount('materials')->get();
        $data['totalMaterials'] = Material::count();
        $data['totalTutors'] = User::count();

        return view('admin.dashboard', compact('data'));
    }

    public function sendEmail(Request $request) {
        Mail::to('padilzaki73@gmail.com')->send(new Message($request));

        return response()->json([
            'message' => 'Sukses'
        ], 200); // Status code here
    }
}

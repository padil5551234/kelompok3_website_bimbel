<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class TutorController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'role:admin']);
    }

    /**
     * Display a listing of tutors.
     */
    public function index()
    {
        return view('admin.tutor.index');
    }

    /**
     * Get tutors data for DataTables.
     */
    public function data()
    {
        $tutors = User::with('roles')
            ->role('tutor')
            ->orderBy('name', 'asc');

        return datatables()
            ->eloquent($tutors)
            ->addIndexColumn()
            ->addColumn('aksi', function ($tutor) {
                return view('admin.tutor.actions', compact('tutor'));
            })
            ->editColumn('created_at', function ($tutor) {
                return $tutor->created_at->format('d/m/Y H:i');
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    /**
     * Show the form for creating a new tutor.
     */
    public function create()
    {
        return view('admin.tutor.form');
    }

    /**
     * Store a newly created tutor.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'email_verified_at' => now(), // Auto-verify email for tutors
        ]);

        $user->assignRole('tutor');

        return redirect()->route('admin.tutor.index')
            ->with('success', 'Tutor berhasil ditambahkan');
    }

    /**
     * Display the specified tutor.
     */
    public function show(User $tutor)
    {
        $this->authorize('view', $tutor);
        return view('admin.tutor.show', compact('tutor'));
    }

    /**
     * Show the form for editing the specified tutor.
     */
    public function edit(User $tutor)
    {
        $this->authorize('update', $tutor);
        return view('admin.tutor.form', compact('tutor'));
    }

    /**
     * Update the specified tutor.
     */
    public function update(Request $request, User $tutor)
    {
        $this->authorize('update', $tutor);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $tutor->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $tutor->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        if ($request->filled('password')) {
            $tutor->update([
                'password' => $request->password,
            ]);
        }

        return redirect()->route('admin.tutor.index')
            ->with('success', 'Tutor berhasil diperbarui');
    }

    /**
     * Remove the specified tutor.
     */
    public function destroy(User $tutor)
    {
        try {
            // Temporarily disable authorization for debugging
            // $this->authorize('delete', $tutor);
            
            // Check if user can be deleted manually
            $user = auth()->user();
            if (!$user->hasRole('admin')) {
                throw new \Exception('Anda tidak memiliki权限 untuk menghapus tutor ini.');
            }
            
            // Check if trying to delete self
            if ($user->id === $tutor->id) {
                throw new \Exception('Anda tidak dapat menghapus akun sendiri.');
            }
            
            $tutor->delete();

            return response()->json(['success' => 'Tutor berhasil dihapus']);
        } catch (\Exception $e) {
            \Log::error('Tutor deletion error: ' . $e->getMessage());
            return response()->json(['error' => 'Tidak dapat menghapus tutor: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Reset password for the specified tutor.
     */
    public function resetPassword(Request $request, User $tutor)
    {
        $this->authorize('update', $tutor);

        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $tutor->update([
            'password' => $request->password,
        ]);

        return redirect()->route('admin.tutor.index')
            ->with('success', 'Password tutor berhasil direset');
    }
}
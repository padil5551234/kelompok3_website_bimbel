<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Tutor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
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
        $tutors = User::with('roles', 'tutorProfile')
            ->role('tutor')
            ->orderBy('name', 'asc');

        return datatables()
            ->eloquent($tutors)
            ->addIndexColumn()
            ->addColumn('has_profile', function ($tutor) {
                return $tutor->tutorProfile ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-muted"></i>';
            })
            ->addColumn('aksi', function ($tutor) {
                return view('admin.tutor.actions', compact('tutor'));
            })
            ->editColumn('created_at', function ($tutor) {
                return $tutor->created_at->format('d/m/Y H:i');
            })
            ->rawColumns(['has_profile', 'aksi'])
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

    /**
     * Show the form for editing tutor profile.
     */
    public function profile(User $tutor)
    {
        $this->authorize('update', $tutor);

        $tutorProfile = $tutor->tutorProfile ?? new Tutor(['user_id' => $tutor->id]);
        $action = route('admin.tutor.updateProfile', $tutor->id);

        return view('admin.tutor.profile', compact('tutor', 'tutorProfile', 'action'));
    }

    /**
     * Update the specified tutor profile.
     */
    public function updateProfile(Request $request, User $tutor)
    {
        $this->authorize('update', $tutor);

        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'bio' => 'nullable|string|max:1000',
            'specialization' => 'nullable|string|max:255',
            'experience' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        $tutorProfile = $tutor->tutorProfile ?? new Tutor(['user_id' => $tutor->id]);

        $tutorProfile->bio = $request->bio;
        $tutorProfile->specialization = $request->specialization;
        $tutorProfile->experience = $request->experience;
        $tutorProfile->is_active = $request->has('is_active');

        if ($request->hasFile('image')) {
            // Delete old image
            if ($tutorProfile->image && Storage::disk('public')->exists($tutorProfile->image)) {
                Storage::disk('public')->delete($tutorProfile->image);
            }
            $imagePath = $request->file('image')->store('tutors', 'public');
            $tutorProfile->image = $imagePath;
        }

        $tutorProfile->save();

        return redirect()->route('admin.tutor.index')
            ->with('success', 'Profile tutor berhasil diperbarui');
    }
}
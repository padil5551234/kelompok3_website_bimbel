<?php

namespace App\Http\Controllers\Admin;

use App\Models\Testimonial;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'role:admin']);
    }

    /**
     * Display a listing of testimonials.
     */
    public function index()
    {
        return view('admin.testimonial.index');
    }

    /**
     * Get testimonials data for DataTables.
     */
    public function data()
    {
        $testimonials = Testimonial::orderBy('created_at', 'desc');

        return datatables()
            ->eloquent($testimonials)
            ->addIndexColumn()
            ->addColumn('rating_display', function ($testimonial) {
                $stars = '';
                for ($i = 1; $i <= 5; $i++) {
                    $stars .= $i <= $testimonial->rating ? '<i class="fas fa-star text-warning"></i>' : '<i class="far fa-star text-warning"></i>';
                }
                return $stars;
            })
            ->addColumn('status', function ($testimonial) {
                return $testimonial->is_active ?
                    '<span class="badge badge-success">Aktif</span>' :
                    '<span class="badge badge-secondary">Tidak Aktif</span>';
            })
            ->addColumn('aksi', function ($testimonial) {
                return view('admin.testimonial.actions', compact('testimonial'));
            })
            ->editColumn('created_at', function ($testimonial) {
                return $testimonial->created_at->format('d/m/Y H:i');
            })
            ->rawColumns(['rating_display', 'status', 'aksi'])
            ->make(true);
    }

    /**
     * Show the form for creating a new testimonial.
     */
    public function create()
    {
        $testimonial = new Testimonial();
        $action = route('admin.testimonial.store');

        return view('admin.testimonial.form', compact('testimonial', 'action'));
    }

    /**
     * Store a newly created testimonial.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'graduation' => 'nullable|string|max:255',
            'message' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'rating' => 'required|integer|min:1|max:5',
            'is_active' => 'boolean',
        ]);

        $testimonial = new Testimonial();
        $testimonial->name = $request->name;
        $testimonial->graduation = $request->graduation;
        $testimonial->message = $request->message;
        $testimonial->rating = $request->rating;
        $testimonial->is_active = $request->has('is_active');

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('testimonials', 'public');
            $testimonial->image = $imagePath;
        }

        $testimonial->save();

        return redirect()->route('admin.testimonial.index')->with('success', 'Testimonial berhasil ditambahkan');
    }

    /**
     * Display the specified testimonial.
     */
    public function show(Testimonial $testimonial)
    {
        //
    }

    /**
     * Show the form for editing the specified testimonial.
     */
    public function edit(Testimonial $testimonial)
    {
        $action = route('admin.testimonial.update', $testimonial->id);

        return view('admin.testimonial.form', compact('testimonial', 'action'));
    }

    /**
     * Update the specified testimonial.
     */
    public function update(Request $request, Testimonial $testimonial)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'graduation' => 'nullable|string|max:255',
            'message' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'rating' => 'required|integer|min:1|max:5',
            'is_active' => 'boolean',
        ]);

        $testimonial->name = $request->name;
        $testimonial->graduation = $request->graduation;
        $testimonial->message = $request->message;
        $testimonial->rating = $request->rating;
        $testimonial->is_active = $request->has('is_active');

        if ($request->hasFile('image')) {
            // Delete old image
            if ($testimonial->image && Storage::disk('public')->exists($testimonial->image)) {
                Storage::disk('public')->delete($testimonial->image);
            }
            $imagePath = $request->file('image')->store('testimonials', 'public');
            $testimonial->image = $imagePath;
        }

        $testimonial->update();

        return redirect()->route('admin.testimonial.index')->with('success', 'Testimonial berhasil diperbarui');
    }

    /**
     * Remove the specified testimonial.
     */
    public function destroy(Testimonial $testimonial)
    {
        try {
            // Delete image if exists
            if ($testimonial->image && Storage::disk('public')->exists($testimonial->image)) {
                Storage::disk('public')->delete($testimonial->image);
            }

            $testimonial->delete();

            return response()->json(['success' => 'Testimonial berhasil dihapus']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Tidak dapat menghapus testimonial: ' . $e->getMessage()], 500);
        }
    }
}
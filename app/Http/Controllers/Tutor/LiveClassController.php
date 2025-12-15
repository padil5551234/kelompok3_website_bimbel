<?php

namespace App\Http\Controllers\Tutor;

use App\Http\Controllers\Controller;
use App\Models\LiveClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LiveClassController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'role:tutor']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Auth::user()->liveClasses();

        // Filter by status
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Search by title
        if ($request->has('search') && !empty($request->search)) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $liveClasses = $query->orderBy('scheduled_at', 'desc')->paginate(10);

        return view('tutor.live-classes.index', compact('liveClasses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $paketUjians = \App\Models\PaketUjian::all(); // Or filter based on tutor's access if needed

        return view('tutor.live-classes.create', compact('paketUjians'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'batch_id' => 'required|exists:paket_ujian,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'meeting_link' => 'nullable|url',
            'meeting_password' => 'nullable|string|max:50',
            'platform' => 'required|in:zoom,google_meet,teams,other',
            'scheduled_at' => 'required|date|after:now',
            'duration_minutes' => 'required|integer|min:15|max:480',
            'max_participants' => 'nullable|integer|min:1|max:1000',
            'materials' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $liveClass = Auth::user()->liveClasses()->create([
            'batch_id' => $request->batch_id,
            'title' => $request->title,
            'description' => $request->description,
            'meeting_link' => $request->meeting_link,
            'meeting_password' => $request->meeting_password,
            'platform' => $request->platform,
            'scheduled_at' => $request->scheduled_at,
            'duration_minutes' => $request->duration_minutes,
            'max_participants' => $request->max_participants,
            'materials' => $request->materials,
            'status' => 'scheduled',
        ]);

        return redirect()->route('tutor.live-classes.index')
            ->with('success', 'Live class berhasil dijadwalkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(LiveClass $liveClass)
    {
        $this->authorize('view', $liveClass);
        
        return view('tutor.live-classes.show', compact('liveClass'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LiveClass $liveClass)
    {
        $this->authorize('update', $liveClass);

        $paketUjians = \App\Models\PaketUjian::all(); // Or filter based on tutor's access if needed

        return view('tutor.live-classes.edit', compact('liveClass', 'paketUjians'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LiveClass $liveClass)
    {
        $this->authorize('update', $liveClass);

        $validator = Validator::make($request->all(), [
            'batch_id' => 'required|exists:paket_ujian,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'meeting_link' => 'nullable|url',
            'meeting_password' => 'nullable|string|max:50',
            'platform' => 'required|in:zoom,google_meet,teams,other',
            'scheduled_at' => 'required|date|after:now',
            'duration_minutes' => 'required|integer|min:15|max:480',
            'max_participants' => 'nullable|integer|min:1|max:1000',
            'materials' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $liveClass->update([
            'batch_id' => $request->batch_id,
            'title' => $request->title,
            'description' => $request->description,
            'meeting_link' => $request->meeting_link,
            'meeting_password' => $request->meeting_password,
            'platform' => $request->platform,
            'scheduled_at' => $request->scheduled_at,
            'duration_minutes' => $request->duration_minutes,
            'max_participants' => $request->max_participants,
            'materials' => $request->materials,
        ]);

        return redirect()->route('tutor.live-classes.index')
            ->with('success', 'Live class berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LiveClass $liveClass)
    {
        $this->authorize('delete', $liveClass);
        
        $liveClass->delete();

        return redirect()->route('tutor.live-classes.index')
            ->with('success', 'Live class berhasil dihapus!');
    }

    /**
     * Start the live class.
     */
    public function start(LiveClass $liveClass)
    {
        $this->authorize('update', $liveClass);

        if ($liveClass->status !== 'scheduled') {
            return redirect()->back()
                ->with('error', 'Live class tidak dapat dimulai!');
        }

        $liveClass->update(['status' => 'ongoing']);

        return redirect()->route('tutor.live-classes.show', $liveClass)
            ->with('success', 'Live class telah dimulai!');
    }

    /**
     * End the live class.
     */
    public function end(LiveClass $liveClass)
    {
        $this->authorize('update', $liveClass);

        if ($liveClass->status !== 'ongoing') {
            return redirect()->back()
                ->with('error', 'Live class tidak sedang berlangsung!');
        }

        $liveClass->update(['status' => 'completed']);

        return redirect()->route('tutor.live-classes.show', $liveClass)
            ->with('success', 'Live class telah selesai!');
    }

    /**
     * Cancel the live class.
     */
    public function cancel(LiveClass $liveClass)
    {
        $this->authorize('update', $liveClass);

        if (!in_array($liveClass->status, ['scheduled', 'ongoing'])) {
            return redirect()->back()
                ->with('error', 'Live class tidak dapat dibatalkan!');
        }

        $liveClass->update(['status' => 'cancelled']);

        return redirect()->route('tutor.live-classes.index')
            ->with('success', 'Live class berhasil dibatalkan!');
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\AdminNotice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class AdminNoticeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // Assuming admin authentication
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notices = AdminNotice::with(['createdBy', 'updatedBy'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);
            
        return view('admin.notices.index', compact('notices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.notices.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'type' => 'required|in:info,success,warning,danger',
            'priority' => 'required|in:low,medium,high',
            'is_active' => 'boolean',
            'is_dismissible' => 'boolean',
            'show_on_dashboard' => 'boolean',
            'show_on_login' => 'boolean',
            'starts_at' => 'nullable|date|after_or_equal:today',
            'expires_at' => 'nullable|date|after:starts_at',
            'target_audience' => 'nullable|array'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $notice = AdminNotice::create([
            'title' => $request->title,
            'content' => $request->content,
            'type' => $request->type,
            'priority' => $request->priority,
            'is_active' => $request->boolean('is_active', true),
            'is_dismissible' => $request->boolean('is_dismissible', true),
            'show_on_dashboard' => $request->boolean('show_on_dashboard', true),
            'show_on_login' => $request->boolean('show_on_login', false),
            'starts_at' => $request->starts_at ? Carbon::parse($request->starts_at) : null,
            'expires_at' => $request->expires_at ? Carbon::parse($request->expires_at) : null,
            'created_by' => Auth::id(),
            'target_audience' => $request->target_audience ?? []
        ]);

        return redirect()->route('admin.notices.index')
            ->with('success', 'Admin notice created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(AdminNotice $notice)
    {
        $notice->load(['createdBy', 'updatedBy']);
        return view('admin.notices.show', compact('notice'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AdminNotice $notice)
    {
        return view('admin.notices.edit', compact('notice'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AdminNotice $notice)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'type' => 'required|in:info,success,warning,danger',
            'priority' => 'required|in:low,medium,high',
            'is_active' => 'boolean',
            'is_dismissible' => 'boolean',
            'show_on_dashboard' => 'boolean',
            'show_on_login' => 'boolean',
            'starts_at' => 'nullable|date',
            'expires_at' => 'nullable|date|after:starts_at',
            'target_audience' => 'nullable|array'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $notice->update([
            'title' => $request->title,
            'content' => $request->content,
            'type' => $request->type,
            'priority' => $request->priority,
            'is_active' => $request->boolean('is_active'),
            'is_dismissible' => $request->boolean('is_dismissible'),
            'show_on_dashboard' => $request->boolean('show_on_dashboard'),
            'show_on_login' => $request->boolean('show_on_login'),
            'starts_at' => $request->starts_at ? Carbon::parse($request->starts_at) : null,
            'expires_at' => $request->expires_at ? Carbon::parse($request->expires_at) : null,
            'updated_by' => Auth::id(),
            'target_audience' => $request->target_audience ?? []
        ]);

        return redirect()->route('admin.notices.index')
            ->with('success', 'Admin notice updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AdminNotice $notice)
    {
        $notice->delete();
        
        return redirect()->route('admin.notices.index')
            ->with('success', 'Admin notice deleted successfully!');
    }

    /**
     * Toggle notice active status
     */
    public function toggleStatus(AdminNotice $notice)
    {
        $notice->update([
            'is_active' => !$notice->is_active,
            'updated_by' => Auth::id()
        ]);

        $status = $notice->is_active ? 'activated' : 'deactivated';
        return back()->with('success', "Notice {$status} successfully!");
    }
}

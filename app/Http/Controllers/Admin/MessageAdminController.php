<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FanMessage;
use App\Models\Fan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class MessageAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    /**
     * Display a listing of fan messages with filters
     */
    public function index(Request $request)
    {
        $query = FanMessage::with(['fan']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('subject', 'like', "%{$search}%")
                  ->orWhere('message', 'like', "%{$search}%")
                  ->orWhereHas('fan', function($fanQuery) use ($search) {
                      $fanQuery->where('first_name', 'like', "%{$search}%")
                               ->orWhere('last_name', 'like', "%{$search}%")
                               ->orWhere('phone', 'like', "%{$search}%");
                  });
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by priority
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Sort messages
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $messages = $query->paginate(20)->appends($request->query());

        // Get statistics
        $stats = [
            'total_messages' => FanMessage::count(),
            'pending_messages' => FanMessage::where('status', 'open')->count(),
            'replied_messages' => FanMessage::where('status', 'replied')->count(),
            'closed_messages' => FanMessage::where('status', 'closed')->count(),
            'high_priority' => FanMessage::where('priority', 'high')->count(),
            'new_today' => FanMessage::whereDate('created_at', Carbon::today())->count(),
            'avg_response_time' => $this->calculateAverageResponseTime(),
        ];

        return view('admin.messages.index', compact('messages', 'stats'));
    }

    /**
     * Calculate average response time for replied messages
     */
    private function calculateAverageResponseTime()
    {
        $repliedMessages = FanMessage::where('status', 'replied')
            ->whereNotNull('replied_at')
            ->get();

        if ($repliedMessages->isEmpty()) {
            return null;
        }

        $totalHours = 0;
        foreach ($repliedMessages as $message) {
            $responseTime = $message->created_at->diffInHours($message->replied_at);
            $totalHours += $responseTime;
        }

        $averageHours = $totalHours / $repliedMessages->count();
        
        if ($averageHours < 1) {
            return round($averageHours * 60) . ' minutes';
        } elseif ($averageHours < 24) {
            return round($averageHours, 1) . ' hours';
        } else {
            return round($averageHours / 24, 1) . ' days';
        }
    }

    /**
     * Display the specified message with full details
     */
    public function show(FanMessage $message)
    {
        $message->load('fan');
        
        // Mark as read if not already
        if (!$message->read_at) {
            $message->update([
                'read_at' => now(),
                'read_by' => auth()->id()
            ]);
        }

        // Get fan's other messages for context
        $fanMessages = FanMessage::where('fan_id', $message->fan_id)
            ->where('id', '!=', $message->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('admin.messages.show', compact('message', 'fanMessages'));
    }

    /**
     * Reply to a fan message
     */
    public function reply(Request $request, FanMessage $message)
    {
        $request->validate([
            'reply_message' => 'required|string|min:10',
            'status' => 'required|in:resolved,closed'
        ]);

        // Update the message with reply
        $message->update([
            'admin_reply' => $request->reply_message,
            'replied_at' => now(),
            'replied_by' => auth()->id(),
            'status' => $request->status
        ]);

        // Optionally send SMS notification to fan
        // This would require SMS service integration
        // $this->sendSMSNotification($message->fan, 'Your message has been replied to by AZAM FC.');

        return redirect()->route('admin.messages.show', $message)
            ->with('success', 'Reply sent successfully!');
    }

    /**
     * Update message status
     */
    public function updateStatus(Request $request, FanMessage $message)
    {
        $request->validate([
            'status' => 'required|in:open,in_progress,resolved,closed'
        ]);

        $message->update([
            'status' => $request->status,
            'updated_by' => auth()->id()
        ]);

        return redirect()->back()
            ->with('success', 'Message status updated successfully!');
    }

    /**
     * Update message priority
     */
    public function updatePriority(Request $request, FanMessage $message)
    {
        $request->validate([
            'priority' => 'required|in:low,medium,high'
        ]);

        $message->update([
            'priority' => $request->priority,
            'updated_by' => auth()->id()
        ]);

        return redirect()->back()
            ->with('success', 'Message priority updated successfully!');
    }

    /**
     * Bulk update message statuses
     */
    public function bulkUpdate(Request $request)
    {
        $request->validate([
            'message_ids' => 'required|array',
            'message_ids.*' => 'exists:fan_messages,id',
            'action' => 'required|in:mark_read,mark_resolved,mark_closed,delete'
        ]);

        $messages = FanMessage::whereIn('id', $request->message_ids);

        switch ($request->action) {
            case 'mark_read':
                $messages->update([
                    'read_at' => now(),
                    'read_by' => auth()->id()
                ]);
                $successMessage = 'Messages marked as read.';
                break;

            case 'mark_resolved':
                $messages->update([
                    'status' => 'resolved',
                    'updated_by' => auth()->id()
                ]);
                $successMessage = 'Messages marked as resolved.';
                break;

            case 'mark_closed':
                $messages->update([
                    'status' => 'closed',
                    'updated_by' => auth()->id()
                ]);
                $successMessage = 'Messages marked as closed.';
                break;

            case 'delete':
                $messages->delete();
                $successMessage = 'Messages deleted successfully.';
                break;
        }

        return redirect()->route('admin.messages.index')
            ->with('success', $successMessage);
    }



    /**
     * Get message statistics for dashboard
     */
    public function getStats()
    {
        return response()->json([
            'total_messages' => FanMessage::count(),
            'pending_messages' => FanMessage::where('status', 'open')->count(),
            'unread_messages' => FanMessage::whereNull('read_at')->count(),
            'high_priority_pending' => FanMessage::where('status', 'open')
                ->where('priority', 'high')->count(),
            'messages_today' => FanMessage::whereDate('created_at', Carbon::today())->count(),
            'avg_response_time' => $this->getAverageResponseTime()
        ]);
    }

    /**
     * Calculate average response time in hours
     */
    private function getAverageResponseTime()
    {
        $repliedMessages = FanMessage::whereNotNull('replied_at')
            ->whereNotNull('created_at')
            ->get();

        if ($repliedMessages->isEmpty()) {
            return 0;
        }

        $totalHours = $repliedMessages->sum(function($message) {
            return $message->created_at->diffInHours($message->replied_at);
        });

        return round($totalHours / $repliedMessages->count(), 1);
    }
}

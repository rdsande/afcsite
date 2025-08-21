<?php

namespace App\Http\Controllers;

use App\Models\FanMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FanMessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:fan');
    }

    /**
     * Display fan's messages
     */
    public function index()
    {
        $fan = Auth::guard('fan')->user();
        
        $messages = FanMessage::where('fan_id', $fan->id)
            ->notSpam()
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $stats = [
            'total' => FanMessage::where('fan_id', $fan->id)->notSpam()->count(),
            'pending' => FanMessage::where('fan_id', $fan->id)->pending()->count(),
            'resolved' => FanMessage::where('fan_id', $fan->id)->where('status', 'resolved')->count(),
        ];

        return view('fan.messages.index', compact('messages', 'stats'));
    }

    /**
     * Show form for creating new message
     */
    public function create()
    {
        $categories = [
            'general' => 'General Inquiry',
            'technical' => 'Technical Support',
            'membership' => 'Membership',
            'events' => 'Events & Tickets',
            'merchandise' => 'Merchandise',
            'complaint' => 'Complaint',
            'suggestion' => 'Suggestion'
        ];

        return view('fan.messages.create', compact('categories'));
    }

    /**
     * Store new message
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
            'category' => 'required|in:general,technical,membership,events,merchandise,complaint,suggestion',
            'priority' => 'required|in:low,medium,high'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $fan = Auth::guard('fan')->user();

        // Check for spam (simple rate limiting)
        $recentMessages = FanMessage::where('fan_id', $fan->id)
            ->where('created_at', '>=', now()->subHour())
            ->count();

        if ($recentMessages >= 5) {
            return redirect()->back()
                ->with('error', 'You have reached the hourly message limit. Please try again later.');
        }

        FanMessage::create([
            'fan_id' => $fan->id,
            'subject' => $request->subject,
            'message' => $request->message,
            'category' => $request->category,
            'priority' => $request->priority,
            'status' => 'open',
            'ip_address' => $request->ip()
        ]);

        return redirect()->route('fan.messages.index')
            ->with('success', 'Your message has been sent successfully. We will respond soon.');
    }

    /**
     * Show specific message
     */
    public function show(FanMessage $message)
    {
        $fan = Auth::guard('fan')->user();
        
        // Ensure fan can only view their own messages
        if ($message->fan_id !== $fan->id) {
            abort(403);
        }

        return view('fan.messages.show', compact('message'));
    }

    /**
     * Delete message
     */
    public function destroy(FanMessage $message)
    {
        $fan = Auth::guard('fan')->user();
        
        // Ensure fan can only delete their own messages
        if ($message->fan_id !== $fan->id) {
            abort(403);
        }

        $message->delete();

        return redirect()->route('fan.messages.index')
            ->with('success', 'Message deleted successfully.');
    }
}

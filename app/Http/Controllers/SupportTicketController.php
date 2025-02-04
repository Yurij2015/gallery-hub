<?php

namespace App\Http\Controllers;

use App\Models\SupportTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupportTicketController extends Controller
{
    public function index()
    {
        if(Auth::user()->hasRole('admin')) {
            $tickets = SupportTicket::all();
            return view('support.index', compact('tickets'));
        }

        $tickets = SupportTicket::where('user_id', Auth::id())->get();
        return view('support.index', compact('tickets'));
    }

    public function create()
    {
        return view('support.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        SupportTicket::create([
            'subject' => $request->subject,
            'message' => $request->message,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('support.index')->with('success', 'Ticket submitted successfully.');
    }

    public function show(SupportTicket $ticket)
    {
        if ($ticket->user_id !== Auth::id() && !Auth::user()->hasRole('admin')) {
            abort(403);
        }
        return view('support.show', compact('ticket'));
    }
}


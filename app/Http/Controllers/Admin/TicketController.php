<?php

namespace App\Http\Controllers\Admin;

use App\Enums\DIDOrderStatus;
use App\Enums\TicketStatus;
use App\Http\Controllers\Controller;
use App\Ticket;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class TicketController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin|operator']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|Response|View
     */
    public function index()
    {
        $tickets = Ticket::withTrashed()->with(['fancy_number.user', 'parent'])->get();
        return view('admin.tickets.index', compact('tickets'));
    }

    /**
     * @param \App\Ticket $ticket
     */
    public function openTicket(Ticket $ticket)
    {
        if ($ticket->isOpen()) {
            return redirect()->back()->with('alert', [
                'type' => 'warning',
                'message' => "Ticket #$ticket->id has already been open."
            ]);
        }

        $ticket->status = TicketStatus::IN_PROGRESS;
        $ticket->started_at = Carbon::now();
        $ticket->assigned_id = Auth::id();

        $ticket->save();

        return redirect()->route('admin.tickets.edit', $ticket->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Application|Factory|Response|View
     */
    public function show(int $id)
    {
        $ticket = Ticket::withTrashed()->find($id);

        return view('admin.tickets.show', compact('ticket'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param Ticket $ticket
     * @return Application|Factory|RedirectResponse|View
     */
    public function edit(Ticket $ticket)
    {
        if ($ticket->isPending()) {
            $ticket_url = route('admin.tickets.show', $ticket->id);

            return redirect()->route('admin.tickets.index')->with('alert', [
                'type' => 'warning',
                'message' => "Ticket #$ticket->id must be <strong>Open</strong> before editing. Click <a href=\"$ticket_url\">here</a> to open the ticket"
            ]);
        }

        if ($ticket->isCompleted() || $ticket->isCanceled()) {
            return redirect()->route('admin.tickets.show', $ticket->id);
        }

        if (!$ticket->belongsToAuthenticatedUser()) {
            return redirect()->route('admin.tickets.index')->with('alert', [
                'type' => 'warning',
                'message' => "Ticket #$ticket->id has already been assigned to another Operator"
            ]);
        }

        $settings = $ticket->fancy_number->settings()->first();

        return view('admin.tickets.edit', compact('ticket', 'settings'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Ticket $ticket
     * @return RedirectResponse
     */
    public function update(Ticket $ticket)
    {
        $ticket->status = TicketStatus::COMPLETED;
        $ticket->completed_at = Carbon::now();

        $ticket->save();

        $fancy_number = $ticket->fancy_number;
        $fancy_number->did_status = DIDOrderStatus::COMPLETED;
        $fancy_number->save();

        return response()->redirectToRoute('admin.tickets.index')->with('alert', [
            'type' => 'success',
            'message' => 'Ticket# ' . $ticket->id . ' completed'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Ticket $ticket
     * @return RedirectResponse
     */
    public function destroy(Ticket $ticket)
    {
        $ticket->delete();

        return response()->redirectToRoute('admin.tickets.index')->with('alert', [
            'type' => 'danger',
            'title' => 'success',
            'message' => 'Ticket #' . $ticket->id . ' inactivated'
        ]);
    }
}

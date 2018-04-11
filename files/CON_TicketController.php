<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ticket;

class TicketController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of all tickets.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tickets = Ticket::get();

        return view('ticket.index', compact('tickets'));
    }

    /**
     * Display a listing of my tickets.
     *
     * @return \Illuminate\Http\Response
     */
    public function mytickets()
    {

        $tickets = auth()->user()->tickets;

        return view('ticket.index', compact('tickets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('ticket.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $ticket = new Ticket();
        $data = $this->validate($request, [
            'description' => 'required',
            'title' => 'required'
        ]);

        $ticket->saveTicket($data);
        return redirect('/home')->with('success', 'New support ticket has been created! Wait sometime to get resolved');
    }

 
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ticket = auth()->user()->tickets->where('id', $id)->first();

        return view('ticket.edit', compact('ticket', 'id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $ticket = new Ticket();
        $data = $this->validate($request, [
            'description' => 'required',
            'title' => 'required'
        ]);
        $data['id'] = $id;
        $ticket->updateTicket($data);

        return redirect('/home')->with('success', 'New support ticket has been updated!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ticket = Ticket::find($id);
        $ticket->delete();

        return redirect('/home')->with('success', 'Ticket has been deleted!!');
    }
}
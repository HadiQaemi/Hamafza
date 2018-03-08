<?php

namespace App\Http\Controllers\Hamahang;

use App\Http\Controllers\Controller;
use App\Models\hamafza\Ticket;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function inbox($uname)
    {
        if (!Auth::check())
        {
            return Redirect()->to('/')->with('message', 'عدم دسترسی')->with('mestype', 'error');
        }
        else
        {
            $res = variable_generator('user', 'message_inbox', $uname);
//            return view('pages.Desktop', $res);
            return view('hamahang.Tickets.inbox', $res);
        }
    }

    public function get_ticket_receive()
    {
        $tickets =  Auth::user()->RecieveTickets()
            ->with('ticket_answer')
            ->with('sender_user')
            ->with('files')
            ->whereHas('sender_user', function($query)
            {
                return $query->where('Name', '<>', '');
            })
            ->groupBy('tickets.id')
            ->orderBy('tickets.id','DESC')
            ->get();

        return \Datatables::of($tickets)
            ->addColumn('has_attachment', function ($data)
            {
                return (bool) $data->files->count();
            })
            ->addColumn('JalaliRegDate', function ($data)
            {
                return $data->JalaliRegDate;
            })
            ->make(true);
    }

    public function outbox($uname)
    {
        if (!Auth::check())
        {
            return Redirect()->to('/')->with('message', 'عدم دسترسی')->with('mestype', 'error');
        }
        else
        {
            $res = variable_generator('user', 'message_outbox', $uname);
//            return view('pages.Desktop', $res);
            return view('hamahang.Tickets.outbox', $res);
        }

    }

    public function get_ticket_send()
    {
        $tickets = Auth::user()->SendTickets()
            ->with('ticket_answer')
            ->with('receiver_users')
            ->with('ticket_files')
            ->whereHas('receiver_users', function($query)
            {
                return $query->where('Name', '<>', '');
            })
            ->groupBy('tickets.id')
            ->orderBy('tickets.id','DESC')
            ->get();

        return \Datatables::of($tickets)
            ->addColumn('has_attachment', function ($data)
            {
                return (bool) $data->files->count();
            })
            ->addColumn('JalaliRegDate', function ($data)
            {
                return $data->JalaliRegDate;
            })
            ->make(true);
    }
}

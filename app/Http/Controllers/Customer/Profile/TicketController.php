<?php

namespace App\Http\Controllers\Customer\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\Profile\StoreAnswerTicketRequest;
use App\Http\Requests\Customer\Profile\StoreTicketRequest;
use App\Http\Services\File\FileService;
use App\Models\Ticket\Ticket;
use App\Models\Ticket\TicketCategory;
use App\Models\Ticket\TicketFile;
use App\Models\Ticket\TicketPriority;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TicketController extends Controller
{
    public function index()
    {
        $tickets = auth()->user()->tickets()->whereNull('ticket_id')->get();
        return view('customer.profile.ticket.my-tickets', compact('tickets'));
    }

    public function show(Ticket $ticket)
    {
        return view('customer.profile.ticket.show-ticket', compact('ticket'));

    }
    public function change(Ticket $ticket)
    {
        $ticket->status = $ticket->status == 1 ? 0 : 1;
        $result = $ticket->save();
        return redirect()->back()->with('swal-success', 'تغییر وضعیت تیکت با موفقیت انجام شد');
    }
    public function answer(StoreAnswerTicketRequest $request, Ticket $ticket)
    {
        $inputs = $request->all();
        $inputs['subject'] = $ticket->subject;
        $inputs['description'] = $request->description;
        $inputs['seen'] = 0;
        $inputs['reference_id'] = $ticket->reference_id;
        $inputs['user_id'] = auth()->user()->id;
        $inputs['category_id'] = $ticket->category_id;
        $inputs['priority_id'] = $ticket->priority_id;
        $inputs['ticket_id'] = $ticket->id;
        $ticket = Ticket::create($inputs);
        return redirect()->back()->with('swal-success', 'پاسخ شما باموفقیت ثبت شد');

    }

    public function create()
    {
        $ticketCategories = TicketCategory::where('status', 1)->get();
        $ticketPriorities = TicketPriority::where('status', 1)->get();
        return view('customer.profile.ticket.create-ticket', compact('ticketCategories', 'ticketPriorities'));
    }

    public function store(StoreTicketRequest $request, FileService $fileService)
    {
        DB::transaction(function () use ($request, $fileService) {
            //ticket-body
            $inputs = $request->all();
            $inputs['status'] = 1;
            $inputs['user_id'] = auth()->user()->id;
            $ticket = Ticket::create($inputs);

            //ticket-file
            if ($request->hasFile('file')) {
                $fileService->setExclusiveDirectory('files' . DIRECTORY_SEPARATOR . 'ticket-files');
                $fileService->setFileSize($request->file('file'));
                $fileSize = $fileService->getFileSize();
                $result = $fileService->moveToPublic($request->file('file'));
                $fileFormat = $fileService->getFileFormat();
                $inputs['ticket_id'] = $ticket->id;
                $inputs['user_id'] = auth()->user()->id;
                $inputs['file_path'] = $result;
                $inputs['file_size'] = $fileSize;
                $inputs['file_type'] = $fileFormat;
                $file = TicketFile::create($inputs);
            }

        });

        return to_route('customer.profile.my-tickets')->with('swal-success', 'تیکت شما باموفقیت ثبت شد');


    }


}

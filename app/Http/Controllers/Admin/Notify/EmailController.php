<?php

namespace App\Http\Controllers\Admin\Notify;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Notify\EmailRequest;
use App\Http\Services\Message\Email\EmailService;
use App\Http\Services\Message\MessageService;
use App\Jobs\SendEmailToUsers;
use App\Models\Notify\Email;
use App\Models\User;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $email = Email::orderBy('created_at', 'desc')->simplePaginate(15);
        return view('admin.notify.email.index', compact('email'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.notify.email.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmailRequest $request)
    {
        $inputs = $request->all();

        //date fixed
        $realTimestampStart = substr($request->published_at, 0,10);
        $inputs['published_at'] = date('Y-m-d H:i:s', (int)$realTimestampStart);
        $post = Email::create($inputs);
        return redirect()->route('admin.notify.email.index')->with('swal-success', "اطلاعیه ایمیلی شما با موفقیت ثبت شد");

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Email $email)
    {
        return view('admin.notify.email.edit', compact('email'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EmailRequest $request, Email $email)
    {
        $inputs = $request->all();
        //date fixed
        $realTimestampStart = substr($request->published_at, 0,10);
        $inputs['published_at'] = date('Y-m-d H:i:s', (int)$realTimestampStart);

        $email->update($inputs);
        return redirect()->route('admin.notify.email.index')->with('swal-success', 'اطلاعیه شما با موفقیت ویرایش شد');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Email  $email)
    {
        $result = $email->delete();
        return redirect()->route('admin.notify.email.index')->with('swal-success', 'اطلاعیه ایمیلی با موفقیت حذف شد');
    }

    public function status(Email $email)
    {
        $email->status = $email->status == 0 ? 1 : 0;
        $result = $email->save();
        $email->status == 1 ? ($status = "فعال") : ($status = "غیرفعال");
        return redirect()->route('admin.notify.email.index')->with('swal-success', 'اطلاعیه مورد نظر'. ' ' . $status .' شد');
    }

    public function sendMail(Email $email)
    {
        SendEmailToUsers::dispatch($email);
        return back()->with('swal-success', 'ایمیل شما باموفقیت ارسال شد');
    }
}

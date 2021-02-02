<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MailLog;
use Carbon\Carbon;
use Mail;
use App\Mail\SendEmail;
use Illuminate\Support\Facades\Auth;

class SendEmailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.admins.mails.send_mail');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'email.*.email' => 'email|unique:users',
            'subject'    => 'required',
            'message'    => 'required',
            'file.*'    => 'mimes:pdf,doc,docx,zip'
        ]);
        // $mails = new MailLog();

        // $mails->mail_log_to             = $request->get('email');
        // $mails->mail_log_subject        = $request->get('subject');
        // $mails->mail_log_body           = $request->get('message');
        // $mails->mail_log_send_datetime  = Carbon::now(); 
        // $mails->mail_log_file           = $request->file('file');
        
        $data = array(
            'email'              => $request->get('email'),
            'multiple_address'   => $request->input('multiple_emails'),
            'subject'            => $request->get('subject'),
            'message'            => $request->get('message'),
            'date_time'          => Carbon::now(),
            'file'               => $request->file('file'),   
        );
        $emails = $data['multiple_address'];
        // dd($emails);
        $list_emails = explode(",",$emails);
        //dd($list_emails);
        if(isset($data['email']))
        {
            Mail::to($data['email'])->send(new SendEmail($data['subject'],$data['message'],$data['date_time'],$data['file']));
        }
        else
        {
            foreach ($list_emails as $mail) {
                Mail::to($mail)->send(new SendEmail($data['subject'],$data['message'],$data['date_time'],$data['file']));
            }
        }
        return back()->with('success','Send Email Successfully');
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

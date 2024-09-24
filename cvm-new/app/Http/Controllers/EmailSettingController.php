<?php

namespace App\Http\Controllers;
use App\Mail\SettingMail;
use App\Models\EmailSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\EmailNotificationSettings;
use Illuminate\Support\Facades\Validator;

class EmailSettingController extends Controller
{
    public function index(){
        $notifications = EmailNotificationSettings::where('company_id',Auth::user()->company_id)->get();
        $setting = EmailSetting::where('company_id',Auth::user()->company_id)->first();
       return view('setting.email-setting',compact('setting','notifications'));
    }
    public function notificationEmail(Request $request){
        EmailNotificationSettings::where('id', $request->notification)
        ->update(['is_active' => $request->status]);
        return response()->json([
            'message' => 'Email notification updated successfully',
            'status'=>true,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'mail_from_name'	=> 'required',
            'mail_from_email'=> 'required|email',
            'mail_host'=> 'required',
            'mail_port'=> 'required',
            'mail_username'=> 'required',
            'mail_password'=> 'required',
            'mail_encryption'=> 'required',
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }
        EmailSetting::updateOrCreate([ 'id'   => $request->id,],$request->all());
        return redirect()->route('emailSetting.index')->with('success','email setting save successfully');
    }
    public function sendMail(Request $request)
    {
        $details = [
            'subject' => 'new test email',
            'title' => $request->title,
            'message' => $request->message
        ];
        try {
        Mail::to($request->sendEmail)->send(new SettingMail($details));
        return response()->json([
            'message' => 'Email send successfully',
            'status'=>true,
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'message' => $e->getMessage(),
            'status'=>false,
        ]);
    }

    }
}

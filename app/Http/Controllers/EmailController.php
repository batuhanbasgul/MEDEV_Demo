<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use App\Mail\JobMail;
use App\Mail\PasswordResetMail;
use App\Models\User;
use App\Models\Job;
use Illuminate\Support\Str;

class EmailController extends Controller
{
    public function sendJobMail(int $job_id){
        $job = Job::findOrFail($job_id);
        if($job->is_multiple_user){
            foreach(Job::where('serial_number',$job->serial_number)->get() as $item){
                $assignedUser = User::findOrFail($item->assigned_to);
                $assignedFrom = User::findOrFail($item->assigned_from);
                session()->forget('job_title');
                session()->forget('job_context');
                session()->forget('assigned_from');
                session()->forget('assigned_from_mail');
                session()->forget('start_date');
                session()->forget('end_date');
                session()->put('job_title',$item->job_title);
                session()->put('job_context',$item->job_context);
                session()->put('assigned_from',$assignedFrom->name);
                session()->put('assigned_from_mail',$assignedFrom->email);
                session()->put('start_date',$item->start_date);
                session()->put('end_date',$item->end_date);

                Mail::to($assignedUser->email)->send(new JobMail);
            }
        }else{
            $assignedUser = User::findOrFail($job->assigned_to);
            $assignedFrom = User::findOrFail($job->assigned_from);

            session()->forget('job_title');
            session()->forget('job_context');
            session()->forget('assigned_from');
            session()->forget('assigned_from_mail');
            session()->forget('start_date');
            session()->forget('end_date');
            session()->put('job_title',$job->job_title);
            session()->put('job_context',$job->job_context);
            session()->put('assigned_from',$assignedFrom->name);
            session()->put('assigned_from_mail',$assignedFrom->email);
            session()->put('start_date',$job->start_date);
            session()->put('end_date',$job->end_date);

            Mail::to($assignedUser->email)->send(new JobMail);
        }

        Session::flash('success', __('general.successful'));
        return redirect()->route('job-controller.index',['filter'=>0,'selectedPage'=>1]);
    }

    public function passwordResetMail(Request $request){
        $user = User::where('email',$request->email)->first();
        if(count(User::where('email',$request->email)->get()) != 1){
            Session::flash('no_account_found', __('general.error'));
            return redirect()->route('password.request');
        }

        $newPassword = Str::random(10);
        $hashedNewPassword = Hash::make($newPassword);

        $user->password = $hashedNewPassword;
        if($user->save()){
            session()->forget('user_name');
            session()->forget('user_new_pwd');
            session()->put('user_name',$user->name);
            session()->put('user_new_pwd',$newPassword);

            Mail::to($user->email)->send(new PasswordResetMail);
            Session::flash('success', __('general.successful'));
            return redirect()->route('password.request');
        }else{
            Session::flash('error', __('general.error'));
            return back();
        }






    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\Message;
use App\Models\MessageData;
use App\Models\Job;
use App\Models\JobData;
use Jenssegers\Agent\Agent;

class Notification
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        /**
         * LANGUAGE
         */
         if(session()->has('langCode')){
             app()->setLocale(session('langCode'));
         }

        $messageNotifications = array();
        foreach(Message::where('sent_to',Auth::id())->where('is_read',0)->orderBy('created_at','desc')->take(5)->get() as $item){
            $temp = new MessageData;
            $temp->id = $item->id;
            $temp->is_read = $item->is_read;
            $temp->image = User::where('id',$item->sent_from)->first()->p_image;
            $temp->sender_name = User::where('id',$item->sent_from)->first()->name;
            $temp->title = $item->title;
            $temp->context = $item->context;
            $temp->date = explode('-',explode(' ',$item->created_at)[0])[2].'.'.explode('-',explode(' ',$item->created_at)[0])[1];
            $temp->time = explode(':',explode(' ',$item->created_at)[1])[0].':'.explode(':',explode(' ',$item->created_at)[1])[1];
            $temp->company_id = $item->company_id;
            array_push($messageNotifications, $temp);
        }
        Session::flash('message_notifications', $messageNotifications);
        Session::flash('message_notification_count',Message::where('sent_to',Auth::id())->where('is_read',0)->count());

        $jobNotifications = array();
        foreach(Job::where('assigned_to',Auth::id())->where('status',0)->orderBy('created_at','asc')->take(5)->get() as $item){
            $temp = new JobData;
            $temp->id = $item->id;
            $temp->job_title = $item->job_title;
            $temp->job_context = $item->job_context;
            $temp->assigned_from = $item->assigned_from;
            $temp->assigned_to = $item->assigned_to;
            $temp->company_id = $item->company_id;
            $temp->serial_number = $item->serial_number;
            $temp->is_multiple_user = $item->is_multiple_user;
            $temp->status = $item->status;
            $temp->unsuccess_reason = $item->unsuccess_reason;
            $temp->start_date = $item->start_date;
            $temp->end_date = $item->end_date;
            array_push($jobNotifications,$temp);

        }
        Session::flash('job_notifications', $jobNotifications);
        Session::flash('job_notification_count',Job::where('assigned_to',Auth::id())->where('status',0)->count());

        $agent = new Agent();
        Session::flash('agent', $agent);

        return $next($request);
    }
}

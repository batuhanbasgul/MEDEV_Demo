<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Job;
use App\Models\JobData;
use App\Models\Message;
use App\Models\MessageData;
use App\Models\User;
use App\Models\Product;
use App\Models\ProductData;
use App\Models\Device;
use App\Models\DeviceTransaction;
use App\Models\Corporation;
use Carbon\Carbon;

class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        /** ►►►►► DEVELOPER ◄◄◄◄◄
         * Sidebar seçili menu.
         */
        session()->forget('selectedSideMenu');
        session()->put('selectedSideMenu','index');

        $uncompletedJobs = array();
        foreach(Job::where('assigned_to',Auth::id())->where('status',0)->orderBy('created_at','asc')->take(4)->get() as $item){
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
            array_push($uncompletedJobs,$temp);
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

        $activeProducts = array();
        foreach(Product::where('company_id',Auth::user()->company_id)->get() as $item){
            $productEndDate = explode('-',$item->end_date); //0->yıl, 1->ay, 2->gün
            /** ►►►►► DEVELOPER ◄◄◄◄◄
             * Güncel Tarih
             */
            $date = explode(' ',Carbon::now()->toDateTimeString());
            $currentDate = explode('-',$date[0]); //0->yıl, 1->ay, 2->gün
            if($productEndDate[0]>$currentDate[0]){
                array_push($activeProducts,$item);
            }elseif($productEndDate[0]==$currentDate[0]){
                if($productEndDate[1]>$currentDate[1]){
                    array_push($activeProducts,$item);
                }elseif($productEndDate[1]==$currentDate[1]){
                    if($productEndDate[2]>=$currentDate[2]){
                        array_push($activeProducts,$item);
                    }
                }
            }
        }

        $activeDeviceCount = 0;
        foreach($activeProducts as $product){
            $activeDeviceCount+=Device::where('product_id',$product->id)->count();
        }

        $products = array();
        foreach(Product::where('company_id',Auth::user()->company_id)->orderBy('created_at','desc')->take(10)->get() as $item){
            /** ►►►►► DEVELOPER ◄◄◄◄◄
             * ProductData, veritabanından bağımsız görüntülenecek veri modeli.
             */
            $productData = new ProductData();
            $productData->id = $item->id;
            $productData->corporation_name = Corporation::findOrFail($item->corporation_id)->name;
            $productData->company_id = $item->company_id;
            $productData->name = $item->name;
            $productData->device_count = $item->device_count;
            $productData->spendable_count = $item->spendable_count;
            $productData->start_date = $item->start_date;
            $productData->end_date = $item->end_date;
            $productData->is_active = $item->is_active;
            array_push($products,$productData);
        }
        return view('index',[
            'uncompletedJobs' => $uncompletedJobs,
            'messageNotifications' => $messageNotifications,
            'activeDeviceCount' => $activeDeviceCount,
            'transactionCount' => DeviceTransaction::where('company_id',Auth::user()->company_id)->count(),
            'transactions' => DeviceTransaction::where('company_id',Auth::user()->company_id)->orderBy('created_at','desc')->take(10)->get(),
            'products' => $products,
        ]);
    }

    public function instructions(){
        return view('instructions');
    }

    public function changeLang(String $langCode){
        session()->forget('langCode');
        session()->put('langCode',$langCode);
        return back();
    }
}

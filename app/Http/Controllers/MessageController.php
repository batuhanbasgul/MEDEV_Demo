<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Message;
use App\Models\MessageData;

class MessageController extends Controller
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
     * Display a listing of the resource.
     */
    public function index()
    {
        /** ►►►►► DEVELOPER ◄◄◄◄◄
         * Sidebar seçili menu.
         */
        session()->forget('selectedSideMenu');
        session()->put('selectedSideMenu','message-controller');

        /** ►►►►► DEVELOPER ◄◄◄◄◄
         * Seçenekler için sayılar.
         */
        $allCount = Message::where('sent_to',Auth::id())->count();
        $unreadCount = Message::where('sent_to',Auth::id())->where('is_read',0)->count();
        $sentCount = Message::where('sent_from',Auth::id())->count();

        /** ►►►►► DEVELOPER ◄◄◄◄◄
         * Seçili sayfa ve filtre;
         * 0 -> Hepsi
         * 1 -> Okunmamış
         * 2 -> Gönderilmiş
         */
        $filter = 0;
        $selectedPage = 1;
        $messages = array();
        $pagedMessages = array();

        /** ►►►►► DEVELOPER ◄◄◄◄◄
         * Url'de eksik parametre varsa default olarak hata mesajı ile birlikte 'all' döner.
         */
        if(count($_GET) != 2){

            /** ►►►►► DEVELOPER ◄◄◄◄◄
             * MessageData, veritabanından bağımsız görüntülenecek veri modeli.
             */
            foreach(Message::where('sent_to',Auth::id())->orderBy('created_at','desc')->take(100)->get() as $item){
                $temp = new MessageData;
                $temp->id = $item->id;
                $temp->is_read = $item->is_read;
                $temp->image = User::where('id',$item->sent_from)->first()->p_image;
                $temp->sender_name = User::where('id',$item->sent_from)->first()->name;
                $temp->sender_department = User::where('id',$item->sent_from)->first()->department;
                $temp->sender_id = $item->sent_from;
                $temp->title = $item->title;
                $temp->context = $item->context;
                $temp->date = explode('-',explode(' ',$item->created_at)[0])[2].'/'.explode('-',explode(' ',$item->created_at)[0])[1].'/'.explode('-',explode(' ',$item->created_at)[0])[0];
                $temp->time = explode(':',explode(' ',$item->created_at)[1])[0].':'.explode(':',explode(' ',$item->created_at)[1])[1];
                $temp->company_id = $item->company_id;
                array_push($messages, $temp);
            }

            /** ►►►►► DEVELOPER ◄◄◄◄◄
             * Sayfa numarasına($selectedPage) göre o numaraya denk gelen 10'lu mesaj çekilir ve döndürülür.
             */
            for($i=0;$i<10;$i++){
                $index = ($selectedPage-1)*10+$i;
                if($index>=count($messages)){
                    break;
                }
                array_push($pagedMessages, $messages[$index]);
            }

            /** ►►►►► DEVELOPER ◄◄◄◄◄
             * Sayfa sayısı varolan mesaj sayısına göre belirlenir.
             */
            $pageCount = ceil(count($messages)/10);
            if($pageCount<1){
                $pageCount=1;
            }

            Session::flash('url_error', __('general.url_error'));
            return view('message-index',[
                'user' => Auth::user(),
                'allCount' => $allCount,
                'unreadCount' => $unreadCount,
                'sentCount' => $sentCount,
                'messages' => $pagedMessages,
                'filter' => $filter,
                'pageCount' => ceil(count($messages)/10),
                'selectedPage' => $selectedPage
            ]);
        }

        /** ►►►►► DEVELOPER ◄◄◄◄◄
         * Seçenekler için sayılar.
         */
        $allCount = Message::where('sent_to',Auth::id())->count();
        $unreadCount = Message::where('sent_to',Auth::id())->where('is_read',0)->count();
        $sentCount = Message::where('sent_from',Auth::id())->count();

        /** ►►►►► DEVELOPER ◄◄◄◄◄
         * Seçili sayfa ve filtre;
         * 0 -> Hepsi
         * 1 -> Okunmamış
         * 2 -> Gönderilmiş
         */
        $filter = 0;
        $selectedPage = 1;
        $messages = array();
        $pagedMessages = array();

        if(1==$_GET['filter']){

            /** ►►►►► DEVELOPER ◄◄◄◄◄
             * MessageData, veritabanından bağımsız görüntülenecek veri modeli.
             */
            foreach(Message::where('sent_to',Auth::id())->where('is_read',0)->orderBy('created_at','desc')->take(100)->get() as $item){
                $temp = new MessageData;
                $temp->id = $item->id;
                $temp->is_read = $item->is_read;
                $temp->image = User::where('id',$item->sent_from)->first()->p_image;
                $temp->sender_name = User::where('id',$item->sent_from)->first()->name;
                $temp->sender_department = User::where('id',$item->sent_from)->first()->department;
                $temp->sender_id = $item->sent_from;
                $temp->title = $item->title;
                $temp->context = $item->context;
                $temp->date = explode('-',explode(' ',$item->created_at)[0])[2].'/'.explode('-',explode(' ',$item->created_at)[0])[1].'/'.explode('-',explode(' ',$item->created_at)[0])[0];
                $temp->time = explode(':',explode(' ',$item->created_at)[1])[0].':'.explode(':',explode(' ',$item->created_at)[1])[1];
                $temp->company_id = $item->company_id;
                array_push($messages, $temp);
            }
            $filter = 1;
        }else if(2==$_GET['filter']){

            /** ►►►►► DEVELOPER ◄◄◄◄◄
             * MessageData, veritabanından bağımsız görüntülenecek veri modeli.
             */
            foreach(Message::where('sent_from',Auth::id())->orderBy('created_at','desc')->take(100)->get() as $item){
                $temp = new MessageData;
                $temp->id = $item->id;
                $temp->is_read = $item->is_read;
                $temp->image = User::where('id',$item->sent_to)->first()->p_image;
                $temp->sender_name = User::where('id',$item->sent_from)->first()->name;
                $temp->sender_department = User::where('id',$item->sent_from)->first()->department;
                $temp->sender_id = $item->sent_from;
                $temp->title = $item->title;
                $temp->context = $item->context;
                $temp->date = explode('-',explode(' ',$item->created_at)[0])[2].'/'.explode('-',explode(' ',$item->created_at)[0])[1].'/'.explode('-',explode(' ',$item->created_at)[0])[0];
                $temp->time = explode(':',explode(' ',$item->created_at)[1])[0].':'.explode(':',explode(' ',$item->created_at)[1])[1];
                $temp->company_id = $item->company_id;
                array_push($messages, $temp);
            }
            $filter = 2;
        }else{

            /** ►►►►► DEVELOPER ◄◄◄◄◄
             * MessageData, veritabanından bağımsız görüntülenecek veri modeli.
             */
            foreach(Message::where('sent_to',Auth::id())->orderBy('created_at','desc')->take(100)->get() as $item){
                $temp = new MessageData;
                $temp->id = $item->id;
                $temp->is_read = $item->is_read;
                $temp->image = User::where('id',$item->sent_from)->first()->p_image;
                $temp->sender_name = User::where('id',$item->sent_from)->first()->name;
                $temp->sender_department = User::where('id',$item->sent_from)->first()->department;
                $temp->sender_id = $item->sent_from;
                $temp->title = $item->title;
                $temp->context = $item->context;
                $temp->date = explode('-',explode(' ',$item->created_at)[0])[2].'/'.explode('-',explode(' ',$item->created_at)[0])[1].'/'.explode('-',explode(' ',$item->created_at)[0])[0];
                $temp->time = explode(':',explode(' ',$item->created_at)[1])[0].':'.explode(':',explode(' ',$item->created_at)[1])[1];
                $temp->company_id = $item->company_id;
                array_push($messages, $temp);
            }
            $filter = 0;
        }

        /** ►►►►► DEVELOPER ◄◄◄◄◄
         * Sayfa sayısı varolan mesaj sayısına göre belirlenir.
         */
        $selectedPage = $_GET['selectedPage'];
        if($selectedPage>ceil(count($messages)/10)){
            $selectedPage=ceil(count($messages)/10);
        }
        if($selectedPage<1){
            $selectedPage=1;
        }

        /** ►►►►► DEVELOPER ◄◄◄◄◄
         * Sayfa numarasına($selectedPage) göre o numaraya denk gelen 10'lu mesaj çekilir ve döndürülür.
         */
        for($i=0;$i<10;$i++){
            $index = ($selectedPage-1)*10+$i;
            if($index>=count($messages)){
                break;
            }
            array_push($pagedMessages, $messages[$index]);
        }

        return view('message-index',[
            'user' => Auth::user(),
            'allCount' => $allCount,
            'unreadCount' => $unreadCount,
            'sentCount' => $sentCount,
            'messages' => $pagedMessages,
            'filter' => $filter,
            'pageCount' => ceil(count($messages)/10),
            'selectedPage' => $selectedPage,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     * GÖNDERİLECEK KULLANICI SEÇİMİ 'create' FONKSIYONUNDA
     * MESAJ GÖNDERME İSE 'edit' FONKSIYONUNDA
     */
    public function create()
    {
        /** ►►►►► DEVELOPER ◄◄◄◄◄
         * Sidebar seçili menu.
         */
        session()->forget('selectedSideMenu');
        session()->put('selectedSideMenu','message-controller');

        $tempUsers = User::where('company_id',Auth::user()->company_id)->orderBy('name','asc')->get();

        /** ►►►►► DEVELOPER ◄◄◄◄◄
         * Kullanıcılar authority seviyesine göre sırayla array içerisine konulur.
         */
        $users = array();
        foreach($tempUsers as $item){
            if($item->authority == 'client'){
                array_push($users,$item);
            }
        }
        foreach($tempUsers as $item){
            if($item->authority == 'subclient'){
                array_push($users,$item);
            }
        }
        foreach($tempUsers as $item){
            if($item->authority == 'temporary'){
                array_push($users,$item);
            }
        }
        return view('message-send',[
            'users' => $users
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        /** ►►►►► DEVELOPER ◄◄◄◄◄
         * Başka şirketin çalışanına mesaj gönderme durumuna engel.
         */
        if($request->sent_to != "0"){
            if(Auth::user()->company_id != User::findOrFail($request->sent_to)->company_id){
                Session::flash('error', __('general.error'));
                return redirect()->route('message-controller.index',['filter'=>0,'selectedPage'=>1]);
            }
        }
        /** ►►►►► DEVELOPER ◄◄◄◄◄
         * 'temporary' seviyesindeli kullanıcı mesaj gönderemez
         */
        if(Gate::allows('temporary')){
            Session::flash('auth_error', __('general.auth_error'));
            return redirect()->route('user-controller.index',['filter'=>0,'selectedPage'=>1]);
        }

        /** ►►►►► DEVELOPER ◄◄◄◄◄
         * 'publish', herkese gönderilecek mesaj anlamına gelir.
         */
        if($request->publish){
            /** ►►►►► DEVELOPER ◄◄◄◄◄
             * 'admin' veya 'client' yetkisi olmayan kullanıcı herkese mesaj gönderemez
             */
            if (Gate::allows('admin') || Gate::allows('client')){
                $users = User::where('company_id',Auth::user()->company_id)->get();
                foreach($users as $user){
                    if($user->id != Auth::id()){
                        $message = new Message();
                        $message->is_read = 0;
                        $message->sent_from = Auth::id();
                        $message->sent_to = $user->id;
                        $message->is_private = 0;
                        $message->company_id = Auth::user()->company_id;
                        /** ►►►►► DEVELOPER ◄◄◄◄◄
                         * adminden gönderilen mesaj için 'company_id' = 0 olur ve mesajlar kırmızı görüntülenir.
                         */
                        if(Auth::user()->authority == 'admin'){
                            $message->company_id = "0";
                        }
                        $message->title = $request->title;
                        $message->context = $request->context;
                        $message->save();
                    }
                }
                Session::flash('success', __('general.successful'));
                return redirect()->route('message-controller.index',['filter'=>0,'selectedPage'=>1]);
            }else{
                Session::flash('auth_error', __('general.auth_error'));
                return redirect()->route('message-controller.index',['filter'=>0,'selectedPage'=>1]);
            }
        }else{
            /** ►►►►► DEVELOPER ◄◄◄◄◄
             * Kullanıcı kendisine mesaj gönderemez
             */
            if($request->sent_to == Auth::user()->id){
                Session::flash('error', __('general.cannot_sent_himself'));
                return redirect()->route('message-controller.index',['filter'=>0,'selectedPage'=>1]);
            }else{
                $user = User::where('id',$request->sent_to)->first();
                $message = new Message();
                $message->is_read = 0;
                $message->sent_from = Auth::id();
                $message->sent_to = $user->id;
                $message->is_private = 1;
                $message->company_id = Auth::user()->company_id;
                if(Auth::user()->authority == 'admin'){
                    $message->company_id = "0";
                }
                $message->title = $request->title;
                $message->context = $request->context;

                if ($message->save()) {
                    Session::flash('success', __('general.successful'));
                } else {
                    Session::flash('error', __('general.unsuccessful'));
                }
                return redirect()->route('message-controller.index',['filter'=>0,'selectedPage'=>1]);
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        /** ►►►►► DEVELOPER ◄◄◄◄◄
         * Sidebar seçili menu.
         */
        session()->forget('selectedSideMenu');
        session()->put('selectedSideMenu','message-controller');

        $allCount = Message::where('sent_to',Auth::id())->count();
        $unreadCount = Message::where('sent_to',Auth::id())->where('is_read',0)->count();
        $sentCount = Message::where('sent_from',Auth::id())->count();

        $temp = Message::where('id',$id)->first();

        $message = new MessageData;
        $message->id = $temp->id;
        $message->is_read = $temp->is_read;
        $message->image = User::where('id',$temp->sent_from)->first()->p_image;
        $message->sender_name = User::where('id',$temp->sent_from)->first()->name;
        $message->sender_department = User::where('id',$temp->sent_from)->first()->department;
        $message->sender_id = $temp->sent_from;
        $message->title = $temp->title;
        $message->context = $temp->context;
        $message->date = explode('-',explode(' ',$temp->created_at)[0])[2].'/'.explode('-',explode(' ',$temp->created_at)[0])[1].'/'.explode('-',explode(' ',$temp->created_at)[0])[0];
        $message->time = explode(':',explode(' ',$temp->created_at)[1])[0].':'.explode(':',explode(' ',$temp->created_at)[1])[1];
        $message->company_id = $temp->company_id;

        $temp->is_read = 0; //DUZENLENECEK
        $temp->save();

        return view('message-show',[
            'message' => $message,
            'user' => Auth::user(),
            'allCount' => $allCount,
            'unreadCount' => $unreadCount,
            'sentCount' => $sentCount,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     * 'id', sent_to user's id.
     */
    //MESAJ YAZMA EKRANINA YONLENDİRİR, id gerektiği için editte create var.
    public function edit(string $id)
    {
        /** ►►►►► DEVELOPER ◄◄◄◄◄
         * Sidebar seçili menu.
         */
        session()->forget('selectedSideMenu');
        session()->put('selectedSideMenu','message-controller');

        /** ►►►►► DEVELOPER ◄◄◄◄◄
         * 'temporary' kullanıcısı mesaj gönderemez
         */
        if(Gate::allows('temporary')){
            Session::flash('auth_error', __('general.auth_error'));
            return redirect()->route('message-controller.index',['filter'=>0,'selectedPage'=>1]);
        }
        /** ►►►►► DEVELOPER ◄◄◄◄◄
         * If $id=0, sent to everyone that member of user's company.
         */
        if($id==0){
            /** ►►►►► DEVELOPER ◄◄◄◄◄
             * Authorization kontrolü.
             */
            if (Gate::allows('admin') || Gate::allows('client')){
                /** ►►►►► DEVELOPER ◄◄◄◄◄
                 * Fetch Users in order
                 */
                $tempUsers = User::where('company_id',Auth::user()->company_id)->orderBy('name','asc')->get();
                $users = array();
                foreach($tempUsers as $item){
                    if($item->authority == 'client'){
                        array_push($users,$item);
                    }
                }
                foreach($tempUsers as $item){
                    if($item->authority == 'subclient'){
                        array_push($users,$item);
                    }
                }
                foreach($tempUsers as $item){
                    if($item->authority == 'temporary'){
                        array_push($users,$item);
                    }
                }
                return view('message-create',[
                    'publish' => 1,
                    'current_user' => Auth::user(),
                    'users' => $users
                ]);

            }else{
                Session::flash('auth_error', __('general.auth_error'));
                return redirect()->route('message-controller.index',['filter'=>0,'selectedPage'=>1]);
            }
        }else{

            if(Auth::user()->company_id != User::findOrFail($id)->company_id){
                Session::flash('error', __('general.error'));
                return redirect()->route('message-controller.index');
            }
            /** ►►►►► DEVELOPER ◄◄◄◄◄
             * Fetch Users in order
             */
            $tempUsers = User::where('company_id',Auth::user()->company_id)->orderBy('name','asc')->get();
            $users = array();
            foreach($tempUsers as $item){
                if($item->authority == 'client'){
                    array_push($users,$item);
                }
            }
            foreach($tempUsers as $item){
                if($item->authority == 'subclient'){
                    array_push($users,$item);
                }
            }
            foreach($tempUsers as $item){
                if($item->authority == 'temporary'){
                    array_push($users,$item);
                }
            }
            return view('message-create',[
                'publish' => 0,
                'sent_to' => User::where('id',$id)->first(),
                'current_user' => Auth::user(),
                'users' => $users
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

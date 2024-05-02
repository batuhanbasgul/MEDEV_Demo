<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\UserDataMin;
use App\Models\Job;
use App\Models\JobData;

class JobController extends Controller
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
        session()->put('selectedSideMenu','job-controller');
        $filter = 0;                //View filters; 0-all, 1-status=0, 2-status=1
        $selectedPage = 1;          //Pagination
        $jobsData = array();        //Custom data model
        $pagedJobsData = array();   //9 jobs per page

        /** ►►►►► DEVELOPER ◄◄◄◄◄
         * Url'de eksik parametre varsa default olarak hata mesajı ile birlikte 'all' döner.
         */
        if(count($_GET) != 2){
            $jobs = Job::where('company_id',Auth::user()->company_id)->orderBy('created_at','desc')->get();
            /** ►►►►► DEVELOPER ◄◄◄◄◄
             * 'serial_number' birden fazla kişiye atanmış işleri 1'den fazla çekmemek için kontrol edilir.
             */
            $fetchedSerialNumbers = array();
            foreach($jobs as $item){
                //If serial number already fetched, continue
                if(in_array($item->serial_number,$fetchedSerialNumbers)){
                    continue;
                }

                /** ►►►►► DEVELOPER ◄◄◄◄◄
                 * JobData, veritabanından bağımsız görüntülenecek veri modeli.
                 */
                $tempJobData = new JobData();
                $tempJobData->id = $item->id;
                $tempJobData->job_title = $item->job_title;
                $tempJobData->job_context = substr($item->job_context, 0, 64);
                $tempJobData->assigned_from = $item->assigned_from;
                $tempJobData->assigned_to = $item->assigned_to;
                $tempJobData->company_id = $item->company_id;
                $tempJobData->start_date = $item->start_date;
                $tempJobData->end_date = $item->end_date;
                $tempJobData->serial_number = $item->serial_number;
                $tempJobData->is_multiple_user = $item->is_multiple_user;
                $tempJobData->status = $item->status;
                $tempJobData->is_success = $item->is_success;
                $tempJobData->unsuccess_reason = $item->unsuccess_reason;


                $users = array();
                //If multiple user assigned, do not push
                if($item->is_multiple_user){
                    $multipleJobs = Job::where('serial_number',$item->serial_number)->get();
                    foreach($multipleJobs as $item2){
                        /** ►►►►► DEVELOPER ◄◄◄◄◄
                         * Bir işin atandığı kullanıcılar JobData içerisine o işin kullanıcıları olarak array şeklinde tutulur.
                         */
                        $user = User::where('id',$item2->assigned_to)->first();
                        $userDataMin = new UserDataMin();
                        $userDataMin->id = $user->id;
                        $userDataMin->name = $user->name;
                        $userDataMin->email = $user->email;
                        $userDataMin->company_id = $user->company_id;
                        $userDataMin->image = $user->image;
                        array_push($users,$userDataMin);
                    }
                        array_push($fetchedSerialNumbers,$tempJobData->serial_number);
                        $tempJobData->users = $users;
                }else{
                    /** ►►►►► DEVELOPER ◄◄◄◄◄
                     * Multiple user yoksa tek kullanıcıdan oluşan array JobData içeirinde tutulur
                     */
                    $user = User::where('id',$item->assigned_to)->first();
                    $userDataMin = new UserDataMin();
                    $userDataMin->id = $user->id;
                    $userDataMin->name = $user->name;
                    $userDataMin->email = $user->email;
                    $userDataMin->company_id = $user->company_id;
                    $userDataMin->image = $user->image;
                    array_push($users,$userDataMin);
                    array_push($fetchedSerialNumbers,$tempJobData->serial_number);

                    $tempJobData->users = $users;
                }
                array_push($jobsData, $tempJobData);
            }

            /** ►►►►► DEVELOPER ◄◄◄◄◄
             * Sayfa numarasına($selectedPage) göre o numaraya denk gelen 9'lu job çekilir ve döndürülür.
             */
            for($i=0;$i<9;$i++){
                $index = ($selectedPage-1)*9+$i;
                if($index>=count($jobsData)){
                    break;
                }
                array_push($pagedJobsData, $jobsData[$index]);
            }
            Session::flash('url_error', __('general.url_error'));

            /** ►►►►► DEVELOPER ◄◄◄◄◄
             * Sayfa sayısı varolan iş sayısına göre belirlenir.
             */
            $pageCount = ceil(count($jobsData)/9);
            if($pageCount<1){
                $pageCount=1;
            }
            return view('job-index',[
                'jobs' => $pagedJobsData,
                'filter' => $filter,
                'pageCount' => ceil(count($jobsData)/9),
                'selectedPage' => $selectedPage
            ]);
        }

        $filter = 0;
        $selectedPage = 1;
        $jobsData = array();
        $pagedJobsData = array();


        /** ►►►►► DEVELOPER ◄◄◄◄◄
         * Filtreleme işlemine göre data çekme.
         * 0 -> Hepsi
         * 1 -> Bitmemiş
         * 2 -> Bitmiş
         * status -> işin tamamlanıp tamamlanmadıgını gösterir
         */

        if(1==$_GET['filter']){
            $jobs = Job::where('company_id',Auth::user()->company_id)->where('status',0)->orderBy('created_at','desc')->get();
            $filter = 1;
        }else if(2==$_GET['filter']){
            $jobs = Job::where('company_id',Auth::user()->company_id)->where('status',1)->orderBy('created_at','desc')->get();
            $filter = 2;
        }else{
            $jobs = Job::where('company_id',Auth::user()->company_id)->orderBy('created_at','desc')->get();
            $filter = 0;
        }

        $fetchedSerialNumbers = array();
        foreach($jobs as $item){
            //If serial number already fetched, continue
            if(in_array($item->serial_number,$fetchedSerialNumbers)){
                continue;
            }

            /** ►►►►► DEVELOPER ◄◄◄◄◄
             * JobData, veritabanından bağımsız görüntülenecek veri modeli.
             */
            $tempJobData = new JobData();
            $tempJobData->id = $item->id;
            $tempJobData->job_title = $item->job_title;
            $tempJobData->job_context = substr($item->job_context, 0, 64);
            $tempJobData->assigned_from = $item->assigned_from;
            $tempJobData->assigned_to = $item->assigned_to;
            $tempJobData->company_id = $item->company_id;
            $tempJobData->start_date = $item->start_date;
            $tempJobData->end_date = $item->end_date;
            $tempJobData->serial_number = $item->serial_number;
            $tempJobData->is_multiple_user = $item->is_multiple_user;
            $tempJobData->status = $item->status;
            $tempJobData->is_success = $item->is_success;
            $tempJobData->unsuccess_reason = $item->unsuccess_reason;

            $users = array();
            //If multiple user assigned, do not push
            if($item->is_multiple_user){
                $multipleJobs = Job::where('serial_number',$item->serial_number)->get();
                foreach($multipleJobs as $item2){
                    /** ►►►►► DEVELOPER ◄◄◄◄◄
                     * Bir işin atandığı kullanıcılar JobData içerisine o işin kullanıcıları olarak array şeklinde tutulur.
                     */
                    $user = User::where('id',$item2->assigned_to)->first();
                    $userDataMin = new UserDataMin();
                    $userDataMin->id = $user->id;
                    $userDataMin->name = $user->name;
                    $userDataMin->email = $user->email;
                    $userDataMin->company_id = $user->company_id;
                    $userDataMin->image = $user->image;
                    array_push($users,$userDataMin);
                }
                    array_push($fetchedSerialNumbers,$tempJobData->serial_number);
                    $tempJobData->users = $users;
            }else{
                /** ►►►►► DEVELOPER ◄◄◄◄◄
                 * Multiple user yoksa tek kullanıcıdan oluşan array JobData içeirinde tutulur
                 */
                $user = User::where('id',$item->assigned_to)->first();
                $userDataMin = new UserDataMin();
                $userDataMin->id = $user->id;
                $userDataMin->name = $user->name;
                $userDataMin->email = $user->email;
                $userDataMin->company_id = $user->company_id;
                $userDataMin->image = $user->image;
                array_push($users,$userDataMin);
                array_push($fetchedSerialNumbers,$tempJobData->serial_number);

                $tempJobData->users = $users;
            }
            array_push($jobsData, $tempJobData);
        }

        /** ►►►►► DEVELOPER ◄◄◄◄◄
         * Sayfa numarasına($selectedPage) göre o numaraya denk gelen 9'lu job çekilir ve döndürülür.
         */
        $selectedPage = $_GET['selectedPage'];
        if($selectedPage>ceil(count($jobsData)/9)){
            $selectedPage=ceil(count($jobsData)/9);
        }
        if($selectedPage<1){
            $selectedPage=1;
        }

        /** ►►►►► DEVELOPER ◄◄◄◄◄
         * Sayfa numarasına($selectedPage) göre o numaraya denk gelen 9'lu job çekilir ve döndürülür.
         */
        for($i=0;$i<9;$i++){
            $index = ($selectedPage-1)*9+$i;
            if($index>=count($jobsData)){
                break;
            }
            array_push($pagedJobsData, $jobsData[$index]);
        }

        return view('job-index',[
            'jobs' => $pagedJobsData,
            'filter' => $filter,
            'pageCount' => ceil(count($jobsData)/9),
            'selectedPage' => $selectedPage
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        /** ►►►►► DEVELOPER ◄◄◄◄◄
         * Sidebar seçili menu.
         */
        session()->forget('selectedSideMenu');
        session()->put('selectedSideMenu','job-controller');

        /** ►►►►► DEVELOPER ◄◄◄◄◄
         * 'client' veya 'subclient' yetkisi olmayan kullanıcı iş ataması yapamaz.
         */
        if(Gate::allows('client') || Gate::allows('subclient')){
           $currentUser = Auth::user();
           $tempUsers = User::where('company_id',Auth::user()->company_id)->get();
           $users = array();
           /** ►►►►► DEVELOPER ◄◄◄◄◄
            * Kullanııclar sadece alt yetkideki kullanıcılara iş ataması yapabilir.
            */
           if($currentUser->authority == 'client'){
               foreach($tempUsers as $item){
                   if($item->authority == 'subclient' || $item->authority == 'temporary'){
                       $userMin = new UserDataMin();
                       $userMin->id = $item->id;
                       $userMin->name = $item->name;
                       $userMin->email = $item->email;
                       $userMin->company_id = $item->company_id;
                       array_push($users, $userMin);
                   }
               }
           }else if($currentUser->authority == 'subclient'){
               foreach($tempUsers as $item){
                   if($item->authority == 'temporary'){
                       $userMin = new UserDataMin();
                       $userMin->id = $item->id;
                       $userMin->name = $item->name;
                       $userMin->email = $item->email;
                       $userMin->company_id = $item->company_id;
                       array_push($users, $userMin);
                   }
               }
           }else{
               $users = [];
           }
           return view('job-create',[
               'current_user' => $currentUser,
               'users' => $users
           ]);
        }else{
           Session::flash('auth_error',__('general.auth_error'));
           return redirect()->route('job-controller.index',['filter'=>0,'selectedPage'=>1]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        /** ►►►►► DEVELOPER ◄◄◄◄◄
         * 'client' veya 'subclient' yetkisi olmayan kullanıcı iş ataması yapamaz.
         */
        if(Gate::allows('client') || Gate::allows('subclient')){
            /** ►►►►► DEVELOPER ◄◄◄◄◄
             * Birden fazla kullanıcıya atanan işler aynı 'serial_number' sahip olur.
             * 'serial_number' şirketin işlerinin sonuncusuna 1 eklenerek oluşturulur.
             */
            if(count($request->selected_users)>0){
                /** ►►►►► DEVELOPER ◄◄◄◄◄
                 * Şirkette daha önce atanmış iş yoksa sıfırdan başlar yoksa üzerine ekler.
                 */
                if(Job::where('company_id',Auth::user()->company_id)->count() != 0){
                    $currentSerialNumber = Job::where('company_id',Auth::user()->company_id)->orderBy('serial_number','desc')->first()->serial_number + 1;
                }else{
                    $currentSerialNumber = 0;
                }
                foreach($request->selected_users as $item){

                    $job = new Job();
                    $job->job_title = $request->job_title;
                    $job->job_context = $request->job_context;
                    $job->assigned_from = Auth::id();
                    $job->assigned_to = $item;
                    $job->company_id = Auth::user()->company_id;
                    $job->start_date = $request->start_date;
                    $job->end_date = $request->end_date;
                    $job->serial_number = $currentSerialNumber;
                    if(count($request->selected_users)>1){
                        $job->is_multiple_user = 1;
                    }else{
                        $job->is_multiple_user = 0;
                    }
                    $job->save();
                }
                return redirect()->route('send-job-mail',$job->id);
            }else{
                Session::flash('no_user_selected',__('general.no_user_assigned'));
                return redirect()->route('job-controller.create');
            }
        }else{
            Session::flash('auth_error',__('general.auth_error'));
            return redirect()->route('job-controller.index',['filter'=>0,'selectedPage'=>1]);
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
        session()->put('selectedSideMenu','job-controller');

        $job = Job::where('id',$id)->first();
        if(Auth::user()->company_id != $job->company_id){
            Session::flash('auth_error',__('general.auth_error'));
            return redirect()->route('job-controller.index',['filter'=>0,'selectedPage'=>1]);
        }
        $currentSerialNumber = $job->serial_number;

        /** ►►►►► DEVELOPER ◄◄◄◄◄
         * Şuanki kullanıcıya mı atanmış
         */
        $isAssignedToUser = false;
        foreach(Job::where('company_id',Auth::user()->company_id)->get() as $item){
            if($item->serial_number == $currentSerialNumber && $item->assigned_to == Auth::id()){
                $isAssignedToUser = true;
            }
        }
        return view('job-show',[
            'assigned_from' => User::where('id',$job->assigned_from)->first(),
            'job' => $job,
            'user_count' => Job::where('serial_number',$job->serial_number)->count(),
            'is_assigned_to_user' => $isAssignedToUser
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        /** ►►►►► DEVELOPER ◄◄◄◄◄
         * Sidebar seçili menu.
         */
        session()->forget('selectedSideMenu');
        session()->put('selectedSideMenu','job-controller');

        /** ►►►►► DEVELOPER ◄◄◄◄◄
         * 'client' veya 'subclient' yetkisi olmayan kullanıcı iş ataması yapamaz.
         */
        $job = Job::where('id',$id)->first();
        if(Auth::id() != $job->assigned_from || Auth::user()->authority != 'client' || Auth::user()->authority != 'subclient'){
            Session::flash('auth_error',__('general.auth_error'));
            return redirect()->route('job-controller.index',['filter'=>0,'selectedPage'=>1]);
        }

        $currentUser = Auth::user();
        $tempUsers = User::where('company_id',Auth::user()->company_id)->get();
        $users = array();

        /** ►►►►► DEVELOPER ◄◄◄◄◄
         * Kullanıcı kendinden düşük yetki seviyesindeki kişilerin işlerini düzenleyebilir.
         */
        if($currentUser->authority == 'client'){
            foreach($tempUsers as $item){
                if($item->authority == 'subclient' || $item->authority == 'temporary'){
                    $userMin = new UserDataMin();
                    $userMin->id = $item->id;
                    $userMin->name = $item->name;
                    $userMin->email = $item->email;
                    $userMin->company_id = $item->company_id;
                    array_push($users, $userMin);
                }
            }
        }else if($currentUser->authority == 'subclient'){
            foreach($tempUsers as $item){
                if($item->authority == 'temporary'){
                    $userMin = new UserDataMin();
                    $userMin->id = $item->id;
                    $userMin->name = $item->name;
                    $userMin->email = $item->email;
                    $userMin->company_id = $item->company_id;
                    array_push($users, $userMin);
                }
            }
        }else{
            $users = [];
        }

        /** ►►►►► DEVELOPER ◄◄◄◄◄
         * JobData, veritabanından bağımsız görüntülenecek veri modeli.
         */
        $temp = new JobData;
        $temp->id = $job->id;
        $temp->job_title = $job->job_title;
        $temp->job_context = $job->job_context;
        $temp->assigned_from = $job->assigned_from;
        $temp->assigned_to = $job->assigned_to;
        $temp->company_id = $job->company_id;
        $temp->serial_number = $job->serial_number;
        $temp->is_multiple_user = $job->is_multiple_user;
        $temp->status = $job->status;
        $temp->unsuccess_reason = $job->unsuccess_reason;
        $temp->start_date = $job->start_date;
        $temp->end_date = $job->end_date;

        /** ►►►►► DEVELOPER ◄◄◄◄◄
         * İşe atanmış kullanıcılar array olarak JobData içerisinde tutulur
         */
        $assigned_users = array();
        foreach(Job::where('assigned_from',Auth::id())->get() as $item){
            if($item->serial_number == $job->serial_number){
                array_push($assigned_users,User::where('id',$item->assigned_to)->first());
            }
        }
        $temp->users = $assigned_users;

        return view('job-edit',[
            'job' => $temp,
            'users' => $users
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $job = Job::where('id',$id)->first();

        /** ►►►►► DEVELOPER ◄◄◄◄◄
         * İş başarılı güncellendiği zaman 'completed'
         */
        if($request->has('completed')){
            /** ►►►►► DEVELOPER ◄◄◄◄◄
             * İşin atandığı kullanıcı dışında iş düzenleme yapamaz.
             * 'status' -> 1 tamamlandı
             * 'is_success' -> 0 başarısız, 1 başarılı
             */
            if(Auth::id() != $job->assigned_to){
                Session::flash('auth_error',__('general.auth_error'));
                return redirect()->route('job-controller.index',['filter'=>0,'selectedPage'=>1]);
            }
            $currentSerialNumber = Job::where('id',$id)->first()->serial_number;
            foreach(Job::where('company_id',Auth::user()->company_id)->get() as $item){
                if($item->serial_number == $currentSerialNumber){
                    $item->status = 1;
                    $item->is_success = 1;
                    $item->save();
                    $user = User::where('id',$item->assigned_to)->first();
                    $user->work_count = $user->work_count + 1;
                    $user->save();
                }
            }
            Session::flash('success', __('general.successful'));
            return redirect()->route('job-controller.show',$id);

        /** ►►►►► DEVELOPER ◄◄◄◄◄
         * İş başarısız güncellendiği zaman 'uncompleted'
         */
        }else if($request->has('uncompleted')){
            /** ►►►►► DEVELOPER ◄◄◄◄◄
             * İşin atandığı kullanıcı dışında iş düzenleme yapamaz.
             */
            if(Auth::id() != $job->assigned_to){
                Session::flash('auth_error',__('general.auth_error'));
                return redirect()->route('job-controller.index',['filter'=>0,'selectedPage'=>1]);
            }
            $currentSerialNumber = Job::where('id',$id)->first()->serial_number;
            foreach(Job::where('company_id',Auth::user()->company_id)->get() as $item){
                if($item->serial_number == $currentSerialNumber){
                    $item->status = 1;
                    $item->is_success = 0;
                    $item->unsuccess_reason = $request->unsuccess_reason;
                    $item->save();
                }
            }
            Session::flash('success', __('general.successful'));
            return redirect()->route('job-controller.show',$id);
        /** ►►►►► DEVELOPER ◄◄◄◄◄
         * İş bvilgilari güncellemesi için 'update_job'
         */
        }else if($request->has('update_job')){
            /** ►►►►► DEVELOPER ◄◄◄◄◄
             * İşin atandığı kullanıcı, 'client' veya 'subclient' yetkisi olmayan kullanıcılar dışında iş düzenleme yapamaz.
             */
            if(Auth::id() != $job->assigned_from || Auth::user()->authority != 'client' || Auth::user()->authority != 'subclient'){
                Session::flash('auth_error',__('general.auth_error'));
                return redirect()->route('job-controller.index',['filter'=>0,'selectedPage'=>1]);
            }

            $currentSerialNumber = Job::where('id',$id)->first()->serial_number;
            foreach(Job::where('company_id',Auth::user()->company_id)->get() as $item){
                if($item->serial_number == $currentSerialNumber){
                    $item->delete();
                }
            }
            foreach($request->selected_users as $item){
                $job = new Job();
                $job->job_title = $request->job_title;
                $job->job_context = $request->job_context;
                $job->assigned_from = Auth::id();
                $job->assigned_to = $item;
                $job->company_id = Auth::user()->company_id;
                $job->start_date = $request->start_date;
                $job->end_date = $request->end_date;
                $job->serial_number = $currentSerialNumber;
                if(count($request->selected_users)>1){
                    $job->is_multiple_user = 1;
                }else{
                    $job->is_multiple_user = 0;
                }
                $job->save();
            }
            return redirect()->route('job-controller.edit',$job->id);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(Auth::id() != Job::where('id',$id)->first()->assigned_from || Auth::user()->authority != 'client'){
            Session::flash('auth_error',__('general.auth_error'));
            return redirect()->route('job-controller.index',['filter'=>0,'selectedPage'=>1]);
        }
        $currentSerialNumber = Job::where('id',$id)->first()->serial_number;
        foreach(Job::where('company_id',Auth::user()->company_id)->get() as $item){
            if($item->serial_number == $currentSerialNumber){
                $item->delete();
            }
        }
        return redirect()->route('job-controller.index',['filter'=>0,'selectedPage'=>1]);
    }

    public function myJobs(){
        $jobs = Job::where('assigned_to',Auth::user()->id)->orderBy('created_at','desc')->get();
        /** ►►►►► DEVELOPER ◄◄◄◄◄
         * 'serial_number' birden fazla kişiye atanmış işleri 1'den fazla çekmemek için kontrol edilir.
         */
        $jobsData = array();
        $fetchedSerialNumbers = array();
        foreach($jobs as $item){
            //If serial number already fetched, continue
            if(in_array($item->serial_number,$fetchedSerialNumbers)){
                continue;
            }

            /** ►►►►► DEVELOPER ◄◄◄◄◄
             * JobData, veritabanından bağımsız görüntülenecek veri modeli.
             */
            $tempJobData = new JobData();
            $tempJobData->id = $item->id;
            $tempJobData->job_title = $item->job_title;
            $tempJobData->job_context = substr($item->job_context, 0, 64);
            $tempJobData->assigned_from = $item->assigned_from;
            $tempJobData->assigned_to = $item->assigned_to;
            $tempJobData->company_id = $item->company_id;
            $tempJobData->start_date = $item->start_date;
            $tempJobData->end_date = $item->end_date;
            $tempJobData->serial_number = $item->serial_number;
            $tempJobData->is_multiple_user = $item->is_multiple_user;
            $tempJobData->status = $item->status;
            $tempJobData->is_success = $item->is_success;
            $tempJobData->unsuccess_reason = $item->unsuccess_reason;


            $users = array();
            //If multiple user assigned, do not push
            if($item->is_multiple_user){
                $multipleJobs = Job::where('serial_number',$item->serial_number)->get();
                foreach($multipleJobs as $item2){
                    /** ►►►►► DEVELOPER ◄◄◄◄◄
                     * Bir işin atandığı kullanıcılar JobData içerisine o işin kullanıcıları olarak array şeklinde tutulur.
                     */
                    $user = User::where('id',$item2->assigned_to)->first();
                    $userDataMin = new UserDataMin();
                    $userDataMin->id = $user->id;
                    $userDataMin->name = $user->name;
                    $userDataMin->email = $user->email;
                    $userDataMin->company_id = $user->company_id;
                    $userDataMin->image = $user->image;
                    array_push($users,$userDataMin);
                }
                    array_push($fetchedSerialNumbers,$tempJobData->serial_number);
                    $tempJobData->users = $users;
            }else{
                /** ►►►►► DEVELOPER ◄◄◄◄◄
                 * Multiple user yoksa tek kullanıcıdan oluşan array JobData içeirinde tutulur
                 */
                $user = User::where('id',$item->assigned_to)->first();
                $userDataMin = new UserDataMin();
                $userDataMin->id = $user->id;
                $userDataMin->name = $user->name;
                $userDataMin->email = $user->email;
                $userDataMin->company_id = $user->company_id;
                $userDataMin->image = $user->image;
                array_push($users,$userDataMin);
                array_push($fetchedSerialNumbers,$tempJobData->serial_number);

                $tempJobData->users = $users;
            }
            array_push($jobsData, $tempJobData);
        }

        return view('job-my-jobs',[
            'jobs' => $jobsData,
        ]);
    }
}

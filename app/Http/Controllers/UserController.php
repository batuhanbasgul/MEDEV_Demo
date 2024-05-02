<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Services\FileManagerService;
use App\Models\User;
use App\Models\Company;
use App\Models\ImageManager;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $fileManagerService;
    public function __construct(FileManagerService $fileManagerService)
    {
        $this->middleware('auth');
        /** ►►►►► DEVELOPER ◄◄◄◄◄
         * FileManagerService resim editi, yüklenmesi ve optimizasyonunu barındırır.
         */
        $this->fileManagerService = $fileManagerService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        /** ►►►►► DEVELOPER ◄◄◄◄◄
         * Sidebar seçili menu.
         */
        session()->forget('selectedSideMenu');
        session()->put('selectedSideMenu','user-controller');
        if($request->refresh){
            return back();
        }
        /** ►►►►► DEVELOPER ◄◄◄◄◄
         * Sidebar selected item
         */
        session()->forget('selectedSideMenu');
        session()->put('selectedSideMenu',last(explode('/',URL::current())));


        /** ►►►►► DEVELOPER ◄◄◄◄◄
         * User order
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

        return view('user-index',[
            'users' => $users,
            'userCount' => User::all()->count(),
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
        session()->put('selectedSideMenu','user-controller');
        if(Auth::user()){
            /** ►►►►► DEVELOPER ◄◄◄◄◄
             * Authorization kontrolü.
             */
            if (Gate::allows('admin') || Gate::allows('client') || Gate::allows('subclient')){
                return view('user-create');
            }else{
                Session::flash('auth_error', __('general.auth_error'));
                return redirect()->route('user-controller.index');
            }
        }else{
            //Firma sitesinden geliyor
            dd('Firma sitesinden geliyor');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(Auth::user()){
            /** ►►►►► DEVELOPER ◄◄◄◄◄
             * 'admin', 'client' veya 'subclient' yetkisi olmayan kullanıcı yeni kullanıcı oluşturamaz.
             */
            if (Gate::allows('admin') || Gate::allows('client') || Gate::allows('subclient')){
                if($request->has('create_user')){

                    /** ►►►►► DEVELOPER ◄◄◄◄◄
                     * Şifre eşleşmesi
                     */
                    if (request()->get('password') != request()->get('confirm_password')) {
                        Session::flash('password_error', __('general.password_unmatched'));
                        return redirect()->route('user-controller.create')->withInput($request->input());
                    } else {

                        /** ►►►►► DEVELOPER ◄◄◄◄◄
                         * email adresi kullanılıyor mu
                         */
                        foreach (User::all() as $user) {
                            if ($request->email == $user->email) {
                                Session::flash('email_error', __('general.email_inuse'));
                                return redirect()->route('user-controller.create')->withInput($request->input());
                            }
                        }
                    }
                    $user = new User();
                    $user->email = $request->email;
                    $user->password = Hash::make($request->password);
                    $user->name = $request->name;
                    $user->phone = $request->phone;
                    $user->department = $request->department;
                    $user->company_id = Auth::user()->company_id;
                    $user->authority = $request->authority;
                    $user->start_date = $request->start_date;

                    if ($user->save()) {
                        Session::flash('success', __('general.successful'));
                    } else {
                        Session::flash('error', __('general.unsuccessful'));
                    }
                    return redirect()->route('user-controller.index');
                }else{
                    return redirect()->route('user-controller.index');
                }
            }else{
                Session::flash('auth_error', __('general.auth_error'));
                return redirect()->route('user-controller.index');
            }
        }else{
            //Firma sitesinden geliyor
            dd('Firma sitesinden geliyor');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        session()->put('selectedSideMenu','user-controller');
        if(Auth::user()->company_id != User::findOrFail($id)->company_id){
            Session::flash('error', __('general.error'));
            return redirect()->route('user-controller.index');
        }
        /** ►►►►► DEVELOPER ◄◄◄◄◄
         * 'admin', 'client' veya 'subclient' yetkisi olmayan veya kendi hesabı olmayan kullanıcı düzenleme yapamaz.
         */
        if (Gate::allows('admin') || Gate::allows('client') || Gate::allows('subclient') || Auth::id() == $id){
            $imageManager = new ImageManager();
            $imageManager->height = 250;
            $imageManager->width = 250;
            $imageManager->ratio = 1.0;
            $imageManager->quality = 90;
            $imageManager->file_size = 1048576000;  //1024
            return view('user-edit',[
                'user' => User::findOrFail($id),
                'imageManager' => $imageManager,
                'companyName' => Company::findOrFail(Auth::user()->company_id)->company_name
            ]);
        }else{
            Session::flash('auth_error', __('general.auth_error'));
            return redirect()->route('user-controller.index');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if(Auth::user()->company_id != User::findOrFail($id)->company_id){
            Session::flash('error', __('general.error'));
            return redirect()->route('user-controller.index');
        }
        /** ►►►►► DEVELOPER ◄◄◄◄◄
         * Changing theme preferences
         */
        if($request->has('updateuserpreferences')){
            $user = User::findOrFail($id);
            $user->theme = $request->theme;
            $user->save();
            return back();
        }

        /** ►►►►► DEVELOPER ◄◄◄◄◄
         * 'admin', 'client' veya 'subclient' yetkisi olmayan kullanıcı yeni kullanıcı oluşturamaz.
         */
        if (Gate::allows('admin') || Gate::allows('client') || Gate::allows('subclient') || Auth::id() == $id){
            /** ►►►►► DEVELOPER ◄◄◄◄◄
             * Fetch User
             */
            $user = User::findOrFail($id);

            /** ►►►►► DEVELOPER ◄◄◄◄◄
             * Check user's authorization
             */
            if(Auth::id() != $id){
                if(Auth::user()->authority == 'temporary'){
                    Session::flash('auth_error', __('general.auth_error'));
                    return redirect()->route('user-controller.index');
                }else if(Auth::user()->authority == 'subclient' && $user->authority == 'admin'){
                    Session::flash('auth_error', __('general.auth_error'));
                    return redirect()->route('user-controller.index');
                }else if(Auth::user()->authority == 'subclient' && $user->authority == 'client'){
                    Session::flash('auth_error', __('general.auth_error'));
                    return redirect()->route('user-controller.index');
                }else if(Auth::user()->authority == 'subclient' && $user->authority == 'subclient'){
                    Session::flash('auth_error', __('general.auth_error'));
                    return redirect()->route('user-controller.index');
                }else if(Auth::user()->authority == 'client' && $user->authority == 'admin'){
                    Session::flash('auth_error', __('general.auth_error'));
                    return redirect()->route('user-controller.index');
                }else if(Auth::user()->authority == 'client' && $user->authority == 'client'){
                    Session::flash('auth_error', __('general.auth_error'));
                    return redirect()->route('user-controller.index');
                }
            }

            /** ►►►►► DEVELOPER ◄◄◄◄◄
             * If request is for updating user info
             */
            if($request->has('save_user')){
                $user->name = $request->name;
                $user->phone = $request->phone;
                $user->department = $request->department;
                $user->authority = $request->authority;
                $user->start_date = $request->start_date;

                if ($user->save()) {
                    Session::flash('success', __('general.successful'));
                } else {
                    Session::flash('error', __('general.unsuccessful'));
                }
                return redirect()->route('user-controller.edit',[$id]);
            /** ►►►►► DEVELOPER ◄◄◄◄◄
             * If request is for updating user password
             */
            }else if($request->has('change_password')){
                /** ►►►►► DEVELOPER ◄◄◄◄◄
                 * 'admin', 'client' yetkisi olmayan kullanıcı şifre değiştiremez.
                 */
                if (Gate::allows('admin') || Gate::allows('client') || Auth::id() == $id){
                    if (Hash::check($request->old_password, $user->password)) {
                        if ($request->password == $request->confirm_password) {
                            $user->password = Hash::make($request->password);
                            if ($user->save()) {
                                Session::flash('success', __('general.password_changed'));
                            } else {
                                Session::flash('error', __('general.password_not_changed'));
                            }
                            return redirect()->route('user-controller.edit',[$id]);
                        } else {
                            Session::flash('error_pwd', __('general.password_unmatched'));
                            return redirect()->route('user-controller.edit',[$id]);
                        }
                    } else {
                        Session::flash('old_pwd', __('general.wrong_old_password'));
                        return redirect()->route('user-controller.edit',[$id]);
                    }
                }else{
                    Session::flash('auth_error', __('general.auth_error'));
                    return redirect()->route('user-controller.index');
                }
            /** ►►►►► DEVELOPER ◄◄◄◄◄
             * If request is for updating user image
             */
            }else if($request->has('updatepimage')){
                /** ►►►►► DEVELOPER ◄◄◄◄◄
                 * 'admin', 'client' yetkisi olmayan kullanıcı profil resmi değiştiremez.
                 */
                if (Auth::id() == $id){
                    /** ►►►►► DEVELOPER ◄◄◄◄◄
                     * Validation for file mime from FileManagerService.
                     */
                    if($request->hasFile('profile_image')){
                        if(!$this->fileManagerService->checkExtension($request->profile_image)){
                            Session::flash('file_extension_error',__('general.file_extension_error'));
                            return redirect()->route('user-controller.edit',[$id]);
                        }
                    }
                    /** ►►►►► DEVELOPER ◄◄◄◄◄
                     * Upload cropped image if there is one.
                     */
                    if ($request->cropped_data) {
                        /** ►►►►► DEVELOPER ◄◄◄◄◄
                        * Quality, fize size, image sizes.
                        */
                        $imageManager = new ImageManager();
                        $imageManager->height = 250;
                        $imageManager->width = 250;
                        $imageManager->ratio = 1.0;
                        $imageManager->quality = 90;
                        $imageManager->file_size = 1048576000;  //1024

                        /** ►►►►► DEVELOPER ◄◄◄◄◄
                         * Uploading image from FileManagerService. Returns file path.
                         */
                        $result = $this->fileManagerService->uploadImage($user->name, $request->cropped_data, 'user_profiles', $imageManager);
                        if($result == '0'){
                            Session::flash('file_size_error', __('general.file_size_error'));
                            return redirect()->route('user-controller.edit',[$id]);
                        }

                        /** ►►►►► DEVELOPER ◄◄◄◄◄
                         * Delete old files if there is.
                         */
                        if (file_exists($user->p_image)) {
                            unlink($user->p_image);
                        }
                        $user->p_image = $result;
                        if ($user->save()) {
                            Session::flash('success', __('general.successful'));
                        } else {
                            Session::flash('error', __('general.unsuccessful'));
                        }
                    }
                    return redirect()->route('user-controller.edit',[$id]);
                }else{
                    Session::flash('auth_error', __('general.auth_error'));
                    return redirect()->route('user-controller.index');
                }
            }else if($request->has('freeze_user')){
                /** ►►►►► DEVELOPER ◄◄◄◄◄
                 * 'admin', 'client' yetkisi olmayan kullanıcı başka bir kullanıcıyı donduramaz.
                 */
                if (Gate::allows('admin') || Gate::allows('client')){

                    if (!Hash::check($request->password, Auth::user()->password)){
                        Session::flash('wrong_pwd', __('general.wrong_password'));
                        return redirect()->route('user-controller.edit',[$id]);
                    }

                    if(Auth::id() == $request->user_id){
                        Session::flash('own', __('general.cannot_freeze_self'));
                        return redirect()->route('user-controller.edit',[$id]);
                    }

                    $targetUser = User::findOrFail($request->user_id);
                    if($targetUser->is_active){
                        $targetUser->is_active = 0;
                    }else{
                        $targetUser->is_active = 1;
                    }

                    if ($targetUser->save()) {
                        Session::flash('success', __('general.successful'));
                    } else {
                        Session::flash('error', __('general.unsuccessful'));
                    }
                    return redirect()->route('user-controller.edit',[$id]);
                }else{
                    Session::flash('auth_error', __('general.auth_error'));
                    return redirect()->route('user-controller.index');
                }
            }else{
                return redirect()->route('user-controller.edit',[$id]);
            }
        }else{
            Session::flash('auth_error', __('general.auth_error'));
            return redirect()->route('user-controller.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function enterPwd(Request $request, string $id)
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

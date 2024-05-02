<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Models\Company;
use App\Models\User;

class CompanyController extends Controller
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
        //
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
        session()->put('selectedSideMenu','company-controller');

        /** ►►►►► DEVELOPER ◄◄◄◄◄
         * Authorization kontrolü.
         */
        if (Gate::allows('admin') || Gate::allows('client')){
            if(Auth::user()->company_id == 0){
                //Redirect to create if there is no company
                Session::flash('no_company_error',__('general.no_company_error'));
                return view('company-create');
            }else{
                //Redirect to edit if there is company
                Session::flash('has_already_company',__('general.has_already_company'));
                return redirect()->route('company-controller.edit',[Auth::user()->company_id]);
            }
        }else{
            Auth::logout();
            return view('auth.login');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        /** ►►►►► DEVELOPER ◄◄◄◄◄
         * Authorization kontrolü.
         */
        if (Gate::allows('admin') || Gate::allows('client')){
            if(Auth::user()->company_id == 0){
                $company = new Company();
                $company->company_name = $request->company_name;
                $company->manager_account_id = Auth::id();
                if($company->save()){
                    $user = User::findOrFail(Auth::id());
                    $user->company_id = $company->id;
                    $user->save();
                    Session::flash('success',__('general.success'));
                    return redirect()->route('index');
                }else{
                    Session::flash('error',__('general.error'));
                    return redirect()->route('company-controller.create');
                }
            }else{
                Session::flash('has_already_company',__('general.has_already_company'));
                return redirect()->route('company-controller.edit',[Auth::user()->company_id]);
            }
        }else{
            Auth::logout();
            return view('auth.login');
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
        session()->put('selectedSideMenu','company-controller');
        /** ►►►►► DEVELOPER ◄◄◄◄◄
         * 'company_id' = 0, şirket oluşturulmamış kullanıcı.
         */
        if(Auth::user()->company_id == 0){
            Session::flash('no_company_error',__('general.no_company_error'));
            return view('company-create');
        }else if(Auth::user()->company_id == $id){
            return view('company-edit',[
                'company' => Company::where('id',Auth::user()->company_id)->first(),
                'user' => Auth::user()
            ]);
        }else{
            Session::flash('auth_error',__('general.auth_error'));
            return redirect()->route('company-controller.edit',$id);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        /** ►►►►► DEVELOPER ◄◄◄◄◄
         * 'company_id' = 0, şirket oluşturulmamış kullanıcı.
         */
        if(Auth::user()->company_id == 0){
            Session::flash('no_company_error',__('general.no_company_error'));
            return view('company-create');
        }else if(Auth::user()->company_id == $id){
            /** ►►►►► DEVELOPER ◄◄◄◄◄
             * Authorization kontrolü.
             */
            if (Gate::allows('admin') || Gate::allows('client')){
                $company = Company::findOrFail(Auth::user()->company_id);
                $company->company_name = $request->company_name;
                if($company->save()){
                    Session::flash('success',__('general.success'));
                    return redirect()->route('company-controller.edit',[Auth::user()->company_id]);
                }else{
                    Session::flash('error',__('general.error'));
                    return redirect()->route('company-controller.edit',[Auth::user()->company_id]);
                }
            }else{
                Session::flash('auth_error',__('general.auth_error'));
                return redirect()->route('company-controller.edit',$id);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

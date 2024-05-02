<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Models\CorporationDepartment;
use App\Models\Corporation;
use App\Models\CorpDepartmentData;
use App\Models\Device;
use App\Models\DeviceData;
use App\Models\Product;
use Illuminate\Support\Facades\Gate;

class CorporationDepartmentController extends Controller
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
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /** ►►►►► DEVELOPER ◄◄◄◄◄
         * Sidebar seçili menu.
         */
        session()->forget('selectedSideMenu');
        session()->put('selectedSideMenu','department-controller');

        $departments = array();
        foreach(CorporationDepartment::where('company_id',Auth::user()->company_id)->orderBy('corporation_id','asc')->get() as $item){
            /** ►►►►► DEVELOPER ◄◄◄◄◄
             * CorpDepartmentData, veritabanından bağımsız görüntülenecek veri modeli.
             */
            $departmentData = new CorpDepartmentData();
            $departmentData->id = $item->id;
            $departmentData->corporation_name = Corporation::findOrFail($item->corporation_id)->name;
            $departmentData->company_id = $item->company_id;
            $departmentData->name = $item->name;
            $departmentData->person = $item->person;
            $departmentData->contact = $item->contact;
            array_push($departments,$departmentData);
        }
        return view('department-index',[
            'departments' => $departments
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        /** ►►►►► DEVELOPER ◄◄◄◄◄
         * Sidebar seçili menu.
         */
        session()->forget('selectedSideMenu');
        session()->put('selectedSideMenu','department-controller');

        return view('department-create',[
            'corporations' => Corporation::where('company_id',Auth::user()->company_id)->orderBy('name','asc')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->has('create_department')){
            /** ►►►►► DEVELOPER ◄◄◄◄◄
             * Authorization kontrolü.
             */
            if(Gate::allows('client') || Gate::allows('subclient')){
                $department = new CorporationDepartment();
                $department->corporation_id = $request->corporation_id;
                $department->company_id = Auth::user()->company_id;
                $department->name = $request->name;
                $department->person = $request->person;
                $department->contact = $request->contact;
                if($department->save()){
                    Session::flash('success',__('general.success'));
                    return redirect()->route('department-controller.index');
                }else{
                    Session::flash('error',__('general.error'));
                    return redirect()->route('department-controller.index');
                }
            }else{
                Session::flash('auth_error',__('general.auth_error'));
                return redirect()->route('department-controller.index');
            }
        }else{
            Session::flash('error',__('general.error'));
            return redirect()->route('department-controller.index');
        }
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
        /** ►►►►► DEVELOPER ◄◄◄◄◄
         * Sidebar seçili menu.
         */
        session()->forget('selectedSideMenu');
        session()->put('selectedSideMenu','department-controller');

        $corporations = Corporation::where('company_id',Auth::user()->company_id)->get();
        $department = CorporationDepartment::findOrFail($id);
        return view('department-edit',[
            'corporations' => $corporations,
            'department' => $department
        ]);
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
        if($request->has('edit_department')){
            /** ►►►►► DEVELOPER ◄◄◄◄◄
             * Authorization kontrolü.
             */
            if(Gate::allows('client') || Gate::allows('subclient')){
                $department = CorporationDepartment::findOrFail($id);
                $department->corporation_id = $request->corporation_id;
                $department->name = $request->name;
                $department->person = $request->person;
                $department->contact = $request->contact;
                if($department->save()){
                    Session::flash('success',__('general.success'));
                    return redirect()->route('department-controller.index');
                }else{
                    Session::flash('error',__('general.error'));
                    return redirect()->route('department-controller.index');
                }
            }else{
                Session::flash('auth_error',__('general.auth_error'));
                return redirect()->route('department-controller.index');
            }
        }else{
            Session::flash('error',__('general.error'));
            return redirect()->route('department-controller.index');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        /** ►►►►► DEVELOPER ◄◄◄◄◄
         * Authorization kontrolü.
         */
        if(Gate::allows('client') || Gate::allows('subclient')){
            $deviceCount = Device::where('department_id',$id)->count();
            /** ►►►►► DEVELOPER ◄◄◄◄◄
             * Eğer birime bağlı cihaz kaydı varsa birim silinemez.
             */
            if($deviceCount > 0){
                Session::flash('device_count',__('general.error'));
                return redirect()->route('department-controller.edit',$id);
            }else{
                $department = CorporationDepartment::findOrFail($id);
                if($department->delete()){
                    Session::flash('success',__('general.success'));
                    return redirect()->route('department-controller.index');
                }else{
                    Session::flash('error',__('general.error'));
                    return redirect()->route('department-controller.edit',$id);
                }
            }
        }else{
            Session::flash('auth_error',__('general.auth_error'));
            return redirect()->route('department-controller.edit',$id);
        }
    }

    public function download($id){
        /** ►►►►► DEVELOPER ◄◄◄◄◄
         * Ürünün dahilindeki cihazların bilgileri olan bir liste PDF olarak indirilir.
         */
        $devices = array();
        foreach(Device::where('department_id',$id)->orderBy('created_at','desc')->get() as $item){
            /** ►►►►► DEVELOPER ◄◄◄◄◄
             * ProductData, veritabanından bağımsız görüntülenecek veri modeli.
             */
            $deviceData = new DeviceData();
            $deviceData->id = $item->id;
            $deviceData->product_name = Product::findOrFail($item->product_id)->name;
            $deviceData->company_id = $item->company_id;
            $deviceData->corporation_name = Corporation::findOrFail($item->corporation_id)->name;
            $deviceData->name = $item->name;
            $deviceData->brand = $item->brand;
            $deviceData->model = $item->model;
            $deviceData->serial_no = $item->serial_no;
            $deviceData->department_name = CorporationDepartment::findOrFail($item->department_id)->name;
            $deviceData->department_contact = CorporationDepartment::findOrFail($item->department_id)->contact;
            $deviceData->spendable_count = $item->spendable_count;
            $deviceData->qr_code = $item->qr_code;
            $deviceData->qr_code_path = $item->qr_code_path;

            array_push($devices,$deviceData);
        }

        if(count($devices) == 0){
            Session::flash('no_data',__('general.error'));
            return redirect()->route('department-controller.index');
        }
        Session::flash('pdf_title',$devices[0]->department_name.' '.__('department.device_list'));
        $data=array();
        foreach($devices as $item){
            array_push($data,$item);
        }
        if(count($data) == 0){
            Session::flash('no_data',__('general.error'));
            return redirect()->route('department-controller.index');
        }
        view()->share('data',$data);
        $pdf = \PDF::loadView('template/qr-pdf', $data);
        return $pdf->download($devices[0]->department_name.'.pdf');
    }
}

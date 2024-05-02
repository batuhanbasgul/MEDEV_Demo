<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Models\Device;
use App\Models\DeviceData;
use App\Models\DeviceTransaction;
use App\Models\Product;
use App\Models\Corporation;
use App\Models\CorporationDepartment;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;

class DeviceTransactionController extends Controller
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
        session()->put('selectedSideMenu','dev-transaction-controller');
        return view('dev-transaction-index',[
            'transactions' => DeviceTransaction::where('company_id',Auth::user()->company_id)->orderBy('created_at','desc')->get()
        ]);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        /** ►►►►► DEVELOPER ◄◄◄◄◄
         * Sidebar seçili menu.
         */
        session()->forget('selectedSideMenu');
        session()->put('selectedSideMenu','dev-transaction-controller');
        return view('dev-transaction-show',[
            'transaction' => DeviceTransaction::findOrFail($id)
        ]);
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
        session()->put('selectedSideMenu','dev-transaction-controller');
        $transaction = DeviceTransaction::findOrFail($id);
        return view('dev-transaction-edit',[
            'transaction' => $transaction,
            'users' => User::where('company_id',Auth::user()->company_id)->orderBy('name','asc')->get()
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
        if($request->has('edit_transaction')){
            /** ►►►►► DEVELOPER ◄◄◄◄◄
             * Authorization kontrolü.
             */
            if(Gate::allows('client') || Gate::allows('subclient')){
                $transaction = DeviceTransaction::findOrFail($id);
                $transaction->transactions = $request->transactions;
                $transaction->personel_id = $request->personel_id;
                $transaction->personel_name = User::findOrFail($request->personel_id)->name;
                $transaction->record_no_to = $request->record_no_to;
                $transaction->record_no_from = $request->record_no_from;
                $transaction->calibration_tag_date = $request->calibration_tag_date;
                $transaction->service_in_date = $request->service_in_date;
                $transaction->service_out_date = $request->service_out_date;
                $transaction->description = $request->description;
                $transaction->verifier_name = $request->verifier_name;
                $transaction->verifier_tel = $request->verifier_tel;
                $transaction->note = $request->note;

                if($transaction->save()){
                    Session::flash('success',__('general.success'));
                    return redirect()->route('dev-transaction-controller.show',$id);
                }else{
                    Session::flash('error',__('general.error'));
                    return redirect()->route('dev-transaction-controller.show',$id);
                }
            }else{
                Session::flash('auth_error',__('general.auth_error'));
                return redirect()->route('dev-transaction-controller.show',$id);
            }
        }else{
            Session::flash('error',__('general.error'));
            return redirect()->route('dev-transaction-controller.show',$id);
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
            $transaction = DeviceTransaction::findOrFail($id);
            if($transaction->delete()){
                Session::flash('success',__('general.success'));
                return redirect()->route('dev-transaction-controller.index');
            }else{
                Session::flash('error',__('general.error'));
                return redirect()->route('dev-transaction-controller.show',$id);
            }
        }else{
            Session::flash('auth_error',__('general.auth_error'));
            return redirect()->route('dev-transaction-controller.show',$id);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function findDevices(){
        /** ►►►►► DEVELOPER ◄◄◄◄◄
         * Authorization kontrolü.
         */
        session()->forget('selectedSideMenu');
        session()->put('selectedSideMenu','dev-transaction-controller');

        /** ►►►►► DEVELOPER ◄◄◄◄◄
         * Manuel ürün bulma için 'company_id' sahip bütün ürünler.
         */
        $tempProducts = Product::where('company_id',Auth::user()->company_id)->orderBy('name','asc')->get();

        /** ►►►►► DEVELOPER ◄◄◄◄◄
         * Güncel Tarih
         */
        $date = explode(' ',Carbon::now()->toDateTimeString());
        $currentDate = explode('-',$date[0]);

        /** ►►►►► DEVELOPER ◄◄◄◄◄
         * Tarihi Geçmiş Ürünler array içerisine eklenmez ve ürün bulma ekranında gösterilmez.
         */
        $products = array();
        foreach($tempProducts as $item){
            $productEndDate = explode('-',$item->end_date);
            $isExpired = false;
            if($productEndDate[0] > $currentDate[0]){
                $isExpired = false;
            }else if($productEndDate[0] == $currentDate[0]){
                if($productEndDate[1] > $currentDate[1]){
                    $isExpired = false;
                }else if($productEndDate[1] == $currentDate[1]){
                    if($productEndDate[2] > $currentDate[2]){
                        $isExpired = false;
                    }else if($productEndDate[2] == $currentDate[2]){    //Son Gün
                        $isExpired = false;
                    }else{
                        $isExpired = true;
                    }
                }else{
                    $isExpired = true;
                }
            }else{
                $isExpired = true;
            }
            if(!$isExpired){
                array_push($products,$item);
            }
        }

        /** ►►►►► DEVELOPER ◄◄◄◄◄
         * Tarihi geçmemiş ürünlerün kurumları da bir array içerisine konulur.
         */
        $corporations = array();
        foreach($products as $item){
            if(!in_array(Corporation::findOrFail($item->corporation_id),$corporations)){
                array_push($corporations,Corporation::findOrFail($item->corporation_id));
            }
        }

        /** ►►►►► DEVELOPER ◄◄◄◄◄
         * Tarihi geçmemiş ürünlerün kurumlarının birimleri de bir array içerisine konulur.
         */
        $departments = array();
        foreach($corporations as $corp){
            $corpDepartments = CorporationDepartment::where('corporation_id',$corp->id)->get();
            foreach($corpDepartments as $dept){
                if(!in_array($dept,$departments)){
                    array_push($departments,$dept);
                }
            }
        }

        return view('dev-transaction-find-devices',[
            'products' => $products,
            'corporations' => $corporations,
            'departments' => $departments
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function fetchDevices(Request $request){
        /** ►►►►► DEVELOPER ◄◄◄◄◄
         * Sidebar seçili menu.
         */
        session()->forget('selectedSideMenu');
        session()->put('selectedSideMenu','dev-transaction-controller');
        if($request->has('find_devices')){
            $devices = array();
            /** ►►►►► DEVELOPER ◄◄◄◄◄
             * Ürün, Kurum ve Birim'e bağlı olan cihaz veya cihazlar getirilir ve array içerisine konulur.
             */
            $tempDevices = Device::where('product_id',$request->product_id)->where('corporation_id',$request->corporation_id)->where('department_id',$request->department_id)->get();
            foreach($tempDevices as $item){
                /** ►►►►► DEVELOPER ◄◄◄◄◄
                 * DeviceData, veritabanından bağımsız görüntülenecek veri modeli.
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
            return view('dev-transaction-fetch-devices',[
                'devices' => $devices
            ]);
        }else{
            Session::flash('error',__('general.error'));
            return redirect()->route('dev-transaction-controller.find-devices');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function transactDeviceQR($qrCode){
        /** ►►►►► DEVELOPER ◄◄◄◄◄
         * Sidebar seçili menu.
         */
        session()->forget('selectedSideMenu');
        session()->put('selectedSideMenu','dev-transaction-controller');

        /** ►►►►► DEVELOPER ◄◄◄◄◄
         * Scan sonrası gelen qr_code ve company_id parametreleri ile cihaz veya cihazlar bulunur ve array içerisine konulur.
         * Devamında Teknik Servis Formu sayfasına yönlendirilir.
         */
        $device = Device::where('company_id',Auth::user()->id)->where('qr_code',$qrCode)->get();

        /** ►►►►► DEVELOPER ◄◄◄◄◄
         * Hiç cihaz bulunmaması durumunda hata ile anasayfaya dönülür.
         */
        if(count($device) != 1){
            Session::flash('error',__('general.error'));
            return redirect()->route('index');
        }

        /** ►►►►► DEVELOPER ◄◄◄◄◄
         * DeviceData, veritabanından bağımsız görüntülenecek veri modeli.
         */
        $deviceData = new DeviceData();
        $deviceData->id = $device[0]->id;
        $deviceData->product_name = Product::findOrFail($device[0]->product_id)->name;
        $deviceData->company_id = $device[0]->company_id;
        $deviceData->corporation_name = Corporation::findOrFail($device[0]->corporation_id)->name;
        $deviceData->name = $device[0]->name;
        $deviceData->brand = $device[0]->brand;
        $deviceData->model = $device[0]->model;
        $deviceData->serial_no = $device[0]->serial_no;
        $deviceData->department_name = CorporationDepartment::findOrFail($device[0]->department_id)->name;
        $deviceData->department_contact = CorporationDepartment::findOrFail($device[0]->department_id)->contact;
        $deviceData->spendable_count = $device[0]->spendable_count;
        $deviceData->qr_code = $device[0]->qr_code;
        $deviceData->qr_code_path = $device[0]->qr_code_path;
        return view('dev-transaction-transact',[
            'device' => $deviceData,
            'department' => CorporationDepartment::findOrFail($device[0]->department_id),
            'users' => User::where('company_id',Auth::user()->company_id)->orderBy('name','asc')->get()
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function transactDevice($id){
        /** ►►►►► DEVELOPER ◄◄◄◄◄
         * Sidebar seçili menu.
         */
        session()->forget('selectedSideMenu');
        session()->put('selectedSideMenu','dev-transaction-controller');

        /** ►►►►► DEVELOPER ◄◄◄◄◄
         * Cihaz listesinden kullanıcının işlem yapmak için seçtiği cihazın 'id'si ile birlikte cihaz bulunut ve teknik servis formuna yönlendirilir.
         */
        $device = Device::findOrFail($id);

        /** ►►►►► DEVELOPER ◄◄◄◄◄
         * DeviceData, veritabanından bağımsız görüntülenecek veri modeli.
         */
        $deviceData = new DeviceData();
        $deviceData->id = $device->id;
        $deviceData->product_name = Product::findOrFail($device->product_id)->name;
        $deviceData->company_id = $device->company_id;
        $deviceData->corporation_name = Corporation::findOrFail($device->corporation_id)->name;
        $deviceData->name = $device->name;
        $deviceData->brand = $device->brand;
        $deviceData->model = $device->model;
        $deviceData->serial_no = $device->serial_no;
        $deviceData->department_name = CorporationDepartment::findOrFail($device->department_id)->name;
        $deviceData->department_contact = CorporationDepartment::findOrFail($device->department_id)->contact;
        $deviceData->spendable_count = $device->spendable_count;
        $deviceData->qr_code = $device->qr_code;
        $deviceData->qr_code_path = $device->qr_code_path;
        return view('dev-transaction-transact',[
            'device' => $deviceData,
            'department' => CorporationDepartment::findOrFail($device->department_id),
            'users' => User::where('company_id',Auth::user()->company_id)->orderBy('name','asc')->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function transactDeviceSave(Request $request){
        if($request->has('create_transact')){
            $device = Device::findOrFail($request->device_id);
            $newTransaction = new DeviceTransaction();
            $newTransaction->company_id = Auth::user()->company_id;
            $newTransaction->corporation_id = $device->corporation_id;
            $newTransaction->corporation_name = $request->corporation_name;
            $newTransaction->department_id = $device->department_id;
            $newTransaction->department_name = $request->department_name;
            $newTransaction->product_id = $device->product_id;
            $newTransaction->product_name = Product::findOrFail($device->product_id)->name;
            $newTransaction->device_id = $device->id;
            $newTransaction->device_name = $request->device_name;
            $newTransaction->device_brand = $request->device_brand;
            $newTransaction->device_model = $request->device_model;
            $newTransaction->device_serial_no = $device->serial_no;
            $newTransaction->personel_id = $request->personel_id;
            $newTransaction->personel_name = User::findOrFail($request->personel_id)->name;
            $newTransaction->description = $request->description;
            $newTransaction->verifier_name = $request->verifier_name;
            $newTransaction->verifier_tel = $request->verifier_tel;
            $newTransaction->transactions = $request->transactions;
            $newTransaction->record_no_to = $request->record_no_to;
            $newTransaction->record_no_from = $request->record_no_from;
            $newTransaction->calibration_tag_date = $request->calibration_tag_date;
            $newTransaction->service_in_date = $request->service_in_date;
            $newTransaction->service_out_date = $request->service_out_date;
            $newTransaction->note = $request->note;



            //ONAY KODU EKLENECEK TELEFONDAN VEYA MAILDEN ONAY İÇİN


            if($newTransaction->save()){
                Session::flash('success',__('general.success'));
                return redirect()->route('dev-transaction-controller.index');
            }
        }else{
            Session::flash('error',__('general.error'));
            return redirect()->route('dev-transaction-controller.find-devices');
        }
    }

    /**
     * Download assets
     *
     * @param  int  $id
     * @param  int  $select, 'img' or 'pdf'
     * @return \Illuminate\Http\Response
     */
    public function downloadForm($id,String $select)
    {
        /** ►►►►► DEVELOPER ◄◄◄◄◄
         * Teknik Servis Formundan form indirme.
         */
        if($select == 'single'){
            $data = array();
            array_push($data, DeviceTransaction::findOrFail($id));

            if(count($data) == 0){
                Session::flash('no_data',__('general.error'));
                return redirect()->route('dev-transaction-controller.index');
            }
            view()->share('data',$data);
            $pdf = \PDF::loadView('template/single-transaction-pdf', $data);
            return $pdf->download('Teknik Servis Formu.pdf');

        /** ►►►►► DEVELOPER ◄◄◄◄◄
         * Cihazlar sayfasından cihaza ait formları indirme.
         */
        }elseif($select == 'device'){
            $device = Device::findOrFail($id);
            $transactions = DeviceTransaction::where('device_id',$id)->get();
            if(count($transactions) <= 0){
                Session::flash('no_transaction_error',__('general.no_transaction_error'));
                return redirect()->route('device-controller.index');
            }

            $data = array();
            foreach($transactions as $item){
                array_push($data,$item);
            }
            if(count($data) == 0){
                Session::flash('no_data',__('general.error'));
                return redirect()->route('dev-transaction-controller.index');
            }
            view()->share('data',$data);
            $pdf = \PDF::loadView('template/multiple-transaction-pdf', $data);
            return $pdf->download($device->name.' Teknik Servis Formları.pdf');

        /** ►►►►► DEVELOPER ◄◄◄◄◄
         * Ürünler sayfasından ürüne ait cihazların formlarını indirme.
         */
        }elseif($select == 'product'){
            $product = Product::findOrFail($id);
            $transactions = DeviceTransaction::where('product_id',$id)->get();
            if(count($transactions) <= 0){
                Session::flash('no_transaction_error',__('general.no_transaction_error'));
                return redirect()->route('product-controller.index');
            }

            $data = array();
            foreach($transactions as $item){
                array_push($data,$item);
            }
            if(count($data) == 0){
                Session::flash('no_data',__('general.error'));
                return redirect()->route('dev-transaction-controller.index');
            }
            view()->share('data',$data);
            $pdf = \PDF::loadView('template/multiple-transaction-pdf', $data);
            return $pdf->download($product->name.' Teknik Servis Formları.pdf');
        }else{
            Session::flash('error',__('general.error'));
            return redirect()->route('dev-transaction-controller.index');
        }

    }

    /**
     * verify transaction
     * @param  int  $id, transaciton id
     */
    public function verifyTransaction($id){
        /** ►►►►► DEVELOPER ◄◄◄◄◄
         * Authorization kontrolü.
         */
        if(Gate::allows('client') || Gate::allows('subclient')){
            $transaction = DeviceTransaction::findOrFail($id);
            $controller = Auth::user();
            $transaction->controller_id = $controller->id;
            $transaction->controller_name = $controller->name;
            $transaction->control_date = Carbon::now()->toDateTimeString();
            if($transaction->save()){
                Session::flash('success',__('general.success'));
                return redirect()->route('dev-transaction-controller.show',$id);
            }else{
                Session::flash('error',__('general.error'));
                return redirect()->route('dev-transaction-controller.show',$id);
            }
        }else{
            Session::flash('auth_error',__('general.auth_error'));
            return redirect()->route('dev-transaction-controller.show',$id);
        }
    }
}

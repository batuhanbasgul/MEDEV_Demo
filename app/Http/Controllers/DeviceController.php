<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Models\Device;
use App\Models\DeviceData;
use App\Models\Product;
use App\Models\Corporation;
use App\Models\CorporationDepartment;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Gate;

class DeviceController extends Controller
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
        session()->put('selectedSideMenu','device-controller');

        /** ►►►►► DEVELOPER ◄◄◄◄◄
         * DeviceData, veritabanından bağımsız görüntülenecek veri modeli.
         */
        $devices = array();
        foreach(Device::where('company_id',Auth::user()->company_id)->orderBy('created_at','desc')->get() as $item){
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
            $deviceData->note = $item->note;
            $deviceData->bill_no = $item->bill_no;
            $deviceData->ern_code = $item->ern_code;
            $deviceData->accessory = $item->accessory;
            array_push($devices,$deviceData);
        }
        return view('device-index',[
            'devices' => $devices
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
        session()->put('selectedSideMenu','device-controller');
        /** ►►►►► DEVELOPER ◄◄◄◄◄
         * 'isNew' ekle/sil'den geldiğinde GET üzerinde ekstra 'count' parametresi olur. 'isNew'=true, ekle/sil'den geldiğini belirtmek için.
         */
        if(count($_GET) == 1){
            $product = Product::findOrFail($_GET['product_id']);
            $deviceControl = Device::where('product_id',$_GET['product_id'])->count();
            if($deviceControl == $product->device_count){
                return redirect()->route('device-controller.index');
            }else{
                $product = Product::findOrFail($_GET['product_id']);
                $corpDepartments = CorporationDepartment::where('corporation_id',$product->corporation_id)->orderBy('name','asc')->get();
                return view('device-create',[
                    'corpDepartments' => $corpDepartments,
                    'product' => $product,
                    'isNew' => false
                ]);
            }
        }else{
            $product = Product::findOrFail($_GET['product_id']);
            $product->device_count = $_GET['count'];
            $corpDepartments = CorporationDepartment::where('corporation_id',$product->corporation_id)->orderBy('name','asc')->get();
            return view('device-create',[
                'corpDepartments' => $corpDepartments,
                'product' => $product,
                'isNew' => true
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->has('create_device')){
            /** ►►►►► DEVELOPER ◄◄◄◄◄
             * Authorization kontrolü.
             */
            if(Gate::allows('client') || Gate::allows('subclient')){
                $product=Product::findOrFail($request->product_id);
                $corporation = Corporation::findOrFail($product->corporation_id);
                /** ►►►►► DEVELOPER ◄◄◄◄◄
                 * ekle/sil veya normal oluşturma üzerinden gelmesinden bağımsız create, çoklu request gönderir.
                 * 'device_count' normal oluşturmada product->device_count, ekle/sil üzerinden ise girilen değer kadar view üzerinde hidden input atanır.
                 */
                for($i=1;$i<=$request->device_count;$i++){
                    $device=new Device();
                    $device->product_id = $product->id;
                    $device->company_id = Auth::user()->company_id;
                    $device->corporation_id = $product->corporation_id;
                    $nameRequest = "name".$i;
                    $device->name = $request->$nameRequest;
                    $brandRequest = "brand".$i;
                    $device->brand = $request->$brandRequest;
                    $modelRequest = "model".$i;
                    $device->model = $request->$modelRequest;
                    $serialNoRequest = "serial_no".$i;
                    $device->serial_no = $request->$serialNoRequest;
                    $corporationDepartmentRequest = "department_id".$i;
                    $device->department_id = $request->$corporationDepartmentRequest;
                    $spendableCountRequest = "spendable_count".$i;
                    $device->spendable_count = $request->$spendableCountRequest;
                    $spendableDescriptiontRequest = "spendable_description".$i;
                    $device->spendable_description = $request->$spendableDescriptiontRequest;
                    $noteRequest = "note".$i;
                    $device->note = $request->$noteRequest;
                    $billNoRequest = "bill_no".$i;
                    $device->bill_no = $request->$billNoRequest;
                    $ernRequest = "ern_code".$i;
                    $device->ern_code = $request->$ernRequest;
                    $accessoryRequest = "accessory".$i;
                    $device->accessory = $request->$accessoryRequest;

                    /** ►►►►► DEVELOPER ◄◄◄◄◄
                     * qr_code veritabanında 'company_id' ile bağlı olan qr_code sayısına 1 eklenerek bulunur ve 9 haneye başına sıfırlar eklenerek tamamlanır.
                     */
                    $code = Device::where('company_id',Auth::user()->company_id)->count()+1;
                    $qr_code = "";
                    for($j=0;$j<9-strlen($code);$j++){
                        $qr_code = $qr_code.'0';
                    }
                    $qr_code = $qr_code.$code;
                    /** ►►►►► DEVELOPER ◄◄◄◄◄
                     * QR code oluşturulur ve kod.png ismi ile uploads/qr_codes klasörüne kaydedilir.
                     */
                    QrCode::size(250)->format('png')->generate($qr_code,'uploads/qr_codes/qr'.$qr_code.'.png');
                    $device->qr_code = $qr_code;
                    $device->qr_code_path = 'uploads/qr_codes/qr'.$qr_code.'.png';
                    $device->save();

                    /** ►►►►► DEVELOPER ◄◄◄◄◄
                     * Oluşturmada çoklu request üzerinden gidildiği için ürün ve kurum harcanabilir sayısı üzerine eklenerek arttırılır.
                     */
                    $product->spendable_count += $device->spendable_count;
                    $product->save();
                    $corporation->spendable_count += $device->spendable_count;
                    $corporation->save();
                }
                if($request->is_new){
                    /** ►►►►► DEVELOPER ◄◄◄◄◄
                     * ekle/sil'den geldiyse kurum ve ürünün harcanabilir sayısı arttırılmasının yanında cihaz sayısı da arttırılır.
                     */
                    $product->device_count += $request->device_count;
                    $product->save();
                    $corporation = Corporation::findOrFail($product->corporation_id);
                    $corporation->device_count += $request->device_count;
                    $corporation->save();
                }
                Session::flash('success',__('general.success'));
                return redirect()->route('device-controller.index');
            }else{
                Session::flash('auth_error',__('general.auth_error'));
                return redirect()->route('product-controller.index');
            }
        }else{
            Session::flash('error',__('general.error'));
            return redirect()->route('product-controller.index');
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
        session()->put('selectedSideMenu','device-controller');
        $device = Device::findOrFail($id);
        $product = Product::findOrFail($device->product_id);
        $corpDepartments = CorporationDepartment::where('corporation_id',$product->corporation_id)->orderBy('name','asc')->get();
        $department = CorporationDepartment::findOrFail($device->department_id);
        return view('device-edit',[
            'device' => $device,
            'corpDepartments' => $corpDepartments,
            'product' => $product,
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
        $product = Product::findOrFail($request->product_id);
        $corporation = Corporation::findOrFail($product->corporation_id);
        if($request->has('edit_device')){
            /** ►►►►► DEVELOPER ◄◄◄◄◄
             * Authorization kontrolü.
             */
            if(Gate::allows('client') || Gate::allows('subclient')){
                $device=Device::findOrFail($id);

                /** ►►►►► DEVELOPER ◄◄◄◄◄
                 * Harcanabilir farkı (spendableDiff) ürün ve kurum harcanabilir sayısına eklenir. '-' veya '+' olabilir.
                 */
                $spendableDiff = $request->spendable_count - $device->spendable_count;

                $device->department_id = $request->department_id;
                $device->name = $request->name;
                $device->brand = $request->brand;
                $device->model = $request->model;
                $device->serial_no = $request->serial_no;
                $device->spendable_count = $request->spendable_count;
                $device->spendable_description = $request->spendable_description;
                $device->note = $request->note;
                $device->bill_no = $request->bill_no;
                $device->ern_code = $request->ern_code;
                $device->accessory = $request->accessory;

                if($device->save()){
                    /** ►►►►► DEVELOPER ◄◄◄◄◄
                     * Harcanabilir farkı (spendableDiff) ürün ve kurum harcanabilir sayısına eklenir. '-' veya '+' olabilir.
                     */
                    $product->spendable_count += $spendableDiff;
                    $product->save();
                    $corporation->spendable_count += $spendableDiff;
                    $corporation->save();
                    Session::flash('success',__('general.success'));
                    return redirect()->route('device-controller.edit',$id);
                }else{
                    Session::flash('error',__('general.error'));
                    return redirect()->route('device-controller.edit',$id);
                }
            }else{
                Session::flash('auth_error',__('general.auth_error'));
                return redirect()->route('product-controller.index');
            }
        }else{
            Session::flash('error',__('general.error'));
            return redirect()->route('product-controller.index');
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function addDrop($id)
    {
        /** ►►►►► DEVELOPER ◄◄◄◄◄
         * Sidebar seçili menu.
         */
        session()->forget('selectedSideMenu');
        session()->put('selectedSideMenu','device-controller');
        $devices = Device::where('product_id',$id)->get();
        return view('device-add-drop',[
            'product_id' => $id,
            'devices' => $devices
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function addDropSave(Request $request)
    {
        /** ►►►►► DEVELOPER ◄◄◄◄◄
         * Authorization kontrolü.
         */
        if(Gate::allows('client') || Gate::allows('subclient')){
            if($request->has('add_device')){
                /** ►►►►► DEVELOPER ◄◄◄◄◄
                 * Ürün id ek olarak 'count' parametresi eklenecek cihaz sayısını belirtir.
                 */
                return redirect()->route('device-controller.create',['product_id' => $request->product_id, 'count' => $request->count]);
            }else if($request->has('drop_device')){
                $devices = Device::where('product_id',$request->product_id)->get();
                $product = Product::findOrFail($request->product_id);
                foreach($devices as $item){
                    /** ►►►►► DEVELOPER ◄◄◄◄◄
                     * $request içerisinde seçili cihaz id'leri bulunur. Eğer mevcutsa o vihaz silinir.
                     */
                    if($request->has('device'.$item->id)){
                        /** ►►►►► DEVELOPER ◄◄◄◄◄
                         * Ürün harcanabilir ve cihaz sayısı azaltılır.
                         */
                        $product->device_count -= 1;
                        $product->spendable_count -= $item->spendable_count;
                        if($item->delete()){
                            $product->save();
                            /** ►►►►► DEVELOPER ◄◄◄◄◄
                             * Devamında kurum harcanabilir ve cihaz sayısı azaltılır.
                             */
                            $corporation = Corporation::findOrFail($product->corporation_id);
                            $corporation->device_count -= 1;
                            $corporation->spendable_count -= $item->spendable_count;
                            $corporation->save();
                        }
                    }
                }
                Session::flash('success',__('general.success'));
                return redirect()->route('product-controller.edit',$request->product_id);
            }else{
                Session::flash('error',__('general.error'));
                return redirect()->route('product-controller.index');
            }
        }else{
            Session::flash('auth_error',__('general.auth_error'));
            return redirect()->route('product-controller.index');
        }
    }

}

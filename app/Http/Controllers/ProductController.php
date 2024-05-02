<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductData;
use App\Models\Corporation;
use App\Models\CorporationDepartment;
use App\Models\Device;
use App\Models\DeviceData;
use ZipArchive;
use Illuminate\Support\Facades\Gate;

class ProductController extends Controller
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
        session()->put('selectedSideMenu','product-controller');

        $products = array();
        foreach(Product::where('company_id',Auth::user()->company_id)->orderBy('created_at','desc')->get() as $item){
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
        return view('product-index',[
            'products' => $products
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
        session()->put('selectedSideMenu','product-controller');
        return view('product-create',[
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
        if($request->has('create_product')){
            /** ►►►►► DEVELOPER ◄◄◄◄◄
             * 'client' veya 'subclient' yetkisi olmayan kullanıcı ürün oluşturamaz.
             */
            if(Gate::allows('client') || Gate::allows('subclient')){
                $product = new Product();
                $product->corporation_id = $request->corporation_id;
                $product->company_id = Auth::user()->company_id;
                $product->name = $request->name;
                $product->device_count = $request->device_count;
                $product->start_date = implode('-', [$request->start_date_year,$request->start_date_month,$request->start_date_day]);
                $product->end_date = implode('-', [$request->end_date_year,$request->end_date_month,$request->end_date_day]);

                if($product->save()){
                    /** ►►►►► DEVELOPER ◄◄◄◄◄
                     * kurum ürün sayısı 1 arttırılır ve cihaz sayısı da ürünün cihaz sayısı kadar arttırılır.
                     */
                    $corporation = Corporation::findOrFail($request->corporation_id);
                    $corporation->product_count += 1;
                    $corporation->device_count += $product->device_count;
                    $corporation->save();
                    Session::flash('success',__('general.success'));
                    return redirect()->route('device-controller.create',['product_id'=>$product->id]);
                }else{
                    Session::flash('error',__('general.error'));
                    return redirect()->route('product-controller.index');
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
        session()->put('selectedSideMenu','product-controller');

        $product = Product::findOrFail($id);

        /** ►►►►► DEVELOPER ◄◄◄◄◄
         * Eğer ürünün cihaz sayısı(product_count) ile veritabanındaki ürüne bağlı cihaz sayısı farklı ise cihaz oluşturma ekranına yönlendirir
         */
        $deviceControl = Device::where('product_id',$id)->count();
        if($deviceControl != $product->device_count){
            Session::flash('create_device_error',__('general.error'));
            return redirect()->route('device-controller.create',['product_id'=>$id]);
        }
        return view('product-edit',[
            'product' => $product,
            'start_day' => explode('-',$product->start_date)[2],
            'start_month' => explode('-',$product->start_date)[1],
            'start_year' => explode('-',$product->start_date)[0],
            'end_day' => explode('-',$product->end_date)[2],
            'end_month' => explode('-',$product->end_date)[1],
            'end_year' => explode('-',$product->end_date)[0],
            'corporations' => Corporation::where('company_id',Auth::user()->company_id)->orderBy('name','asc')->get()
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
        if($request->has('edit_product')){
            /** ►►►►► DEVELOPER ◄◄◄◄◄
             * 'client' veya 'subclient' yetkisi olmayan kullanıcı ürün oluşturamaz.
             */
            if(Gate::allows('client') || Gate::allows('subclient')){
                $product = Product::findOrFail($id);
                $product->corporation_id = $request->corporation_id;
                $product->company_id = $product->company_id;
                $product->name = $request->name;
                $product->start_date = implode('-', [$request->start_date_year,$request->start_date_month,$request->start_date_day]);
                $product->end_date = implode('-', [$request->end_date_year,$request->end_date_month,$request->end_date_day]);

                if($product->save()){
                    /** ►►►►► DEVELOPER ◄◄◄◄◄
                     * Kurumun cihaz ve harcanabilir sayısı ürün güncellendiğinde baştan sayılıp yazılır.
                     */
                    $corps_products = Product::where('corporation_id',$request->corporation_id)->get();
                    $deviceSum = 0;
                    $spendableSum = 0;
                    foreach($corps_products as $item){
                        $deviceSum+=$item->device_count;
                        $spendableSum+=$item->spendable_count;
                    }
                    $corporation = Corporation::findOrFail($request->corporation_id);
                    $corporation->product_count=count($corps_products);
                    $corporation->device_count=$deviceSum;
                    $corporation->spendable_count=$spendableSum;
                    $corporation->save();

                    Session::flash('success',__('general.success'));
                    return redirect()->route('product-controller.edit',$id);
                }else{
                    Session::flash('error',__('general.error'));
                    return redirect()->route('product-controller.edit',$id);
                }
            }else{
                Session::flash('auth_error',__('general.auth_error'));
                return redirect()->route('product-controller.edit',$id);
            }
        }else{
            Session::flash('error',__('general.error'));
            return redirect()->route('product-controller.edit',$id);
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
     * @param  int  $select, 'img' or 'pdf'
     * @return \Illuminate\Http\Response
     */
    public function downloadQR($id,String $select)
    {
        /** ►►►►► DEVELOPER ◄◄◄◄◄
         * Ürünün dahilindeki cihazların QR reismleri zip içierisine eklenir ve indirilir.
         */
        if($select == 'img'){
            $product = Product::findOrFail($id);
            $devices = Device::where('product_id',$id)->get();
            $zip = new ZipArchive;
            $fileName = $product->name.'-'.$product->id.'.zip';

            if ($zip->open(public_path('/uploads/qr_code_zips/'.$fileName), ZipArchive::CREATE) === TRUE){
                foreach($devices as $item){
                    $imgName = $item->name.'-'.CorporationDepartment::findOrFail($item->department_id)->name.'.png';
                    $zip->addFile($item->qr_code_path, $imgName);
                }
                $zip->close();
            }

            if($zip->lastId < 0){
                Session::flash('no_data',__('general.error'));
                return redirect()->route('product-controller.index');
            }
            return response()->download(public_path('/uploads/qr_code_zips/'.$fileName));
        }else{

            /** ►►►►► DEVELOPER ◄◄◄◄◄
             * Ürünün dahilindeki cihazların bilgileri olan bir liste PDF olarak indirilir.
             */
            $devices = array();
            foreach(Device::where('product_id',$id)->orderBy('created_at','desc')->get() as $item){
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
                return redirect()->route('product-controller.index');
            }
            Session::flash('pdf_title',$devices[0]->product_name.' '.__('product.device_list'));
            $data=array();
            foreach($devices as $item){
                array_push($data,$item);
            }
            if(count($data) == 0){
                Session::flash('no_data',__('general.error'));
                return redirect()->route('product-controller.index');
            }
            view()->share('data',$data);
            $pdf = \PDF::loadView('template/qr-pdf', $data);
            return $pdf->download($devices[0]->product_name.'.pdf');
        }
    }
}

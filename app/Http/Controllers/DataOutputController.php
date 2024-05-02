<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Models\CorporationDepartment;
use App\Models\Corporation;
use App\Models\Device;
use App\Models\DeviceTransaction;
use App\Models\DataOutput;
use App\Models\DataOutputFinal;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use App\Exports\DataExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class DataOutputController extends Controller
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


    /** ►►►►► DEVELOPER ◄◄◄◄◄
     * Şehir listesi. Kurum oluşturmak için.
     */
    public $cities = [
        'istanbul' => 'İstanbul',
        'ankara' => 'Ankara',
        'izmir' => 'İzmir',
        'adana' => 'Adana',
        'adiyaman' => 'Adıyaman',
        'afyon' => 'Afyon',
        'agri' => 'Ağrı',
        'amasya' => 'Amasya',
        'antalya' => 'Antalya',
        'ardahan' => 'Ardahan',
        'artvin' => 'Artvin',
        'aydin' => 'Aydın',
        'balıkesir' => 'Balıkesir',
        'bartin' => 'Bartın',
        'batman' => 'Batman',
        'bayburt' => 'Bayburt',
        'bilecik' => 'Bilecik',
        'bingol' => 'Bingöl',
        'bitlis' => 'Bitlis',
        'bolu' => 'Bolu',
        'burdur' => 'Burdur',
        'bursa' => 'Bursa',
        'canakkale' => 'Çanakkale',
        'cankiri' => 'Çankırı',
        'corum' => 'Çorum',
        'denizli' => 'Denizli',
        'diyarbakir' => 'Diyarbakır',
        'duzce' => 'Düzce',
        'edirne' => 'Edirne',
        'elazig' => 'Elazığ',
        'erzincan' => 'Erzincan',
        'erzurum' => 'Erzurum',
        'eskisehir' => 'Eskişehir',
        'gaziantep' => 'Gaziantep',
        'giresun' => 'Giresun',
        'gumushane' => 'Gümüşhane',
        'hakkari' => 'Hakkari',
        'hatay' => 'Hatay',
        'igdir' => 'Iğdır',
        'isparta' => 'Isparta',
        'mersin' => 'Mersin',
        'kahramanmaras' => 'Kahramanmaraş',
        'karabuk' => 'Karabük',
        'karaman' => 'Karaman',
        'kars' => 'Kars',
        'kastamonu' => 'Kastamonu',
        'kayseri' => 'Kayseri',
        'kilis' => 'Kilis',
        'kirikkale' => 'Kırıkkale',
        'kirklareli' => 'Kırklareli',
        'kirsehir' => 'Kırşehir',
        'kocaeli' => 'Kocaeli',
        'konya' => 'Konya',
        'kutahya' => 'Kütahya',
        'malatya' => 'Malatya',
        'manisa' => 'Manisa',
        'mardin' => 'Mardin',
        'mersin' => 'Mersin',
        'mugla' => 'Muğla',
        'mus' => 'Muş',
        'nevsehir' => 'Nevşehir',
        'nigde' => 'Niğde',
        'ordu' => 'Ordu',
        'osmaniye' => 'Osmaniye',
        'rize' => 'Rize',
        'sakarya' => 'Sakarya',
        'samsun' => 'Samsun',
        'siirt' => 'Siirt',
        'sinop' => 'Sinop',
        'sivas' => 'Sivas',
        'sanliurfa' => 'Şanlıurfa',
        'sirnak' => 'Şırnak',
        'tekirdag' => 'Tekirdağ',
        'tokat' => 'Tokat',
        'trabzon' => 'Trabzon',
        'tunceli' => 'Tunceli',
        'usak' => 'Uşak',
        'van' => 'Van',
        'yalova' => 'Yalova',
        'yozgat' => 'Yozgat',
        'zonguldak' => 'Zonguldak',
    ];

    private function whichMonth(String $month){
        if($month == 'Ocak'){
            return '1';
        }else if($month == 'Şubat'){
            return '2';
        }else if($month == 'Mart'){
            return '3';
        }else if($month == 'Nisan'){
            return '4';
        }else if($month == 'Mayıs'){
            return '5';
        }else if($month == 'Haziran'){
            return '6';
        }else if($month == 'Temmuz'){
            return '7';
        }else if($month == 'Ağustos'){
            return '8';
        }else if($month == 'Eylül'){
            return '9';
        }else if($month == 'Ekim'){
            return '10';
        }else if($month == 'Kasım'){
            return '11';
        }else if($month == 'Aralık'){
            return '12';
        }else{
            return 0;
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        session()->put('selectedSideMenu','data-output-controller');

        $company_id = Auth::user()->company_id;
        return view('data-export-create',[
            'cities' => $this->cities,
            'corporations' => Corporation::where('company_id',$company_id)->orderBy('name','asc')->get(),
            'products' => Product::where('company_id',$company_id)->orderBy('name','asc')->get(),
            'users' => User::where('company_id',$company_id)->orderBy('name','asc')->get()
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
        if($request->has('export_data')){
            /** ►►►►► DEVELOPER ◄◄◄◄◄
             * Authorization kontrolü.
             */
            if(Gate::allows('client') || Gate::allows('subclient')){
                /** ►►►►► DEVELOPER ◄◄◄◄◄
                 * Data Filtrelemesi
                 * Bu adımda bütün veri çekiliyor ve 'DataOutput' modeline göre dizi içerisine ekleniyor
                 */
                $transactions = DeviceTransaction::where('company_id',Auth::user()->company_id)->orderBy('created_at','desc')->get();
                $data = array();
                $i=1;
                foreach($transactions as $transaction){
                    $dataOutput = new DataOutput();
                    $dataOutput->order = $i;
                    $dataOutput->transaction_id = $transaction->id;
                    $dataOutput->record_no_to = $transaction->record_no_to;
                    $dataOutput->record_no_from = $transaction->record_no_from;
                    $dataOutput->service_in_date = $transaction->service_in_date;
                    $dataOutput->service_out_date = $transaction->service_out_date;
                    $dataOutput->transactions = $transaction->transactions;
                    $dataOutput->personel_id = $transaction->personel_id;
                    $dataOutput->personel_name = $transaction->personel_name;
                    $createdDateArr = explode('-',explode(' ',$transaction->created_at)[0]);
                    $dataOutput->transaction_date = $createdDateArr[2].'-'.$createdDateArr[1].'-'.$createdDateArr[0];
                    $dataOutput->department = CorporationDepartment::findOrFail($transaction->department_id)->name;
                    $dataOutput->verifier_name = $transaction->verifier_name;
                    $dataOutput->verifier_tel = $transaction->verifier_tel;
                    $dataOutput->controller_id = $transaction->controller_id;
                    $dataOutput->controller_name = $transaction->controller_name;
                    if($transaction->control_date){
                        $controlDateArr = explode('-',explode(' ',$transaction->control_date)[0]);
                        $dataOutput->control_date = $controlDateArr[2].'-'.$controlDateArr[1].'-'.$controlDateArr[0];
                    }
                    $dataOutput->calibration_tag_date = $transaction->calibration_tag_date;
                    $dataOutput->note = $transaction->note;

                    $device = Device::findOrFail($transaction->device_id);
                    $dataOutput->device_name = $device->name;
                    $dataOutput->device_brand = $device->brand;
                    $dataOutput->device_model = $device->model;
                    $dataOutput->device_serial_no = $device->serial_no;
                    $dataOutput->device_ern_code = $device->ern_code;
                    $dataOutput->accessory = $device->accessory;
                    $dataOutput->bill_no = $device->bill_no;

                    $dataOutput->corporation_id = $transaction->corporation_id;
                    $dataOutput->corporation_name = $transaction->corporation_name;

                    $dataOutput->product_id = $transaction->product_id;
                    $dataOutput->product_name = $transaction->product_name;

                    array_push($data,$dataOutput);
                    $i++;
                }

                /** ►►►►► DEVELOPER ◄◄◄◄◄
                 * Data Filtrelemesi
                 * Bu adımda bütün çekilen veriden filtreye uygun olmayanlar array içerisinden çıkarılıyor.
                 */
                $i=0;
                foreach($data as $item){
                    if($request->city != 0){
                        if(Corporation::findOrFail($item->corporation_id)->city != $request->city){
                            unset($data[$i]);
                            $i++;
                            continue;
                        }
                    }
                    if($request->corporation_id != 0){
                        if($item->corporation_id != $request->corporation_id){
                            unset($data[$i]);
                            $i++;
                            continue;
                        }
                    }
                    if($request->product_id != 0){
                        if($item->product_id != $request->product_id){
                            unset($data[$i]);
                            $i++;
                            continue;
                        }
                    }
                    if($request->personel_id != 0){
                        if($item->personel_id != $request->personel_id){
                            unset($data[$i]);
                            $i++;
                            continue;
                        }
                    }
                    if($request->start_checkbox != 'on' && $request->start_date){
                        $startDate = explode(' ',$request->start_date);
                        if($this->whichMonth($startDate[1]) != 0){
                            $startDate[1] = $this->whichMonth($startDate[1]);
                            $transactionDate = explode('-',$item->transaction_date);

                            if($transactionDate[2] < $startDate[2]){
                                unset($data[$i]);
                                $i++;
                                continue;
                            }elseif($transactionDate[2] == $startDate[2]){
                                if($transactionDate[1] < $startDate[1]){
                                    unset($data[$i]);
                                    $i++;
                                    continue;
                                }elseif($transactionDate[1] == $startDate[1]){
                                    if($transactionDate[0] < $startDate[0]){
                                        unset($data[$i]);
                                        $i++;
                                        continue;
                                    }
                                }
                            }
                        }
                    }
                    if($request->end_checkbox != 'on' && $request->end_date){
                        $endDate = explode(' ',$request->end_date);
                        if($this->whichMonth($endDate[1]) != 0){
                            $endDate[1] = $this->whichMonth($endDate[1]);
                            $transactionDate = explode('-',$item->transaction_date);

                            if($transactionDate[2] > $endDate[2]){
                                unset($data[$i]);
                                $i++;
                                continue;
                            }elseif($transactionDate[2] == $endDate[2]){
                                if($transactionDate[1] > $endDate[1]){
                                    unset($data[$i]);
                                    $i++;
                                    continue;
                                }elseif($transactionDate[1] == $endDate[1]){
                                    if($transactionDate[0] > $endDate[0]){
                                        unset($data[$i]);
                                        $i++;
                                        continue;
                                    }
                                }
                            }
                        }
                    }
                    $i++;
                }

                /** ►►►►► DEVELOPER ◄◄◄◄◄
                 * Export edilecek excel formatına göre modele oturtulması
                 */
                $dataOutputFinal = array();
                foreach($data as $item){
                    $dataItem = new DataOutputFinal();
                    $dataItem->order = $item->order;
                    $dataItem->device_name = $item->device_name;
                    $dataItem->device_brand = $item->device_brand;
                    $dataItem->device_model = $item->device_model;
                    $dataItem->device_serial_no = $item->device_serial_no;
                    $dataItem->device_ern_code = $item->device_ern_code;
                    $dataItem->record_no_to = $item->record_no_to;
                    $dataItem->record_no_from = $item->record_no_from;
                    $dataItem->corporation_name = $item->corporation_name;
                    $dataItem->service_in_date = $item->service_in_date;
                    $dataItem->service_out_date = $item->service_out_date;
                    $dataItem->transactions = $item->transactions;
                    $dataItem->personel_name = $item->personel_name;
                    $dataItem->transaction_date = $item->transaction_date;
                    $dataItem->department = $item->department;
                    $dataItem->verifier_name = $item->verifier_name;
                    $dataItem->verifier_tel = $item->verifier_tel;
                    $dataItem->accessory = $item->accessory;
                    $dataItem->controller_name = $item->controller_name;
                    $dataItem->control_date = $item->control_date;
                    $dataItem->bill_no = $item->bill_no;
                    $dataItem->calibration_tag_date = $item->calibration_tag_date;
                    $dataItem->note = $item->note;
                    array_push($dataOutputFinal,$dataItem);
                }

                /** ►►►►► DEVELOPER ◄◄◄◄◄
                 * filtreye göre veri bulunamamışsa
                 */
                if(count($dataOutputFinal) < 1){
                    Session::flash('no_data',__('general.error'));
                    return redirect()->route('data-output-controller.create');
                }

                /** ►►►►► DEVELOPER ◄◄◄◄◄
                 * Güncel Tarih
                 */
                $date = explode(' ',Carbon::now()->toDateTimeString());
                $currentDate = explode('-',$date[0]);
                /** ►►►►► DEVELOPER ◄◄◄◄◄
                 * Export edilecek veri modelinin excel paket dosyasına gönderilmesi.
                 */
                return Excel::download(new DataExport($dataOutputFinal), $currentDate[2].'-'.$currentDate[1].'-'.$currentDate[0].'.xlsx');
            }else{
                Session::flash('auth_error',__('general.auth_error'));
                return redirect()->route('data-output-controller.create');
            }
        }else{
            Session::flash('error',__('general.error'));
            return redirect()->route('data-output-controller.create');
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
        //
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
        //
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
}

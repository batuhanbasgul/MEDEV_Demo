<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Models\Corporation;
use App\Models\Product;
use Illuminate\Support\Facades\Gate;

class CorporationController extends Controller
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
        session()->put('selectedSideMenu','corporation-controller');

        return view('corporation-index',[
            'corporations' => Corporation::where('company_id',Auth::user()->company_id)->orderBy('created_at','desc')->get(),
            'cities' => $this->cities
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
        session()->put('selectedSideMenu','corporation-controller');

        return view('corporation-create',[
            'cities' => $this->cities
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
        if($request->has('create_corporation')){
            /** ►►►►► DEVELOPER ◄◄◄◄◄
             * Authorization kontrolü.
             */
            if(Gate::allows('client') || Gate::allows('subclient')){
                $corporation = new Corporation();
                $corporation->company_id = Auth::user()->company_id;
                $corporation->name = $request->name;
                $corporation->city = $request->city;
                $corporation->province = $request->province;

                if($corporation->save()){
                    Session::flash('success',__('general.success'));
                    return redirect()->route('corporation-controller.index');
                }else{
                    Session::flash('error',__('general.error'));
                    return redirect()->route('corporation-controller.index');
                }
            }else{
                Session::flash('auth_error',__('general.auth_error'));
                return redirect()->route('corporation-controller.index');
            }
        }else{
            Session::flash('error',__('general.error'));
            return redirect()->route('corporation-controller.index');
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
        session()->put('selectedSideMenu','corporation-controller');

        return view('corporation-edit',[
            'corporation' => Corporation::findOrFail($id),
            'cities' => $this->cities
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
        if($request->has('edit_corporation')){
            /** ►►►►► DEVELOPER ◄◄◄◄◄
             * Authorization kontrolü.
             */
            if(Gate::allows('client') || Gate::allows('subclient')){
                $corporation = Corporation::findOrFail($id);
                $corporation->company_id = Auth::user()->company_id;
                $corporation->name = $request->name;
                $corporation->city = $request->city;
                $corporation->province = $request->province;
                if($corporation->save()){
                    Session::flash('success',__('general.success'));
                    return redirect()->route('corporation-controller.index');
                }else{
                    Session::flash('error',__('general.error'));
                    return redirect()->route('corporation-controller.index');
                }
            }else{
                Session::flash('auth_error',__('general.auth_error'));
                return redirect()->route('corporation-controller.index');
            }
        }else{
            Session::flash('error',__('general.error'));
            return redirect()->route('corporation-controller.index');
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

    public function download($id){
        $products = Product::where('corporation_id',$id)->orderBy('end_date','asc')->get();
        $corporation = Corporation::findOrFail($id);


        Session::flash('pdf_title',$corporation->name.' '.__('corporation.product_list'));
        $data=array();
        foreach($products as $item){
            array_push($data,$item);
        }

        if(count($data) == 0){
            Session::flash('no_data',__('general.error'));
            return redirect()->route('corporation-controller.index');
        }
        view()->share('data',$data);
        $pdf = \PDF::loadView('template/product-pdf', $data);
        return $pdf->download($corporation->name.'.pdf');
    }
}

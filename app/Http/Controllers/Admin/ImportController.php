<?php namespace App\Http\Controllers\Admin;

use App\Color;
use App\DisplayProduct;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductColorRequest;
use App\Http\Requests\Admin\ProductRequest;
use App\Http\Requests\Admin\ProductSizeRequest;
use App\OrderItem;
use App\Product;
use App\ProductBrand;
use App\ProductCategory;
use App\ProductCategorySub;
use App\ProductCategoryType;
use App\ProductColor;
use App\ProductHasRelatedProduct;
use App\ProductModel;
use App\ProductPhoto;
use App\ProductSize;
use App\RsrProduct;
use App\Size;
use App\Store;
use App\StoreCategory;
use App\StoreProduct;
use Auth;
use DateTime;
use Excel;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Session;
use Zipper;

class ImportController extends Controller
{
    public function __construct(Product $product, ProductCategory $category, ProductCategorySub $categorySub, ProductPhoto $photo, ProductBrand $brand, ProductModel $model, ProductColor $productColor, Color $color, ProductCategoryType $productCategoryType, Size $size, ProductSize $productSize, Store $store, StoreProduct $storeProduct, StoreCategory $storeCategory, ProductHasRelatedProduct $productHasRelatedProduct)
    {
        $this->module = "import";
        $this->data = $product;
        $this->category = $category;
        $this->categorySub = $categorySub;
        $this->brand = $brand;
        $this->model = $model;
        $this->photo = $photo;
        $this->productColor = $productColor;
        $this->color = $color;
        $this->productCategoryType = $productCategoryType;
        $this->size = $size;
        $this->productSize = $productSize;
        $this->store = $store;
        $this->storeProduct = $storeProduct;
        $this->storeCategory = $storeCategory;
        $this->productHasRelatedProduct = $productHasRelatedProduct;

        $this->option = Cache::get('optionCache');
        $this->middleware('auth');
    }

    public function get_category()
    {
        $module = $this->module;
        return view('admin.'.$module.'.import_category',compact('module'));
    }

    public function post_category(Request $request)
    {
        $this->validate($request, array(
            'file' => 'required|mimes:xlsx,xls,csv',
        ));

        try {
            $path = $request->file->getRealPath();
            $data = Excel::load($path, function($reader) {})->get();
            // $data = Excel::selectSheets('Data')->load($path, function($reader) {})->get();

            foreach ($data as $key => $value) {
                $insert[] = [
                    'department_id' => $value[0],
                    'department_name' => $value[1],
                    'category_id' => $value[2],
                    'category_name' => $value[3],
                    'created_at' => new DateTime,
                    'updated_at' => new DateTime,
                ];
            }

            $insertData = DB::table('rsr_products_categories')->insert($insert);

            return redirect()->back()->with('success', 'Data has been imported');
        }
        catch (\Exception $exception){
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function get_product()
    {
        $module = $this->module;
        return view('admin.'.$module.'.import_product',compact('module'));
    }

    // ---
    public function post_product(Request $request)
    {
        $this->validate($request, array(
            'file' => 'required|mimes:xlsx,xls,csv',
        ));

        try {
            $path = $request->file->getRealPath();
            $data = Excel::load($path, function($reader) {})->get();
            // $data = Excel::selectSheets('Data')->load($path, function($reader) {})->get();

            // Excel::filter('chunk')->load($path)->chunk(250, function($results) {
            //     foreach ($results as $key => $value) {
            //         $user = RsrProduct::create([
            //             'rsr_stock_number' =>  $value[0],
            //             // other fields
            //         ]);
            //     }
            // });

            foreach ($data as $key => $value) {
                $insert[] = [
                    'rsr_stock_number' => $value[0],
                    'upc_code' => $value[1],
                    'product_description' => $value[2],
                    'department_number' => $value[3],
                    'manufacturer_id' => $value[4],
                    'retail_price' => $value[5],
                    'rsr_pricing' => $value[6],
                    'product_weight' => $value[7],
                    'inventory_quantity' => $value[8],
                    'model' => $value[9],
                    'full_manufacturer_name' => $value[10],
                    'manufacturer_part_number' => $value[11],
                    'allocated_closeout_deleted' => $value[12],
                    'expanded_product_description' => $value[13],
                    'image_name' => $value[14],
                    'Ak' => $value[15],
                    'AL' => $value[16],
                    'AR' => $value[17],
                    'AZ' => $value[18],
                    'CA' => $value[19],
                    'CO' => $value[20],
                    'CT' => $value[21],
                    'DC' => $value[22],
                    'DE' => $value[23],
                    'FL' => $value[24],
                    'GA' => $value[25],
                    'HI' => $value[26],
                    'IA' => $value[27],
                    'ID_Idaho' => $value[28],
                    'IL' => $value[29],
                    'IN' => $value[30],
                    'KS' => $value[31],
                    'KY' => $value[32],
                    'LA' => $value[33],
                    'MA' => $value[34],
                    'MD' => $value[35],
                    'ME' => $value[36],
                    'MI' => $value[37],
                    'MN' => $value[38],
                    'MO' => $value[39],
                    'MS' => $value[40],
                    'MT' => $value[41],
                    'NC' => $value[42],
                    'ND' => $value[43],
                    'NE' => $value[44],
                    'NH' => $value[45],
                    'NJ' => $value[46],
                    'NM' => $value[47],
                    'NV' => $value[48],
                    'NY' => $value[49],
                    'OH' => $value[50],
                    'OK' => $value[51],
                    'OR' => $value[52],
                    'PH' => $value[53],
                    'RI' => $value[54],
                    'SC' => $value[55],
                    'SD' => $value[56],
                    'TN' => $value[57],
                    'TX' => $value[58],
                    'UT' => $value[59],
                    'VA' => $value[60],
                    'WA' => $value[61],
                    'WI' => $value[62],
                    'WV' => $value[63],
                    'WY' => $value[64],
                    'ground_shipments_only' => $value[65],
                    'adult_signature_required' => $value[66],
                    'blocked_from_dropship' => $value[67],
                    'date_entered' => $value[68],
                    'retail_map' => $value[69],
                    'image_disclaimer' => $value[70],
                    'shipping_length' => $value[71],
                    'shipping_width' => $value[72],
                    'shipping_height' => $value[73],
                    'prop_65' => $value[74],
                    'vendor_approval_required' => $value[75],

                    'created_at' => new DateTime,
                    'updated_at' => new DateTime,
                ];
            }

            $insertData = DB::table('rsr_products')->insert($insert);

            return redirect()->back()->with('success', 'Data has been imported');
        }
        catch (\Exception $exception){
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function get_import()
    {
        $module = $this->module;
        $singleData = $this->data;
        $brand = $this->brand->where('status', 1)->pluck('name', 'id');
        $categories = $this->category->where('status', 1)->pluck('name', 'id');
        $categorySubs = $this->categorySub->where('status', 1)->pluck('name', 'id');
        return view('admin.'.$module.'.xlsx_import',compact('module','brand','categories','categorySubs','singleData'));
    }

    public function post_import(Request $request)
    {
        $this->validate($request, array(
            'brand_id' => 'required',
            'file' => 'required',
            'category_id' => 'required',
            'category_main_id' => 'required',
        ));

        $partNumber = $this->data->pluck('part_number')->toArray();

        if($request->hasFile('file')){
            $extension = strtolower(File::extension($request->file->getClientOriginalName()));

            if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {

                $path = $request->file->getRealPath();
                // $data = Excel::load($path, function($reader) {})->get();
                $data = Excel::selectSheets('Data')->load($path, function($reader) {})->get();

                if(!empty($data) && $data->count()){

                    foreach ($data as $key => $value) {

                        if (in_array($value->part_number, $partNumber))
                        continue;
                      
                        $insert[] = [
                        'part_number' => $value->part_number,
                        'brand_aaiaid' => $value->brand_aaiaid,
                        'brand_label' => $value->brand_label,
                        'part_terminology_id' => $value->part_terminology_id,
                        'part_term_label' => $value->part_term_label,
                        'primary_image_file_name' => $value->primary_image_file_name,
                        'product_description_extended' => $value->product_description_extended,
                        'marketing_description' => $value->marketing_description,
                        'price_type_jobber' => $value->price_type_jobber,
                        'price_type_retail' => $value->price_type_retail,
                        'price_type_retail_map' => $value->price_type_retail_map,
                        'package_bar_code_characters' => $value->package_bar_code_characters,

                        'slug' => str_slug($value->part_term_label." ".$value->part_number),
                        'name' => $value->part_term_label,
                        'description' => $value->product_description_extended,
                        'main_image' => $value->primary_image_file_name,
                        'special_price' => $value->price_type_retail,
                        'quantity' => "2",
                        'sku' => $value->part_number,
                        'upc' => $value->package_bar_code_characters,
                        'category_id' => $request->category_id,
                        'brand_id' =>$request->brand_id,
                        'user_id' => Auth::user()->id,
                        'status' => true,
                        'created_at' => new DateTime,
                        'updated_at' => new DateTime,
                        ];
                    }


                    if(!empty($insert)){
                        $insertData = DB::table('products')->insert($insert);
                        if ($insertData) {
                            Session::flash('success', 'Your Data has successfully imported');
                        }else {                        
                            Session::flash('error', 'Error inserting the data..');
                            return back();
                        }
                    }
                }

                return back();

            }else {
                Session::flash('error', 'File is a '.$extension.' file.!! Please upload a valid xlsx file..!!');
                return back();
            }
        }
    }

    public function zip_post_import(Request $request)
    {
        $module = $this->module;
        $this->validate($request, array(
            'zip_file' => 'required',
        ));

        $filename = null;
        if($request->zip_file) {
            $file = $request->zip_file;
            $filename = pathinfo($file->getClientOriginalName(),PATHINFO_FILENAME).'_'.\Carbon\Carbon::now()->format('Y_m_d').'_'.time().'.'.$file->getClientOriginalExtension();
            $filepath = $module.'s/images/'.$filename;
            Storage::put($filepath, file_get_contents($file), 'public');
        }

        $zipPath = storage_path('app/public/'.$module.'s/images/'.$filename);
        Zipper::make($zipPath)->extractTo(storage_path('app/public/products/images'));
      
        return redirect()->back()->with('success', 'The zip file('.$filename.') has been uploaded successfully.');
    }
    
    public function unzip()
    {
        $zipPath = storage_path('app/footer5.zip');
        Zipper::make($zipPath)->extractTo(storage_path('app/foo'));
    }

    // 
    public function get_split()
    {
        $module = $this->module;
        return view('admin.'.$module.'.import_split',compact('module'));
    }
    
    public function post_split(Request $request)
    {
        if($request->hasfile('file')){
            ini_set('auto_detect_line_endings', TRUE);
                $main_input = $request->file('file');
                $main_output = 'output';
                $filesize = 10000;
                $input = fopen($main_input,'r');
                $rowcount = 0;
                $filecount = 1;
                $output = '';

                // echo "here1";
                while(!feof($input)){
                    if ($rowCount == 0) {
                        $output = fopen('php://output', storage_path(). "/tmp/".$main_output.$filecount++ . '.csv','w');
                    }
                    if(($rowcount % $filesize) == 0){
                        if($rowcount>0) { 
                            fclose($output);
                            $rowCount = 0;
                            continue;
                        }

                    }
                    $data = fgetcsv($input);
                    print_r($data);

                    if($data) {

                        fputcsv($output, $data);
                    }

                    $rowcount++;
                }
                fclose($output);
        }
    }
}
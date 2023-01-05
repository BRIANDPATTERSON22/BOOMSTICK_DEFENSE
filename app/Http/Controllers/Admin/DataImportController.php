<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Product;
use App\Store;
use App\StoreCategory;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use Exception;

class DataImportController extends Controller
{
	function __construct(Product $product, Store $store)
	{
		$this->product = $product;
		$this->store = $store;
		$this->module = 'data-import';
	}

	public function get_import()
	{
	    $module = $this->module;
	    // $singleData = $this->data;
	    // $brand = $this->brand->where('status', 1)->pluck('name', 'id');
	    // $categories = $this->category->where('status', 1)->pluck('name', 'id');
	    // $categorySubs = $this->categorySub->where('status', 1)->pluck('name', 'id');
	    // return view('admin.'.$module.'.index',compact('module','brand','categories','categorySubs','singleData'));
	    return view('admin.'.$module.'.import',compact('module'));
	}

	public function post_import(Request $request)
	{
		try {
			    $this->validate($request, array(
			        'file' => 'required|mimes:xls,xlsx,csv'
			    ));
			    $path = $request->file->getRealPath();

			    // Excel::selectSheets('Store')->load($path, function($reader) {})->get();
			    Excel::filter('chunk')->selectSheets('Store')->load($path)->chunk(250, function($results)
			    {
			            // foreach($results as $row)
			            // {
			            //     // do stuff
			            // }

                        foreach ($results as $key => $value) {

                            // if (in_array($value->part_number, $partNumber))
                            // continue;
                            
                            Store::insert([
        						'slug' => str_slug($value->division.'-'.$value->banner.'-'.$value->store_id),
        						'division' => $value->division,
        						'banner' => $value->banner,
        						'legacy' => $value->legacy,
        						'store_id' => $value->store_id,
        						'store_category_id' => StoreCategory::where('title', $value->division)->first()->id,
        						'address_1' => $value->store_address,
        						// 'address_2' => $value->store_address,
        						'city' => $value->city,
        						'state' => $value->state,
        						'zip' => $value->zip,
        						'phone_no' => $value->store_phone,
        						// 'mobile_no' => $value->mobile_no,
        						// 'description' => $value->description,
        						// 'image' => $value->image,
        						// 'phone_no' => $value->store_phone,
        						'user_id' => Auth::user()->id,
        						'status' => true,
        						'created_at' => new DateTime,
        						'updated_at' => new DateTime,
                            ]);

                            // DB::table('stores')->insert($insert);

                        }


                        // if(!empty($insert)){

                        // 	// $insertData = Store::updateOrCreate(
                        // 	//     ['store_id' => $value->store_id],
                        // 	//     $insert
                        // 	// );


                        //     $insertData = DB::table('stores')->insert($insert);
                        //     if ($insertData) {
                        //         Session::flash('success', 'Your Data has successfully imported');
                        //     }else {                        
                        //         Session::flash('error', 'Error inserting the data..');
                        //         return back();
                        //     }
                        // }
			    });
			    

			    // $partNumber = $this->store->pluck('part_number')->toArray();

			    // if($request->hasFile('file')){
			    //     $extension = strtolower(File::extension($request->file->getClientOriginalName()));

			    //     if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {

			    //         $path = $request->file->getRealPath();
			    //         // $data = Excel::load($path, function($reader) {})->get();
			    //         $data = Excel::selectSheets('Store')->load($path, function($reader) {})->get();

			    //         // dd($data);

			    //         if(!empty($data) && $data->count()){

			    //             foreach ($data as $key => $value) {

			    //                 // if (in_array($value->part_number, $partNumber))
			    //                 // continue;
			                  
			    //                 $insert[] = [
							// 		'slug' => str_slug($value->store_id),
							// 		'division' => $value->division,
							// 		'banner' => $value->banner,
							// 		'legacy' => $value->legacy,
							// 		'store_id' => $value->store_id,
							// 		'address_1' => $value->store_address,
							// 		// 'address_2' => $value->store_address,
							// 		'city' => $value->city,
							// 		'state' => $value->state,
							// 		'zip' => $value->zip,
							// 		'phone_no' => $value->store_phone,
							// 		// 'mobile_no' => $value->mobile_no,
							// 		// 'description' => $value->description,
							// 		// 'image' => $value->image,
							// 		// 'phone_no' => $value->store_phone,
							// 		'user_id' => Auth::user()->id,
							// 		'status' => true,
							// 		'created_at' => new DateTime,
							// 		'updated_at' => new DateTime,
			    //                 ];
			    //             }


			    //             if(!empty($insert)){

			    //             	$insertData = Store::updateOrCreate(
			    //             	    ['store_id' => $value->store_id],
			    //             	    $insert
			    //             	);


			    //                 // $insertData = DB::table('stores')->insert($insert);
			    //                 if ($insertData) {
			    //                     Session::flash('success', 'Your Data has successfully imported');
			    //                 }else {                        
			    //                     Session::flash('error', 'Error inserting the data..');
			    //                     return back();
			    //                 }
			    //             }
			    //         }

			    //         return back();

			    //     }else {
			    //         Session::flash('error', 'File is a '.$extension.' file.!! Please upload a valid xlsx file..!!');
			    //         return back();
			    //     }
			    // }
		} catch (Exception $e) {
			// print_r($exception->getMessage());
			return redirect()->back()->with('error', $e->getMessage());
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
}

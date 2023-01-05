<?php namespace App\Http\Controllers\Admin;

use App\BrandSalesPerson;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SalesPersonRequest;
use App\ProductBrand;
use App\SalesPerson;
use App\SalesPersonHasStore;
use App\StoreCategory;
use App\User;
use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class SalesPersonController extends Controller {

    public function __construct(SalesPerson $salesPerson, ProductBrand $productBrand, BrandSalesPerson $brandSalesPerson, StoreCategory $storeCategory, SalesPersonHasStore $salesPersonHasStore, User $user)
    {
        $this->module = "product";
        $this->data = $salesPerson;
        $this->productBrand = $productBrand;
        $this->brandSalesPerson = $brandSalesPerson;
        $this->storeCategory = $storeCategory;
        $this->salesPersonHasStore = $salesPersonHasStore;
        $this->user = $user;
        $this->middleware('auth');
    }

    public function index($id = null)
    {
        $module = $this->module;
        $allData = $this->data->orderBy('id', 'DESC')->get();
        // $brandsData = $this->productBrand->where('status', 1)->pluck('name', 'id');
        $brandsData = $this->productBrand->where('status', 1)->get();
        $storeCategoriesData = $this->storeCategory->where('status', 1)->select('id', 'title')->with('storesData')->get();

        if($id) {
            $singleData = $this->data->find($id);

            $oldBrands = $this->brandSalesPerson->where('sales_person_id', $id)->pluck('brand_id')->toArray();
            $singleData->brands = $oldBrands;

            $oldStores = $this->salesPersonHasStore->where('sales_person_id', $id)->pluck('store_id')->toArray();
            $singleData->stores = $oldStores;
        }else {
            $singleData = $this->data;
        }

        return view('admin.'.$module.'.sales_person', compact('allData', 'singleData', 'module', 'brandsData', 'storeCategoriesData'));
    }

    public function post_add(SalesPersonRequest $request)
    {
        $user = $this->user->where('email', $request->email)->first();

        if ($user) {
            return redirect()->back()->with('error', 'User already registered.')->withInput();
        }

        //Create user
        $this->user->role_id = 4;
        $this->user->name = $request->title;
        $this->user->email = strtolower($request->email);
        // $this->user->password = Hash::make($request->password);
        $this->user->password =  bcrypt($request->password);
        $this->user->status = 1;
        $this->user->verified  =  1;
        $this->user->ip  = $request->getClientIp(); // Registered IP Address
        $this->user->save();
        $userId = $this->user->id; //Get last save id

        //Assign role
        DB::table('model_has_roles')->insert(['role_id' => '4','model_id' =>  $userId, 'model_type'=>'App\User']);

        $filename = null;
        if($request->image)
        {
            $file = $request->image;
            // Image::make($file)->widen(1024, function ($constraint) {$constraint->upsize(); })->save($file);
            Image::make($file)->widen(600, function ($constraint) {$constraint->upsize(); })->crop(600,600)->fill('#ffffff', 0, 0)->save($file);

            $filename = time().'.'.$file->getClientOriginalExtension();
            $filepath = 'sales-persons/'.$filename;
            Storage::put($filepath, file_get_contents($file), 'public');
        }

        $this->data->fill($request->all());

        $slug = str_slug($request->title);
        $existingSlugs = $this->data->where('slug', 'like', '%'.$slug.'%')->count();
        $existingSlugs > 0 ? $this->data->slug =$slug.$existingSlugs : $this->data->slug = $slug;

        $this->data->image = $filename;
        $this->data->status = 1;
        $this->data->user_id = $userId;
        $this->data->save();
        $dataId = $this->data->id;

        // Assign brands to a person
        $availableBrands = null;
        if($request->brands) {
            foreach ($request->brands as $brand) {
                $availableBrands[] = [
                    'sales_person_id' => $dataId,
                    'brand_id' => $brand,
                    'created_at' => new DateTime,
                    'updated_at' => new DateTime,
                ];
            }
        }

        if($availableBrands) {
            $this->brandSalesPerson->insert($availableBrands);
        }

        //Assign stores to sales person
        $availableStores = null;
        if($request->stores) {
            foreach ($request->stores as $addStore) {
                $availableStores[] = [
                    'sales_person_id' => $dataId,
                    'store_id' => $addStore,
                    'created_at' => new DateTime,
                    'updated_at' => new DateTime,
                ];
            }
        }

        if($availableStores) {
            $this->salesPersonHasStore->insert($availableStores);
        }

        $sessionMsg = $this->data->name;
        return redirect('admin/sales-person')->with('success', 'Data '.$sessionMsg.' has been updated');
    }

    public function post_edit(SalesPersonRequest $request, $id)
    {
        $this->data = $this->data->find($id);
        $oldFilename = $filename = $this->data->image;
        $this->data->fill($request->all());
        $this->data->slug = str_slug($request->slug);
        $request->status == 1 ? $this->data->status = 1 : $this->data->status = 0;

        //Image upload function
        if($request->image) {
            $file = $request->image;
            // Image::make($file)->widen(1024, function ($constraint) {$constraint->upsize(); })->save($file);

            Image::make($file)->widen(600, function ($constraint) {$constraint->upsize(); })->crop(600,600)->fill('#ffffff', 0, 0)->save($file);

            $filename = time().'.'.$file->getClientOriginalExtension();
            $filepath = 'sales-persons/'.$filename;
            Storage::put($filepath, file_get_contents($file), 'public');
            if($oldFilename)
                Storage::delete('sales-persons/'.$oldFilename);
        }
        $this->data->image = $filename;
        $this->data->save();

        if ($request->password) {
            // $this->user->find($this->data->user_id);
            // $this->user->password = Hash::make($request->password);
            // $this->user->save();

            $user =  $this->user->find($this->data->user_id);
            $user->password = bcrypt($request->password);
            $user->save();
        }

        //Assign Brands
        $oldBrands = $this->brandSalesPerson->where('sales_person_id', $id)->pluck('brand_id')->toArray();
        $availableBrands = null;
        if($request->brands) {
            foreach ($request->brands as $newBrand) {
                if (!in_array($newBrand, $oldBrands)) {
                    $availableBrands[] = [
                        'sales_person_id' => $id,
                        'brand_id' => $newBrand,
                        'created_at' => new DateTime,
                        'updated_at' => new DateTime,
                    ];
                } else {
                    $key = array_search($newBrand, $oldBrands);
                    unset($oldBrands[$key]);
                }
            }
        }
        if($availableBrands) {
            $this->brandSalesPerson->insert($availableBrands);
        }
        //Delete old Brands
        $this->brandSalesPerson->whereIn('brand_id', $oldBrands)->where('sales_person_id', $id)->forceDelete();


        //Assign Stores to sales person
        $oldStores = $this->salesPersonHasStore->where('sales_person_id', $id)->pluck('store_id')->toArray();
        $availableStores = null;
        if($request->stores) {
            foreach ($request->stores as $newStore) {
                if (!in_array($newStore, $oldStores)) {
                    $availableStores[] = [
                        'sales_person_id' => $id,
                        'store_id' => $newStore,
                        'created_at' => new DateTime,
                        'updated_at' => new DateTime,
                    ];
                } else {
                    $key = array_search($newStore, $oldStores);
                    unset($oldStores[$key]);
                }
            }
        }
        if($availableStores) {
            $this->salesPersonHasStore->insert($availableStores);
        }
        //Delete old Resorts
        $this->salesPersonHasStore->whereIn('store_id', $oldStores)->where('sales_person_id', $id)->forceDelete();

        $sessionMsg = $this->data->name;
        return redirect('admin/sales-person')->with('success', 'Data '.$sessionMsg.' has been updated');
    }

    public function image_delete($id)
    {
        $data = $this->data->find($id);
        if($data) {
            Storage::delete('sales-persons/'.$data->image);
            $data->update(['image'=>'']);
            return redirect()->back()->with('success', 'The image has been deleted successfully.');
        }
        else {
            return redirect()->back()->with('error', 'The image has not been deleted.');
        }
    }

    public function get_delete($id)
    {
        $data = $this->data->find($id);

        if (!$data) {
            return redirect('admin/sales-person')->with('error', 'Please delete corresponding data before delete the data');
        }

        $this->user->find($data->user_id)->delete();
        DB::table('model_has_roles')->where('model_id', $data->user_id)->delete();

        $this->brandSalesPerson->where('sales_person_id', $id)->delete();
        $this->salesPersonHasStore->where('sales_person_id', $id)->delete();



        if($data->image){
            Storage::delete('sales-persons/'.$data->image);
        }
        $data->delete();

        return redirect('admin/sales-person')->with('success', 'Data has been deleted successfully.');
    }
}
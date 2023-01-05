<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreManagerRequest;
use App\SalesPersonHasStore;
use App\StoreCategory;
use App\StoreManager;
use App\StoreManagerHasStore;
use App\User;
use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class StoreManagerController extends Controller {

    public function __construct(StoreManager $storeManager, StoreCategory $storeCategory, StoreManagerHasStore $storeManagerHasStore, User $user)
    {
        $this->module = "store";
        $this->data = $storeManager;
        $this->storeCategory = $storeCategory;
        $this->storeManagerHasStore = $storeManagerHasStore;
        $this->user = $user;
        $this->middleware('auth');
    }

    public function index($id = null)
    {
        $module = $this->module;
        $allData = $this->data->orderBy('id', 'DESC')->get();

        $storeCategoriesData = $this->storeCategory->where('status', 1)->select('id', 'title')->with('storesData')->get();

        if($id) {
            $singleData = $this->data->find($id);

            $oldStores = $this->storeManagerHasStore->where('store_manager_id', $id)->pluck('store_id')->toArray();
            $singleData->stores = $oldStores;
        }else {
            $singleData = $this->data;
        }

        return view('admin.'.$module.'.store_manager', compact('allData', 'singleData', 'module', 'storeCategoriesData'));
    }

    public function post_add(StoreManagerRequest $request)
    {
        $user = $this->user->where('email', $request->email)->first();

        if ($user) {
            return redirect()->back()->with('error', 'User already registered.')->withInput();
        }
        
        //Create user
        $this->user->role_id = 5;
        // $this->user->name = $request->title;
        $this->user->name = $request->first_name.' '.$request->last_name;
        $this->user->email = strtolower($request->email);
        // $this->user->password = Hash::make($request->password);
        $this->user->password =  bcrypt($request->password);
        $this->user->status = 1;
        $this->user->verified  =  1;
        $this->user->ip  = $request->getClientIp(); // Registered IP Address
        $this->user->save();
        $userId = $this->user->id; //Get last save id

        //Assign role
        DB::table('model_has_roles')->insert(['role_id' => '5','model_id' =>  $userId, 'model_type'=>'App\User']);

        $filename = null;
        if($request->image)
        {
            $file = $request->image;
            // Image::make($file)->widen(1024, function ($constraint) {$constraint->upsize(); })->save($file);
            Image::make($file)->widen(600, function ($constraint) {$constraint->upsize(); })->crop(600,600)->fill('#ffffff', 0, 0)->save($file);

            $filename = time().'.'.$file->getClientOriginalExtension();
            $filepath = 'store_managers/'.$filename;
            Storage::put($filepath, file_get_contents($file), 'public');
        }

        $this->data->fill($request->all());

        $slug = str_slug($request->first_name . $request->last_name);
        $existingSlugs = $this->data->where('slug', 'like', '%'.$slug.'%')->count();
        $existingSlugs > 0 ? $this->data->slug = $slug.'_'.$existingSlugs : $this->data->slug = $slug;

        $this->data->image = $filename;
        $this->data->status = 1;
        $this->data->user_id = $userId;
        $this->data->save();
        $dataId = $this->data->id;

        //Assign stores to sales person
        $availableStores = null;
        if($request->stores) {
            foreach ($request->stores as $addStore) {
                $availableStores[] = [
                    'store_manager_id' => $dataId,
                    'store_id' => $addStore,
                    'created_at' => new DateTime,
                    'updated_at' => new DateTime,
                ];
            }
        }

        if($availableStores) {
            $this->storeManagerHasStore->insert($availableStores);
        }

        $sessionMsg = $this->data->name;
        return redirect('admin/store-manager')->with('success', 'Data '.$sessionMsg.' has been updated');
    }

    public function post_edit(StoreManagerRequest $request, $id)
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
            $filepath = 'store_managers/'.$filename;
            Storage::put($filepath, file_get_contents($file), 'public');
            if($oldFilename)
                Storage::delete('store_managers/'.$oldFilename);
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

        
        //Assign Stores to sales person
        $oldStores = $this->storeManagerHasStore->where('store_manager_id', $id)->pluck('store_id')->toArray();
        $availableStores = null;
        if($request->stores) {
            foreach ($request->stores as $newStore) {
                if (!in_array($newStore, $oldStores)) {
                    $availableStores[] = [
                        'store_manager_id' => $id,
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
            $this->storeManagerHasStore->insert($availableStores);
        }
        //Delete old Resorts
        $this->storeManagerHasStore->whereIn('store_id', $oldStores)->where('store_manager_id', $id)->forceDelete();

        $sessionMsg = $this->data->name;
        return redirect('admin/store-manager')->with('success', 'Data '.$sessionMsg.' has been updated');
    }

    public function image_delete($id)
    {
        $data = $this->data->find($id);
        if($data) {
            Storage::delete('store_managers/'.$data->image);
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
            return redirect('admin/store-manager')->with('error', 'Please delete corresponding data before delete the data');
        }

        $this->user->find($data->user_id)->delete();
        DB::table('model_has_roles')->where('model_id', $data->user_id)->delete();

        $this->storeManagerHasStore->where('store_manager_id', $id)->delete();

        if($data->image){
            Storage::delete('store_managers/'.$data->image);
        }
        $data->delete();

        return redirect('admin/store-manager')->with('success', 'Data has been deleted successfully.');
    }
}
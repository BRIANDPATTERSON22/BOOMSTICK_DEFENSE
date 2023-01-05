<?php namespace App\Http\Controllers\Admin;

use DB;
use Auth;
use Hash;
use App\User;
use App\Customer;
use App\Page;
use App\Event;
use App\Video;
use App\PhotoAlbum;
use App\Advertisement;
use App\Http\Requests\Admin\UserRequest;
use App\Http\Requests\Admin\ProfileRequest;
use App\Http\Requests\Admin\PasswordRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Intervention\Image\Facades\Image;

class UserController extends Controller {

    public function __construct(User $user, Role $role, Permission $permission)
    {
        $this->module = "user";
        $this->data = $user;

        $this->role = $role;
        $this->permission = $permission;

        $this->option = Cache::get('optionCache');
        $this->middleware('auth');
    }

    public function index($id = null)
    {
        $module = $this->module;
        $allData = $this->data->select('users.*')
            ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            // ->whereNotIn('model_has_roles.role_id', [1,2])
            ->orderBy('users.created_at', 'ASC')
            ->groupBy('model_has_roles.model_id')
            ->get();

            // dd($allData);

        // $roles = $this->role->whereNotIn('id', [1,2])->pluck('name', 'id');
        $roles = $this->role->pluck('name', 'id');
        $permissions = $this->permission->pluck('name', 'id');
        if($id) {
            $singleData = $this->data->find($id);
            $assignedRoles = $singleData->roles->pluck('id');
            $singleData->roles_id = $assignedRoles;
            $assignedPermissions = $singleData->permissions->pluck('id');
            $singleData->permissions_id = $assignedPermissions;
        }else {
            $singleData = $this->data;
        }

        return view('admin.'.$module.'.user', compact('allData','roles', 'permissions', 'singleData', 'module'));
    }

    public function post_add(UserRequest $request)
    {
        $module = $this->module;

        try {
            $this->data->fill($request->all());
            // $this->data->password = Hash::make($request->password);
            $this->data->email = strtolower($request->email);
            $this->data->password = bcrypt($request->password);
            $this->data->ip  = $request->getClientIp();
            $this->data->is_verified  = 1;
            $this->data->status = 1;
            $this->data->save();
            $this->data->assignRole($request->roles_id);
            $this->data->givePermissionTo($request->permissions_id);

            return redirect('admin/' . $module . 's')->with('success', 'User ' . $request->name . ' has been created');
        }
        catch (\Exception $exception){
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function post_edit(UserRequest $request, $id)
    {
        try {
            $this->data = $this->data->find($id);
            $this->data->fill($request->all());
            if ($request->password != null){
                // $this->data->password = Hash::make($request->password);
                $this->data->password = bcrypt($request->password);;
            }
            $this->data->save();
            $this->data->syncRoles($request->roles_id);
            $this->data->syncPermissions($request->permissions_id);

            return redirect()->back()->with('success', 'User ' . $request->name . ' has been updated');
        }

        catch (\Exception $exception){
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function post_password(PasswordRequest $request, $id)
    {
        $this->data = $this->data->find($id);
        $this->data->fill($request->all());
        if($request->password != null)
            $this->data->password = Hash::make($request->password);
        $this->data->save();

        return redirect()->back()->with('success', 'The password has been updated');
    }

    public function get_delete($id)
    {
        $module = $this->module;

        $events = Event::where('user_id', $id)->count();
        $videos = Video::where('user_id', $id)->count();
        $photos = PhotoAlbum::where('user_id', $id)->count();
        $pages = Page::where('user_id', $id)->count();
        $ads = Advertisement::where('user_id', $id)->count();
        $customers = Customer::where('user_id', $id)->count();

        if($pages>0) {
            return redirect('admin/'.$module.'s')->with('error', 'User has not been deleted, The user has pages');
        }
        elseif($videos>0) {
            return redirect('admin/'.$module.'s')->with('error', 'User has not been deleted, The user has videos');
        }
        elseif($photos>0) {
            return redirect('admin/'.$module.'s')->with('error', 'User has not been deleted, The user has photos');
        }
        elseif($events>0) {
            return redirect('admin/'.$module.'s')->with('error', 'User has not been deleted, The user has events');
        }
        elseif($customers>0) {
            return redirect('admin/'.$module.'s')->with('error', 'User has not been deleted, The user has customer');
        }
        elseif($ads>0) {
            return redirect('admin/'.$module.'s')->with('error', 'User has not been deleted, The user has advertisements');
        }
        else {
            $this->data->find($id)->delete();
            return redirect('admin/'.$module.'s')->with('success', 'User has been deleted successfully.');
        }
    }

    //Profile
    public function get_profile()
    {
        $module = $this->module;
        $singleData = $this->data->find(Auth::id());

        return view('admin.'.$module.'.profile', compact('singleData', 'module'));
    }

    public function post_profile(ProfileRequest $request)
    {
        $module = $this->module;
        $user = $this->data->find(Auth::id());
        $oldFilename = $filename = $user->image;
        $user->fill($request->all());
        $user->password = Hash::make($request->password);

        //Image upload function
        if($request->image) {
            $file = $request->image;
            // Image::make($file)->widen(160, function ($constraint) {$constraint->upsize(); })->save($file);
            Image::make($file)->widen(160, function ($constraint) {$constraint->upsize(); })->crop(160,160)->fill('#ffffff', 0, 0)->save($file);
            $filename = time().'.'.$file->getClientOriginalExtension();
            $filepath = $module.'s/'.Auth::id().'/'.$filename;
            Storage::put($filepath, file_get_contents($file), 'public');
            if($oldFilename)
                Storage::delete($module.'s/'.Auth::id().'/'.$oldFilename);
        }

        $user->image = $filename;
        $user->save();
        Auth::login($user);
        
        return redirect()->back()->with('success', 'Profile has been successfully updated');
    }
    public function user_profile_image_delete($id)
    {
        $data = $this->data->find(Auth::id());
        if($data) {
            Storage::delete('users/'.$id.'/'.$data->image);
            $data->update(['image'=> NULL]);
            return redirect()->back()->with('success', 'The image has been deleted successfully.');
        }
        else {
            return redirect()->back()->with('error', 'The image has not been deleted.');
        }
    }


}
<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\RoleRequest;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller {

    public function __construct(Role $role, Permission $permission) {

        $this->role = $role;
        $this->permission = $permission;
        $this->middleware('auth');
    }

    public function index($id = null)
    {
        $allData = $this->role->orderBy('id', 'ASC')->get();

        if($id) {
            $permissions = $this->permission->pluck('name', 'id');
            $singleData = $this->role->find($id);

            $assignedPermissions = $singleData->permissions->pluck('id');
            $singleData->permissions_id = $assignedPermissions;
        }else {
            $singleData = $this->role;
            $permissions = $this->permission->pluck('name', 'id');
        }

        return view('admin.user.role', compact('singleData','allData', 'permissions'));
    }

    public function post_add(RoleRequest $request)
    {
        try {
            $this->role->create(['name' => $request->name, 'guard_name' => $request->guard_name]);
            return redirect('admin/roles')->with('success', 'Role ' . $request->name . ' data has been created');
        }
        catch (\Exception $exception){
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function post_edit(RoleRequest $request, $id)
    {
        try {
            $this->role = $this->role->find($id);
            // $this->role->fill($request->all());
            $this->role->name = $request->name;
            $this->role->guard_name = $request->guard_name;
            $this->role->save();
            $this->role->syncPermissions($request->permissions_id);

            return redirect('admin/roles')->with('success', 'Role ' . $request->name . ' data has been updated');
        }
        catch (\Exception $exception){
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function get_delete($id)
    {
        if($this->role->find($id)->delete()) {
            return redirect('admin/roles')->with('success', 'Your data has been deleted successfully.');
        }else {
            return redirect('admin/roles')->with('error', 'Your data has not been deleted, Delete User & Permissions first');
        }
    }
}

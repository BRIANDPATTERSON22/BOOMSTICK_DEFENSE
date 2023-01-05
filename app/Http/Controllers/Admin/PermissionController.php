<?php namespace App\Http\Controllers\Admin;

use Spatie\Permission\Models\Permission;
use App\Http\Requests\Admin\PermissionRequest;
use App\Http\Controllers\Controller;

class PermissionController extends Controller {

    public function __construct(Permission $permission)
    {
        $this->permission = $permission;

        $this->middleware('auth');
    }

    public function index($id = null)
    {
        $allData = $this->permission->orderBy('id', 'DESC')->get();

        if($id) {
            $singleData = $this->permission->find($id);
        }else {
            $singleData = $this->permission;
        }

        return view('admin.user.permission', compact('allData', 'singleData'));
    }

    public function post_add(PermissionRequest $request)
    {
        $this->permission->fill($request->all());
        $this->permission->save();

        return redirect('admin/permissions')->with('success', 'Permission assgined to a role data has been created');
    }

    public function post_edit(PermissionRequest $request, $id)
    {
        $this->permission = $this->permission->find($id);
        $this->permission->fill($request->all());
        $this->permission->save();

        return redirect('admin/permissions')->with('success', 'Permission assgined to a role  data has been updated');
    }

    public function get_delete($id)
    {
        if($this->permission->find($id)->delete()) {
            return redirect('admin/permissions')->with('success', 'Your data has been deleted successfully.');
        }else {
            return redirect('admin/permissions')->with('error', 'Your data has not been deleted.');
        }
    }
}
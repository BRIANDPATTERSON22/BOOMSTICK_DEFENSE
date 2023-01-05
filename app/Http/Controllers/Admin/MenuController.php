<?php namespace App\Http\Controllers\Admin;

use App\Page;
use App\Menu;
use App\MenuSub;
use App\Http\Requests\Admin\MenuRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class MenuController extends Controller {

    public function __construct(Page $page, Menu $menu, MenuSub $menuSub)
    {
        $this->module = "menu";
        $this->data = $menu;
        $this->page = $page;
        $this->menuSub = $menuSub;

        $this->middleware('auth');
    }

    public function index($id = null)
    {
        $module = $this->module;

        $allData = $this->data->orderBy('type', 'DESC')->orderBy('order', 'ASC')->get();
        $pages = $this->page->where('status', 1)->select('title', 'slug')->get();
        $menus = $this->data->where('url', "parent")->select('title', 'id')->get();

        if($id) {
            $singleData = $this->data->find($id);
        }
        else {
            $singleData = $this->data;
        }

        //
        $headerMenu = $this->data->where('type', "header")->where('status', 1)->orderBy('order', 'ASC')->get();
        Cache::forever('headerMenuCache', $headerMenu);

        $footerMenu = $this->data->where('type', "footer")->where('status', 1)->orderBy('order', 'ASC')->get();
        Cache::forever('footerMenuCache', $footerMenu);

        return view('admin.'.$module.'.index', compact('allData', 'singleData', 'module', 'pages', 'menus'));
    }

    public function post_add(MenuRequest $request)
    {
        $module = $this->module;
        if($request->menu_id) {
            $this->menuSub->fill($request->all());
            $this->menuSub->status = 1;
            $this->menuSub->save();
        }
        else{
            $this->data->fill($request->all());
            $this->data->status = 1;
            $this->data->save();
        }

        $sessionMsg = $this->data->title;
        return redirect('admin/'.$module.'s')->with('success', 'The menu '.$sessionMsg.' data has been created');
    }

    public function post_edit(MenuRequest $request, $id)
    {
        $module = $this->module;

        if($request->menu_id) {
            $this->menuSub = $this->menuSub->find($id);
            $this->menuSub->fill($request->all());
            $request->status == 1 ? $this->menuSub->status = 1 : $this->menuSub->status = 0;
            $this->menuSub->save();
        }
        else{
            $this->data = $this->data->find($id);
            $this->data->fill($request->all());
            $request->status == 1 ? $this->data->status = 1 : $this->data->status = 0;
            $this->data->save();
        }

        $sessionMsg = $this->data->title;
        return redirect('admin/'.$module.'s')->with('success', 'The menu '.$sessionMsg.' has been updated');
    }

    public function get_delete($id)
    {
        if($this->data->find($id)->delete()) {
            $this->menuSub->where('menu_id', $id)->delete();
            return redirect()->back()->with('success', 'Your data has been deleted successfully');
        }
        else {
            return redirect()->back()->with('error', 'Your data has not been deleted');
        }
    }

    public function get_delete_sub($id)
    {
        if($this->menuSub->find($id)->delete()) {
            return redirect()->back()->with('success', 'Your data has been deleted successfully');
        }
        else {
            return redirect()->back()->with('error', 'Your data has not been deleted');
        }
    }
}
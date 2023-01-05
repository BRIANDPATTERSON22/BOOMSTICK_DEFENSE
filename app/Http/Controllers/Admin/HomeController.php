<?php namespace App\Http\Controllers\Admin;

use App\Advertisement;
use App\Block;
use App\Company;
use App\Contact;
use App\Customer;
use App\Event;
use App\Http\Controllers\Controller;
use App\Menu;
use App\Option;
use App\Order;
use App\Page;
use App\PhotoAlbum;
use App\Product;
use App\ProductBrand;
use App\ProductCategory;
use App\ProductModel;
use App\RsrMainCategory;
use App\RsrProduct;
use App\RsrSubCategory;
use App\SalesPerson;
use App\SliderImage;
use App\Store;
use App\StoreCategory;
use App\StoreManager;
use App\StoreProduct;
use App\ThemeSettings;
use App\Upload;
use App\User;
use App\Video;
use Auth;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->option = Cache::get('optionCache');
        $this->siteThemeSettings = Cache::get('themeCache');
        $this->loginUser = Auth::user();
        $this->middleware('auth');
    }

    public function index()
    {
        if(Auth::user()->hasRole('customer'))
            return redirect('/');

        $ads = Advertisement::count();
        $pages = Page::count();
        $photos = PhotoAlbum::count();
        $videos = Video::count();
        $events = Event::count();
        $sliders = SliderImage::count();
        $blocks = Block::count();

        $products = Product::count();
        $categories = ProductCategory::count();
        $brands = ProductBrand::count();
        $models = ProductModel::count();

        $customers = Customer::count();
        $orders = Order::count();
        $admins = User::role('admin')->count();

        $mediaLibrary = Upload::count();
        $contactCount = Contact::where('is_viewed', 0)->count();

        $storeCount = Store::count();
        $storeProductCount = StoreProduct::count();
        $storeCategoryCount = StoreCategory::count();
        $storeCompaniesCount = Company::count();
        $salesPersonsCount = SalesPerson::count();
        $storeManagersCount = StoreManager::count();

        $rsrProductCount = RsrProduct::count();
        $rsrMainCategoryCount = RsrMainCategory::count();
        $rsrSubCategoryCount = RsrSubCategory::count();

        return view('admin.home.dashboard', compact('events','pages', 'ads', 'photos', 'videos', 'sliders', 'blocks', 'admins', 'products', 'categories','brands', 'models', 'customers', 'orders', 'mediaLibrary','contactCount', 'storeCount', 'storeProductCount', 'storeCategoryCount', 'storeCompaniesCount', 'salesPersonsCount', 'storeManagersCount', 'rsrProductCount', 'rsrMainCategoryCount', 'rsrSubCategoryCount'));
    }

    public function cache_flush()
    {
        Cache::flush();

        $option = Option::first();
        Cache::forever('optionCache', $option);

        $siteThemeSettings = ThemeSettings::first();
        Cache::forever('themeCache', $siteThemeSettings);

        $headerMenu = Menu::where('type', "header")->where('status', 1)->orderBy('order', 'ASC')->get();
        Cache::forever('headerMenuCache', $headerMenu);

        $footerMenu = Menu::where('type', "footer")->where('status', 1)->orderBy('order', 'ASC')->get();
        Cache::forever('footerMenuCache', $footerMenu);

        return redirect()->back()->with('success', 'All cache data removed');
    }

    //Link storage path
    public function run_artisan($com)
    {
        Artisan::call($com);

        return redirect()->back()->with('success', 'The artisan command has been executed');
    }

    public function maintenance_down()
    {
        $option = Option::first();
        $option->status = 0;
        $option->save();

        Cache::forever('optionCache', $option);

        return redirect()->back()->with('error', 'The site is offline');
    }

    public function maintenance_up()
    {
        $option = Option::first();
        $option->status = 1;
        $option->save();

        Cache::forever('optionCache', $option);

        return redirect()->back()->with('success', 'The site is online');
    }
}
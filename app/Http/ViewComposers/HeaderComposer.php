<?php namespace App\Http\ViewComposers;

use App\CategoryGroup;
use App\Contact;
use App\Product;
use App\ProductCategory;
use App\ProductCategorySub;
use App\ProductCategoryType;
use App\ProductModel;
use App\RsrMainCategory;
use App\RsrProduct;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;

class HeaderComposer {

    public function __construct(Contact $contact, ProductCategory $category, ProductCategorySub $categorySub, ProductCategoryType $productCategoryType)
    {
        $this->contact = $contact;
        $this->category = $category;
        $this->productCategoryType = $productCategoryType;
        $this->categorySub = $categorySub;
    }

    public function includeDataAdmin(View $view)
    {
        $contacts = $this->contact->orderBy('id', 'DESC')->get();
        $view->with('contacts', $contacts);
    }

    public function includeDataSite(View $view)
    {
        $menus = Cache::get('headerMenuCache');
        $view->with('menus', $menus);

        // ---
        $categoriesComposerData = $this->category->where('status', 1)->get();
        $view->with('categoriesComposerData', $categoriesComposerData);

        $mainMenuCategoriesComposerData = ProductCategory::where('status', 1)->where('is_enabled_on_menu', 1)->orderBy('menu_order_no', 'ASC')->with('subCategories')->get();
        $view->with('mainMenuCategoriesComposerData', $mainMenuCategoriesComposerData);

        // ---
        $rsrCategoriesComposerData =  RsrMainCategory::where('status', 1)->orderBy('category_name', 'ASC')->limit(40)->get();
        $view->with('rsrCategoriesComposerData', $rsrCategoriesComposerData);

        $rsrMainMenuCategoriesComposerData = RsrMainCategory::where('status', 1)->where('is_enabled_on_menu', 1)->orderBy('menu_order_no', 'ASC')->with('rsr_sub_categories')->get();
        $view->with('rsrMainMenuCategoriesComposerData', $rsrMainMenuCategoriesComposerData);

        // --
        $categoryGroupsComposerData = CategoryGroup::where('status', 1)->where('is_boomstick_category', 1)->where('is_enabled_on_menu', 1)->with('have_main_categories')->orderBy('menu_order_no', 'ASC')->get();
        $view->with('categoryGroupsComposerData', $categoryGroupsComposerData);

        $rsrCategoryGroupsComposerData = CategoryGroup::where('status', 1)->where('is_boomstick_category', 0)->where('is_enabled_on_menu', 1)->with('have_rsr_main_categories')->orderBy('menu_order_no', 'ASC')->get();
        $view->with('rsrCategoryGroupsComposerData', $rsrCategoryGroupsComposerData);

        // --
        // $rsrManufacturesComposerData = RsrProduct::groupBy('manufacturer_id')->limit(35)->get(['manufacturer_id', 'full_manufacturer_name']);
        // $view->with('rsrManufacturesComposerData', $rsrManufacturesComposerData);
    }

    public function includeFilterData(View $view)
    {

    }

    public function includeProductFilterData(View $view)
    {

    }
}
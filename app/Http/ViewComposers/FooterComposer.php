<?php namespace App\Http\ViewComposers;

use App\ProductBrand;
use App\ProductCategory;
use App\ProductCategorySub;
use App\Blog;
use App\BlogCategory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;

class FooterComposer {

    public function __construct(ProductCategory $category, ProductCategorySub $categorySub, ProductBrand $productBrand, Blog $blog, BlogCategory $blogCategory)
    {
        $this->category = $category;
        $this->categorySub = $categorySub;
        $this->productBrand = $productBrand;
        $this->blog = $blog;
        $this->blogCategory = $blogCategory;
    }

    public function includeDataSite(View $view)
    {
        $menus = Cache::get('footerMenuCache');
        $view->with('menus', $menus);

        // $productCategories = $this->categorySub->select('products_category_sub.*')
        //     ->join('products', 'products_category_sub.id', '=', 'products.category_id')
        //     ->groupBy('products_category_sub.id')
        //     ->inRandomOrder()->limit(6)->get();
        // $view->with('productCategories', $productCategories);

        // $footerProductCategoriesComposer = $this->category->inRandomOrder()->get();
        // $view->with('footerProductCategoriesComposer', $footerProductCategoriesComposer);

        // $brandsDataComposer = $this->productBrand->where('status', 1)->inRandomOrder()->limit(5)->get();
        // $view->with('brandsDataComposer', $brandsDataComposer);

        // $blogsDataComposer = $this->blog->where('status', 1)->inRandomOrder()->get();
        // $view->with('blogsDataComposer', $blogsDataComposer);
    }
}
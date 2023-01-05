<?php namespace App\Http\ViewComposers;

use App\Product;
use App\ProductCategory;
use App\RsrMainCategory;
use App\RsrProduct;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;

class OptionComposer {
	
    public function __construct()
    {
        
    }

    public function includeData(View $view )
    {
        $option = Cache::get('optionCache');
        $view->with('option', $option);
    }
}
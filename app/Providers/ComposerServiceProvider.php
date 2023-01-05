<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\View\Factory as ViewFactory;

class ComposerServiceProvider extends ServiceProvider {

    public function register()
    {

    }

    public function boot(ViewFactory $view)
    {
        $view->composers([

            'App\Http\ViewComposers\OptionComposer@includeData' => '*',

            'App\Http\ViewComposers\HeaderComposer@includeDataAdmin' => 'admin.partials.mainheader',
            // 'App\Http\ViewComposers\HeaderComposer@includeDataSite' => 'site.partials.mainheader',
            'App\Http\ViewComposers\HeaderComposer@includeDataSite' => 'site.partials.mainheader_2',
            'App\Http\ViewComposers\FooterComposer@includeDataSite' => 'site.partials.footer',

            // 'App\Http\ViewComposers\HeaderComposer@includeFilterData' => 'site.partials.filter',
            // 'App\Http\ViewComposers\HeaderComposer@includeProductFilterData' => 'site.partials.product_filter',
            // 'App\Http\ViewComposers\IncludeComposer@includePromoSidebar' => 'site.partials.promo_sidebar',
            'App\Http\ViewComposers\IncludeComposer@includePromoSidebar' => 'site.product.sidebar',
            // 'App\Http\ViewComposers\IncludeComposer@includePromoSidebar' => ['site.product.sidebar', 'site.product.sidebar_sub_category'],
        ]);
    }

}

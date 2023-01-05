<?php namespace App\Http\ViewComposers;

use App\Block;
use App\RsrMainCategory;
use App\RsrProducAttribute;
use Illuminate\Contracts\View\View;

class IncludeComposer {

    public function __construct(Block $block)
    {
        $this->block = $block;
    }

    public function includePromoSidebar(View $view)
    {
        // $promoSidebar = $this->block->where('slug', 'promo-sidebar')->where('status', 1)->first();
        // $view->with('promoSidebar', $promoSidebar);

        $rsrCategoriesComposerData = RsrMainCategory::where('status', 1)->orderBy('department_name', 'ASC')->get();
        // $rsrCategoriesComposerData = RsrMainCategory::orderBy('category_name', 'ASC')->get();
        $view->with('rsrCategoriesComposerData', $rsrCategoriesComposerData);

        // $rsrProductAttributeCaliber = RsrProducAttribute::whereNotNull('caliber')->groupBY('caliber')->orderBy('caliber', 'ASC')->get(['caliber']);
        // $view->with('rsrProductAttributeCaliber', $rsrProductAttributeCaliber);

        // $rsrProductAttributeBarrelLength = RsrProducAttribute::whereNotNull('barrel_length')->groupBY('barrel_length')->orderBy('barrel_length', 'ASC')->get(['barrel_length']);
        // $view->with('rsrProductAttributeBarrelLength', $rsrProductAttributeBarrelLength);
    }
}
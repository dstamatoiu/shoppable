<?php

namespace Modules\MobileApp\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class MobileController extends Controller
{
    public function termsAndCondition(){
        $selected_page = get_static_option("mobile_terms_and_condition");

        $page = Page::where('slug', $selected_page)->select( "title","page_content")->first();

        return response()->json($page);
    }

    public function privacyPolicy(){
        $selected_page = get_static_option("mobile_privacy_and_policy");

        $page = Page::where('slug', $selected_page)->select( "title","page_content")->first();
        return response()->json($page);
    }

    public function site_currency_symbol(){
        $is_rtl_on_or_not = get_user_lang_direction() == 1 ?? false;

        return response()->json(["symbol" => site_currency_symbol(),"currencyPosition" => get_static_option('site_currency_symbol_position'),
            "rtl" => $is_rtl_on_or_not]);
    }
}

<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\MobileApp\Http\Controllers\Api\V1\UserController;
use Modules\MobileApp\Http\Controllers\MobileIntroApiController;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use Modules\MobileApp\Http\Controllers\Api\V1\CategoryController;
use Modules\MobileApp\Http\Controllers\Api\V1\ChildCategoryController;
use Modules\MobileApp\Http\Controllers\Api\V1\CountryController;
use Modules\MobileApp\Http\Controllers\Api\V1\LanguageController;
use Modules\MobileApp\Http\Controllers\Api\V1\MobileSliderController;
use Modules\MobileApp\Http\Controllers\Api\V1\SiteSettingsController;
use Modules\MobileApp\Http\Controllers\Api\V1\SubCategoryController;
use Modules\MobileApp\Http\Controllers\CampaignController;
use Modules\MobileApp\Http\Controllers\FeaturedProductController;
use Modules\MobileApp\Http\Controllers\MobileController;
use Modules\MobileApp\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::middleware([
    'api',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->prefix('api/tenant')->group(function () {
    Route::prefix("v1")->group(function () {

        Route::post('/register',[UserController::class,'register']);
        Route::post('/login',[UserController::class,'login']);
        Route::post('social/login',[UserController::class,'socialLogin']);
        Route::get('/country',[CountryController::class,'country']);
        Route::get('/state/{country_id}',[CountryController::class,'stateByCountryId']);
        Route::post('/send-otp-in-mail',[UserController::class,'sendOTP']);
        Route::post('/otp-success',[UserController::class,'sendOTPSuccess']);
        Route::post('/reset-password',[UserController::class,'resetPassword']);

        /*
         * todo:: all category route are below this line
         * */

        /* category */
        Route::group(['prefix' => 'category'],function(){
            Route::get('/',[CategoryController::class,'allCategory']);
            Route::get('/{id}',[CategoryController::class,'singleCategory']);
        });
        /* sub category */
        Route::group(['prefix' => 'subcategory'],function(){
            Route::get('/{category_id}',[SubCategoryController::class,'allSubCategory']);
            Route::get('/{category_id}/{id}',[SubCategoryController::class,'singleSubCategory']);
        });
        /* sub category */
        Route::group(['prefix' => 'child-category'],function(){
            Route::get('/{sub_category}',[ChildCategoryController::class,'allChildCategory']);
            Route::get('/{sub_category}/{id}',[ChildCategoryController::class,'singleChildCategory']);
        });

        Route::get("all-categories", [CategoryController::class,"allCategories"]);
        /*
         * todo:: all type of category route ends
         * */

        /*
         * todo:: all type of products route starts
         * */


// Product Route
// Fetch feature product
        Route::get("featured/product", [FeaturedProductController::class,'index']);
        Route::get("campaign/product/{id?}", [FeaturedProductController::class,'campaign']);
        Route::get("campaign", [CampaignController::class,'index']); // done
        Route::get("product", [ProductController::class,'search'])->name("api.product.search");
        Route::get("product/{id}", [ProductController::class,'productDetail']);
        Route::get("product/price-range", [ProductController::class,'priceRange']);
        Route::post("product-review", [ProductController::class,'storeReview']);
        Route::post('/category/{id}',[ProductController::class,'singleProducts']);
        Route::post('/subcategory/{id}',[ProductController::class,'singleProducts']);
        Route::get('/terms-and-condition-page', [MobileController::class, 'termsAndCondition']);
        Route::get('/privacy-policy-page', [MobileController::class, 'privacyPolicy']);
        Route::get('site_currency_symbol', [MobileController::class, 'site_currency_symbol']);
        Route::get('/language',[LanguageController::class,'languageInfo']);
        Route::post('/translate-string',[LanguageController::class,'translateString']);
        /*
         * todo:: all type of products route ends
         * */
        Route::get('/mobile-slider',[MobileSliderController::class,"index"]);
        Route::get('/mobile-intro',[MobileIntroApiController::class,"mobileIntro"]);

        Route::get("/payment-gateway-list",[SiteSettingsController::class,"payment_gateway_list"]);

        Route::group(['prefix' => 'user/','middleware' => 'auth:sanctum'],function (){
            Route::post('logout',[UserController::class,'logout']);
            Route::get('profile',[UserController::class,'profile']);
            Route::post('change-password',[UserController::class,'changePassword']);
            Route::post('update-profile',[UserController::class,'updateProfile']);
            Route::group(['prefix' => 'support-tickets'],function(){
                Route::post('/',[UserController::class,'allTickets']);
                Route::post('/{id}',[UserController::class,'viewTickets']);
            });

            /* Add shipping method */
            Route::get("/all-shipping-address",[UserController::class,"get_all_shipping_address"]);
            Route::get("/shipping-address/delete/{shipping}",[UserController::class,"delete_shipping_address"]);
            Route::post("/add-shipping-address",[UserController::class,"storeShippingAddress"]);
            Route::get("/get-department",[UserController::class,"get_department"]);
            Route::get("ticket",[UserController::class,"get_all_tickets"]);
            Route::get("ticket/{id}",[UserController::class,"single_ticket"]);
            Route::get("ticket/chat/{ticket_id}",[UserController::class,"fetch_support_chat"]);
            Route::post("ticket/chat/send/{ticket_id}",[UserController::class,"send_support_chat"]);
            Route::post('ticket/message-send',[UserController::class,'sendMessage']);
            Route::post('ticket/create',[UserController::class,'createTicket']);
            Route::post('ticket/priority-change', [UserController::class,'priority_change']);
            Route::post('ticket/status-change', [UserController::class,'status_change']);

            /* Order list */
            Route::get('order', [UserController::class, 'all_order_list']);
            Route::get('order/{order_id}', [UserController::class, 'single_order_details']);
            Route::post('order/refund', [UserController::class, 'request_order_refund']);

            Route::get("refund",[UserController::class,"get_all_refund_list"]);
        });
    });
});
Route::fallback(function (){
   return response()->json(['msg' => __('page not found')],404);
});

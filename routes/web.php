<?php
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ConfigWebController;
use Illuminate\Support\Facades\Route;


// Backend
Route::get('/admin', [AdminController::class, 'index']);
Route::get('/login-admin', [AdminController::class, 'login_admin']);
Route::get('/signout-admin', [AdminController::class, 'signout_admin']);
Route::post('/login-check', [AdminController::class, 'login_check']);

Route::group(['middleware' => 'protectAuthLog'], function () {
    Route::group(['prefix' => '/admin/dashboard'], function () {
        Route::get('/filter-by-date', [AdminController::class, 'filter_by_date']);
        
    });
    
    
    // Category: thể loại
    Route::group(['prefix' => '/admin/category'], function () {
        Route::get('/add-category', [CategoryController::class, 'add_category']);
        Route::get('/load-category', [CategoryController::class, 'load_category']);
        Route::get('/all-category', [CategoryController::class, 'all_category']);
        Route::get('/delete-category', [CategoryController::class, 'delete_category']);
        Route::get('/unactive-category', [CategoryController::class, 'an_danh_muc']);
        Route::get('/active-category', [CategoryController::class, 'hien_danh_muc']);
        Route::post('/save-category', [CategoryController::class, 'save_category']);
        Route::get('/edit-category', [CategoryController::class, 'edit_category']);
        Route::post('/update-category', [CategoryController::class, 'update_category']);

        Route::get('/list-deleted-category', [CategoryController::class, 'list_deleted_category']);
        Route::get('/load-bin-category', [CategoryController::class, 'load_bin_category']); 
        Route::get('/count-bin-category', [CategoryController::class, 'count_bin_category']); 
        Route::post('/restore-category', [CategoryController::class, 'restore_category']);
        Route::post('/delete-trash-category', [CategoryController::class, 'delete_trash_category']);
    });

    // Food and Food sale
    Route::group(['prefix' => '/admin/food'], function () {
        Route::get('/add-food', [FoodController::class, 'add_food']);
        Route::get('/load-food', [FoodController::class, 'load_food']);
        Route::get('/all-food', [FoodController::class, 'all_food']);
        Route::get('/delete-food', [FoodController::class, 'delete_food']);
        Route::get('/detail-food', [FoodController::class, 'detail_food']);
        Route::get('/unactive-food', [FoodController::class, 'an_mon_an']);
        Route::get('/active-food', [FoodController::class, 'hien_mon_an']);
        Route::post('/save-food', [FoodController::class, 'save_food']);
        Route::get('/edit-food', [FoodController::class, 'edit_food']);
        Route::post('/update-food', [FoodController::class, 'update_food']);
        Route::get('/all-food-sale', [FoodController::class, 'all_food_sale']);

        Route::get('/list-deleted-food', [FoodController::class, 'list_deleted_food']);
        Route::get('/load-bin-food', [FoodController::class, 'load_bin_food']); 
        Route::get('/count-bin-food', [FoodController::class, 'count_bin_food']); 
        Route::post('/restore-food', [FoodController::class, 'restore_food']);
        Route::post('/delete-trash-food', [FoodController::class, 'delete_trash_food']);
    });

    // Đơn đặt hàng
    Route::group(['prefix' => '/admin/order'], function () {
        Route::get('/manager-order', [OrderController::class, 'manager_order']);
        Route::get('/view-order', [OrderController::class, 'view_order']);
        Route::get('/delete-order', [OrderController::class, 'delete_order']);
        Route::get('/confirm-order-status', [OrderController::class, 'confirmation_order']);
        Route::get('/cancel-order', [OrderController::class, 'cancel_order']);
        Route::get('/load-order', [OrderController::class, 'load_order']);
        Route::get('/print-order', [OrderController::class, 'print_order']);
    });

    // Delivery: phí vận chuyển
    Route::group(['prefix' => '/admin/feeship'], function () {
        Route::get('/delivery', [DeliveryController::class, 'delivery']);
        Route::post('/select-delivery', [DeliveryController::class, 'select_delivery']);
        Route::get('/insert-delivery', [DeliveryController::class, 'insert_delivery']);
        Route::get('/select-feeship', [DeliveryController::class, 'select_feeship']);
        Route::get('/delete-delivery', [DeliveryController::class, 'delete_delivery']);
        Route::post('/update-delivery', [DeliveryController::class, 'update_delivery']);
    });

    // Slider
    Route::group(['prefix' => '/admin/slider'], function () {
        Route::get('/add-slider', [SliderController::class, 'add_slider']);
        Route::get('/select-slider', [SliderController::class, 'select_slider']);
        Route::post('/insert-slider', [SliderController::class, 'insert_slider']);
        Route::get('/delete-slider', [SliderController::class, 'delete_slider']);
        Route::post('/update-slider-name', [SliderController::class, 'update_slider_name']);
        Route::post('/update-slider', [SliderController::class, 'update_slider']);
    });

    // Mã giảm giá
    Route::group(['prefix' => '/admin/coupon'], function () {
        Route::get('/insert-coupon', [CouponController::class, 'insert_coupon']);
        Route::get('/list-coupon', [CouponController::class, 'list_coupon']);
        Route::get('/delete-coupon', [CouponController::class, 'delete_coupon']);
        Route::post('/insert-coupon-code', [CouponController::class, 'insert_coupon_code']);
        Route::get('/edit-coupon-code', [CouponController::class, 'edit_coupon_code']);
        Route::post('/update-coupon-code', [CouponController::class, 'update_coupon_code']);
        Route::get('/load-coupon', [ CouponController::class, 'load_coupon']);
    });

    // Khách hàng
    Route::group(['prefix' => '/admin/customer'], function () {
        Route::get('/all-customers', [CustomerController::class, 'all_customers']);
        Route::get('/delete-customers', [CustomerController::class, 'delete_customers']);
    });

    // Tin
    Route::group(['prefix' => '/admin/news'], function () {
        Route::get('/add-news', [NewsController::class, 'add_news']);
        Route::get('/all-news', [NewsController::class, 'all_news']);
        Route::get('/delete-news', [NewsController::class, 'delete_news']);
        Route::get('/update-status-news', [NewsController::class, 'update_status_news']);
        Route::post('/save-news', [NewsController::class, 'save_news']);
        Route::get('/edit-news', [NewsController::class, 'edit_news']);
        Route::post('/update-news', [NewsController::class, 'update_news']);
        Route::get('/load-news', [NewsController::class, 'load_news']);
    });

    // Cấu hình web
    Route::group(['prefix' => '/admin/configweb'], function () {
        Route::get('/add-configweb', [ConfigWebController::class, 'add_configweb']);
        Route::post('/add-configweb-logo', [ConfigWebController::class, 'add_configweb_logo']);
        Route::post('/update-configweb-logo', [ConfigWebController::class, 'update_configweb_logo']);
        Route::get('/load-configweb-logo', [ConfigWebController::class, 'load_configweb_logo']);
        Route::get('/insert-configweb-footer', [ConfigWebController::class, 'insert_configweb_footer']);
        Route::get('/load-configweb-footer', [ConfigWebController::class, 'load_configweb_footer']);
        Route::get('/edit-configweb-footer', [ConfigWebController::class, 'edit_configweb_footer']);
        Route::get('/delete-configweb-footer', [ConfigWebController::class, 'delete_configweb_footer']);
    });
    
});



// < ------------------------------------------------------ >
// Frontend
Route::get('/', [HomeController::class, 'index']);
Route::get('/trang-chu', [HomeController::class, 'index_home']);

// Show category index
Route::get('/danh-muc', [CategoryController::class, 'category']); // Ở thực đơn
Route::get('/loading-category-menu', [CategoryController::class, 'loading_category_menu']);
Route::get('/tim-kiem-mon', [CategoryController::class, 'search_food']);
Route::get('/loading-food', [CategoryController::class, 'loading_food']);

// Chi tiết món 
Route::get('/tat-ca-mon', [FoodController::class, 'all_food_home']);

// Cart ajax
Route::get('/loading-cart', [CartController::class, 'loading_cart']);
Route::post('/them-gio-hang', [CartController::class, 'them_gio_hang']);
Route::get('/xoa-gio-hang', [CartController::class, 'xoa_gio_hang']);
Route::get('/cap-nhat-gio-hang', [CartController::class, 'cap_nhat_gio_hang']);
Route::get('/chi-tiet-gio-hang', [CartController::class, 'chi_tiet_gio_hang']);
Route::get('/count-cart', [CartController::class, 'count_cart']);

// Thanh toán
Route::get('/payment', [CheckoutController::class, 'payment']); 
Route::get('/dang-nhap', [CheckoutController::class, 'dang_nhap']);
Route::get('/dang-xuat', [CheckoutController::class, 'dang_xuat']);
Route::get('/dang-ky', [CheckoutController::class, 'dang_ky']);
Route::get('/thu-tuc-thanh-toan', [CheckoutController::class, 'thu_tuc_thanh_toan']);
Route::get('/thanh-toan', [CheckoutController::class, 'thanh_toan']);
Route::post('/dang-nhap-check', [CheckoutController::class, 'dang_nhap_check']);
Route::post('/them-dang-ky', [CheckoutController::class, 'them_dang_ky']);
Route::post('/thong-tin-van-chuyen', [CheckoutController::class, 'thong_tin_van_chuyen']);
Route::post('/dat-hang', [CheckoutController::class, 'dat_hang']);
Route::post('/select-delivery-home', [CheckoutController::class, 'select_delivery_home']);
Route::get('/calculate-fee', [CheckoutController::class, 'calculate_fee']);

// Check mã giảm giá
Route::post('/check-coupon', [CouponController::class, 'check_coupon']);

// Blog
Route::get('/ve-chung-toi', [NewsController::class, 'about_us']);

// Load more
Route::get('/load-more-food', [HomeController::class, 'load_more_food']);

// Check đơn hàng
Route::get('/kiem-tra-don-hang', [HomeController::class, 'check_order']);
Route::post('/check-info-order', [HomeController::class, 'check_info_order']); //Người dùng là khách vãn lai
Route::get('/thong-tin-don-hang', [HomeController::class, 'info_order']);
Route::get('/don-hang-trong', [HomeController::class, 'order_empty']);
Route::get('/update-order', [HomeController::class, 'update_order']);

Route::get('/view-order-old', [HomeController::class, 'view_order_old']);
Route::get('/load-order-old', [HomeController::class, 'load_order_old']);
Route::get('/load-view-order', [HomeController::class, 'load_view_order']);
Route::get('/cancel-order', [HomeController::class, 'cancel_order']);
Route::get('/delete-order', [HomeController::class, 'delete_order']);

Route::get('chi-tiet-mon', [HomeController::class, 'detail_food']);









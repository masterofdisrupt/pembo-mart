<?php

use App\Http\Controllers\Backend\V1\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Backend\V1\AdminController;
use App\Http\Controllers\Backend\V1\AgentController;
use App\Http\Controllers\Backend\V1\EmailController;
use App\Http\Controllers\Backend\V1\UserTimeController;
use App\Http\Controllers\Backend\V1\NotificationController;
use App\Http\Controllers\Backend\V1\QRCodeController;
use App\Http\Controllers\Backend\V1\ProductController;
use App\Http\Controllers\Backend\V1\SMTPController;
use App\Http\Controllers\Backend\V1\ColourController;
use App\Http\Controllers\Backend\V1\OrdersController;
use App\Http\Controllers\Backend\V1\BlogController;
use App\Http\Controllers\Backend\V1\LocationController;
use App\Http\Controllers\Backend\V1\SendPDFController;
use App\Http\Controllers\Backend\V1\TransactionsController;
use App\Http\Controllers\Backend\V1\FullCalendarController;
use App\Http\Controllers\Backend\V1\DiscountCodeController;
use App\Http\Controllers\Backend\V1\SupportsController;
use App\Http\Controllers\Backend\V1\CategoryController;
use App\Http\Controllers\Backend\V1\SubCategoryController;
use App\Http\Controllers\Backend\V1\BrandsController;
use App\Http\Controllers\Backend\V1\ShippingChargesController;
use App\Http\Controllers\Backend\V1\PagesController;
use App\Http\Controllers\Backend\V1\SliderController;
use App\Http\Controllers\Backend\V1\PartnerController;
use App\Http\Controllers\Backend\V1\BlogCategoryController;
use App\Http\Controllers\ProductController as FrontendProductController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;



Route::get('/login', [AuthController::class, 'showLogin'])->name('show.login');
Route::post('/login', [AuthController::class, 'authLogin'])->name('login');

Route::get('forgot', [AuthController::class, 'forgot'])->name('forgot');
Route::post('forgot', [AuthController::class, 'forgotPassword']);
Route::get('reset/{token}', [AuthController::class, 'reset']);
Route::post('reset/{token}', [AuthController::class, 'postReset']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::get('set_new_password/{token}', [AuthController::class, 'set_new_password'])->name('show.set.new.password');
Route::post('set_new_password/{token}', [AuthController::class, 'new_password_store'])->name('set.new.password');





Route::group(['middleware' => 'admin'], function () {
    Route::get('admin/dashboard', [DashboardController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('admin/profile', [AdminController::class, 'profile'])->name('admin.profile');
    Route::post('admin_profile/update', [AdminController::class, 'profile_update']);
    Route::get('admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('admin/users/view/{id}', [AdminController::class, 'view_users'])->name('admin.users.view');

    Route::get('admin/users/add', [AdminController::class, 'admin_add_users'])->name('admin.add.users');
    Route::post('admin/users/add', [AdminController::class, 'add_users_store'])->name('add.users.store');
    Route::get('admin/users/edit/{id}', [AdminController::class, 'admin_users_edit'])->name('admin.users.edit');
    Route::put('admin/users/edit/{id}', [AdminController::class, 'admin_users_edit_update'])->name('admin.users.edit.update');
    Route::delete('admin/users/delete/{id}', [AdminController::class, 'admin_users_delete'])->name('admin.users.delete');
    Route::post('admin/users/update', [AdminController::class, 'admin_users_update'])->name('admin.users.update');
    Route::get('admin/users/changeStatus', [AdminController::class, 'admin_users_changeStatus'])->name('admin.users.change.status');
    Route::post('checkemail', [AdminController::class, 'checkEmail'])->name('check.email');

    Route::get('admin/customer/list', [AdminController::class, 'customer_list'])->name('admin.customers');

    // Change Password
    Route::get('admin/change_password', [AdminController::class, 'change_password'])->name('change.password');
    Route::put('admin/change_password/update', [AdminController::class, 'update_password'])->name('update.password');


    Route::get('admin/email/compose', [EmailController::class, 'email_compose']);
    Route::post('admin/email/post', [EmailController::class, 'email_store']);
    Route::get('admin/email/sent', [EmailController::class, 'email_sent'])->name('email.send');
    Route::delete('admin/email_sent', [EmailController::class, 'sent_delete'])->name('sent.delete');
    Route::get('admin/email/read/{id}', [EmailController::class, 'email_read'])->name('email.read');
    Route::get('admin/email/read_delete/{id}', [EmailController::class, 'read_delete'])->name('read.delete');

    // User Week Start
    Route::get('admin/week', [UserTimeController::class, 'week_list'])->name('week.list');
    Route::get('admin/week/add', [UserTimeController::class, 'week_add'])->name('week.add');
    Route::post('admin/week/add', [UserTimeController::class, 'week_store'])->name('week.add.store');
    Route::get('admin/week/edit/{id}', [UserTimeController::class, 'week_edit'])->name('week.edit');
    Route::post('admin/week/edit/{id}', [UserTimeController::class, 'week_update'])->name('week.edit.update');
    Route::delete('admin/week/delete/{id}', [UserTimeController::class, 'week_delete'])->name('week.delete');

    // User Week End

    // User Week Time Start
    Route::get('admin/week_time', [UserTimeController::class, 'week_time_list'])->name('week.time.list');
    Route::get('admin/week_time/add', [UserTimeController::class, 'week_time_add'])->name('week.time.add');
    Route::post('admin/week_time/add', [UserTimeController::class, 'week_time_store'])->name('week.time.add.store');
    Route::get('admin/week_time/edit/{id}', [UserTimeController::class, 'week_time_edit'])->name('week.time.edit');
    Route::post('admin/week_time/edit/{id}', [UserTimeController::class, 'week_time_update'])->name('week.time.edit.update');
    Route::delete('admin/week_time/delete/{id}', [UserTimeController::class, 'week_time_delete'])->name('week.time.delete');
    // User Week Time End

    // Schedule Start
    Route::get('admin/schedule', [UserTimeController::class, 'admin_schedule'])->name('admin.schedule');
    Route::post('admin/schedule', [UserTimeController::class, 'admin_schedule_update'])->name('admin.schedule.update');
    // Schedule End

    // AutoComplete Search
    Route::get('admin/users/typeahead_autocomplete', [AdminController::class, 'typeahead_autocomplete'])->name('typeahead.autocomplete');

    // Full Calendar Start
    Route::get('admin/full_calendar', [FullCalendarController::class, 'full_calendar'])->name('fullCalendar');
    Route::post('admin/full_calendar/action', [FullCalendarController::class, 'action'])->name('fullCalendar.action');

    // Notification Start
    Route::get('admin/notification', [NotificationController::class, 'notification_index'])->name('notification');
    Route::post('admin/notification_send', [NotificationController::class, 'notification_send'])->name('notification.send');
    // Notification End

    // Category Start
    Route::get('admin/category', [CategoryController::class, 'category_list'])->name('category');
    Route::get('admin/category/add', [CategoryController::class, 'add_category'])->name('category.add');
    Route::post('admin/category/add', [CategoryController::class, 'store_category'])->name('category.store');
    Route::get('admin/category/edit/{id}', [CategoryController::class, 'edit_category'])->name('category.edit');
    Route::put('admin/category/edit/{id}', [CategoryController::class, 'update_category'])->name('category.update');
    Route::delete('admin/category/delete/{id}', [CategoryController::class, 'delete_category'])->name('category.delete');
    // Category End

    // Sub Category Start
    Route::get('admin/sub_category', [SubCategoryController::class, 'sub_category'])->name('sub.category');
    Route::get('admin/sub_category/add', [SubCategoryController::class, 'sub_category_add'])->name('sub.category.add');
    Route::post('admin/sub_category/add', [SubCategoryController::class, 'sub_category_store'])->name('sub.category.store');
    Route::get('admin/sub_category/edit/{id}', [SubCategoryController::class, 'sub_category_edit'])->name('sub.category.edit');
    Route::put('admin/sub_category/edit/{id}', [SubCategoryController::class, 'sub_category_update'])->name('sub.category.update');
    Route::delete('admin/sub_category/delete/{id}', [SubCategoryController::class, 'sub_category_delete'])->name('sub.category.delete');

    Route::post('admin/get_sub_categories', [SubCategoryController::class, 'get_sub_categories'])->name('get.sub.categories');


    // Sub Category End

    // Brands Start
    Route::get('admin/brands', [BrandsController::class, 'index'])->name('brands');
    Route::get('admin/brands/add', [BrandsController::class, 'create'])->name('brands.add');
    Route::post('admin/brands/add', [BrandsController::class, 'store'])->name('brands.store');
    Route::get('admin/brands/edit/{id}', [BrandsController::class, 'edit'])->name('brands.edit');
    Route::put('admin/brands/edit/{id}', [BrandsController::class, 'update'])->name('brands.update');
    Route::delete('admin/brands/delete/{id}', [BrandsController::class, 'delete'])->name('brands.delete');
    // Brands End    

    // Product Start
    Route::get('admin/product', [ProductController::class, 'list'])->name('product');
    Route::get('admin/product/add', [ProductController::class, 'add_product'])->name('product.add');
    Route::post('admin/product/add', [ProductController::class, 'store_product'])->name('product.store');
    Route::get('admin/product/edit/{id}', [ProductController::class, 'edit_product'])->name('product.edit');
    Route::put('admin/product/edit/{id}', [ProductController::class, 'update_product'])->name('product.update');
    Route::delete('admin/product/delete/{id}', [ProductController::class, 'delete_product'])->name('product.delete');

    Route::delete('/admin/product/image/{id}', [ProductController::class, 'deleteImage']);
    Route::post('/admin/product_image_sort', [ProductController::class, 'product_image_sort'])->name('product.image.sort');

    // Product End

    // SMTP Start
    Route::get('admin/smtp', [SMTPController::class, 'smtp_list'])->name('smtp');
    Route::put('admin/smtp_update', [SMTPController::class, 'smtp_update'])->name('smtp.update');
    // SMTP End

    // Colour Start
    Route::get('admin/colour', [ColourController::class, 'colour_list'])->name('colour');
    Route::get('admin/colour/add', [ColourController::class, 'add_colour'])->name('colour.add');
    Route::post('admin/colour/add', [ColourController::class, 'store_colour'])->name('colour.store');
    Route::get('admin/colour/edit/{id}', [ColourController::class, 'edit_colour'])->name('colour.edit');
    Route::put('admin/colour/edit/{id}', [ColourController::class, 'update_colour'])->name('colour.update');
    Route::delete('admin/colour/delete/{id}', [ColourController::class, 'delete_colour'])->name('colour.delete');
    Route::post('admin/colour/change_status', [ColourController::class, 'change_status'])->name('colour.change_status');
    // Colour End

    // Order Start
    Route::post('admin/update_order_status', [OrdersController::class, 'update_order_status'])->name('update.order.status');
    Route::get('admin/orders', [OrdersController::class, 'list_orders'])->name('orders');
    Route::get('admin/orders/add', [OrdersController::class, 'add_orders'])->name('add.orders');
    Route::post('admin/orders/add', [OrdersController::class, 'store_orders'])->name('store.orders');
    Route::get('admin/orders/edit/{id}', [OrdersController::class, 'edit_orders'])->name('edit.orders');
    Route::put('admin/orders/edit/{id}', [OrdersController::class, 'update_orders'])->name('update.orders');
    Route::get('admin/orders/view/{id}', [OrdersController::class, 'view_orders'])->name('view.orders');
    Route::delete('admin/orders/delete/{id}', [OrdersController::class, 'delete_orders'])->name('delete.orders');
    // Order End

    // Discount Code
    Route::get('admin/discount_code', [DiscountCodeController::class, 'discount_code'])->name('discount.code');
    Route::get('admin/discount_code/add', [DiscountCodeController::class, 'discount_code_add'])->name('discount.code.add');
    Route::post('admin/discount_code/add', [DiscountCodeController::class, 'discount_code_store'])->name('discount.code.store');
    Route::get('admin/discount_code/edit/{id}', [DiscountCodeController::class, 'discount_code_edit'])->name('discount.code.edit');
    Route::put('admin/discount_code/edit/{id}', [DiscountCodeController::class, 'discount_code_update'])->name('discount.code.update');
    Route::delete('admin/discount_code/delete/{id}', [DiscountCodeController::class, 'discount_code_delete'])->name('discount.code.delete');

    // Shipping Charge
    Route::get('admin/shipping_charge', [ShippingChargesController::class, 'shipping_charges'])->name('shipping.charge');
    Route::get('admin/shipping_charge/add', [ShippingChargesController::class, 'add_shipping_charges'])->name('shipping.charge.add');
    Route::post('admin/shipping_charge/add', [ShippingChargesController::class, 'store_shipping_charges'])->name('shipping.charge.store');
    Route::get('admin/shipping_charge/edit/{id}', [ShippingChargesController::class, 'edit_shipping_charges'])->name('shipping.charge.edit');
    Route::put('admin/shipping_charge/edit/{id}', [ShippingChargesController::class, 'update_shipping_charges'])->name('shipping.charge.update');
    Route::delete('admin/shipping_charge/delete/{id}', [ShippingChargesController::class, 'delete_shipping_charges'])->name('shipping.charge.delete');

    // Slider
    Route::get('admin/slider', [SliderController::class, 'index'])->name('admin.slider');
    Route::get('admin/slider/add', [SliderController::class, 'add'])->name('add.slider');
    Route::post('admin/slider/add', [SliderController::class, 'store'])->name('slider.store');
    Route::get('admin/slider/edit/{id}', [SliderController::class, 'edit'])->name('edit.slider');
    Route::put('admin/slider/edit/{id}', [SliderController::class, 'update'])->name('update.slider');
    Route::delete('admin/slider/delete/{id}', [SliderController::class, 'delete'])->name('delete.slider');

    // Support Start
    Route::get('admin/support', [SupportsController::class, 'supports'])->name('supports');
    Route::get('admin/support/reply/{id}', [SupportsController::class, 'support_reply'])->name('support.reply');
    Route::post('admin/support/reply/{id}', [SupportsController::class, 'reply_store'])->name('support.reply.store');
    Route::get('admin/change_support_status', [SupportsController::class, 'change_support_status'])->name('change.support.status');
    Route::get('admin/support/status_update/{id}', [SupportsController::class, 'status_update'])->name('support.status.update');
    Route::delete('admin/support/delete_multi_item', [SupportsController::class, 'delete_multi_item'])->name('support.delete.multi.item');


    // Blog Start
    Route::get('admin/blogs', [BlogController::class, 'index'])->name('blog');
    Route::get('admin/blog/sadd', [BlogController::class, 'create'])->name('add.blog');
    Route::post('admin/blogs/add', [BlogController::class, 'store'])->name('store.blog');
    Route::get('admin/blogs/edit/{id}', [BlogController::class, 'edit'])->name('edit.blog');
    Route::put('admin/blogs/edit/{id}', [BlogController::class, 'update'])->name('update.blog');
    Route::get('admin/blogs/view/{id}', [BlogController::class, 'view'])->name('view.blog');
    Route::delete('admin/blogs/delete/{id}', [BlogController::class, 'delete'])->name('delete.blog');
    // Blog End

    // Blog Delete All
    Route::get('admin/blogs/truncate', [BlogController::class, 'truncate'])->name('blogs.truncate');

    // Blog Category
    Route::get('admin/blog_category', [BlogCategoryController::class, 'index'])->name('blog.category');
    Route::get('admin/blog_category/add', [BlogCategoryController::class, 'create'])->name('blog.category.add');
    Route::post('admin/blog_category/add', [BlogCategoryController::class, 'store'])->name('blog.category.store');
    Route::get('admin/blog_category/edit/{id}', [BlogCategoryController::class, 'edit'])->name('blog.category.edit');
    Route::put('admin/blog_category/edit/{id}', [BlogCategoryController::class, 'update'])->name('blog.category.update');
    Route::delete('admin/blog_category/delete/{id}', [BlogCategoryController::class, 'destroy'])->name('blog.category.delete');
    // Blog Category End

    // Transactions Start
    Route::get('admin/transactions', [TransactionsController::class, 'transactions_index'])->name('transactions');
    Route::get('admin/transactions/edit/{id}', [TransactionsController::class, 'transactions_edit'])->name('transactions.edit');
    Route::put('admin/transactions/update/{id}', [TransactionsController::class, 'transactions_update'])->name('transactions.update');
    Route::delete('admin/transactions/delete/{id}', [TransactionsController::class, 'transactions_delete'])->name('transactions.delete');
    // Transactions End

    // PDF Start
    Route::get('admin/pdf', [ColourController::class, 'pdf'])->name('pdf');
    Route::get('admin/pdf_colour', [ColourController::class, 'pdf_colour'])->name('pdf.colour');
    Route::get('admin/colour/pdf/{id}', [ColourController::class, 'pdf_by_id'])->name('pdf.by.id');
    // PDF End

    // Send PDF
    Route::get('admin/send_pdf', [SendPDFController::class, 'send_pdf'])->name('send.pdf');
    Route::post('admin/send_pdf_sent', [SendPDFController::class, 'send_pdf_sent'])->name('send.pdf.sent');
    // Send PDF End

    // Address Start
    Route::get('admin/countries', [LocationController::class, 'countries_index'])->name('countries');
    Route::get('admin/countries/add', [LocationController::class, 'countries_add'])->name('countries.add');
    Route::post('admin/countries/add', [LocationController::class, 'countries_store'])->name('countries.store');
    Route::get('admin/countries/edit/{id}', [LocationController::class, 'countries_edit'])->name('countries.edit');
    Route::put('admin/countries/edit/{id}', [LocationController::class, 'countries_update'])->name('countries.update');
    Route::delete('admin/countries/delete/{id}', [LocationController::class, 'countries_delete'])->name('countries.delete');

    Route::get('admin/states', [LocationController::class, 'states_index'])->name('states');
    Route::get('admin/states/add', [LocationController::class, 'states_add'])->name('add.states');
    Route::post('admin/states/add', [LocationController::class, 'states_store'])->name('store.states');
    Route::get('admin/states/edit/{id}', [LocationController::class, 'states_edit'])->name('edit.states');
    Route::put('admin/states/edit/{id}', [LocationController::class, 'states_update'])->name('update.states');
    Route::delete('admin/states/delete/{id}', [LocationController::class, 'states_delete'])->name('delete.states');

    Route::get('admin/cities', [LocationController::class, 'cities_index'])->name('cities');
    Route::get('admin/cities/add', [LocationController::class, 'cities_add'])->name('add.cities');
    Route::get('get-states-record/{countryId}', [LocationController::class, 'get_state_name'])->name('get.state.name');
    Route::post('admin/cities/add', [LocationController::class, 'cities_store'])->name('store.cities');
    Route::get('admin/cities/edit/{id}', [LocationController::class, 'cities_edit'])->name('edit.cities');
    Route::put('admin/cities/edit/{id}', [LocationController::class, 'cities_update'])->name('update.cities');
    Route::delete('admin/cities/delete/{id}', [LocationController::class, 'cities_delete'])->name('delete.cities');

    // Address End

    // address menu start
    Route::get('admin/address', [LocationController::class, 'admin_address'])->name('admin.address');
    Route::get('admin/address/add', [LocationController::class, 'admin_address_add'])->name('admin.address.add');
    Route::get('get-states/{countryId}', [LocationController::class, 'get_states'])->name('get.states');
    Route::get('get-cities/{stateId}', [LocationController::class, 'get_cities'])->name('get.cities');
    Route::post('admin/address/add', [LocationController::class, 'admin_address_store'])->name('admin.address.store');
    Route::get('admin/address/edit/{id}', [LocationController::class, 'admin_address_edit'])->name('admin.address.edit');
    Route::put('admin/address/edit/{id}', [LocationController::class, 'admin_address_update'])->name('admin.address.update');
    Route::delete('admin/address/delete/{id}', [LocationController::class, 'admin_address_delete'])->name('admin.address.delete');
    // address menu end

    // Pages start 
    Route::get('admin/pages', [PagesController::class, 'index'])->name('admin.pages');
    Route::get('admin/pages/edit/{id}', [PagesController::class, 'edit'])->name('pages.edit');
    Route::put('admin/pages/edit/{id}', [PagesController::class, 'update'])->name('pages.update');

    Route::get('admin/system-setting', [PagesController::class, 'system_setting'])->name('system.setting');
    Route::post('admin/system-setting', [PagesController::class, 'update_system_setting'])->name('upadate.system.setting');

    Route::get('admin/payment-setting', [PagesController::class, 'payment_system'])->name('payment.setting');
    Route::post('admin/payment-setting', [PagesController::class, 'update_payment_setting'])->name('update.payment.setting');

    Route::get('admin/home-setting', [PagesController::class, 'home_setting'])->name('home.setting');
    Route::post('admin/home-setting', [PagesController::class, 'update_home_setting'])->name('update.home.setting');
    // Pages end 

    // Partner Logo
    Route::get('admin/partner', [PartnerController::class, 'index'])->name('partner');
    Route::get('admin/partner/add', [PartnerController::class, 'add'])->name('add.partner');
    Route::post('admin/partner/add', [PartnerController::class, 'store'])->name('store.partner');
    Route::get('admin/partner/edit/{id}', [PartnerController::class, 'edit'])->name('edit.partner');
    Route::put('admin/partner/edit/{id}', [PartnerController::class, 'update'])->name('update.partner');
    Route::delete('admin/partner/delete/{id}', [PartnerController::class, 'delete'])->name('delete.partner');

    Route::get('admin/contact-us', [PagesController::class, 'contactUs'])->name('admin.contact.us');
    Route::delete('admin/contact-us/delete/{id}', [PagesController::class, 'contactUsDelete'])->name('contact.us.delete');

    Route::get('admin/notification/list', [PagesController::class, 'notification'])->name('admin.notification');


    // Personal profile edit
    Route::get('admin/my_profile', [AdminController::class, 'my_profile'])->name('admin.my.profile');
    Route::post('admin/my_profile/update', [AdminController::class, 'my_profile_update'])->name('admin.my.profile.update');


});


Route::group(['middleware' => 'agent'], function () {
    Route::get('agent/dashboard', [DashboardController::class, 'dashboard'])->name('agent.dashboard');

    Route::get('agent/email/inbox', [AgentController::class, 'agent_email_inbox'])->name('agent.email.inbox');

    // Agent Transactions Start
    Route::get('agent/transactions', [TransactionsController::class, 'agent_transactions_add'])->name('agent.transactions');
    Route::post('agent/transactions/add', [TransactionsController::class, 'agent_transactions_store'])->name('agent.transactions.store');
    Route::get('agent/transactions/list', [TransactionsController::class, 'agent_transactions_list'])->name('agent.transactions.list');

    Route::delete('transactions_delete/{id}', [TransactionsController::class, 'destroy'])->name('transactions.destroy');

});

Route::middleware(['auth'])->group(function () {
    Route::get('user/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');

    Route::get('user/wallet', [UserController::class, 'wallet'])->name('user.wallet');
    Route::get('wallet.topup', [UserController::class, 'wallet_topup'])->name('user.wallet.topup');
    Route::post('user/wallet/topup', [UserController::class, 'wallet_topup_post'])->name('user.wallet.topup.post');
    Route::get('user/wallet/transactions', [UserController::class, 'wallet_transactions'])->name('user.wallet.transactions');
    Route::get('user.wallet.withdraw', [UserController::class, 'wallet_withdraw'])->name('user.wallet.withdraw');

    Route::get('user/orders', [UserController::class, 'orders'])->name('user.orders');
    Route::get('user/orders/view/{id}', [UserController::class, 'viewOrder'])->name('user.orders.view');

    Route::get('user/edit-profile', [UserController::class, 'profile'])->name('user.edit.profile');
    Route::post('user/edit-profile', [UserController::class, 'profileUpdate'])->name('user.update.profile');

    Route::get('user/notifications', [UserController::class, 'notification'])->name('user.notification');

    Route::get('user/change-password', [UserController::class, 'changePassword'])->name('user.change.password');
    Route::post('user/change-password', [UserController::class, 'updatePassword'])->name('user.update.password');

    Route::post('wishlist/add', [UserController::class, 'addToWishlist'])->name('wishlist.add');
    Route::post('user/make-review', [UserController::class, 'makeReview'])->name('user.make.review');

    Route::get('my/wishlist', [FrontendProductController::class, 'myWishlist'])->name('my.wishlist');

    Route::post('blogs/submit-comment', [HomeController::class, 'submitComment'])->name('blogs.submit.comment');
});

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('recent-arrivals', [HomeController::class, 'recentArrivals'])->name('recent.arrivals');

Route::get('contact', [HomeController::class, 'contact'])->name('contact.us');
Route::post('contact', [HomeController::class, 'submitContact'])->name('submit.contact');

Route::get('about', [HomeController::class, 'about'])->name('about.us');
Route::get('blogs', [HomeController::class, 'blogs'])->name('blogs');
Route::get('blog/category/{slug}', [HomeController::class, 'blogCategory'])->name('blogs.category');
Route::get('blogs/{slug}', [HomeController::class, 'blogDetail'])->name('blogs.detail');
Route::get('faq', [HomeController::class, 'faq'])->name('faq');

Route::get('payment-methods', [HomeController::class, 'paymentMethod'])->name('payment.methods');
Route::get('money-back-guarantee', [HomeController::class, 'moneyBackGuarantee'])->name('money.back.guarantee');
Route::get('returns', [HomeController::class, 'return'])->name('returns');
Route::get('shipping', [HomeController::class, 'shipping'])->name('shipping');
Route::get('terms-and-conditions', [HomeController::class, 'termsCondition'])->name('terms.and.conditions');
Route::get('privacy-policy', [HomeController::class, 'privacyPolicy'])->name('privacy.policy');

Route::post('register', [AuthController::class, 'showRegister'])->name('register');
Route::post('signin', [AuthController::class, 'showSignin'])->name('signin');

Route::get('forgot-password', [AuthController::class, 'forgot_password'])->name('forgot.password');
Route::post('forgot-password', [AuthController::class, 'forgot_password_post'])->name('forgot.password.post');

Route::get('reset_password/{token}', [AuthController::class, 'reset_password'])->name('reset.password');
Route::post('reset_password/{token}', [AuthController::class, 'reset_password_post'])->name('reset.password.post');
Route::get('activate_email/{id}', [AuthController::class, 'activateEmail'])->where('id', '.*')->name('activate');

Route::get('search', [FrontendProductController::class, 'search'])->name('search');
Route::post('products_filter', [FrontendProductController::class, 'products_filter'])->name('products.filter');
Route::post('products/load-more', [FrontendProductController::class, 'loadMore'])
    ->name('products.load-more');

// Payment
Route::get('cart', [PaymentController::class, 'cart'])
    ->name('cart');
Route::delete('delete_cart_item/{rowId}', [PaymentController::class, 'deleteCartItem'])
    ->name('delete.cart.item');   
Route::post('products/add-to-cart', [PaymentController::class, 'addToCart'])
    ->name('products.add-to-cart');
Route::post('update.cart', [PaymentController::class, 'updateCart'])
    ->name('update.cart');


Route::get('checkout', [PaymentController::class, 'checkout'])
    ->name('checkout');
Route::post('checkout/place_order', [PaymentController::class, 'placeOrder'])
    ->name('checkout.place.order');
Route::get('checkout/success/{encoded}', [PaymentController::class, 'orderSuccess'])->name('order.success');


Route::post('apply-discount', [PaymentController::class, 'applyDiscount'])
    ->name('apply.discount');




// Dynamic catch-all routes
Route::get('/product/{slug}', [FrontendProductController::class, 'productDetails'])
    ->name('product.details');

Route::get('{category?}/{subCategory?}', [FrontendProductController::class, 'getCategory'])
    ->where([
        'category' => '[A-Za-z0-9\-]+',
        'subCategory' => '[A-Za-z0-9\-]+',
    ])
    ->name('get.category');



<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Pages;
use App\Models\SystemSetting;
use App\Models\ContactUs;
use App\Models\Slider;
use App\Models\Partner;
use App\Models\Backend\V1\CategoryModel;
use App\Models\Backend\V1\ProductModel;
use App\Models\Backend\V1\BlogModel; 
use App\Models\Backend\V1\BlogCategoryModel;
use App\Models\BlogComment;
use App\Mail\ContactUsMail;
use Session;
use Auth;
use Mail;

class HomeController extends Controller
{
    public function index()
{
    $getPages = Pages::getSlug('home');
    $getBlog = BlogModel::getActiveHomeRecords();
    $getSlider = Slider::getActiveRecords();
    $getPartners = Partner::getActiveRecords();
    $getCategory = CategoryModel::getCategoryStatusHome();
    $getProduct = ProductModel::getRecentArrivals();
    $getTrendyProduct = ProductModel::getTrendyProducts();

    return view('home', [
        'getSlider' => $getSlider,
        'getPages' => $getPages,
        'getBlog' => $getBlog,
        'getPartners' => $getPartners,
        'getCategory' => $getCategory,
        'getProduct' => $getProduct,
        'getTrendyProduct' => $getTrendyProduct,
    ]);
}

public function recentArrivals(Request $request)
{
    $categoryId = $request->category_id; 

    $getProduct = ProductModel::getRecentArrivals($categoryId);

    $getCategory = CategoryModel::getRecordById($categoryId);

    return response()->json([
        'status' => true,
        'message' => 'Recent arrivals fetched successfully.',
        'success' => view('products._list_recent_arrivals', [
            'getProduct' => $getProduct,
            'getCategory' => $getCategory,
        ])->render(),
    ], 200);
}

   public function contact()
{
    $first_number = rand(1, 9);
    $second_number = rand(1, 9);

    Session::put('total_number', $first_number + $second_number);

    $getPages = Pages::getSlug('contact');
    $getSystemSettingApp = SystemSetting::getSingleRecord();

    return view('pages.contact', compact('getPages', 'getSystemSettingApp', 'first_number', 'second_number'));
}

public function submitContact(Request $request)
{
    $expectedAnswer = Session::get('total_number');

    if (empty($request->verification) || $expectedAnswer === null) {
        Session::flash('error', 'Please complete the verification to submit your message.');
        return redirect()->back();
    }

    if ((int) $request->verification !== $expectedAnswer) {
        Session::flash('error', 'Verification failed. Please try again.');
        return redirect()->back();
    }

    $contact = new ContactUs();
    if (Auth::check()) {
        $contact->user_id = Auth::id();
    }

    $contact->name = $request->name;
    $contact->email = $request->email;
    $contact->subject = $request->subject;
    $contact->message = $request->message;
    $contact->save();

    $getSystemSetting = SystemSetting::getSingleRecord();
    if (!empty($getSystemSetting->contact_email)) {
        Mail::to($getSystemSetting->contact_email)->send(new ContactUsMail($contact));
    }

    Session::flash('success', 'Your message has been sent successfully.');
    return redirect()->back();
}


    public function about()
    {
        $getPages = Pages::getSlug('about');

        return view('pages.about', compact('getPages'));
    }

    public function faq()
    {
        $getPages = Pages::getSlug('faq'); 
        return view('pages.faq', [
            'getPages' => $getPages,
        ]);
    }

    public function paymentMethod()
    {
        $getPages = Pages::getSlug('payment-methods');
        return view('pages.payment_methods', compact('getPages'));
    }

    public function moneyBackGuarantee()
    {
        $getPages = Pages::getSlug('money-back-guarantee');

        return view('pages.money_back_guarantee', compact('getPages'));
    }

    public function return()
    {
        $getPages = Pages::getSlug('returns');

        return view('pages.returns', compact('getPages'));
    }

    public function shipping()
    {
        $getPages = Pages::getSlug('shipping');

        return view('pages.shipping', compact('getPages'));
    }

    public function termsCondition()
    {
        $getPages = Pages::getSlug('terms-and-conditions');

        return view('pages.terms_and_conditions', compact('getPages'));
    }

    public function privacyPolicy()
    {
        $getPages = Pages::getSlug('privacy-policy');

        return view('pages.privacy_policy', compact('getPages'));
    }

    public function blogs()
    {
        $getPages = Pages::getSlug('blog');
        $getBlog = BlogModel::getBlog();
        $getBlogCategory = BlogCategoryModel::getActiveRecords();
        $getPopular = BlogModel::getPopularBlogs();

        return view('blogs.list', [
            'getPages' => $getPages,
            'getBlog' => $getBlog,
            'getBlogCategory' => $getBlogCategory,
            'getPopular' => $getPopular,
        ]);
    }

    public function blogDetail($slug)
    {
        $getBlog = BlogModel::getRecordBySlug($slug);
        if (empty($getBlog)) {
            abort(404);
        }

        $getBlog->increment('total_views');


        $getPages = Pages::getSlug('blog');
        $getBlogCategory = BlogCategoryModel::getActiveRecords();
        $getPopular = BlogModel::getPopularBlogs();
        $getRelatedPost = BlogModel::getRelatedPosts($getBlog->blog_category_id, $getBlog->id);

        return view('blogs.detail', [
            'getPages' => $getPages,
            'getBlog' => $getBlog,
            'getBlogCategory' => $getBlogCategory,
            'getPopular' => $getPopular,
            'getRelatedPost' => $getRelatedPost,
        ]);
    }

    public function blogCategory($slug)
    {
        $getCategory = BlogCategoryModel::getRecordBySlug($slug);
        if (empty($getCategory)) {
            abort(404);
        }

        $getBlogCategory = BlogCategoryModel::getActiveRecords();
        $getBlog = BlogModel::getBlog($getCategory->id);
        $getPopular = BlogModel::getPopularBlogs();

        return view('blogs.category', [
            'getBlog' => $getBlog,
            'getBlogCategory' => $getBlogCategory,
            'getPopular' => $getPopular,
            'getCategory' => $getCategory,
        ]);
    }

    public function submitComment(Request $request)
    {
        $request->validate([
            'blog_id' => 'required|exists:blog,id',
            'comment' => 'required|string',
        ]);

        $comment = new BlogComment();
        $comment->blog_id = $request->blog_id;
        $comment->user_id = Auth::check() ? Auth::id() : null; 
        $comment->comment = trim($request->comment);
        $comment->save();

        Session::flash('success', 'Your comment has been submitted successfully.');
        return redirect()->back();
    }

}

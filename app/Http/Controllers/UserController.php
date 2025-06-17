<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Backend\V1\OrdersModel;
use App\Models\User;
use App\Models\ProductWishlists;
use App\Models\ProductReviews;
use App\Models\Backend\V1\ProductModel;
use App\Models\Backend\V1\NotificationModel;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
   public function dashboard()
{
    $metaData = [
        'meta_title' => 'Dashboard',
        'meta_description' => '',
        'meta_keywords' => '',
    ];

    
    $totalOrders =  OrdersModel::userTotalOrders(Auth::id()); 
    $todayOrders = OrdersModel::userTodayOrders(Auth::id());
    $totalAmount = OrdersModel::userTotalAmount(Auth::id());
    $todayAmount =  OrdersModel::userTodayAmount(Auth::id());

    $pendingOrders = OrdersModel::userPendingOrders(Auth::id(), 0);
    $processingOrders = OrdersModel::userProcessingOrders(Auth::id(), 1);
    $completedOrders = OrdersModel::userCompletedOrders(Auth::id(), 3);
    $canceledOrders = OrdersModel::userCanceledOrders(Auth::id(), 4);

    $metrics = [
        ['label' => 'Total Orders',      'value' => $totalOrders],
        ['label' => 'Today Orders',      'value' => $todayOrders],
        ['label' => 'Total Amount',      'value' => $totalAmount, 'formatted' => number_format($totalAmount, 2)],
        ['label' => 'Today Amount',      'value' => $todayAmount, 'formatted' => number_format($todayAmount, 2)],
        ['label' => 'Pending Orders',    'value' => $pendingOrders],
        ['label' => 'Processing Orders','value' => $processingOrders],
        ['label' => 'Completed Orders',  'value' => $completedOrders],
        ['label' => 'Canceled Orders',   'value' => $canceledOrders],
    ];

    return view('user.dashboard', array_merge($metaData, [
    'metrics' => $metrics,
]));

}


    public function orders(Request $request)
    {
        if ($request->filled('notif_id')) {
            $notification = NotificationModel::find($request->notif_id);

            if ($notification) {
                $notification->update(['is_read' => 1]);
            }
        }

        $getOrders = OrdersModel::getUserOrders(Auth::id());
        $metaData = [
            'meta_title' => 'Orders',
            'meta_description' => '',
            'meta_keywords' => '',
        ];

        return view('user.orders', 
            [
                'meta_title' => $metaData['meta_title'],
                'meta_description' => $metaData['meta_description'],
                'meta_keywords' => $metaData['meta_keywords'],
                'getOrders' => $getOrders,
            ]
        );
    }

    public function profile()
    {
        $getRecord = User::find(Auth::id());
        $metaData = [
            'meta_title' => 'Edit Profile',
            'meta_description' => '',
            'meta_keywords' => '',
        ];

        return view('user.profile', 
            [
                'meta_title' => $metaData['meta_title'],
                'meta_description' => $metaData['meta_description'],
                'meta_keywords' => $metaData['meta_keywords'],
                'getRecord' => $getRecord,
            ]
        );
    }

    public function profileUpdate(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
        ]);

        $user = Auth::user();
        $user->name = $request->input('first_name');
        $user->surname = $request->input('last_name');
        $user->email = $request->input('email');
        $user->company_name = $request->input('company_name', ''); 
        $user->address = $request->input('address_one', ''); 
        $user->address_two = $request->input('address_two', '');
        $user->city = $request->input('city', ''); 
        $user->state = $request->input('state', ''); 
        $user->country = $request->input('country', ''); 
        $user->postcode = $request->input('postcode', ''); 
        $user->phone = $request->input('phone');
        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }

    public function notification(Request $request)
    {
        $metaData = [
            'meta_title' => 'Notifications',
            'meta_description' => '',
            'meta_keywords' => '',
        ];
        $getRecord = NotificationModel::getRecordUser(Auth::id());
        return view('user.notification', 
            [
                'meta_title' => $metaData['meta_title'],
                'meta_description' => $metaData['meta_description'],
                'meta_keywords' => $metaData['meta_keywords'],
                'getRecord' => $getRecord,
            ]
        );
    }


    public function changePassword()
    {
        $metaData = [
            'meta_title' => 'Change Password',
            'meta_description' => '',
            'meta_keywords' => '',
        ];

        return view('user.change_password', 
            [
                'meta_title' => $metaData['meta_title'],
                'meta_description' => $metaData['meta_description'],
                'meta_keywords' => $metaData['meta_keywords'],
            ]
        );
    }

    public function updatePassword(Request $request)
{
    $request->validate([
        'current_password' => 'required|string',
        'password' => 'required|string|min:8|confirmed',
    ]);

    $user = Auth::user();

    if (!Hash::check($request->current_password, $user->password)) {
        return back()->withErrors(['current_password' => 'Old password is incorrect.']);
    }

    $user->password = Hash::make($request->password);
    $user->save();

    return redirect()->back()->with('success', 'Password updated successfully.');
}


    public function wallet()
{
    $metaData = [
        'meta_title' => 'Wallet',
        'meta_description' => '',
        'meta_keywords' => '',
    ];

    return view('user.wallet', 
        [
            'meta_title' => $metaData['meta_title'],
            'meta_description' => $metaData['meta_description'],
            'meta_keywords' => $metaData['meta_keywords'],
        ]
    );
}

    public function viewOrder($id)
{
        $getRecord = OrdersModel::getUserOrderById(Auth::id(), $id);
        if (!$getRecord) {
        abort(404); 
        }
        $metaData = [
            'meta_title' => 'View Order',
            'meta_description' => '',
            'meta_keywords' => '',
        ];
        return view('user.view_order', 
            [
                'meta_title' => $metaData['meta_title'],
                'meta_description' => $metaData['meta_description'],
                'meta_keywords' => $metaData['meta_keywords'],
                'getRecord' => $getRecord,
            ]
        );
}

    public function addToWishlist(Request $request)
{

    $userId = Auth::id();
    $productId = $request->product_id;

    $existing = ProductWishlists::checkExisting($userId, $productId);

    if (!$existing) {
        ProductWishlists::create([
            'user_id' => $userId,
            'product_id' => $productId,
        ]);
        $isWishlist = 1;
    } else {
        ProductWishlists::deleteRecord($userId, $productId);
        $isWishlist = 0;
    }

    return response()->json([
        'status' => true,
        'is_wishlist' => $isWishlist,
    ]);
}

public function makeReview(Request $request)
{
    $request->validate([
        'product_id' => 'required|integer|exists:product,id',
        'order_id' => 'required|integer|exists:orders,id',
        'rating' => 'required|integer|min:1|max:5',
        'review' => 'nullable|string|max:1000',
    ]);

    $userId = Auth::id();
    $productId = $request->input('product_id');
    $orderId = $request->input('order_id');
    $rating = $request->input('rating');
    $review = $request->input('review', '');

    // Check if the user has already reviewed this product for the given order
    $existingReview = ProductReviews::where('user_id', $userId)
        ->where('product_id', $productId)
        ->where('order_id', $orderId)
        ->first();

    if ($existingReview) {
        // Update existing review
        $existingReview->rating = $rating;
        $existingReview->review = $review;
        $existingReview->save();
    } else {
        // Create new review
        ProductReviews::create([
            'user_id' => $userId,
            'product_id' => $productId,
            'order_id' => $orderId,
            'rating' => $rating,
            'review' => $review,
        ]);
    }

    return redirect()->back()->with('success', 'Review submitted successfully!');
}

}

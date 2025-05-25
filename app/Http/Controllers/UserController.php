<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Backend\V1\OrdersModel;
use Illuminate\Support\Facades\Auth; 

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


    public function orders()
    {
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
            ]
        );
    }

    public function profile()
    {
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
}

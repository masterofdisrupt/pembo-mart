<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class UserController extends Controller
{
   public function dashboard()
{
    $metaData = [
        'meta_title' => 'Dashboard',
        'meta_description' => '',
        'meta_keywords' => '',
    ];

    
    $totalOrders = 0; 
    $todayOrders = 0;
    $totalAmount = 0;
    $todayAmount = 0;
    $pendingOrders = 0;
    $inProgressOrders = 0;
    $completedOrders = 0;
    $canceledOrders = 0;

    $metrics = [
        ['label' => 'Total Orders',      'value' => $totalOrders],
        ['label' => 'Today Orders',      'value' => $todayOrders],
        ['label' => 'Total Amount',      'value' => $totalAmount],
        ['label' => 'Today Amount',      'value' => $todayAmount],
        ['label' => 'Pending Orders',    'value' => $pendingOrders],
        ['label' => 'In Progress Orders','value' => $inProgressOrders],
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

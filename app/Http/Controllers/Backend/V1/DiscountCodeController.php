<?php

namespace App\Http\Controllers\Backend\V1;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Backend\V1\DiscountCodeModel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use App\Models\User;
use Carbon\Carbon;
use Exception;


class DiscountCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function discount_code(Request $request)
{

        $getRecord = DiscountCodeModel::getAllRecord($request);

        return view('backend.admin.discount_code.list', [
        'getRecord' => $getRecord,
        'activeCount' => DiscountCodeModel::where('expiry_date', '>', now())->count(),
        'expiringCount' => DiscountCodeModel::whereBetween('expiry_date', [now(), now()->addDays(7)])->count(),
        'expiredCount' => DiscountCodeModel::where('expiry_date', '<=', now())->count()
    ]);

    
}
    /**
     * Show the form for creating a new discount code.
     *
     * @return \Illuminate\View\View
     */
    public function discount_code_add()
    {
        return view('backend.admin.discount_code.add');
    }

/**
 * Store a newly created discount code in storage.
 *
 * @param \Illuminate\Http\Request $request
 * @return \Illuminate\Http\RedirectResponse
 */
public function discount_code_store(Request $request): RedirectResponse
{

        // Validate request data
        $validator = Validator::make($request->all(), [
            'code' => 'required|unique:discount_code,code|max:50',
            'discount_price' => [
                'required',
                'numeric',
                'min:0',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->type == 0 && $value > 100) {
                        $fail('The percentage discount cannot be greater than 100.');
                    }
                },
            ],
            'expiry_date' => 'required|date|after:today',
            'type' => 'required|in:0,1',
            'usages' => 'required|in:0,1'
        ], [
            'code.unique' => 'This discount code already exists.',
            'discount_price.max' => 'Percentage discount cannot exceed 100%.',
            'expiry_date.after' => 'Expiry date must be after today.'
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Create new discount code
        $discountCode = DiscountCodeModel::create([
            'user_id' => Auth::id(),
            'code' => strtoupper(trim($request->code)),
            'discount_price' => trim($request->discount_price),
            'expiry_date' => Carbon::parse($request->expiry_date),
            'type' => $request->type,
            'usages' => $request->usages,
            'is_delete' => 0
        ]);

        Log::info('Discount code created', [
            'code' => $discountCode->code,
            'created_by' => Auth::id()
        ]);

        return redirect()
            ->route('discount.code')
            ->with('success', 'Discount code created successfully!');

    
}

/**
 * Show the form for editing the specified discount code.
 *
 * @param int $id
 * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
 */
public function discount_code_edit($id)
{
    
        $discountCode = DiscountCodeModel::findOrFail($id);
        
        
        $expiryDate = $discountCode->expiry_date instanceof Carbon 
            ? $discountCode->expiry_date->format('Y-m-d')
            : Carbon::parse($discountCode->expiry_date)->format('Y-m-d');
        
        return view('backend.admin.discount_code.edit', [
            'discountCode' => $discountCode,
            'expiryDate' => $expiryDate,
            'users' => User::select('id', 'username')->get(),
            'types' => [
                0 => 'Percentage',
                1 => 'Fixed Amount'
            ],
            'usages' => [
                0 => 'One-time',
                1 => 'Unlimited'
            ]
        ]);

}

/**
 * Update the specified discount code.
 *
 * @param int $id
 * @param Request $request
 * @return RedirectResponse
 */

    public function discount_code_update($id, Request $request): RedirectResponse
    {
   
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'code' => "required|unique:discount_code,code,{$id}|max:50",
            'discount_price' => [
                'required',
                'numeric',
                'min:0',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->type == 0 && $value > 100) {
                        $fail('The percentage discount cannot be greater than 100.');
                    }
                },
            ],
            'expiry_date' => 'required|date|after:today',
            'type' => 'required|in:0,1',
            'usages' => 'required|in:0,1'
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Find and update discount code
        $discountCode = DiscountCodeModel::findOrFail($id);
        $discountCode->user_id = $request->user_id;
        $discountCode->code = strtoupper(trim($request->code));
        $discountCode->discount_price = trim($request->discount_price);
        $discountCode->expiry_date = Carbon::parse($request->expiry_date);
        $discountCode->type = $request->type;
        $discountCode->usages = $request->usages;
        $discountCode->save();

        return redirect()
            ->route('discount.code')
            ->with('success', 'Discount code updated successfully!');
        }


/**
 * Soft delete the specified discount code.
 *
 * @param int $id
 * @return RedirectResponse
 */

    public function discount_code_delete($id): RedirectResponse
    {
    
        $discountCode = DiscountCodeModel::findOrFail($id);
        
        // Check if already deleted
        if ($discountCode->is_delete) {
            return redirect()
                ->route('discount.code')
                ->with('warning', 'Discount code was already deleted.');
        }

        // Perform soft delete
        $discountCode->is_delete = 1;
        
        $discountCode->save();

        Log::info('Discount code deleted', [
            
            'code' => $discountCode->discount_code,
            
        ]);

        return redirect()
            ->route('discount.code')
            ->with('success', 'Discount code deleted successfully.');   
        }
}
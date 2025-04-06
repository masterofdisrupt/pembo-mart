<?php

namespace App\Models\Backend\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Request;
use Carbon\Carbon;

class DiscountCodeModel extends Model
{
    use HasFactory;

    protected $table = 'discount_code';
    protected $fillable = [
        'discount_code',
        'discount_price',
        'expiry_date',
        'type',
        'usages',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'expiry_date' => 'datetime',
        'type' => 'integer',
        'usages' => 'integer',
        'discount_price' => 'float',
    ];


/**
 * Get all discount codes with filters
 *
 * @param \Illuminate\Http\Request $request
 * @return \Illuminate\Pagination\LengthAwarePaginator
 */
public static function getAllRecord($request): LengthAwarePaginator
{
    try {
        $query = self::select([
                'discount_code.*',
                'users.username',
                DB::raw('CASE 
                    WHEN expiry_date <= NOW() THEN "expired"
                    WHEN expiry_date <= DATE_ADD(NOW(), INTERVAL 7 DAY) THEN "expiring"
                    ELSE "active"
                    END as status')
            ])
            ->join('users', 'users.id', '=', 'discount_code.user_id')
            ->where('discount_code.is_delete', '=', 0);

        // Apply filters
        if ($request->filled('id')) {
            $query->where('discount_code.id', $request->id);
        }

        if ($request->filled('username')) {
            $query->where('users.username', 'like', "%{$request->username}%");
        }

        if ($request->filled('discount_code')) {
            $query->where('discount_code.discount_code', 'like', "%{$request->discount_code}%");
        }

        // Price range filter
        if ($request->filled('price_min') || $request->filled('price_max')) {
            $query->whereBetween('discount_code.discount_price', [
                $request->input('price_min', 0),
                $request->input('price_max', PHP_FLOAT_MAX)
            ]);
        }

        // Status filter with optimization
        if ($request->filled('status')) {
            $now = Carbon::now();
            switch ($request->status) {
                case 'active':
                    $query->where('expiry_date', '>', $now);
                    break;
                case 'expired':
                    $query->where('expiry_date', '<=', $now);
                    break;
                case 'expiring':
                    $query->whereBetween('expiry_date', [
                        $now,
                        $now->copy()->addDays(7)
                    ]);
                    break;
            }
        }

        // Add sorting
        $query->orderBy($request->input('sort_by', 'discount_code.id'), 
                       $request->input('sort_order', 'desc'));

        return $query->paginate($request->input('per_page', 40));

    } catch (\Exception $e) {
        \Log::error('Error fetching discount codes: ' . $e->getMessage());
        return new LengthAwarePaginator([], 0, 40);
    }
}


    /**
     * Get the status badge HTML for the discount code
     *
     * @return string
     */
    public function getStatusBadge(): string
    {
        $expiryDate = Carbon::parse($this->expiry_date);
        $today = Carbon::today();

        if ($expiryDate->isPast()) {
            return '<span class="badge bg-danger">Expired</span>';
        }

        if ($expiryDate->diffInDays($today) <= 7) {
            return '<span class="badge bg-warning">Expiring Soon</span>';
        }

        if ($this->usages == 0) {
            return '<span class="badge bg-info">One-time Use</span>';
        }

        return '<span class="badge bg-success">Active</span>';
    }

}
    


   
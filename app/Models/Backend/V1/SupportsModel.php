<?php

namespace App\Models\Backend\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class SupportsModel extends Model
{
    use HasFactory;

    protected $table = 'supports';

    /**
     * Status constants
     */
    public const STATUS_OPEN = 0;
    public const STATUS_CLOSED = 1;
    public const STATUS_PENDING = 2;

    /**
     * Priority constants
     */
    public const PRIORITY_LOW = 0;
    public const PRIORITY_MEDIUM = 1;
    public const PRIORITY_HIGH = 2;

    /**
     * Status labels mapping
     */
    public const STATUSES = [
        self::STATUS_OPEN => 'Open',
        self::STATUS_CLOSED => 'Closed',
        self::STATUS_PENDING => 'Pending'
    ];

    /**
     * Priority labels mapping
     */
    public const PRIORITIES = [
        self::PRIORITY_LOW => 'Low',
        self::PRIORITY_MEDIUM => 'Medium',
        self::PRIORITY_HIGH => 'High'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'status' => 'integer',
        'priority' => 'integer'
    ];

    /**
     * Get filtered support tickets list
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function getSupportList($request)
    {
        return static::query()
            ->select('supports.*')
            ->with(['user:id,name,email'])
            ->when($request->id, fn ($query, $id) => 
                $query->where('supports.id', $id))
            ->when($request->user_id, fn ($query, $userId) => 
                $query->where('supports.user_id', $userId))
            ->when($request->title, fn ($query, $title) => 
                $query->where('supports.title', 'like', "%{$title}%"))
            ->when($request->filled('status'), function ($query) use ($request) {
            return $query->where('supports.status', $request->status);
        })
            ->when($request->date, function ($query) use ($request) {
                $date = Carbon::parse($request->date);
                return $query->whereDate('created_at', $date);
            })
            ->latest('id')
            ->paginate(40)
            ->withQueryString();
    }

    /**
     * User relationship
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get status badge color
     *
     * @return string
     */
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            self::STATUS_OPEN => 'success',
            self::STATUS_PENDING => 'warning',
            self::STATUS_CLOSED => 'danger',
            default => 'secondary'
        };
    }

    /**
     * Get the priority color for badges
     *
     * @return string
     */
    public function getPriorityColorAttribute(): string
    {
        return match($this->priority) {
            self::PRIORITY_LOW => 'info',
            self::PRIORITY_MEDIUM => 'warning',
            self::PRIORITY_HIGH => 'danger',
            default => 'secondary'
        };
    }

    /**
     * Scope for open tickets
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeOpen(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_OPEN);
    }

    /**
     * Check if ticket is open
     *
     * @return bool
     */
    public function isOpen(): bool
    {
        return $this->status === self::STATUS_OPEN;
    }

/**
 * Get the replies for this support ticket
 */
public function replies()
{
    return $this->hasMany(SupportReplysModel::class, 'support_id');
}
}


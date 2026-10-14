<?php

namespace App\Models;

use Database\Factories\EmployeeLeaveFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeeLeave extends Model
{
    /** @use HasFactory<EmployeeLeaveFactory> */
    use HasFactory;

    protected $table = 'employee_leaves';

    protected $fillable = [
        'employee_id',
        'leave_type',
        'from_date',
        'to_date',
        'reason',
        'status',
        'approved_by',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'from_date' => 'date',
            'to_date' => 'date',
        ];
    }

    /**
     * Get the duration in days for this leave.
     */
    protected function daysCount(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (! $this->from_date || ! $this->to_date) {
                    return 1;
                }

                return $this->from_date->diffInDays($this->to_date) + 1;
            }
        );
    }

    /**
     * Scope a query to only include pending leaves.
     */
    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope a query to only include approved leaves.
     */
    public function scopeApproved(Builder $query): Builder
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope a query to only include rejected leaves.
     */
    public function scopeRejected(Builder $query): Builder
    {
        return $query->where('status', 'rejected');
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}

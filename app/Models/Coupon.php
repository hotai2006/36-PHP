<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'type',
        'value',
        'min_order_amount',
        'usage_limit',
        'used_count',
        'start_date',
        'end_date',
        'status',
    ];

    public function isValid($orderTotal)
    {
        if (!$this->status) {
            return false;
        }

        if ($this->usage_limit !== null && $this->used_count >= $this->usage_limit) {
            return false;
        }

        $now = now();
        if ($this->start_date && $now->lt($this->start_date)) {
            return false;
        }

        if ($this->end_date && $now->gt($this->end_date)) {
            return false;
        }

        if ($this->min_order_amount > 0 && $orderTotal < $this->min_order_amount) {
            return false;
        }

        return true;
    }

    public function calculateDiscount($orderTotal)
    {
        if (!$this->isValid($orderTotal)) {
            return 0;
        }

        if ($this->type === 'percent') {
            $discount = $orderTotal * ($this->value / 100);
            return $discount;
        }

        // fixed
        return min($this->value, $orderTotal);
    }
}

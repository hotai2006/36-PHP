<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coupon;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::orderBy('id', 'desc')->paginate(10);
        return view('admin.coupon.index', compact('coupons'));
    }

    public function create()
    {
        return view('admin.coupon.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|unique:coupons',
            'type' => 'required|in:percent,fixed',
            'value' => 'required|numeric|min:0',
            'min_order_amount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'boolean',
        ]);

        Coupon::create($request->all());

        return redirect('/admin/coupon')->with('success', 'Thêm mã giảm giá thành công.');
    }

    public function edit($id)
    {
        $coupon = Coupon::findOrFail($id);
        return view('admin.coupon.edit', compact('coupon'));
    }

    public function update(Request $request, $id)
    {
        $coupon = Coupon::findOrFail($id);

        $request->validate([
            'code' => 'required|string|unique:coupons,code,' . $coupon->id,
            'type' => 'required|in:percent,fixed',
            'value' => 'required|numeric|min:0',
            'min_order_amount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'boolean',
        ]);

        $data = $request->all();
        $data['status'] = $request->has('status') ? 1 : 0;
        
        $coupon->update($data);

        return redirect('/admin/coupon')->with('success', 'Cập nhật mã giảm giá thành công.');
    }

    public function destroy($id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->delete();

        return redirect('/admin/coupon')->with('success', 'Xóa mã giảm giá thành công.');
    }

    public function applyCoupon(Request $request)
    {
        $code = $request->input('code');
        $orderTotal = $request->input('order_total', 0);

        if (!$code) {
            return response()->json(['success' => false, 'message' => 'Vui lòng nhập mã giảm giá.']);
        }

        $coupon = Coupon::where('code', $code)->first();

        if (!$coupon) {
            return response()->json(['success' => false, 'message' => 'Mã giảm giá không tồn tại.']);
        }

        if (!$coupon->isValid($orderTotal)) {
            $message = 'Mã giảm giá không hợp lệ hoặc không đủ điều kiện áp dụng.';
            if ($coupon->min_order_amount > $orderTotal) {
                 $message = 'Đơn hàng tối thiểu ' . number_format($coupon->min_order_amount, 0, ',', '.') . ' VNĐ để áp dụng mã này.';
            }
            if ($coupon->start_date && now()->lt($coupon->start_date)) {
                $message = 'Mã giảm giá chưa đến ngày bắt đầu.';
            }
            if ($coupon->end_date && now()->gt($coupon->end_date)) {
                $message = 'Mã giảm giá đã hết hạn.';
            }
            if ($coupon->usage_limit !== null && $coupon->used_count >= $coupon->usage_limit) {
                $message = 'Mã giảm giá đã hết lượt sử dụng.';
            }
            if (!$coupon->status) {
                $message = 'Mã giảm giá đã bị khóa.';
            }

            return response()->json(['success' => false, 'message' => $message]);
        }

        $discountAmount = $coupon->calculateDiscount($orderTotal);

        return response()->json([
            'success' => true,
            'message' => 'Áp dụng mã giảm giá thành công!',
            'discount_amount' => $discountAmount,
            'coupon_code' => $coupon->code,
            'type' => $coupon->type,
            'value' => $coupon->value,
            'min_order_amount' => $coupon->min_order_amount
        ]);
    }
}

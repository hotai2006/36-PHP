<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\OrderService;
use App\Services\CartService;
use App\Services\PaymentService;
use App\Models\Order;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    protected $orderService;
    protected $cartService;
    protected $paymentService;

    public function __construct(OrderService $orderService, CartService $cartService,PaymentService $paymentService )
    {
        $this->orderService = $orderService;
        $this->cartService = $cartService;
        $this->paymentService = $paymentService;
    }



    public function getAllOrder(Request $request){
        $search = $request->input('search');
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');

        if ($search || $fromDate || $toDate) {
            $orders = $this->orderService->searchOrders($search, $fromDate, $toDate);
        } else {
            $orders = $this->orderService->getAllOrder();
        }

        return view('admin.order.show', compact('orders'));
    }


    public function detailOrder($id){
        try {
            $orders = $this->orderService->getOrderById($id);
            if(!$orders){
                return view('admin.order.detail', ['orders'=>null]);
            }
            return view('admin.order.detail', compact('orders'));
        } catch (\Throwable $th) {
            return view('admin.order.detail', ['orders'=>null]);
        }
    }

    public function getOrderHistory(){
        try {
            $id = session('user_id');
            $orders = $this->orderService->getOrdersByUserId($id);
            if(!$orders){
                return view('client.cart.orderHistory', ['orders'=>null]);
            }
            return view('client.cart.orderHistory', compact('orders'));
        } catch (\Throwable $th) {
            return view('client.cart.orderHistory', ['orders'=>null]);
        }
    }

    public function updateOrder($id){
        try {
            $orders = $this->orderService->getOrderById($id);
            if(!$orders){
                return view('admin.order.update', ['orders'=>null]);
            }
            return view('admin.order.update', compact('orders'));
        } catch (\Throwable $th) {
            return view('admin.order.update', ['orders'=>null]);
        }
    }

    public function handleUpdateOrder(Request $request, $id){
        $newStatus = $request['order_status'];
        
        // 1. Phân quyền Shipper (role_id = 2)
        if (auth()->check() && auth()->user()->role_id == 2) {
            // Shipper chỉ được phép chuyển trạng thái thành 'shipping' hoặc 'complete'
            if (!in_array($newStatus, ['shipping', 'complete'])) {
                return redirect()->back()->with('error', 'Shipper chỉ có quyền xác nhận nhận hàng (Đang giao) hoặc Đã giao thành công!');
            }
            
            // Bắt buộc phải có ảnh giao hàng làm bằng chứng khi chuyển sang 'complete' (Đã giao hàng)
            if ($newStatus === 'complete') {
                if (!$request->hasFile('delivery_image')) {
                    $order = $this->orderService->getOrderById($id);
                    if (!$order || !$order->delivery_image) {
                        return redirect()->back()->with('error', 'Bắt buộc phải tải lên ảnh chụp giao hàng thành công làm bằng chứng!');
                    }
                }
            }
        }

        // 2. Xử lý tải ảnh nếu có
        $imageName = null;
        if ($request->hasFile('delivery_image')) {
            $file = $request->file('delivery_image');
            $imageName = 'delivery_' . time() . '_' . $id . '.' . $file->getClientOriginalExtension();
            
            // Đảm bảo thư mục public/deliveries tồn tại
            if (!file_exists(public_path('deliveries'))) {
                mkdir(public_path('deliveries'), 0777, true);
            }
            
            $file->move(public_path('deliveries'), $imageName);
        }

        // 3. Cập nhật đơn hàng qua service
        $this->orderService->handleUpdateOrder($newStatus, $id, $imageName);
        
        return redirect()->back()->with('success', 'Cập nhật trạng thái đơn hàng thành công!');
    }


    // Xử lý đặt hàng
    public function placeOrder(Request $request)
    {
        // Lấy ID người dùng từ session
        $userId = Session::get('user_id');

        // Kiểm tra người dùng đăng nhập
        if (!$userId) {
            return redirect()->route('login');
        }

        // Dữ liệu từ form đặt hàng
        $data = $request->only(['receiverName', 'receiverAddress', 'receiverPhone', 'paymentMethod']);
        $cartData = $this->cartService->fetchCartByUser($userId);

        if (empty($cartData['cartDetails']) || count($cartData['cartDetails']) == 0) {
            return redirect()->route('getCartPage')->with('error', 'Giỏ hàng của bạn đang trống hoặc các sản phẩm đã được thanh toán!');
        }

        $totalPrice = $cartData['totalPrice'];
        $couponCode = $request->input('coupon_code');
        $discount = 0;
        $couponId = null;

        if ($couponCode) {
            $coupon = \App\Models\Coupon::where('code', $couponCode)->first();
            if ($coupon && $coupon->isValid($totalPrice)) {
                $discount = $coupon->calculateDiscount($totalPrice);
                $couponId = $coupon->id;
                
                // Increment used count
                $coupon->used_count++;
                $coupon->save();
            }
        }

        $shippingFee = ($totalPrice >= 1000000) ? 0 : 30000;
        $finalPrice = max(0, $totalPrice - $discount + $shippingFee);

        // Gọi service để xử lý đặt hàng
        $order = $this->orderService->placeOrder($userId, array_merge($data, [
            'totalPrice' => $finalPrice,
            'coupon_id' => $couponId,
            'discount_amount' => $discount,
        ]), $cartData['cartDetails']);

        if ($order) {
        // Thanh toán MOMO
        if ($data['paymentMethod'] === 'MOMO') {
            $time = strval(time());
            $orderId = "MOMO" . $time;
            $orderInfo = "Payment for order " . $orderId;
            $amount = number_format($finalPrice, 0, '', '');
            $requestId = "MOMO" . $time . "001";

            // Tạo yêu cầu thanh toán MOMO
            $paymentRequest = [
                'amount' => $amount,
                'orderId' => $orderId,
                'orderInfo' => $orderInfo,
                'requestId' => $requestId,
                'extraData' => strval($order->id),  // Gắn ID đơn hàng vào extraData
            ];

            // Gửi yêu cầu thanh toán đến MOMO
            $response = $this->paymentService->createPayment($paymentRequest);
            $jsonResponse = json_decode($response, true);

            // Lấy URL thanh toán
            $paymentUrl = $jsonResponse['payUrl'] ?? '';

            if (!empty($paymentUrl)) {
                // Lưu orderId và requestId vào session để kiểm tra sau
                Session::put('momoOrderId', $orderId);
                Session::put('momoRequestId', $requestId);
                return redirect($paymentUrl);
            }
        }

        return redirect()->route('thank')->with('success', 'Đặt hàng thành công!');
    } else {
        return redirect()->back()->with('error', 'Đặt hàng thất bại. Vui lòng thử lại.');
    }
    }

    public function thank(Request $request)
    {
        // Kiểm tra trạng thái giao dịch từ request
        $resultCode = $request->query('resultCode');
        if ($resultCode !== null && intval($resultCode) !== 0) {
            return view('client.cart.failure');
        }
        $orderId = $request->query('extraData');
        // Kiểm tra trạng thái giao dịch qua session
        $momoOrderId = Session::get('momoOrderId');
        $momoRequestId = Session::get('momoRequestId');

        if ($momoOrderId && $momoRequestId) {
            // Gọi phương thức checkPaymentStatus để kiểm tra trạng thái giao dịch
            $transactionStatus = $this->paymentService->queryTransactionStatus($momoOrderId, $momoRequestId);

            // Kiểm tra nếu không có phản hồi hoặc phản hồi không phải là JSON hợp lệ
            if (empty($transactionStatus)) {
                return view('client.cart.failure')->with('error', 'Không nhận được phản hồi từ MoMo.');
            }

            $jsonResponse = json_decode($transactionStatus, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                return view('client.cart.failure')->with('error', 'Phản hồi không hợp lệ từ MoMo.');
            }

            $resultCodeFromApi = $jsonResponse['resultCode'] ?? -1;
            if ($resultCodeFromApi === 0) {
                $order = Order::where('id', $orderId)->first();
                if ($order) {
                    $order->update([
                        'pay' => 1, // Cập nhật trạng thái thanh toán
                    ]);
                }
                return view('client.cart.thank');
            } else {
                return view('client.cart.failure')->with('error', 'Thanh toán thất bại. Vui lòng thử lại.');
            }
        }

        return view('client.cart.thank');

    }

    public function track(Request $request)
    {
        $order_id = $request->id;

        // Tìm đơn hàng theo mã (order_code)
        $order = $this->orderService->getOrderById($order_id);

        if (!$order) {
            return view('client.cart.track', ['error' => 'Không tìm thấy đơn hàng.']);
        }

        return view('client.cart.track', compact('order'));
    }

    public function cancelOrder(Request $request, $id)
    {
        try {
            $userId = session('user_id');
            $order = $this->orderService->getOrderById($id);

            if (!$order) {
                return response()->json(['success' => false, 'message' => 'Không tìm thấy đơn hàng.']);
            }

            if ($order->user_id != $userId) {
                return response()->json(['success' => false, 'message' => 'Bạn không có quyền hủy đơn hàng này.']);
            }

            if ($order->order_status !== 'pending') {
                return response()->json(['success' => false, 'message' => 'Đơn hàng không thể hủy vì đã được xử lý.']);
            }

            $this->orderService->handleUpdateOrder('cancel', $id);

            return response()->json(['success' => true, 'message' => 'Hủy đơn hàng thành công!']);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'message' => 'Đã có lỗi xảy ra: ' . $th->getMessage()]);
        }
    }
}
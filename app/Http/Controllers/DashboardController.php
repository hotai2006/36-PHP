<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use App\Services\ProductService;
use App\Services\OrderService;
use Illuminate\Http\Request;
class DashboardController
{
    private $userService;
    private $productService;
    private $orderService;

    public function __construct(UserService $userService, ProductService $productService, OrderService $orderService)
    {
        $this->userService = $userService;
        $this->productService = $productService; 
        $this->orderService = $orderService;
    }

    public function viewDashboard(Request $request){

        // Check if the user is authenticated and has the role of admin (role_id = 1
        if (!auth()->check() || auth()->user()->role_id != 1) {
            return redirect('/')->with('error', 'You do not have permission to access this page.');
        }

        $range = (int)$request->query('range', 7);
        if (!in_array($range, [1, 7, 30])) {
            $range = 7;
        }

        // Get range-based counts
        $userCount = \App\Models\User::where('created_at', '>=', now()->subDays($range))->count();
        $productCount = $this->productService->getAllProductCount(); 
        $orderCount = \App\Models\Order::where('created_at', '>=', now()->subDays($range))->count();

        $orderCountByYear = $this->orderService->getOrderCountByYear(date('2025'));
        $revenueByYear = $this->orderService->getRevenueByYear(date('2025'));

        // Prepare chart data based on date range
        $chartLabels = [];
        $chartOrderCompleted = [];
        $chartOrderIncomplete = [];
        $chartOrderCancelled = [];
        $chartRevenueCompleted = [];
        $chartRevenueIncomplete = [];
        $chartRevenueCancelled = [];

        if ($range === 1) {
            $chartTitleSuffix = 'ngày ' . now()->format('d/m/Y');
            // Last 24 hours, hourly data
            for ($i = 23; $i >= 0; $i--) {
                $time = now()->subHours($i);
                $chartLabels[] = $time->format('H:00');
                
                $chartOrderCompleted[] = \App\Models\Order::where('created_at', '>=', $time->copy()->startOfHour())
                    ->where('created_at', '<=', $time->copy()->endOfHour())
                    ->where('order_status', 'complete')
                    ->count();

                $chartOrderIncomplete[] = \App\Models\Order::where('created_at', '>=', $time->copy()->startOfHour())
                    ->where('created_at', '<=', $time->copy()->endOfHour())
                    ->whereNotIn('order_status', ['complete', 'cancel'])
                    ->count();

                $chartOrderCancelled[] = \App\Models\Order::where('created_at', '>=', $time->copy()->startOfHour())
                    ->where('created_at', '<=', $time->copy()->endOfHour())
                    ->where('order_status', 'cancel')
                    ->count();
                    
                $chartRevenueCompleted[] = (float)\App\Models\Order::where('order_status', 'complete')
                    ->where('created_at', '>=', $time->copy()->startOfHour())
                    ->where('created_at', '<=', $time->copy()->endOfHour())
                    ->sum('total_price');

                $chartRevenueIncomplete[] = (float)\App\Models\Order::whereNotIn('order_status', ['complete', 'cancel'])
                    ->where('created_at', '>=', $time->copy()->startOfHour())
                    ->where('created_at', '<=', $time->copy()->endOfHour())
                    ->sum('total_price');

                $chartRevenueCancelled[] = (float)\App\Models\Order::where('order_status', 'cancel')
                    ->where('created_at', '>=', $time->copy()->startOfHour())
                    ->where('created_at', '<=', $time->copy()->endOfHour())
                    ->sum('total_price');
            }
        } else {
            $chartTitleSuffix = 'từ ngày ' . now()->subDays($range - 1)->format('d/m/Y') . ' đến ngày ' . now()->format('d/m/Y');
            // Last 7 or 30 days, daily data
            for ($i = $range - 1; $i >= 0; $i--) {
                $time = now()->subDays($i);
                $chartLabels[] = $time->format('d/m');
                
                $chartOrderCompleted[] = \App\Models\Order::whereDate('created_at', $time->format('Y-m-d'))->where('order_status', 'complete')->count();
                $chartOrderIncomplete[] = \App\Models\Order::whereDate('created_at', $time->format('Y-m-d'))->whereNotIn('order_status', ['complete', 'cancel'])->count();
                $chartOrderCancelled[] = \App\Models\Order::whereDate('created_at', $time->format('Y-m-d'))->where('order_status', 'cancel')->count();
                
                $chartRevenueCompleted[] = (float)\App\Models\Order::where('order_status', 'complete')
                    ->whereDate('created_at', $time->format('Y-m-d'))
                    ->sum('total_price');

                $chartRevenueIncomplete[] = (float)\App\Models\Order::whereNotIn('order_status', ['complete', 'cancel'])
                    ->whereDate('created_at', $time->format('Y-m-d'))
                    ->sum('total_price');

                $chartRevenueCancelled[] = (float)\App\Models\Order::where('order_status', 'cancel')
                    ->whereDate('created_at', $time->format('Y-m-d'))
                    ->sum('total_price');
            }
        }

        return view("admin.dashboard.show",
            [
                'userCount' => $userCount,
                'productCount' => $productCount,
                'orderCount' => $orderCount,
                'orderCountByYear' => $orderCountByYear,
                'revenueByYear' => $revenueByYear,
                'chartLabels' => $chartLabels,
                'chartOrderCompleted' => $chartOrderCompleted,
                'chartOrderIncomplete' => $chartOrderIncomplete,
                'chartOrderCancelled' => $chartOrderCancelled,
                'chartRevenueCompleted' => $chartRevenueCompleted,
                'chartRevenueIncomplete' => $chartRevenueIncomplete,
                'chartRevenueCancelled' => $chartRevenueCancelled,
                'chartTitleSuffix' => $chartTitleSuffix,
                'range' => $range,
            ]
        );
    }
}
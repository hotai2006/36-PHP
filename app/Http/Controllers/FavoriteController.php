<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorite;
use App\Models\Product;
use App\Models\User;

class FavoriteController extends Controller
{
    public function toggleFavoriteAjax(Request $request)
    {
        $userId = $request->session()->get('user_id', null);
        if (!$userId) {
            return response()->json([
                'status' => 'not_logged_in',
                'message' => 'Bạn cần đăng nhập để thực hiện thao tác này.'
            ]);
        }

        $productId = $request->input('product_id');
        $product = Product::find($productId);

        if (!$product) {
            return response()->json([
                'status' => 'error',
                'message' => 'Sản phẩm không tồn tại.'
            ]);
        }

        $favorite = Favorite::where('user_id', $userId)
                            ->where('product_id', $productId)
                            ->first();

        if ($favorite) {
            $favorite->delete();
            return response()->json([
                'status' => 'removed',
                'message' => 'Đã xóa sản phẩm khỏi danh sách yêu thích.'
            ]);
        } else {
            Favorite::create([
                'user_id' => $userId,
                'product_id' => $productId
            ]);
            return response()->json([
                'status' => 'added',
                'message' => 'Đã thêm sản phẩm vào danh sách yêu thích.'
            ]);
        }
    }

    public function getFavoritesPage(Request $request)
    {
        $userId = $request->session()->get('user_id', null);
        if (!$userId) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để xem danh sách yêu thích.');
        }

        $user = User::find($userId);
        $products = $user->favoriteProducts()->paginate(8);

        return view('client.product.favorites', compact('products'));
    }
}

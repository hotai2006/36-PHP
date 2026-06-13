<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use App\Services\ProductService;
use App\Services\DiscountService;
use Illuminate\Http\Request;
class HomePageController extends Controller{

    private $productService;
    private $discountService;
    private $userService;

    function __construct(ProductService $productService, DiscountService $discountService, UserService $userService){
        $this->productService = $productService;
        $this->discountService = $discountService;
        $this->userService = $userService;
    }

    public function getHomePage(Request $request){

        $products = $this->productService->getAllProduct()->appends($request->query());
        $allproduct = $this->productService->getAllProductsWithoutPagination();
        $productDiscounts = $this->discountService->getAllProductDiscountActive(6, 'discount_page')->appends($request->query());
        return view("client.homePage.homePage", compact('products','allproduct', 'productDiscounts'), );
    }

    public function errorHomePage(){
        return view("client.auth.error");
    }

    public function getUserProfile(){
        $userId = session('user_id');
        $user = $this->userService->getUserById($userId);
        return view("client.profile.profile", compact('user'));
    }

    public function postUpdateProfile(Request $request){
        // Validate input

        $id = session('user_id');
        
        $validated = $request->validate([
            'user_name'    => 'required|string|max:255',
            'user_email'   => 'nullable|email|max:255',
            'user_phone'   => 'nullable|string|max:20',
            'user_address' => 'nullable|string|max:255',
            'user_avatar'  => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'role_id'      => 'nullable|integer|in:1,3'
        ]);

        // Tìm user
        $user = $this->userService->getUserById($id);

        // Truyền file nếu có
        $validated['user_avatar'] = $request->file('user_avatar');

        if(!$this->userService->updateProfileUserHomepage($validated, $user)){
            return redirect('/user-profile')->with('error', 'Cập nhật thông tin thất bại!');
        }

        // Cập nhật lại session role_id
        session()->put('role_id', $user->role_id);

        return redirect('/user-profile')->with('success', 'Cập nhật thông tin thành công!');
    }

    public function changeRole(Request $request)
    {
        $validated = $request->validate([
            'role_id' => 'required|integer|in:1,3'
        ]);

        $id = session('user_id');
        $user = $this->userService->getUserById($id);
        
        if ($user) {
            $user->role_id = $validated['role_id'];
            $user->save();
            session()->put('role_id', $user->role_id);
            return redirect()->back()->with('success', 'Đổi vai trò thành công!');
        }

        return redirect()->back()->with('error', 'Không tìm thấy người dùng!');
    }
}
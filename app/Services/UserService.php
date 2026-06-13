<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;


class UserService
{
    public function getAllUsers($perPage = 10)
    {
        return User::orderBy('id', 'desc')->paginate($perPage);
    }

    public function searchUsers($searchTerm, $perPage = 10)
    {
        return User::where('user_name', 'like', '%' . $searchTerm . '%')
            ->orWhere('user_email', 'like', '%' . $searchTerm . '%')
            ->orWhere('user_phone', 'like', '%' . $searchTerm . '%')
            ->orderBy('id', 'desc')
            ->paginate($perPage);
    }
    // Phương thức để lấy tổng số người dùng
    public function getAllUserCount()
    {
        return User::count();
    }


    public function getUserById($id)
    {
        return User::find($id);
    }

    // Phương thức để xóa người dùng
    public function deleteByUser($id)
    {
        $user = User::find($id);
        if ($user) {
            // Xóa avatar cũ nếu có
            if ($user->user_avatar) {
                // Kiểm tra nếu đường dẫn avatar có chứa thư mục 'avatars'
                $avatarPath = 'avatars/' . $user->user_avatar;
                if ($user->user_avatar != "default-google.png" && $user->user_avatar != "default-avatar.jpg") {
                    if (Storage::disk('public')->exists($avatarPath)) {
                        // Xóa avatar cũ
                        Storage::disk('public')->delete($avatarPath);
                    }
                }
            }

            \Illuminate\Support\Facades\DB::transaction(function () use ($user) {
                // 1. Xóa Cart và CartDetails liên quan
                if ($user->cart) {
                    $user->cart->cartDetails()->delete();
                    $user->cart->delete();
                }

                // 2. Xóa Favorites
                $user->favorites()->delete();

                // 3. Xóa Reviews
                $user->reviews()->delete();

                // 4. Xóa địa chỉ UserAddress
                $user->addresses()->delete();

                // 5. Xóa Orders, OrderDetails và Shippings liên quan
                foreach ($user->orders as $order) {
                    $order->orderDetails()->delete();
                    if ($order->shipping) {
                        $order->shipping()->delete();
                    }
                    $order->delete();
                }

                // 6. Xóa người dùng khỏi cơ sở dữ liệu
                $user->delete();
            });

            return true;
        }

        return false;
    }

    public function handleCreateUser($data)
    {

         // Xác định role_id từ vai trò
        $roleMap = [
            '1' => 1,  // ADMIN
            '2' => 2,  // SHIPPED
            '3' => 3,  // USER
        ];
        $roleId = $roleMap[$data['user_role']] ?? 3; // Mặc định là USER nếu không xác định


        // Lưu avatar (nếu có)
        $avatarPath = null;
        if (isset($data['user_avatar'])) {
            $avatarPath = $data['user_avatar']->store('avatars', 'public');
            // Lấy chỉ tên file từ đường dẫn
            $avatarPath = basename($avatarPath);
        }

        // Tạo user
        return User::create([
            'user_name' => $data['user_name'],
            'user_email' => $data['user_email'],
            'user_password' => $data['user_password'],
            'user_phone' => $data['user_phone'] ?? null,
            'user_address' => $data['user_address'] ?? null,
            'user_avatar' => $avatarPath,
            'role_id' => $roleId,
        ]);
    }

    public function handleUpdateUser($id, $data)
    {
        $user = User::find($id);

        if (!$user) {
            return null;
        }

         // Xác định role_id từ vai trò
        $roleMap = [
            '1' => 1,  // ADMIN
            '2' => 2,  // SHIPPED
            '3' => 3,  // USER
        ];
        $roleId = $roleMap[$data['user_role']] ?? 3; // Mặc định là USER nếu không xác định

        // Lưu avatar mới (nếu có) và xóa avatar cũ
        if (isset($data['user_avatar'])) {
            // Nếu có avatar cũ, xóa nó
            if ($user->user_avatar != "default-google.png" || $user->user_avatar != "default-avatar.jpg") {
                Storage::disk('public')->delete('avatars/' . $user->user_avatar); // Thêm thư mục vào đường dẫn
            }
            // Lưu avatar mới và chỉ lưu tên file
            $data['user_avatar'] = basename($data['user_avatar']->store('avatars', 'public'));
        } else {
            // Nếu không có avatar mới, giữ lại avatar cũ
            $data['user_avatar'] = $user->user_avatar;
        }

        // Cập nhật thông tin người dùng
        $user->update([
            'user_name' => $data['user_name'],
            'user_email' => $data['user_email'],
            'user_phone' => $data['user_phone'] ?? null,
            'user_address' => $data['user_address'] ?? null,
            'user_avatar' => $data['user_avatar'],
            'role_id' => $roleId,
        ]);

        return $user;
    }


    public function updateProfileUserHomepage(array $data, User $user)
    {
        // Cập nhật thông tin cơ bản
        $user->user_name    = $data['user_name'];
        $user->user_email   = $data['user_email'] ?? $user->user_email;
        $user->user_phone   = $data['user_phone'] ?? null;
        $user->user_address = $data['user_address'] ?? null;
        if (isset($data['role_id'])) {
            $user->role_id  = $data['role_id'];
        }


        // Lưu avatar mới (nếu có) và xóa avatar cũ
        if (isset($data['user_avatar']) && $data['user_avatar'] instanceof \Illuminate\Http\UploadedFile) {
            if (
                $user->user_avatar !== "default-google.png" &&
                $user->user_avatar !== "default-avatar.jpg" &&
                Storage::disk('public')->exists('avatars/' . $user->user_avatar)
            ) {
                Storage::disk('public')->delete('avatars/' . $user->user_avatar);
            }

            $data['user_avatar'] = basename($data['user_avatar']->store('avatars', 'public'));
            $user->user_avatar = $data['user_avatar'];
        }

        $user->save();

        return true;
    }

}
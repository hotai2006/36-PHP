<?php
/**
 * Fix: Cập nhật lại toàn bộ mapping ảnh chưa chính xác cho 25 sản phẩm
 * và copy ảnh từ public/img vào thư mục storage của Laravel.
 */

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Product;
use Illuminate\Support\Facades\File;

// 1. Tạo thư mục storage/app/public/products nếu chưa có
$targetDir = storage_path('app/public/products');
if (!File::exists($targetDir)) {
    File::makeDirectory($targetDir, 0777, true, true);
    echo "✓ Đã tạo thư mục: {$targetDir}\n";
}

// 2. Sao chép các file ảnh từ public/img sang thư mục storage
$sourceDir = public_path('img');
if (File::exists($sourceDir)) {
    $files = File::files($sourceDir);
    foreach ($files as $file) {
        $destPath = $targetDir . '/' . $file->getFilename();
        File::copy($file->getRealPath(), $destPath);
        chmod($destPath, 0777);
    }
    echo "✓ Đã sao chép " . count($files) . " hình ảnh vào storage/app/public/products\n";
} else {
    echo "⚠️ Không tìm thấy thư mục ảnh nguồn tại {$sourceDir}\n";
}

// 3. Ánh xạ danh sách ảnh thực tế cho 25 sản phẩm thể thao
$fixes = [
    // Giày thể thao
    1 => 'Giay-Nike-Air-Zoom-Pegasus-41-White-Dusty-Cactus-FD2722-103.jpg',
    5 => 'a60f07b9b103.jpg',
    7 => 'img-5702-optimized.jpg',
    12 => 'Giay-Nike-Air-Zoom-Pegasus-41-White-Dusty-Cactus-FD2722-103.jpg',
    14 => 'a60f07b9b103.jpg',
    16 => 'Giay-Nike-Air-Zoom-Pegasus-41-White-Dusty-Cactus-FD2722-103.jpg',

    // Áo thể thao
    2 => '100245913_FR_eCom.jpg',
    4 => 'ea-ua-hg-authentics-comp-ls-tops-womens-black-9ee2aec5-e9f1-4337-8e88-e89b53248a51-jpgrendition.jpg',
    11 => '100245913_FR_eCom.jpg',
    13 => 'ea-ua-hg-authentics-comp-ls-tops-womens-black-9ee2aec5-e9f1-4337-8e88-e89b53248a51-jpgrendition.jpg',
    19 => 'ea-ua-hg-authentics-comp-ls-tops-womens-black-9ee2aec5-e9f1-4337-8e88-e89b53248a51-jpgrendition.jpg',
    20 => 'ea-ua-hg-authentics-comp-ls-tops-womens-black-9ee2aec5-e9f1-4337-8e88-e89b53248a51-jpgrendition.jpg',

    // Quần thể thao
    3 => 'sg-11134201-824j4-mfc364q593ppd4.jpg',
    8 => 'p1942855.jpg',
    21 => 'sg-11134201-824j4-mfc364q593ppd4.jpg',
    24 => 'p1942855.jpg',

    // Phụ kiện / Dụng cụ thể thao
    6 => 'POWER-BACKPACK-ADIDAS-5.jpg',
    9 => 'picture.jpg',
    10 => '186691e91cc04a39ad8004d2cf7706fa.jpg', // Quả bóng
    15 => 'khung-vot-cau-long-lining-halbertec-7000-twilight-purple-paypw0154v-3_a048eac363a342efbc7ce7cb79e456b9.jpg', // Vợt
    17 => 'gang-tay-the-thao-adidas-predator-pro-gloves-hn3345-mau-den-trang-6424f982759ce-30032023095250.jpg', // Găng tay
    18 => 'POWER-BACKPACK-ADIDAS-5.jpg',
    22 => 'picture.jpg',
    23 => 'gang-tay-the-thao-adidas-predator-pro-gloves-hn3345-mau-den-trang-6424f982759ce-30032023095250.jpg',
    25 => 'picture.jpg',
];

$updatedCount = 0;
foreach ($fixes as $id => $image) {
    $product = Product::find($id);
    if ($product) {
        $old = $product->product_image_url;
        $product->product_image_url = $image;
        $product->save();
        $updatedCount++;
        echo "✓ ID {$id}: {$product->product_name}\n  {$old} → {$image}\n\n";
    }
}

echo "Hoàn tất cập nhật hình ảnh cho {$updatedCount} sản phẩm!\n";

<?php

namespace Database\Seeders;

use App\Enums\ProductStatusEnum;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Order::truncate();
        Product::truncate();
        Category::truncate();
        User::truncate();
        Schema::enableForeignKeyConstraints();

        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin'),
        ]);

        User::factory()->count(99)->create();

        $categoryNames = [
            'Phở Việt Viral',
            'Bún Nướng Chill',
            'Street Food Sài Gòn',
            'Đồ Chay Healthy',
            'Đặc Sản Vùng Miền',
            'Hải Sản Sốt Độc Lạ',
            'Đồ Uống Mixology',
            'Dessert TikTok',
            'BBQ Khói & Lửa',
            'Ăn Vặt Thần Tốc',
        ];

        $categories = Category::factory()
            ->count(count($categoryNames))
            ->sequence(fn ($sequence) => ['name' => $categoryNames[$sequence->index]])
            ->create();

        $baseDishes = [
            'Phở bò Hà Nội',
            'Bánh mì kẹp thịt',
            'Bún chả thủ đô',
            'Bún bò Huế',
            'Gỏi cuốn tôm thịt',
            'Cơm tấm sườn bì',
            'Bánh xèo miền Tây',
            'Mì Quảng gà vàng',
            'Bánh tráng nướng Đà Lạt',
            'Chè khúc bạch',
            'Bánh bao kim sa',
            'Lẩu thái hải sản',
            'Bánh cuốn Thanh Trì',
            'Xôi gà Hội An',
            'Bún riêu cua đồng',
            'Bánh đa cua Hải Phòng',
            'Nem nướng Nha Trang',
            'Bánh bèo chén',
            'Súp cua Sài Gòn',
            'Bánh hỏi lòng heo',
            'Ốc len xào dừa',
            'Bánh đúc nóng',
            'Cà phê trứng',
            'Sữa chua trân châu',
            'Kem dừa Cần Thơ',
        ];

        $descriptors = [
            'phiên bản Premium',
            'sốt Truffle',
            'vị Mala',
            'fusion Seoul',
            'topping Lava Cheese',
            'signature chef',
            'healthy fit',
            'matcha latte',
            'đặc sản mùa lễ hội',
            'phiên bản cold brew',
            'topping chà bông',
            'sốt mắm tắc',
            'phiên bản chay',
            'gluten-free',
            'phiên bản lửa hồng',
            'vị phô mai tan chảy',
            'sốt tiêu xanh',
            'topping trân châu đường đen',
            'phiên bản detox',
            'sốt me cay ngọt',
        ];

        $tagPool = [
            '#Trending',
            '#FoodTikTok',
            '#MustTry',
            '#MonNgonMoiNgay',
            '#CheckinQuanNet',
            '#HotHit2025',
            '#BestSeller',
            '#FoodieCall',
            '#ViralFood',
            '#AnGiDiDau',
        ];

        $faker = fake('vi_VN');
        $productData = [];

        foreach ($baseDishes as $baseDish) {
            foreach ($descriptors as $descriptor) {
                $name = trim("{$baseDish} {$descriptor}");
                $category = $categories->random();
                $status = Arr::random(ProductStatusEnum::cases());
                $tags = Arr::random($tagPool, 3);

                $productData[] = [
                    'name' => $name,
                    'description' => "Món {$name} đang gây bão trên mạng xã hội. Hashtags: " . implode(' ', $tags),
                    'price' => $faker->numberBetween(45000, 350000),
                    'status' => $status->value,
                    'is_active' => $faker->boolean(85),
                    'category_id' => $category->id,
                ];

                if (count($productData) >= 50) {
                    break 2;
                }
            }
        }

        Product::factory()
            ->count(count($productData))
            ->sequence(fn ($sequence) => $productData[$sequence->index])
            ->create();

        $users = User::all();
        $products = Product::all();

        Order::factory()
            ->count(1000)
            ->state(function () use ($users, $products, $faker) {
                $user = $users->random();
                $product = $products->random();

                return [
                    'user_id' => $user->id,
                    'product_id' => $product->id,
                    'price' => $product->price,
                    'created_at' => $faker->dateTimeBetween('-1 week', 'now'),
                    'updated_at' => $faker->dateTimeBetween('-1 week', 'now'),
                ];
            })
            ->create();
    }
}

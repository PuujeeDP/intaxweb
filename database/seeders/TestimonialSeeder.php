<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Testimonial;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $testimonials = [
            [
                'client_name' => 'Баярсайхан',
                'client_position' => 'Захирал',
                'client_company' => 'Монгол Технологи ХХК',
                'content' => 'Маш сайхан хамтын ажиллагаа болсон. Манай вэб сайтыг маш түргэн хугацаанд хийж гүйцэтгэсэн. Ажлын чанар, хурд бүгд маш сайн байлаа. Баярлалаа!',
                'rating' => 5,
                'order' => 1,
                'is_active' => true,
            ],
            [
                'client_name' => 'Сарнай',
                'client_position' => 'Маркетингийн менежер',
                'client_company' => 'Дижитал Маркетинг ХХК',
                'content' => 'Бүх зүйл маш мэргэжлийн түвшинд, цаг хугацаандаа хийгдсэн. Вэбсайт маш үзэсгэлэнтэй, хэрэглэхэд хялбар болсон. Санал болгож байна.',
                'rating' => 5,
                'order' => 2,
                'is_active' => true,
            ],
            [
                'client_name' => 'Болд',
                'client_position' => 'Гүйцэтгэх захирал',
                'client_company' => 'Бизнес Солюшн ХХК',
                'content' => 'Маш их баярлалаа. Манай бизнесийн онцлогийг маш сайн ойлгож, төгс шийдэл гаргасан. CMS систем нь хэрэглэхэд маш хялбар байна.',
                'rating' => 5,
                'order' => 3,
                'is_active' => true,
            ],
            [
                'client_name' => 'Оюунчимэг',
                'client_position' => 'Бүтээгдэхүүний менежер',
                'client_company' => 'Инновэйшн Хаб',
                'content' => 'Үнэхээр найдвартай, мэргэжлийн баг. Манай шаардлагыг бүрэн хангасан вэб систем бүтээсэн. Дэмжлэг үзүүлэх үйлчилгээ нь маш сайн.',
                'rating' => 5,
                'order' => 4,
                'is_active' => true,
            ],
            [
                'client_name' => 'Төмөр',
                'client_position' => 'IT менежер',
                'client_company' => 'Корпорэйт Групп',
                'content' => 'Техникийн түвшин өндөр, дизайн орчин үеийн. Вэбсайтын хурд сайн, админ хэсэг хэрэглэхэд амар. 5 од зүтгэж байна!',
                'rating' => 5,
                'order' => 5,
                'is_active' => true,
            ],
            [
                'client_name' => 'Номин',
                'client_position' => 'Санхүү захирал',
                'client_company' => 'Үндэсний Санхүү',
                'content' => 'Төсөл цаг хугацаандаа, төсөвтөө багтан хийгдсэн. Баг маш мэргэжлийн, харилцаа маш сайн байлаа. Баярлалаа.',
                'rating' => 4,
                'order' => 6,
                'is_active' => true,
            ],
            [
                'client_name' => 'Ганбаатар',
                'client_position' => 'Гүйцэтгэх захирал',
                'client_company' => 'Логистик Солюшн',
                'content' => 'Бидний вэб платформ одоо маш сайхан ажиллаж байна. Хэрэглэгчдийн санал хүсэлт ихсэж, онлайн борлуулалт өссөн. Баярлалаа!',
                'rating' => 5,
                'order' => 7,
                'is_active' => true,
            ],
            [
                'client_name' => 'Цэцэгмаа',
                'client_position' => 'Борлуулалтын менежер',
                'client_company' => 'E-Commerce Plus',
                'content' => 'Онлайн дэлгүүрийн систем маань төгс ажиллаж байна. SEO оновчтой бөгөөд Google-д сайн харагддаг болсон. Маш их баярлалаа.',
                'rating' => 5,
                'order' => 8,
                'is_active' => true,
            ],
        ];

        foreach ($testimonials as $testimonialData) {
            Testimonial::create($testimonialData);
        }
    }
}

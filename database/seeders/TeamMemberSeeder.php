<?php

namespace Database\Seeders;

use App\Models\Media;
use App\Models\TeamMember;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TeamMemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing team members
        TeamMember::query()->delete();
        $this->command->info('Cleared existing team members.');

        $teamMembers = [
            ['name' => 'Д.Түмэнжаргал', 'position' => 'Partner, Auditor', 'photo_url' => '/uploads/team/744a9a2c7c076124249ef9369cc544553d509557.jpg', 'order' => 1],
            ['name' => 'С. Мөнхбаяр', 'position' => 'CEO, Partner, Tax Consultant, Auditor', 'photo_url' => '/uploads/team/384f711a510bb1325840c78b0ee7ac4143159189.jpg', 'order' => 2],
            ['name' => 'Н. Мандах', 'position' => 'Auditor', 'photo_url' => '/uploads/team/89ad4ba42663b0fbbf3fe3464f6518e9f64bf112.jpg', 'order' => 3],
            ['name' => 'Д. Болорчулуун', 'position' => 'Tax Consultant', 'photo_url' => '/uploads/team/7462c2a33f0a32e112cefb6dc6aed4446de5edae.jpg', 'order' => 4],
            ['name' => 'П. Навчаа', 'position' => 'Training Manager', 'photo_url' => '/uploads/team/20ef9959cf36912f9c0bd026edc57178e2d43df9.jpg', 'order' => 5],
            ['name' => 'Ч. Алтангэрэл', 'position' => 'General Manager', 'photo_url' => '/uploads/team/fe2cb8782a8a6d1497dea3e9e27cbb96dc768416.jpg', 'order' => 6],
            ['name' => 'Х. Алтанзаяа', 'position' => 'Quality Control Manager, Auditor', 'photo_url' => '/uploads/team/d783feea31b62a90250a557d90c1ff107167ab5e.png', 'order' => 7],
            ['name' => 'О. Амартүвшин', 'position' => 'Consultant', 'photo_url' => '/uploads/team/8c4ef2bdc8927a8e7f4feb839ff18ef6cc6ac854.jpg', 'order' => 8],
            ['name' => 'Х. Амгаланзаяа', 'position' => 'Tax Manager', 'photo_url' => '/uploads/team/b1e2da55e4a9d1dfeeff80e6667d3f6d04ba938a.jpg', 'order' => 9],
            ['name' => 'Д. Пүрэвсүрэн', 'position' => 'Consulting Manager', 'photo_url' => '/uploads/team/35aac89921fcd38fa4982a16ba62cb6dc4fb9b1b.jpg', 'order' => 10],
            ['name' => 'Д. Батцэцэг', 'position' => 'Senior Auditor', 'photo_url' => '/uploads/team/a77c0c2e526a493c129347fc4080c1796a805ca6.jpg', 'order' => 11],
            ['name' => 'Г.Оюун', 'position' => 'Senior Auditor', 'photo_url' => '/uploads/team/b789e328db5cc9faccdd5a22481db4993c36ce8c.jpg', 'order' => 12],
            ['name' => 'Н.Мөнхзаяа', 'position' => 'Audit Manager, MBA', 'photo_url' => '/uploads/team/ead1fb808adaf9058b361ec88c6c3c4c1631cc01.jpg', 'order' => 13],
            ['name' => 'Д. Эрдэнэчулуун', 'position' => 'Marketing/Content Manager', 'photo_url' => '/uploads/team/0892bd83e1a4a0bb1b652fabb1343e73ed40524e.jpg', 'order' => 14],
            ['name' => 'З. Цэлмүүн', 'position' => 'Auditor', 'photo_url' => '/uploads/team/b0e6ed46b1bcd4d9df013aed64b858fb65177923.jpg', 'order' => 15],
            ['name' => 'Б.Данзандорж', 'position' => 'Assistant Auditor', 'photo_url' => '/uploads/team/892a086088d16cb3775fe187f82ca6008cda0b08.jpg', 'order' => 16],
            ['name' => 'Б. Мөнхтуяа', 'position' => 'Accountant', 'photo_url' => '/uploads/team/6680b96f9419c2a5fb05fe4458125371417ffddc.jpg', 'order' => 17],
            ['name' => 'Г. Янжинсүрэн', 'position' => 'Finance Trainer', 'photo_url' => '/uploads/team/9eb89bbc67bdc983446cb75fd2add9b2c107c825.jpg', 'order' => 18],
            ['name' => 'Г. Даваасүрэн', 'position' => 'Training Manager', 'photo_url' => '/uploads/team/d4f3f23f7397e34d1a0811612036e2b62966c5b0.jpg', 'order' => 19],
            ['name' => 'Г.Оюунтуяа', 'position' => 'Finance Trainer', 'photo_url' => '/uploads/team/418d4846d77d2f79c0650dbb8123a2f60a122c99.png', 'order' => 20],
            ['name' => 'Т. Баярмаа', 'position' => 'Finance Trainer', 'photo_url' => '/uploads/team/55d92419e9e2bf30f02c957b51d72ae612c2dfee.jpg', 'order' => 21],
            ['name' => 'Э. Тулга-Эрдэнэ', 'position' => 'Chief Accountant', 'photo_url' => '/uploads/team/112faabb9dbff0d1ec93f68c20e84cbb148d9d82.jpg', 'order' => 22],
            ['name' => 'В. Ангар', 'position' => 'Accountant', 'photo_url' => '/uploads/team/1b88b008d32683456b1567bee865bff5e8ac76ee.png', 'order' => 23],
            ['name' => 'Г. Бямбацэцэг', 'position' => 'Accountant', 'photo_url' => '/uploads/team/c8c7923ee9985ebfc3d992b6cc2b158260dd7d27.jpg', 'order' => 24],
            ['name' => 'Н. Лхамцэрэн', 'position' => 'Accountant', 'photo_url' => '/uploads/team/3f7377653e290a516243a7daaebc18f178d719d9.png', 'order' => 25],
            ['name' => 'О.Одсумъяа', 'position' => 'Finance Trainer', 'photo_url' => '/uploads/team/baa0c8759bc27927390bcd5c14bca9dcb287c2d2.jpg', 'order' => 26],
            ['name' => 'О. Гүндэгмаа', 'position' => 'Business Analyst', 'photo_url' => '/uploads/team/fa10c6daa106ce413e87380547e09b71b05afed3.jpg', 'order' => 27],
            ['name' => 'Г.Балдандорж', 'position' => 'Program Service Staff, Assistant Auditor, MBA', 'photo_url' => '/uploads/team/6ef702f065d539fba85397b177b67dc29d062b30.jpg', 'order' => 28],
            ['name' => 'О. Баярт', 'position' => 'Assistant Auditor', 'photo_url' => '/uploads/team/89c7719e92cc6b25ff0be683840eb4a16e40e684.jpg', 'order' => 29],
            ['name' => 'Ж.Ариунтуяа', 'position' => 'Receptionist', 'photo_url' => '/uploads/team/1b32c99f5d3b3f5c570baf5fabc44c5f68aa5c53.jpg', 'order' => 30],
            ['name' => 'Б.Саруул', 'position' => 'Assistant Accountant', 'photo_url' => '/uploads/team/891e5ec1bc0a53a64003f450c35087ae482d175a.jpg', 'order' => 31],
            ['name' => 'Г. Оюунтуул', 'position' => 'Receptionist', 'photo_url' => '/uploads/team/8c370df364d0bcd2cb98817ac3443f13fb0653b1.jpg', 'order' => 32],
            ['name' => 'Б. Сугаррагчаа', 'position' => 'Assistant Auditor', 'photo_url' => '/uploads/team/3d824674672e5f71e04c51957660979c3580f166.jpg', 'order' => 33],
            ['name' => 'Н.Номин', 'position' => 'Assistant Auditor', 'photo_url' => '/uploads/team/dfa414601d600a4a0cad5c4e1194724a4b5c3059.jpg', 'order' => 34],
            ['name' => 'Д.Анужин', 'position' => 'Accountant', 'photo_url' => '/uploads/team/78b2827e5d8e79fb1550e4d6d19a14f9b0de9b5f.jpg', 'order' => 35],
            ['name' => 'Г. Мэндбаяр', 'position' => 'Accountant', 'photo_url' => '/uploads/team/562dbbb897d20ec11143444eead9a182d4b6840c.jpg', 'order' => 36],
            ['name' => 'Ч. Ундрах', 'position' => 'Accountant', 'photo_url' => '/uploads/team/c844175e46925f01950655669338347bbbeedf08.jpg', 'order' => 37],
            ['name' => 'Э. Нансалмаа', 'position' => 'Accountant', 'photo_url' => '/uploads/team/663b3e51c06af0fe119234961c82d93ea4116a6e.jpg', 'order' => 38],
            ['name' => 'Ё. Өнөрцэцэг', 'position' => 'Accountant', 'photo_url' => '/uploads/team/2cc1326433269537fec06af3b569478fd2b5afea.jpg', 'order' => 39],
        ];

        foreach ($teamMembers as $memberData) {
            // Create or find media record
            $media = null;
            if (isset($memberData['photo_url'])) {
                $photoPath = ltrim($memberData['photo_url'], '/');
                $fileName = basename($photoPath);

                $media = Media::firstOrCreate([
                    'path' => $photoPath,
                ], [
                    'name' => pathinfo($fileName, PATHINFO_FILENAME),
                    'file_name' => $fileName,
                    'mime_type' => 'image/jpeg',
                    'size' => 0,
                    'disk' => 'public',
                    'uploaded_by' => 1,
                ]);
            }

            // Create team member
            $teamMember = TeamMember::create([
                'slug' => Str::slug($memberData['name']),
                'photo_id' => $media?->id,
                'email' => null,
                'phone' => null,
                'facebook' => null,
                'twitter' => null,
                'linkedin' => null,
                'is_active' => true,
                'order' => $memberData['order'],
            ]);

            // Add translations
            $teamMember->setTranslation('name', 'mn', $memberData['name']);
            $teamMember->setTranslation('name', 'en', $memberData['name']);
            $teamMember->setTranslation('name', 'zh', $memberData['name']);

            $teamMember->setTranslation('position', 'mn', $memberData['position']);
            $teamMember->setTranslation('position', 'en', $memberData['position']);
            $teamMember->setTranslation('position', 'zh', $memberData['position']);

            $teamMember->setTranslation('bio', 'mn', '');
            $teamMember->setTranslation('bio', 'en', '');
            $teamMember->setTranslation('bio', 'zh', '');

            $teamMember->save();
        }

        $this->command->info('Team members seeded successfully!');
    }
}

<?php

namespace Database\Seeders;

use App\Models\CompanyHistory;
use Illuminate\Database\Seeder;

class CompanyHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing data
        CompanyHistory::query()->delete();

        $histories = [
            [
                'year' => 2005,
                'title' => [
                    'en' => 'Company Founded',
                    'mn' => 'Компани үүсгэн байгуулагдсан',
                    'zh' => '公司成立',
                ],
                'description' => [
                    'en' => 'Magic Financial Group was established with a vision to provide comprehensive financial and business consulting services in Mongolia.',
                    'mn' => 'Монгол улсад санхүү болон бизнесийн зөвлөх үйлчилгээг иж бүрнээр үзүүлэх зорилготойгоор Мэжик Файнэншиал Групп компани үүсгэн байгуулагдсан.',
                    'zh' => 'Magic Financial Group 成立，旨在为蒙古提供全面的金融和商业咨询服务。',
                ],
                'order' => 1,
            ],
            [
                'year' => 2008,
                'title' => [
                    'en' => 'First Major Audit Contract',
                    'mn' => 'Анхны томоохон аудитын гэрээ',
                    'zh' => '首个大型审计合同',
                ],
                'description' => [
                    'en' => 'Secured our first major audit contract with a leading mining company, establishing our reputation in the industry.',
                    'mn' => 'Уул уурхайн салбарын тэргүүлэх компанитай анхны томоохон аудитын гэрээ байгуулж, салбарт нэр хүндээ тогтоосон.',
                    'zh' => '与一家领先的矿业公司签订了我们的第一份大型审计合同，在行业中树立了声誉。',
                ],
                'order' => 2,
            ],
            [
                'year' => 2010,
                'title' => [
                    'en' => 'Expanded Service Portfolio',
                    'mn' => 'Үйлчилгээний төрлөө өргөжүүлсэн',
                    'zh' => '扩展服务组合',
                ],
                'description' => [
                    'en' => 'Added tax consulting, legal services, and IT solutions to our comprehensive service offering.',
                    'mn' => 'Татварын зөвлөгөө, хуулийн үйлчилгээ, мэдээллийн технологийн шийдлүүдийг нэмж өргөжүүлсэн.',
                    'zh' => '在我们的综合服务中增加了税务咨询、法律服务和IT解决方案。',
                ],
                'order' => 3,
            ],
            [
                'year' => 2012,
                'title' => [
                    'en' => 'ISO Certification Achieved',
                    'mn' => 'ISO баталгаажуулалт хүлээн авсан',
                    'zh' => '获得ISO认证',
                ],
                'description' => [
                    'en' => 'Received ISO 9001:2008 certification, demonstrating our commitment to quality management systems.',
                    'mn' => 'ISO 9001:2008 баталгаажуулалт хүлээн авч, чанарын менежментийн системд тавих хүлээлтээ харуулсан.',
                    'zh' => '获得ISO 9001:2008认证，展示了我们对质量管理体系的承诺。',
                ],
                'order' => 4,
            ],
            [
                'year' => 2015,
                'title' => [
                    'en' => '50+ Corporate Clients',
                    'mn' => '50+ байгууллагын үйлчлүүлэгч',
                    'zh' => '50多家企业客户',
                ],
                'description' => [
                    'en' => 'Reached a milestone of serving over 50 corporate clients across various industries including mining, construction, and trade.',
                    'mn' => 'Уул уурхай, барилга, худалдаа зэрэг олон салбарын 50 гаруй байгууллагад үйлчилсэн түүхэн ололтод хүрсэн.',
                    'zh' => '达到为包括采矿、建筑和贸易在内的各行业50多家企业客户提供服务的里程碑。',
                ],
                'order' => 5,
            ],
            [
                'year' => 2018,
                'title' => [
                    'en' => 'Digital Transformation',
                    'mn' => 'Дижитал шилжилт хийсэн',
                    'zh' => '数字化转型',
                ],
                'description' => [
                    'en' => 'Launched our digital platform for real-time financial reporting and client collaboration, enhancing service efficiency.',
                    'mn' => 'Санхүүгийн тайлан болон үйлчлүүлэгчтэй хамтран ажиллах цахим платформыг нээж, үйлчилгээний үр ашгийг дээшлүүлсэн.',
                    'zh' => '推出了我们的数字平台，用于实时财务报告和客户协作，提高了服务效率。',
                ],
                'order' => 6,
            ],
            [
                'year' => 2020,
                'title' => [
                    'en' => 'Pandemic Resilience',
                    'mn' => 'Цар тахлын үед тогтвортой үйл ажиллагаа',
                    'zh' => '疫情期间的韧性',
                ],
                'description' => [
                    'en' => 'Successfully transitioned to remote operations during COVID-19, ensuring uninterrupted service delivery to all clients.',
                    'mn' => 'COVID-19 цар тахлын үед алсын зайнаас үйл ажиллагаагаа амжилттай явуулж, бүх үйлчлүүлэгчдэд тасралтгүй үйлчилгээ үзүүлсэн.',
                    'zh' => '在COVID-19期间成功过渡到远程操作，确保向所有客户提供不间断的服务。',
                ],
                'order' => 7,
            ],
            [
                'year' => 2022,
                'title' => [
                    'en' => 'Regional Expansion',
                    'mn' => 'Бүс нутагт тэлэлт хийсэн',
                    'zh' => '区域扩张',
                ],
                'description' => [
                    'en' => 'Opened branch offices in major provincial centers, extending our reach across Mongolia.',
                    'mn' => 'Монгол улсын томоохон аймгийн төвүүдэд салбар оффис нээж, хамрах хүрээгээ өргөжүүлсэн.',
                    'zh' => '在主要省级中心开设分支机构，将我们的业务范围扩展到蒙古各地。',
                ],
                'order' => 8,
            ],
            [
                'year' => 2024,
                'title' => [
                    'en' => '100+ Team Members',
                    'mn' => '100+ багийн гишүүн',
                    'zh' => '100多名团队成员',
                ],
                'description' => [
                    'en' => 'Grew our team to over 100 certified professionals, including auditors, tax consultants, lawyers, and IT specialists.',
                    'mn' => 'Аудитор, татварын зөвлөх, хуульч, мэдээллийн технологийн мэргэжилтнүүдийг багтаасан 100 гаруй баталгаатай мэргэжилтнүүдтэй баг болж өргөжсөн.',
                    'zh' => '我们的团队已发展到100多名经过认证的专业人员，包括审计师、税务顾问、律师和IT专家。',
                ],
                'order' => 9,
            ],
            [
                'year' => 2025,
                'title' => [
                    'en' => '20 Years of Excellence',
                    'mn' => '20 жилийн амжилт',
                    'zh' => '20年卓越',
                ],
                'description' => [
                    'en' => 'Celebrating two decades of delivering exceptional financial and business solutions, trusted by Mongolia\'s leading companies.',
                    'mn' => 'Монгол улсын тэргүүлэх компаниудын итгэлийг хүлээж, санхүү болон бизнесийн шилдэг шийдлүүдийг хоёр арван жил үргэлжлүүлэн хүргэж байгаагаа тэмдэглэж байна.',
                    'zh' => '庆祝二十年来为蒙古领先公司提供卓越的金融和商业解决方案，赢得了他们的信任。',
                ],
                'order' => 10,
            ],
        ];

        foreach ($histories as $historyData) {
            $history = CompanyHistory::create([
                'year' => $historyData['year'],
                'image_id' => null,
                'is_active' => true,
                'order' => $historyData['order'],
            ]);

            // Set translations
            foreach (['en', 'mn', 'zh'] as $locale) {
                $history->setTranslation('title', $locale, $historyData['title'][$locale]);
                $history->setTranslation('description', $locale, $historyData['description'][$locale]);
            }

            $history->save();
        }

        $this->command->info('Company history seeded successfully!');
    }
}

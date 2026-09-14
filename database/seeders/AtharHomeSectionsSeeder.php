<?php

namespace Database\Seeders;

use App\Models\HomeSettingPage;
use App\Models\HomeSettingPageTranslation;
use Illuminate\Database\Seeder;

class AtharHomeSectionsSeeder extends Seeder
{
    public function run(): void
    {
        $sections = [
            'why-us' => [
                'ar' => ['title' => 'شريكك نحو مستقبل أكبر', 'sub_title' => 'لماذا أثر؟', 'description' => 'نؤمن أن كل علامة تجارية تحمل قصة فريدة، ونحوّل هذه القصة إلى حضور رقمي مؤثر ونتائج ملموسة.'],
                'en' => ['title' => 'Your partner for a bigger future', 'sub_title' => 'Why Athar?', 'description' => 'Every brand carries a unique story. We turn it into an influential digital presence and measurable results.'],
            ],
            'why-feature-1' => [
                'ar' => ['title' => 'نهج استراتيجي', 'sub_title' => '01', 'description' => 'نخطط بنظرة طويلة المدى.'],
                'en' => ['title' => 'Strategic approach', 'sub_title' => '01', 'description' => 'We plan with a long-term view.'],
            ],
            'why-feature-2' => [
                'ar' => ['title' => 'فريق متخصص', 'sub_title' => '02', 'description' => 'خبرات تصنع النتائج.'],
                'en' => ['title' => 'Specialized team', 'sub_title' => '02', 'description' => 'Expertise that creates results.'],
            ],
            'why-feature-3' => [
                'ar' => ['title' => 'إبداع بلا حدود', 'sub_title' => '03', 'description' => 'أفكار تصنع الفرق.'],
                'en' => ['title' => 'Boundless creativity', 'sub_title' => '03', 'description' => 'Ideas that make a difference.'],
            ],
            'why-feature-4' => [
                'ar' => ['title' => 'التزام بالتميز', 'sub_title' => '04', 'description' => 'جودة في كل تفصيلة.'],
                'en' => ['title' => 'Committed to excellence', 'sub_title' => '04', 'description' => 'Quality in every detail.'],
            ],
            'process' => [
                'ar' => ['title' => 'من الفكرة إلى الأثر', 'sub_title' => 'من الفكرة إلى الأثر', 'description' => 'منهجية واضحة ومرنة تقود مشروعك من فهم الهدف إلى نتائج مستمرة.'],
                'en' => ['title' => 'From idea to impact', 'sub_title' => 'From idea to impact', 'description' => 'A clear, flexible methodology that takes your project from understanding the goal to lasting results.'],
            ],
            'process-step-1' => [
                'ar' => ['title' => 'نفهم الهدف', 'sub_title' => '01', 'description' => 'نستمع لأهدافك ونحلل احتياجات المشروع بعمق.'],
                'en' => ['title' => 'Understand the goal', 'sub_title' => '01', 'description' => 'We listen to your goals and analyze the project requirements.'],
            ],
            'process-step-2' => [
                'ar' => ['title' => 'نضع الاستراتيجية', 'sub_title' => '02', 'description' => 'نحوّل الفكرة إلى خطة واضحة وخطوات قابلة للتنفيذ.'],
                'en' => ['title' => 'Build the strategy', 'sub_title' => '02', 'description' => 'We turn the idea into a clear and actionable plan.'],
            ],
            'process-step-3' => [
                'ar' => ['title' => 'ننفذ بإبداع', 'sub_title' => '03', 'description' => 'نصمم ونطوّر بإتقان لنصنع أثرًا حقيقيًا.'],
                'en' => ['title' => 'Create with purpose', 'sub_title' => '03', 'description' => 'We design and build with precision to create real impact.'],
            ],
            'process-step-4' => [
                'ar' => ['title' => 'نقيس ونطوّر', 'sub_title' => '04', 'description' => 'نقيس الأثر ونحسّن النتائج باستمرار.'],
                'en' => ['title' => 'Measure and improve', 'sub_title' => '04', 'description' => 'We measure impact and continuously improve results.'],
            ],
            'statistics' => [
                'ar' => ['title' => 'أرقام تتحدث عن أثرنا', 'sub_title' => 'نتائج قابلة للقياس', 'description' => 'إنجازات نفخر بها وشراكات صنعت فرقًا حقيقيًا.'],
                'en' => ['title' => 'Numbers that show our impact', 'sub_title' => 'Measurable results', 'description' => 'Achievements we are proud of and partnerships that made a real difference.'],
            ],
            'blogs' => [
                'ar' => ['title' => 'أحدث المقالات', 'sub_title' => 'المدونة', 'description' => 'أفكار ورؤى تساعدك على صناعة حضور رقمي أقوى.'],
                'en' => ['title' => 'Latest articles', 'sub_title' => 'Blog', 'description' => 'Ideas and insights to help you build a stronger digital presence.'],
            ],
            'partners' => [
                'ar' => ['title' => 'شركاء في النجاح', 'sub_title' => 'شركاؤنا', 'description' => 'نفخر بثقة علامات وجهات رائدة.'],
                'en' => ['title' => 'Partners in success', 'sub_title' => 'Our partners', 'description' => 'Proud to be trusted by leading brands and organizations.'],
            ],
            'cta' => [
                'ar' => ['title' => 'جاهز لصناعة أثرك الرقمي؟', 'sub_title' => 'لنبدأ رحلتك الرقمية معًا', 'description' => 'تواصل معنا الآن واحصل على استشارة مبدئية لمشروعك.'],
                'en' => ['title' => 'Ready to create your digital impact?', 'sub_title' => 'Let’s start your digital journey', 'description' => 'Contact us today for an initial consultation about your project.'],
            ],
        ];

        foreach ($sections as $key => $translations) {
            $section = HomeSettingPage::firstOrCreate(
                ['title_section' => $key],
                ['status' => 1]
            );

            foreach ($translations as $locale => $content) {
                HomeSettingPageTranslation::firstOrCreate(
                    ['home_setting_id' => $section->id, 'locale' => $locale],
                    $content
                );
            }
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\About;
use App\Models\Blog;
use App\Models\Portfolios;
use App\Models\PortfolioTags;
use App\Models\ServiceCategory;
use App\Models\Services;
use App\Models\Statistic;
use Illuminate\Database\Seeder;

class AtharBrandContentSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['key'=>'web-apps','ar'=>'المواقع والتطبيقات','en'=>'Websites & applications','ar_desc'=>'مواقع وتطبيقات عصرية تجمع بين الإبداع وسهولة الاستخدام والأداء العالي.','en_desc'=>'Modern websites and applications that combine creativity, usability, and performance.'],
            ['key'=>'brand-identity','ar'=>'تصميم الهوية البصرية','en'=>'Visual identity design','ar_desc'=>'هويات بصرية متكاملة تعبّر عن علامتك وتبقى في ذاكرة جمهورك.','en_desc'=>'Distinctive visual identities that express your brand and stay memorable.'],
            ['key'=>'social-media','ar'=>'إدارة وسائل التواصل','en'=>'Social media management','ar_desc'=>'حضور قوي ومؤثر عبر محتوى إبداعي واستراتيجية مستمرة.','en_desc'=>'A strong, influential presence built through creative content and clear strategy.'],
            ['key'=>'digital-marketing','ar'=>'الإعلانات الرقمية','en'=>'Digital advertising','ar_desc'=>'حملات مدروسة تصل إلى جمهورك وتحوّل الاهتمام إلى نتائج.','en_desc'=>'Focused campaigns that reach the right audience and turn attention into results.'],
        ];

        foreach ($categories as $index => $item) {
            $category = ServiceCategory::updateOrCreate(
                ['service_unique_name' => $item['key']],
                ['image'=>'', 'sort'=>$index + 1, 'feature'=>1, 'status'=>1]
            );
            foreach (['ar','en'] as $locale) {
                $category->trans()->updateOrCreate(['locale'=>$locale], [
                    'title'=>$item[$locale], 'slug'=>$item['key'], 'description'=>$item[$locale.'_desc'],
                    'meta_title'=>$item[$locale], 'meta_desc'=>$item[$locale.'_desc'],
                ]);
            }

            $service = Services::updateOrCreate(
                ['service_category_id'=>$category->id, 'sort'=>1],
                ['status'=>1, 'feature'=>1]
            );
            $service->trans()->updateOrCreate(['locale'=>'ar'], ['title'=>$item['ar'],'slug'=>$item['key'].'-athar','description'=>$item['ar_desc'],'content'=>'نبدأ بفهم أهدافك وجمهورك، ثم نصنع أثرًا واضحًا قابلًا للقياس والتطوير.']);
            $service->trans()->updateOrCreate(['locale'=>'en'], ['title'=>$item['en'],'slug'=>$item['key'].'-athar','description'=>$item['en_desc'],'content'=>'We begin by understanding your goals and audience, then create focused impact that can be measured and improved.']);
        }

        $tag = PortfolioTags::firstOrCreate(['sort'=>1], ['status'=>1,'feature'=>1]);
        $tag->trans()->updateOrCreate(['locale'=>'ar'], ['title'=>'مشاريع رقمية','slug'=>'digital-projects']);
        $tag->trans()->updateOrCreate(['locale'=>'en'], ['title'=>'Digital projects','slug'=>'digital-projects']);
        $works = [
            ['slug'=>'nukhba-brand','ar'=>'هوية نخبة','en'=>'Nukhba identity'],
            ['slug'=>'mada-platform','ar'=>'منصة مدى','en'=>'Mada platform'],
            ['slug'=>'move-app','ar'=>'تطبيق MOVE','en'=>'MOVE app'],
            ['slug'=>'riwaq-app','ar'=>'تطبيق رواق','en'=>'Riwaq app'],
        ];
        foreach ($works as $index => $work) {
            $portfolio = Portfolios::updateOrCreate(['link'=>'#'.$work['slug']], ['tag_id'=>$tag->id,'image'=>'/site/images/athar-devices.png','sort'=>$index+1,'status'=>1,'feature'=>1,'type'=>'image']);
            $portfolio->trans()->updateOrCreate(['locale'=>'ar'], ['title'=>$work['ar'],'slug'=>$work['slug'],'description'=>'عمل رقمي متكامل من أثر صُمم ليعكس شخصية العلامة ويحقق تجربة واضحة ومؤثرة.']);
            $portfolio->trans()->updateOrCreate(['locale'=>'en'], ['title'=>$work['en'],'slug'=>$work['slug'],'description'=>'Integrated digital work by Athar, designed to express the brand and deliver a clear, engaging experience.']);
        }

        $posts = [
            ['slug'=>'strong-digital-identity','ar'=>'أهمية الهوية الرقمية القوية لنجاح علامتك','en'=>'Why a strong digital identity matters'],
            ['slug'=>'social-media-presence','ar'=>'كيف تبني حضورًا قويًا في وسائل التواصل؟','en'=>'How to build a strong social presence'],
            ['slug'=>'ecommerce-growth','ar'=>'استراتيجيات عملية لنمو تجارتك الإلكترونية','en'=>'Practical strategies for ecommerce growth'],
        ];
        foreach ($posts as $index => $post) {
            $blog = Blog::updateOrCreate(['sort'=>$index+1], ['image'=>'site/images/athar-devices.png','status'=>1,'feature'=>1]);
            $blog->trans()->updateOrCreate(['locale'=>'ar'], ['title'=>$post['ar'],'slug'=>$post['slug'],'description'=>'الحضور الرقمي القوي يبدأ بفهم واضح للعلامة والجمهور، ثم يتحول إلى تجربة متناسقة ومحتوى يقدم قيمة حقيقية. في أثر نربط الاستراتيجية بالإبداع والقياس حتى تستمر النتائج في النمو.','meta_title'=>$post['ar']]);
            $blog->trans()->updateOrCreate(['locale'=>'en'], ['title'=>$post['en'],'slug'=>$post['slug'],'description'=>'A strong digital presence begins with a clear understanding of the brand and its audience, then becomes a consistent experience and genuinely useful content. At Athar, we connect strategy, creativity, and measurement to sustain growth.','meta_title'=>$post['en']]);
        }

        $about = About::firstOrCreate([], ['status'=>1,'sort'=>1]);
        $valuesAr = [['title'=>'التميز','description'=>'نهتم بالتفاصيل التي تصنع الفارق.'],['title'=>'الابتكار','description'=>'نبتكر أثرًا يواكب المستقبل.'],['title'=>'المصداقية','description'=>'نبني علاقات قائمة على الوضوح.'],['title'=>'الشراكة','description'=>'نجاح عملائنا هو نجاحنا.']];
        $valuesEn = [['title'=>'Excellence','description'=>'We care about details that make a difference.'],['title'=>'Innovation','description'=>'We create impact ready for the future.'],['title'=>'Integrity','description'=>'We build relationships on clarity.'],['title'=>'Partnership','description'=>'Our clients success is our success.']];
        $about->trans()->updateOrCreate(['locale'=>'ar'], ['title'=>'من نحن','subtitle'=>'من فكرة إلى أثر حقيقي','description'=>'نحن فريق يؤمن بأن كل علامة تجارية تحمل قصة فريدة. نحوّل هذه القصة إلى حضور رقمي مؤثر ونتائج ملموسة.','our_story_title'=>'من فكرة إلى أثر حقيقي','our_story_description'=>'تأسست أثر برؤية واضحة: تمكين العلامات العربية من بناء حضور رقمي قوي ومستدام يجمع بين المعرفة العميقة بالسوق وأحدث التقنيات.','vision'=>'أن نكون الشريك الأول للعلامات العربية في صناعة الحضور الرقمي المؤثر.','mission'=>'تمكين العلامات التجارية من النمو عبر أثر إبداعي واستراتيجيات مبتكرة تصنع فرقًا حقيقيًا.','core_values'=>$valuesAr]);
        $about->trans()->updateOrCreate(['locale'=>'en'], ['title'=>'About us','subtitle'=>'From an idea to real impact','description'=>'We are a team that believes every brand has a distinct story. We turn that story into an influential digital presence and measurable results.','our_story_title'=>'From an idea to real impact','our_story_description'=>'Athar was founded with a clear vision: empower Arab brands to build strong, sustainable digital experiences by combining deep market understanding with modern technology.','vision'=>'To become the first partner for Arab brands creating influential digital experiences.','mission'=>'To enable brand growth through creative impact and innovative strategies that make a real difference.','core_values'=>$valuesEn]);

        $statistics = [['count'=>250,'ar'=>'عميل سعيد','en'=>'Happy clients'],['count'=>450,'ar'=>'مشروع منجز','en'=>'Projects delivered'],['count'=>5,'ar'=>'سنوات من الخبرة','en'=>'Years of experience'],['count'=>98,'ar'=>'رضا العملاء %','en'=>'Client satisfaction %']];
        foreach ($statistics as $index => $item) {
            $stat = Statistic::updateOrCreate(['sort'=>$index+1], ['count'=>$item['count'],'status'=>1,'feature'=>1]);
            $stat->trans()->updateOrCreate(['locale'=>'ar'], ['title'=>$item['ar'],'slug'=>'stat-'.$index]);
            $stat->trans()->updateOrCreate(['locale'=>'en'], ['title'=>$item['en'],'slug'=>'stat-'.$index]);
        }
    }
}

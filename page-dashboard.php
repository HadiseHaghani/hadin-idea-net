<?php
/* Template Name: داشبورد (IdeaNet) */

// اگر کاربر وارد نشده بود، به صفحه ورود منتقل بشه
if (!is_user_logged_in()) {
    wp_redirect(home_url('/login'));
    exit;
}

get_header();

// دریافت اطلاعات کاربر جاری
$current_user = wp_get_current_user();
$user_role    = ideanet_get_user_role();
?>

<main id="primary" class="site-main">
    <div class="flex flex-col lg:flex-row min-h-screen bg-gray-100">

        <!-- سایدبار -->
        <aside class="w-full lg:w-1/4 p-6 bg-white shadow-lg lg:min-h-screen">
            <nav>
                <ul class="space-y-4">
                    <li>
                        <a href="<?php echo home_url('/dashboard'); ?>"
                           class="flex items-center p-4 text-[#c1121f] bg-red-50 rounded-lg font-bold transition-colors duration-200">
                            <i class="fas fa-home ml-3"></i>
                            <span>داشبورد</span>
                        </a>
                    </li>

                    <?php if ($user_role === 'idea_owner') : ?>
                        <li>
                            <a href="<?php echo home_url('/submit-idea'); ?>"
                               class="flex items-center p-4 text-[#003049] hover:bg-gray-100 rounded-lg transition-colors duration-200">
                                <i class="fas fa-plus-circle ml-3"></i>
                                <span>ثبت ایده جدید</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo home_url('/my-ideas'); ?>"
                               class="flex items-center p-4 text-[#003049] hover:bg-gray-100 rounded-lg transition-colors duration-200">
                                <i class="fas fa-lightbulb ml-3"></i>
                                <span>ایده‌های من</span>
                            </a>
                        </li>
                    <?php endif; ?>

                    <li>
                        <a href="<?php echo home_url('/ideas'); ?>"
                           class="flex items-center p-4 text-[#003049] hover:bg-gray-100 rounded-lg transition-colors duration-200">
                            <i class="fas fa-search ml-3"></i>
                            <span>کشف ایده‌ها</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo home_url('/notifications'); ?>"
                           class="flex items-center p-4 text-[#003049] hover:bg-gray-100 rounded-lg transition-colors duration-200">
                            <i class="fas fa-bell ml-3"></i>
                            <span>اعلان‌ها</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo home_url('/messaging'); ?>"
                           class="flex items-center p-4 text-[#003049] hover:bg-gray-100 rounded-lg transition-colors duration-200">
                            <i class="fas fa-envelope ml-3"></i>
                            <span>پیام‌ها</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo home_url('/profile'); ?>"
                           class="flex items-center p-4 text-[#003049] hover:bg-gray-100 rounded-lg transition-colors duration-200">
                            <i class="fas fa-user-circle ml-3"></i>
                            <span>پروفایل من</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo home_url('/education'); ?>"
                           class="flex items-center p-4 text-[#003049] hover:bg-gray-100 rounded-lg transition-colors duration-200">
                            <i class="fas fa-graduation-cap ml-3"></i>
                            <span>منابع آموزشی</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo wp_logout_url(home_url()); ?>"
                           class="flex items-center p-4 text-[#003049] hover:bg-gray-100 rounded-lg transition-colors duration-200">
                            <i class="fas fa-sign-out-alt ml-3"></i>
                            <span>خروج</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- محتوای اصلی داشبورد -->
        <div class="flex-1 p-6 lg:p-12">

            <!-- پیام وضعیت -->
            <?php ideanet_display_status_message(); ?>

            <h1 class="text-3xl font-bold text-[#003049] mb-8">
                <?php echo 'خوش آمدید، ' . esc_html($current_user->display_name) . '!'; ?>
            </h1>

            <!-- نمایش بخش‌های مختلف بر اساس نقش کاربری -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php if ($user_role === 'idea_owner') : ?>
                    <div class="p-6 bg-red-50 rounded-xl shadow-inner border-r-4 border-red-500">
                        <h2 class="text-xl font-bold text-red-700 mb-2">داشبورد صاحب ایده</h2>
                        <p class="text-gray-700">ایده جدیدی ثبت کنید یا وضعیت ایده‌های قبلی خود را پیگیری نمایید.</p>
                        <a href="<?php echo home_url('/submit-idea'); ?>"
                           class="inline-block mt-4 px-6 py-2 bg-red-500 text-white rounded-full hover:bg-red-600 transition-colors duration-200">
                            ثبت ایده جدید
                        </a>
                        <a href="<?php echo home_url('/my-ideas'); ?>"
                           class="inline-block mt-4 px-6 py-2 bg-red-500 text-white rounded-full hover:bg-red-600 transition-colors duration-200">
                            مشاهده ایده‌ها
                        </a>
                    </div>

                <?php elseif ($user_role === 'investor') : ?>
                    <div class="p-6 bg-blue-50 rounded-xl shadow-inner border-r-4 border-blue-500">
                        <h2 class="text-xl font-bold text-blue-700 mb-2">داشبورد سرمایه‌گذار</h2>
                        <p class="text-gray-700">آخرین ایده‌های جذاب برای سرمایه‌گذاری را بررسی کنید.</p>
                        <a href="<?php echo home_url('/ideas'); ?>"
                           class="inline-block mt-4 px-6 py-2 bg-blue-500 text-white rounded-full hover:bg-blue-600 transition-colors duration-200">
                            جستجوی ایده‌ها
                        </a>
                    </div>

                <?php elseif ($user_role === 'specialist') : ?>
                    <div class="p-6 bg-yellow-50 rounded-xl shadow-inner border-r-4 border-yellow-500">
                        <h2 class="text-xl font-bold text-yellow-700 mb-2">داشبورد متخصص</h2>
                        <p class="text-gray-700">برای مشاوره فنی به صاحبان ایده، ایده‌های در انتظار تخصص را بررسی کنید.</p>
                        <a href="<?php echo home_url('/ideas'); ?>"
                           class="inline-block mt-4 px-6 py-2 bg-yellow-500 text-white rounded-full hover:bg-yellow-600 transition-colors duration-200">
                            مشاهده ایده‌ها
                        </a>
                    </div>
                <?php endif; ?>
            </div>

            <!-- فعالیت‌های اخیر -->
            <div class="mt-8">
                <h2 class="text-2xl font-bold text-[#003049] mb-4">فعالیت‌های اخیر</h2>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <ul class="divide-y divide-gray-200">
                        <li class="py-4 flex justify-between items-center">
                            <div class="text-gray-700">
                                <span class="font-bold">فاطمه احمدی</span> به ایده
                                <span class="text-[#c1121f] font-bold">"اپلیکیشن هوش مصنوعی برای مدیریت مالی"</span>
                                ابراز علاقه کرد.
                            </div>
                            <span class="text-sm text-gray-500">۳ ساعت پیش</span>
                        </li>
                        <li class="py-4 flex justify-between items-center">
                            <div class="text-gray-700">
                                <span class="font-bold">محسن کریمی</span> برای ایده
                                <span class="text-[#c1121f] font-bold">"پلتفرم آموزشی آنلاین"</span>
                                پیشنهاد مشاوره فنی داد.
                            </div>
                            <span class="text-sm text-gray-500">۱ روز پیش</span>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</main>

<?php get_footer(); ?>

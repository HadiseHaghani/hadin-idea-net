<?php
// این فایل مسئول نمایش صفحه منابع آموزشی است.

get_header(); // فراخوانی هدر سایت

// بررسی اینکه آیا کاربر وارد شده است یا خیر
if (!is_user_logged_in()) {
    // اگر کاربر وارد نشده باشد، به صفحه ورود هدایت می‌شود.
    wp_redirect(site_url('/login'));
    exit;
}
?>

<div class="container mx-auto py-8 px-4 md:px-0">
    <div class="bg-white p-6 rounded-lg shadow-md">

        <h1 class="text-3xl font-bold text-[#003049] mb-6 text-center md:text-right">
            منابع آموزشی
        </h1>
        <p class="text-gray-600 mb-8 text-center md:text-right">
            در این بخش می‌توانید به منابع آموزشی کاربردی در زمینه کارآفرینی و جذب سرمایه دسترسی پیدا کنید.
        </p>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            <!-- کارت نمونه برای یک مقاله/ویدیو آموزشی -->
            <div class="bg-gray-50 p-6 rounded-lg shadow-inner flex flex-col items-start text-right">
                <h3 class="text-lg font-bold text-[#c1121f] mb-2">چگونه یک طرح کسب‌وکار موفق بنویسیم؟</h3>
                <p class="text-gray-700 text-sm mb-4 flex-1">
                    در این مقاله، مراحل کلیدی نوشتن یک Business Plan جامع و متقاعدکننده را آموزش می‌دهیم
                    که می‌تواند نظر سرمایه‌گذاران را جلب کند.
                </p>
                <a href="#"
                   class="inline-block mt-auto p-2 bg-[#003049] text-white rounded-lg hover:bg-[#c1121f] transition duration-300">
                    مطالعه بیشتر
                </a>
            </div>

            <!-- کارت نمونه دیگر -->
            <div class="bg-gray-50 p-6 rounded-lg shadow-inner flex flex-col items-start text-right">
                <h3 class="text-lg font-bold text-[#c1121f] mb-2">اصول اولیه جذب سرمایه برای استارتاپ‌ها</h3>
                <p class="text-gray-700 text-sm mb-4 flex-1">
                    این راهنما شما را با اصطلاحات و فرآیندهای رایج در دنیای سرمایه‌گذاری خطرپذیر آشنا می‌کند
                    و به شما کمک می‌کند تا برای جلسات سرمایه‌گذاری آماده شوید.
                </p>
                <a href="#"
                   class="inline-block mt-auto p-2 bg-[#003049] text-white rounded-lg hover:bg-[#c1121f] transition duration-300">
                    مطالعه بیشتر
                </a>
            </div>

            <!-- کارت نمونه دیگر -->
            <div class="bg-gray-50 p-6 rounded-lg shadow-inner flex flex-col items-start text-right">
                <h3 class="text-lg font-bold text-[#c1121f] mb-2">بازاریابی دیجیتال برای ایده‌های نوآورانه</h3>
                <p class="text-gray-700 text-sm mb-4 flex-1">
                    بیاموزید چگونه از ابزارهای بازاریابی دیجیتال برای معرفی و رشد ایده خود در فضای آنلاین استفاده کنید
                    و به مخاطبان هدف دسترسی پیدا کنید.
                </p>
                <a href="#"
                   class="inline-block mt-auto p-2 bg-[#003049] text-white rounded-lg hover:bg-[#c1121f] transition duration-300">
                    مطالعه بیشتر
                </a>
            </div>

        </div>
    </div>
</div>

<?php get_footer(); // فراخوانی فوتر سایت ?>

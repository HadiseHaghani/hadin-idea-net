<?php
// این فایل مسئول نمایش سیستم پیام‌رسان داخلی است.

get_header(); // فراخوانی هدر سایت

// بررسی اینکه آیا کاربر وارد شده است یا خیر
if (!is_user_logged_in()) {
    // اگر کاربر وارد نشده باشد، به صفحه ورود هدایت می‌شود.
    wp_redirect(site_url('/login'));
    exit;
}

$current_user = wp_get_current_user();
?>

<div class="container mx-auto py-8 px-4 md:px-0">
    <div class="bg-white p-6 rounded-lg shadow-md">

        <h1 class="text-3xl font-bold text-[#003049] mb-6 text-center md:text-right">پیام‌های خصوصی</h1>
        <p class="text-gray-600 mb-8 text-center md:text-right">
            در این بخش می‌توانید با سایر کاربران پلتفرم به صورت خصوصی در ارتباط باشید.
        </p>

        <div class="flex flex-col md:flex-row gap-6">

            <!-- سایدبار گفتگوها -->
            <div class="w-full md:w-1/3 bg-gray-50 p-4 rounded-lg shadow-inner">
                <h2 class="text-xl font-bold text-[#003049] mb-4 text-center">گفتگوها</h2>
                <ul class="space-y-2">
                    <!-- نمونه‌ای از گفتگوهای اخیر -->
                    <li class="p-3 bg-white rounded-lg shadow-sm border border-gray-200 cursor-pointer hover:bg-gray-100 transition-colors duration-200">
                        <div class="flex items-center justify-between">
                            <span class="font-bold text-[#c1121f]">امیر رضایی</span>
                            <span class="text-xs text-gray-500">دیروز</span>
                        </div>
                        <p class="text-sm text-gray-600 mt-1 truncate">سلام، درباره ایده شما سوالی داشتم...</p>
                    </li>
                    <li class="p-3 bg-white rounded-lg shadow-sm border border-gray-200 cursor-pointer hover:bg-gray-100 transition-colors duration-200">
                        <div class="flex items-center justify-between">
                            <span class="font-bold text-[#c1121f]">مهندس کریمی</span>
                            <span class="text-xs text-gray-500">۳ روز پیش</span>
                        </div>
                        <p class="text-sm text-gray-600 mt-1 truncate">قرارداد NDA رو آماده کردم...</p>
                    </li>
                    <li class="p-3 bg-white rounded-lg shadow-sm border border-gray-200 cursor-pointer hover:bg-gray-100 transition-colors duration-200">
                        <div class="flex items-center justify-between">
                            <span class="font-bold text-[#c1121f]">فاطمه حسینی</span>
                            <span class="text-xs text-gray-500">هفته پیش</span>
                        </div>
                        <p class="text-sm text-gray-600 mt-1 truncate">پیشنهاد سرمایه‌گذاری جدید...</p>
                    </li>
                </ul>
            </div>

            <!-- بخش نمایش پیام‌ها و فرم ارسال -->
            <div class="w-full md:w-2/3 bg-gray-50 p-4 rounded-lg shadow-inner flex flex-col justify-between" style="min-height: 500px;">
                
                <h2 class="text-xl font-bold text-[#003049] mb-4 text-center">گفتگو با امیر رضایی</h2>

                <!-- نمونه پیام‌ها -->
                <div class="flex-1 overflow-y-auto space-y-4 p-4">
                    <div class="flex justify-start">
                        <div class="bg-[#c1121f] text-white p-3 rounded-2xl max-w-xs shadow">
                            سلام، درباره ایده شما سوالی داشتم. می‌تونید بیشتر توضیح بدید؟
                        </div>
                    </div>
                    <div class="flex justify-end">
                        <div class="bg-[#003049] text-white p-3 rounded-2xl max-w-xs shadow">
                            سلام، بله حتماً. چه سوالی دارید؟
                        </div>
                    </div>
                </div>

                <!-- فرم ارسال پیام -->
                <form class="flex mt-4 gap-2">
                    <input 
                        type="text" 
                        placeholder="پیام خود را بنویسید..." 
                        class="flex-1 p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#c1121f] text-right"
                    >
                    <button 
                        type="submit" 
                        class="p-3 bg-[#003049] text-white rounded-lg hover:bg-[#c1121f] transition duration-300"
                    >
                        ارسال
                    </button>
                </form>

            </div>
        </div>
    </div>
</div>

<?php get_footer(); // فراخوانی فوتر سایت ?>

<?php 
// این فایل مسئول نمایش صفحه اعلان‌ها برای کاربران است.
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
        <h1 class="text-3xl font-bold text-[#003049] mb-6 text-center md:text-right">اعلان‌ها</h1>
        <p class="text-gray-600 mb-8 text-center md:text-right">
            اعلان‌های جدید و مهم شما در این بخش نمایش داده می‌شوند.
        </p>

        <div class="bg-gray-50 p-6 rounded-lg shadow-inner">
            <ul class="space-y-4">
                <!-- نمونه یک اعلان جدید -->
                <li class="flex items-start bg-white p-4 rounded-lg shadow-sm border border-gray-200">
                    <div class="w-2 h-2 bg-[#c1121f] rounded-full mt-2 ml-4"></div>
                    <div>
                        <p class="font-bold text-[#003049] text-right mb-1">قرارداد NDA جدید</p>
                        <p class="text-gray-700 text-right text-sm">
                            قرارداد NDA برای ایده 'پلتفرم هوشمند کشاورزی' توسط سرمایه‌گذار **امیر رضایی** امضا شد.
                        </p>
                        <span class="text-xs text-gray-400 block text-left mt-2">۲ ساعت پیش</span>
                    </div>
                </li>

                <!-- نمونه یک اعلان خوانده شده -->
                <li class="flex items-start bg-white p-4 rounded-lg shadow-sm border border-gray-200 opacity-60">
                    <div class="w-2 h-2 bg-gray-400 rounded-full mt-2 ml-4"></div>
                    <div>
                        <p class="font-bold text-[#003049] text-right mb-1">پیام جدید</p>
                        <p class="text-gray-700 text-right text-sm">
                            شما یک پیام جدید از **مهندس کریمی** دارید.
                        </p>
                        <span class="text-xs text-gray-400 block text-left mt-2">۱ روز پیش</span>
                    </div>
                </li>

                <!-- نمونه یک اعلان دیگر -->
                <li class="flex items-start bg-white p-4 rounded-lg shadow-sm border border-gray-200 opacity-60">
                    <div class="w-2 h-2 bg-gray-400 rounded-full mt-2 ml-4"></div>
                    <div>
                        <p class="font-bold text-[#003049] text-right mb-1">ایده شما تأیید شد</p>
                        <p class="text-gray-700 text-right text-sm">
                            ایده 'فروشگاه آنلاین محصولات دست‌ساز' برای نمایش عمومی تأیید شد.
                        </p>
                        <span class="text-xs text-gray-400 block text-left mt-2">۳ روز پیش</span>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>

<?php get_footer(); // فراخوانی فوتر سایت ?>

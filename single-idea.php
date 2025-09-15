<?php
// این فایل مسئول نمایش جزئیات یک ایده است.
get_header(); // فراخوانی هدر سایت

// بررسی اینکه آیا یک ایده نمایش داده می‌شود
if (have_posts()) :
    while (have_posts()) : the_post();

        // عنوان ایده
        $idea_title = get_the_title();

        // شبیه‌سازی سطح دسترسی
        $user_access_level = 0; // سطح 0 = عمومی
        $has_signed_nda = false; // شبیه‌سازی وضعیت امضای NDA

        if (is_user_logged_in()) {
            $current_user = wp_get_current_user();
            $user_role = ideanet_get_user_role();

            if ($user_role === 'investor' || $user_role === 'specialist') {
                $user_access_level = 1; // سطح 1: دسترسی به جزئیات خصوصی

                // شبیه‌سازی بررسی اینکه آیا کاربر NDA را برای این ایده امضا کرده است.
                // در آینده این منطق باید با بررسی دیتابیس جایگزین شود.
                if ($user_role === 'investor' && isset($_GET['access']) && $_GET['access'] === 'full') {
                    $has_signed_nda = true;
                }
            }
        }

        // شبیه‌سازی محتوای مراحل مختلف (این اطلاعات باید از Custom Fields دریافت شوند)
        $public_details  = get_the_content();
        $private_details = 'این جزئیات برای اعضای تأیید شده قابل مشاهده است. (مدل کسب‌وکار، تیم اجرایی)';
        $nda_details     = 'این جزئیات کامل و فنی پس از امضای قرارداد NDA قابل مشاهده است. (طرح‌های فنی کامل، پیش‌بینی‌های مالی دقیق، و اطلاعات محرمانه)';
        ?>

        <div class="container mx-auto py-8">
            <div class="bg-white p-6 rounded-lg shadow-md mb-8">
                <h1 class="text-3xl md:text-4xl font-extrabold text-[#003049] mb-4 text-center">
                    <?php echo esc_html($idea_title); ?>
                </h1>

                <!-- مرحله ۱: معرفی کوتاه و عمومی (همیشه قابل مشاهده) -->
                <div class="border-t border-[#669bbc] pt-4 mt-4">
                    <h2 class="text-2xl font-bold text-[#c1121f] mb-4">مرحله ۱: معرفی کوتاه و عمومی</h2>
                    <div class="text-[#003049] leading-relaxed rtl">
                        <?php echo apply_filters('the_content', $public_details); ?>
                    </div>
                </div>

                <!-- مرحله ۲: جزئیات برای اعضای تأیید شده (سرمایه‌گذاران و متخصصان) -->
                <?php if ($user_access_level >= 1) : ?>
                    <div class="border-t border-[#669bbc] pt-4 mt-6">
                        <h2 class="text-2xl font-bold text-[#c1121f] mb-4">مرحله ۲: جزئیات برای اعضای تأیید شده</h2>
                        <div class="text-[#003049] leading-relaxed rtl">
                            <p><?php echo esc_html($private_details); ?></p>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- مرحله ۳: جزئیات کامل (پس از امضای NDA) -->
                <?php if ($user_access_level >= 1 && $has_signed_nda) : ?>
                    <div class="border-t border-[#669bbc] pt-4 mt-6">
                        <h2 class="text-2xl font-bold text-[#c1121f] mb-4">مرحله ۳: جزئیات کامل و فنی (محرمانه)</h2>
                        <div class="text-[#003049] leading-relaxed rtl">
                            <p><?php echo esc_html($nda_details); ?></p>
                        </div>
                    </div>
                <?php elseif ($user_access_level >= 1 && !$has_signed_nda) : ?>
                    <!-- نمایش دکمه هدایت به صفحه NDA -->
                    <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded-lg mt-6" role="alert">
                        <p class="font-bold">برای دسترسی به جزئیات کامل ایده، نیاز به امضای قرارداد NDA است.</p>
                        <a href="<?php echo home_url('/nda?idea_id=' . get_the_ID()); ?>"
                           class="inline-block mt-2 font-semibold text-yellow-800 hover:text-yellow-900 underline">
                            مشاهده و امضای قرارداد NDA
                        </a>
                    </div>
                <?php elseif ($user_access_level === 0) : ?>
                    <!-- نمایش پیام برای کاربران عمومی -->
                    <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-4 rounded-lg mt-6" role="alert">
                        <p class="font-bold">برای مشاهده جزئیات بیشتر، وارد شوید.</p>
                        <a href="<?php echo home_url('/login'); ?>"
                           class="inline-block mt-2 font-semibold text-blue-800 hover:text-blue-900 underline">
                            ورود به حساب کاربری
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>

    <?php endwhile;
else :
    // اگر ایده‌ای یافت نشد
    echo '<div class="container mx-auto py-8"><div class="bg-white p-6 rounded-lg shadow-md text-center"><p class="text-lg font-bold text-[#003049]">متاسفانه ایده مورد نظر یافت نشد.</p></div></div>';
endif;

get_footer();

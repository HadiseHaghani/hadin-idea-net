<?php
/*
Template Name: NDA (IdeaNet)
*/

// بررسی اینکه آیا کاربر وارد شده است یا خیر
if (!is_user_logged_in()) {
    // اگر کاربر وارد نشده باشد، به صفحه ورود هدایت می‌شود.
    wp_redirect(site_url('/login'));
    exit;
}

get_header(); // فراخوانی هدر سایت

// دریافت اطلاعات کاربر فعلی و نقش او
$current_user = wp_get_current_user();
$user_role = ideanet_get_user_role();

// شبیه‌سازی اطلاعات ایده و NDA (این داده‌ها باید از دیتابیس واقعی دریافت شوند)
$idea_title = 'پلتفرم هوشمند کشاورزی';
$nda_content = "
<p>این قرارداد عدم افشا (NDA) در تاریخ [تاریخ] بین <strong>صاحب ایده: امیر رضایی</strong> و <strong>سرمایه‌گذار: [نام شما]</strong> منعقد می‌گردد.</p>
<p><strong>۱. موضوع قرارداد:</strong> طرف افشاکننده (سرمایه‌گذار) متعهد می‌شود تمامی اطلاعات محرمانه و اختصاصی مربوط به ایده '{$idea_title}' شامل جزئیات فنی، مدل کسب‌وکار، طرح‌های بازاریابی و هرگونه داده‌ای که از صاحب ایده دریافت می‌کند را محرمانه نگه دارد.</p>
<p><strong>۲. تعهد به محرمانگی:</strong> طرف افشاکننده متعهد می‌شود که اطلاعات محرمانه را به هیچ شخص ثالث، شرکت یا نهادی، بدون رضایت کتبی صاحب ایده، افشا نکند.</p>
<p><strong>۳. مدت قرارداد:</strong> این قرارداد به مدت ۵ سال از تاریخ امضای آن معتبر است.</p>
<p><strong>۴. جریمه نقض قرارداد:</strong> در صورت نقض هر یک از مفاد این قرارداد، طرف افشاکننده موظف به پرداخت جریمه‌ای معادل [مبلغ جریمه] به صاحب ایده خواهد بود.</p>
<p><strong>۵. امضا:</strong> با کلیک بر روی دکمه «امضای قرارداد»، شما به صورت دیجیتال این توافقنامه را امضا و به آن پایبند خواهید بود.</p>
";
?>

<div class="container mx-auto py-8 px-4 md:px-0">
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-3xl font-bold text-[#003049] mb-6 text-center md:text-right">قرارداد NDA (عدم افشا)</h1>
        <p class="text-gray-600 mb-8 text-center md:text-right">
            در این صفحه می‌توانید قراردادهای عدم افشا را مشاهده و امضا کنید تا به جزئیات ایده‌ها دسترسی کامل داشته باشید.
        </p>

        <?php if ($user_role !== 'investor') : ?>
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg" role="alert">
                <p class="font-bold">دسترسی محدود</p>
                <p>شما برای مشاهده و امضای قراردادهای NDA، باید نقش «سرمایه‌گذار» داشته باشید.</p>
            </div>
        <?php else : ?>
            <div class="bg-gray-50 p-6 rounded-lg shadow-inner">
                <h2 class="text-xl font-bold text-[#c1121f] mb-4 text-center">عنوان قرارداد: NDA ایده '<?php echo esc_html($idea_title); ?>'</h2>
                
                <!-- متن قرارداد با استفاده از کلاس prose برای خوانایی بهتر -->
                <div class="prose max-w-none text-right text-gray-700 leading-relaxed mb-6" dir="rtl">
                    <?php echo $nda_content; ?>
                </div>

                <!-- بخش امضای قرارداد و دکمه -->
                <div class="flex flex-col md:flex-row items-center justify-between mt-6 gap-4">
                    <button
                        id="sign-nda-btn"
                        class="w-full md:w-auto bg-secondary text-white font-bold py-3 px-6 rounded-lg hover:bg-secondary/90 transition-colors"
                    >
                        امضای قرارداد
                    </button>
                    <div id="signing-status" class="w-full md:w-1/2 text-center md:text-right text-gray-500 italic hidden">
                        در حال امضای قرارداد...
                    </div>
                    <div id="signed-success" class="w-full md:w-1/2 text-center md:text-right text-green-700 font-bold hidden">
                        <p>قرارداد با موفقیت امضا شد! اکنون می‌توانید به جزئیات کامل ایده دسترسی پیدا کنید.</p>
                    </div>
                </div>
            </div>
        <?php endif; ?>

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const signBtn = document.getElementById('sign-nda-btn');
        const signingStatus = document.getElementById('signing-status');
        const signedSuccess = document.getElementById('signed-success');

        if (signBtn) {
            signBtn.addEventListener('click', () => {
                // نمایش وضعیت "در حال امضا"
                signBtn.disabled = true;
                signBtn.classList.add('opacity-50', 'cursor-not-allowed');
                signingStatus.classList.remove('hidden');

                // شبیه‌سازی فرآیند امضای دیجیتال
                setTimeout(() => {
                    signingStatus.classList.add('hidden');
                    signedSuccess.classList.remove('hidden');
                    
                    // در اینجا باید منطق واقعی برای ثبت امضا در دیتابیس و اعطای دسترسی پیاده‌سازی شود
                    // برای مثال، ارسال یک درخواست AJAX به سرور وردپرس
                    // fetch('<?php echo home_url('/wp-json/ideanet/v1/sign-nda'); ?>', {
                    //     method: 'POST',
                    //     headers: {
                    //         'Content-Type': 'application/json',
                    //         'X-WP-Nonce': '<?php echo wp_create_nonce('wp_rest'); ?>'
                    //     },
                    //     body: JSON.stringify({ idea_id: '<?php echo get_the_ID(); ?>' })
                    // })
                    // .then(response => response.json())
                    // .then(data => {
                    //     if (data.success) {
                    //         signedSuccess.classList.remove('hidden');
                    //         // هدایت به صفحه ایده برای نمایش جزئیات کامل
                    //         // window.location.href = '<?php the_permalink(); ?>?access=full';
                    //     } else {
                    //         alert('مشکلی در امضای قرارداد رخ داد.');
                    //         signBtn.disabled = false;
                    //         signBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                    //     }
                    // })
                    // .catch(error => {
                    //     console.error('Error:', error);
                    //     alert('خطا در برقراری ارتباط با سرور.');
                    //     signBtn.disabled = false;
                    //     signBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                    // });

                }, 2000); // شبیه‌سازی تاخیر ۲ ثانیه برای امضا
            });
        }
    });
</script>

<?php get_footer(); ?>

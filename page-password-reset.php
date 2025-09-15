<?php
/*
Template Name: صفحه بازیابی رمز عبور (IdeaNet)
*/

// بررسی اینکه آیا کاربر قبلاً وارد شده است
// اگر بله، به صفحه داشبورد هدایت می‌شود.
if (is_user_logged_in()) {
    wp_redirect(home_url('/dashboard'));
    exit;
}

// فراخوانی هدر قالب وردپرس
get_header();

// بررسی وضعیت بازیابی رمز عبور از طریق پارامترهای URL
$reset_status = isset($_GET['reset_status']) ? sanitize_text_field($_GET['reset_status']) : '';
$status_message = '';
$status_class = '';

if ($reset_status === 'success') {
    $status_message = 'لینک بازیابی رمز عبور به ایمیل شما ارسال شد. لطفاً صندوق ورودی خود را بررسی کنید.';
    $status_class = 'bg-green-100 border-green-500 text-green-700';
} elseif ($reset_status === 'failed') {
    $status_message = 'متاسفانه مشکلی در ارسال لینک بازیابی رخ داد. لطفاً مطمئن شوید ایمیل صحیح است و دوباره تلاش کنید.';
    $status_class = 'bg-red-100 border-red-500 text-red-700';
} elseif ($reset_status === 'invalid_email') {
    $status_message = 'این ایمیل یا نام کاربری در سیستم ما وجود ندارد.';
    $status_class = 'bg-red-100 border-red-500 text-red-700';
} elseif ($reset_status === 'email_sent') {
    $status_message = 'اگر ایمیل شما در سیستم ثبت شده باشد، لینک بازیابی رمز عبور برای شما ارسال خواهد شد.';
    $status_class = 'bg-green-100 border-green-500 text-green-700';
}
?>

<main id="primary" class="site-main flex items-center justify-center min-h-screen py-10">
    <div class="bg-white p-8 md:p-12 rounded-2xl shadow-2xl w-full max-w-md text-center">
        <!-- عنوان فرم -->
        <h2 class="text-3xl font-bold text-primary mb-6">
            بازیابی رمز عبور
        </h2>

        <!-- توضیحات فرم -->
        <p class="text-text mb-8">
            لطفاً ایمیل یا نام کاربری خود را وارد کنید تا لینک بازیابی رمز عبور برایتان ارسال شود.
        </p>

        <!-- نمایش پیام وضعیت -->
        <?php if ($status_message) : ?>
            <div class="<?php echo $status_class; ?> p-4 rounded-lg border mb-6 text-sm" role="alert">
                <p><?php echo $status_message; ?></p>
            </div>
        <?php endif; ?>

        <!-- فرم بازیابی رمز عبور -->
        <form action="<?php echo esc_url(site_url('wp-login.php?action=lostpassword', 'login_post')); ?>" method="post" class="space-y-6">
            <!-- فیلد ایمیل یا نام کاربری -->
            <div>
                <input
                    type="text"
                    id="user_login"
                    name="user_login"
                    placeholder="نام کاربری یا ایمیل"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent transition-colors"
                    required
                >
            </div>

            <!-- دکمه ارسال -->
            <button
                type="submit"
                class="w-full bg-secondary text-white py-3 rounded-lg font-bold text-lg transition-all duration-300 hover:bg-primary"
            >
                ارسال لینک بازیابی
            </button>
        </form>

        <!-- لینک‌های کمکی -->
        <div class="mt-6 text-sm">
            <a href="<?php echo home_url('/login'); ?>" class="text-accent hover:underline transition-colors">
                بازگشت به صفحه ورود
            </a>
        </div>
    </div>
</main>

<?php get_footer(); ?>

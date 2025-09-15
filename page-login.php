<?php
/*
Template Name: صفحه ورود (IdeaNet)
*/

// بررسی اینکه آیا کاربر قبلاً وارد شده است
// اگر بله، به صفحه داشبورد هدایت می‌شود تا از ورود مجدد جلوگیری شود.
if (is_user_logged_in()) {
    wp_redirect(home_url('/dashboard'));
    exit;
}

// فراخوانی هدر قالب وردپرس
get_header();

// Display error message based on URL parameters
$error_message = '';
if (isset($_GET['login'])) {
    $login_status = sanitize_text_field($_GET['login']);
    if ($login_status === 'failed' || $login_status === 'invalid_username' || $login_status === 'invalid_email' || $login_status === 'incorrect_password') {
        $error_message = 'نام کاربری یا رمز عبور اشتباه است. لطفاً دوباره تلاش کنید.';
    } elseif ($login_status === 'empty_fields') {
        $error_message = 'لطفاً تمامی فیلدهای الزامی را پر کنید.';
    } elseif ($login_status === 'user_not_found') {
        $error_message = 'این نام کاربری در سیستم وجود ندارد.';
    } elseif ($login_status === 'logged_out') {
        $error_message = 'شما با موفقیت از سیستم خارج شدید.';
    }
}
?>

<!--
    این تمپلیت، فرم ورود به IdeaNet را نمایش می‌دهد.
    فرم به صورت پیش‌فرض به wp-login.php وردپرس پست می‌شود تا از سیستم احراز هویت داخلی استفاده کند.
-->
<main id="primary" class="site-main flex items-center justify-center min-h-screen py-10 px-4">
    <div class="bg-white p-8 md:p-10 rounded-2xl shadow-2xl w-full max-w-md border border-gray-200 text-center">
        <div class="mb-8">
            <a href="<?php echo home_url(); ?>">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.png" alt="لوگو IdeaNet" class="mx-auto h-12 mb-4">
            </a>
            <h1 class="text-3xl font-bold text-primary mb-2">ورود به حساب کاربری</h1>
            <p class="text-gray-600">برای دسترسی به امکانات سایت، وارد شوید.</p>
        </div>

        <?php if ($error_message) : ?>
            <div class="bg-red-100 border-r-4 border-red-500 text-red-700 p-4 rounded-lg mb-6 text-sm" role="alert">
                <p><?php echo $error_message; ?></p>
            </div>
        <?php endif; ?>

        <!-- فرم ورود با اکشن پیش‌فرض وردپرس -->
        <form id="ideanet-login-form" action="<?php echo esc_url(site_url('wp-login.php', 'login_post')); ?>" method="post" class="space-y-6 text-right">

            <!-- فیلد نام کاربری -->
            <div>
                <label for="username" class="block text-sm font-medium text-gray-700 mb-1">نام کاربری یا ایمیل</label>
                <input
                    type="text"
                    id="username"
                    name="log"
                    placeholder="نام کاربری یا ایمیل"
                    value="<?php echo isset($_GET['log']) ? esc_attr($_GET['log']) : ''; ?>"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent transition-colors"
                >
            </div>

            <!-- فیلد رمز عبور -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">رمز عبور</label>
                <input
                    type="password"
                    id="password"
                    name="pwd"
                    placeholder="رمز عبور"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent transition-colors"
                >
            </div>

            <!-- دکمه ورود -->
            <button
                type="submit"
                class="w-full bg-secondary text-white py-3 rounded-lg font-bold text-lg transition-all duration-300 hover:bg-primary"
            >
                ورود
            </button>
            <?php wp_nonce_field('wordpress-login', '_wpnonce'); ?>
            <input type="hidden" name="redirect_to" value="<?php echo home_url('/dashboard'); ?>" />
        </form>

        <!-- لینک‌های کمکی -->
        <div class="mt-6 text-sm">
            <a href="<?php echo wp_lostpassword_url(home_url('/password-reset')); ?>" class="text-accent hover:underline transition-colors">رمز عبور را فراموش کرده‌اید؟</a>
            <span class="mx-2 text-gray-500">|</span>
            <a href="<?php echo home_url('/register'); ?>" class="text-accent hover:underline transition-colors">ثبت‌نام در IdeaNet</a>
        </div>
    </div>
</main>
<?php get_footer(); ?>

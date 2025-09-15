<?php
/*
Template Name: صفحه ثبت‌نام (IdeaNet)
*/

// فراخوانی هدر
get_header();

// بررسی اینکه آیا کاربر وارد شده است یا خیر
if (is_user_logged_in()) {
    wp_redirect(home_url('/dashboard'));
    exit;
}

// نمایش پیام خطا در صورت وجود
$error_message = '';
if (isset($_GET['reg_status'])) {
    $status = sanitize_text_field($_GET['reg_status']);
    if ($status === 'failed') {
        $error_message = 'ثبت‌نام با مشکل مواجه شد. لطفا مجدداً تلاش کنید.';
    } elseif ($status === 'username_exists') {
        $error_message = 'این نام کاربری قبلاً ثبت شده است. لطفاً نام دیگری را انتخاب کنید.';
    } elseif ($status === 'email_exists') {
        $error_message = 'این ایمیل قبلاً ثبت شده است. اگر حساب دارید، وارد شوید.';
    } elseif ($status === 'empty_fields') {
        $error_message = 'لطفا تمامی فیلدهای الزامی را پر کنید.';
    }
}
?>

<!-- صفحه ثبت‌نام در IdeaNet یک فرم ساده و مینیمال برای ثبت‌نام کاربران جدید -->
<main id="primary" class="site-main flex items-center justify-center min-h-screen py-10">
    <div class="bg-white p-8 md:p-12 rounded-2xl shadow-2xl w-full max-w-md text-center">
        <!-- عنوان فرم -->
        <h2 class="text-3xl font-bold text-primary mb-6">ثبت‌نام در IdeaNet</h2>
        <!-- توضیحات فرم -->
        <p class="text-text mb-8">به جامعه بزرگ IdeaNet بپیوندید و ایده خود را به واقعیت تبدیل کنید.</p>

        <!-- پیام خطا -->
        <?php if ($error_message) : ?>
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg relative mb-6" role="alert">
                <span class="block sm:inline"><?php echo esc_html($error_message); ?></span>
            </div>
        <?php endif; ?>

        <!-- فرم ثبت‌نام -->
        <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post" class="space-y-6">
            <input type="hidden" name="action" value="ideanet_register_user">

            <!-- فیلد نام کاربری -->
            <div>
                <input type="text" id="username" name="user_login" placeholder="نام کاربری"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent transition-colors text-right"
                       required>
            </div>

            <!-- فیلد ایمیل -->
            <div>
                <input type="email" id="email" name="user_email" placeholder="ایمیل"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent transition-colors text-right"
                       required>
            </div>

            <!-- فیلد رمز عبور -->
            <div>
                <input type="password" id="password" name="user_pass" placeholder="رمز عبور"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent transition-colors text-right"
                       required>
            </div>

            <!-- فیلد نقش کاربری -->
            <div class="flex flex-col items-center md:items-start text-right">
                <label class="text-gray-700 font-bold mb-2">نقش کاربری خود را انتخاب کنید:</label>
                <div class="flex flex-wrap justify-center md:justify-start gap-4 space-y-2 md:space-y-0 md:space-x-4 md:space-x-reverse">
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="radio" name="user_role" value="idea_owner" class="form-radio text-primary h-4 w-4" checked>
                        <span class="mr-2 text-gray-700">صاحب ایده</span>
                    </label>
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="radio" name="user_role" value="investor" class="form-radio text-primary h-4 w-4">
                        <span class="mr-2 text-gray-700">سرمایه‌گذار</span>
                    </label>
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="radio" name="user_role" value="specialist" class="form-radio text-primary h-4 w-4">
                        <span class="mr-2 text-gray-700">متخصص</span>
                    </label>
                </div>
            </div>

            <?php wp_nonce_field('ideanet-register-nonce', 'ideanet_register_nonce'); ?>
            <input type="hidden" name="redirect_to" value="<?php echo esc_url(home_url('/dashboard')); ?>" />

            <!-- دکمه ثبت‌نام -->
            <button type="submit"
                    class="w-full bg-secondary text-white py-3 rounded-lg font-bold text-lg transition-all duration-300 hover:bg-primary">
                ثبت‌نام
            </button>
        </form>

        <!-- لینک ورود -->
        <div class="mt-6 text-sm">
            <a href="<?php echo home_url('/login'); ?>" class="text-accent hover:underline transition-colors">
                قبلاً ثبت‌نام کرده‌اید؟ وارد شوید.
            </a>
        </div>
    </div>
</main>

<?php get_footer(); ?>

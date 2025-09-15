<?php
/**
 * این فایل به صورت موقت برای ایجاد کاربر ادمین "hadin" است.
 * بعد از اجرای موفقیت‌آمیز، این فایل را از سرور خود حذف کنید.
 * برای اجرای آن، این فایل را در پوشه اصلی قالب قرار دهید و سپس به URL زیر بروید:
 * http://your-site.com/wp-content/themes/your-theme-name/create-admin-user.php
 *
 * ******************************
 * ** توجه: این فایل را در محیط واقعی و در دسترس عموم قرار ندهید. **
 * ******************************
 */

// مطمئن شوید که وردپرس لود شده است
require_once('../../../wp-load.php');

// دسترسی را فقط به ادمین محدود کنید تا از ایجاد مجدد کاربر توسط افراد غیرمجاز جلوگیری شود
if (!current_user_can('manage_options')) {
    wp_die('شما مجوز لازم برای اجرای این اسکریپت را ندارید.');
}

// اطلاعات کاربر جدید
$username = 'hadin';
$password = '123456';
$email    = 'admin@yoursite.com'; // ایمیل را به دلخواه خود تغییر دهید

// بررسی وجود کاربر با این نام کاربری
if (username_exists($username)) {
    echo 'کاربر "' . esc_html($username) . '" از قبل وجود دارد.<br>';
} else {
    // ایجاد کاربر
    $user_id = wp_create_user($username, $password, $email);

    if (is_wp_error($user_id)) {
        echo 'خطا در ایجاد کاربر: ' . esc_html($user_id->get_error_message()) . '<br>';
    } else {
        // اختصاص نقش 'administrator' به کاربر
        $user = new WP_User($user_id);
        $user->set_role('administrator');

        echo 'کاربر ادمین با نام کاربری "' . esc_html($username) . '" با موفقیت ایجاد شد.<br>';
    }
}
?>

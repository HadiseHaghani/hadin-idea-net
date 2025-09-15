<?php
// این فایل توابع اصلی و تنظیمات قالب رو مدیریت می‌کنه.

// تابعی برای فراخوانی فایل‌های استایل و اسکریپت
function hadin_enqueue_styles() {
    // فراخوانی فایل استایل اصلی (style.css)
    wp_enqueue_style('hadin-style', get_stylesheet_uri());

    // فراخوانی فایل TailwindCSS
    wp_enqueue_script('tailwind-cdn', 'https://cdn.tailwindcss.com', array(), '3.3.5', false);

    // فراخوانی فونت IRANSans
    wp_enqueue_style('hadin-iransans', get_template_directory_uri() . '/style.css', array(), '1.0');
}
add_action('wp_enqueue_scripts', 'hadin_enqueue_styles');

// تنظیمات قالب
function hadin_theme_setup() {
    // پشتیبانی از عنوان دینامیک
    add_theme_support('title-tag');

    // ثبت منوهای اصلی قالب
    register_nav_menus( array(
        'primary-menu' => __('منوی اصلی', 'ideanet'),
        'footer-menu'  => __('منوی فوتر', 'ideanet'),
    ) );

    // افزودن پشتیبانی از تصاویر بندانگشتی (thumbnails)
    add_theme_support('post-thumbnails');

    // ایجاد نقش‌های کاربری سفارشی
    add_role('idea_owner', 'صاحب ایده', array('read' => true, 'level_0' => true));
    add_role('investor', 'سرمایه‌گذار', array('read' => true, 'level_0' => true));
    add_role('specialist', 'متخصص', array('read' => true, 'level_0' => true));
}
add_action('after_setup_theme', 'hadin_theme_setup');

// تابعی برای ایجاد انواع پست سفارشی
function ideanet_register_custom_post_types() {
    // ایجاد Custom Post Type برای "ایده"
    register_post_type('idea', array(
        'labels' => array(
            'name'          => __('ایده‌ها', 'ideanet'),
            'singular_name' => __('ایده', 'ideanet'),
        ),
        'public'      => true,
        'has_archive' => true,
        'rewrite'     => array('slug' => 'ideas'),
        'supports'    => array('title', 'editor', 'author', 'thumbnail', 'excerpt', 'custom-fields'),
        'menu_icon'   => 'dashicons-lightbulb',
    ) );

    // ایجاد Custom Post Type برای "منبع آموزشی"
    register_post_type('education', array(
        'labels' => array(
            'name'          => __('منابع آموزشی', 'ideanet'),
            'singular_name' => __('منبع آموزشی', 'ideanet'),
        ),
        'public'      => true,
        'has_archive' => true,
        'rewrite'     => array('slug' => 'education'),
        'supports'    => array('title', 'editor', 'author', 'thumbnail', 'excerpt'),
        'menu_icon'   => 'dashicons-welcome-learn-more',
    ) );
}
add_action('init', 'ideanet_register_custom_post_types');

// تابعی برای ایجاد دسته‌بندی سفارشی (Taxonomy) برای ایده‌ها
function ideanet_register_idea_taxonomy() {
    $labels = array(
        'name'              => _x('دسته‌بندی ایده', 'taxonomy general name', 'ideanet'),
        'singular_name'     => _x('دسته‌بندی', 'taxonomy singular name', 'ideanet'),
        'search_items'      => __('جستجو در دسته‌بندی‌ها', 'ideanet'),
        'all_items'         => __('همه دسته‌بندی‌ها', 'ideanet'),
        'parent_item'       => __('دسته‌بندی والد', 'ideanet'),
        'parent_item_colon' => __('دسته‌بندی والد:', 'ideanet'),
        'edit_item'         => __('ویرایش دسته‌بندی', 'ideanet'),
        'update_item'       => __('به‌روزرسانی', 'ideanet'),
        'add_new_item'      => __('افزودن دسته‌بندی جدید', 'ideanet'),
        'new_item_name'     => __('نام دسته‌بندی جدید', 'ideanet'),
        'menu_name'         => __('دسته‌بندی ایده', 'ideanet'),
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'idea_category'),
    );

    register_taxonomy('idea_category', array('idea'), $args);
}
add_action('init', 'ideanet_register_idea_taxonomy');

// تابعی برای دریافت نقش کاربری فعلی
function ideanet_get_user_role() {
    if (is_user_logged_in()) {
        $user  = wp_get_current_user();
        $roles = (array) $user->roles;
        return $roles[0];
    }
    return false;
}

// تابعی برای نمایش پیام‌های وضعیت در داشبورد
function ideanet_display_status_message() {
    $status  = isset($_GET['submit_status']) ? sanitize_text_field($_GET['submit_status']) : '';
    $message = '';
    $class   = '';

    if ($status === 'success') {
        $message = 'ایده شما با موفقیت ثبت شد و پس از بررسی توسط تیم ادمین، تأیید و نمایش داده خواهد شد.';
        $class   = 'bg-green-100 border-green-500 text-green-700';
    } elseif ($status === 'failed') {
        $message = 'ثبت ایده با مشکل مواجه شد. لطفا دوباره تلاش کنید.';
        $class   = 'bg-red-100 border-red-500 text-red-700';
    } elseif ($status === 'not_logged_in') {
        $message = 'شما برای ثبت ایده باید وارد حساب کاربری خود شوید.';
        $class   = 'bg-yellow-100 border-yellow-500 text-yellow-700';
    } elseif ($status === 'access_denied') {
        $message = 'شما مجوز لازم برای دسترسی به این بخش را ندارید.';
        $class   = 'bg-red-100 border-red-500 text-red-700';
    }

    if ($message) {
        echo '<div class="my-6 p-4 rounded-lg border-r-4 ' . $class . '" role="alert">';
        echo ' <p class="text-sm">' . $message . '</p>';
        echo '</div>';
    }
}
add_action('the_content', 'ideanet_display_status_message');

// تابع برای مدیریت ثبت‌نام کاربر
function ideanet_handle_user_registration() {
    if (isset($_POST['ideanet_register_nonce']) && wp_verify_nonce($_POST['ideanet_register_nonce'], 'ideanet-register-nonce')) {
        $username = sanitize_user($_POST['user_login']);
        $email    = sanitize_email($_POST['user_email']);
        $password = $_POST['user_password'];
        $role     = isset($_POST['user_role']) ? sanitize_text_field($_POST['user_role']) : 'subscriber';

        // بررسی فیلدهای خالی
        if (empty($username) || empty($email) || empty($password)) {
            wp_redirect(add_query_arg('reg_status', 'empty_fields', home_url('/register')));
            exit;
        }

        // بررسی وجود نام کاربری
        if (username_exists($username)) {
            wp_redirect(add_query_arg('reg_status', 'username_exists', home_url('/register')));
            exit;
        }

        // بررسی وجود ایمیل
        if (email_exists($email)) {
            wp_redirect(add_query_arg('reg_status', 'email_exists', home_url('/register')));
            exit;
        }

        $user_id = wp_create_user($username, $password, $email);
        if (!is_wp_error($user_id)) {
            // نقش کاربری سفارشی را به کاربر جدید اختصاص دهید
            $user = new WP_User($user_id);
            $user->set_role($role);

            // ثبت‌نام با موفقیت انجام شد، به صفحه ورود هدایت می‌شود
            wp_redirect(add_query_arg('reg_status', 'success', home_url('/login')));
            exit;
        } else {
            // ثبت‌نام با خطا مواجه شد
            wp_redirect(add_query_arg('reg_status', 'failed', home_url('/register')));
            exit;
        }
    }
}
add_action('init', 'ideanet_handle_user_registration');

// تابعی برای مدیریت ثبت ایده جدید
function ideanet_handle_idea_submission() {
    if (isset($_POST['submit_idea_nonce']) && wp_verify_nonce($_POST['submit_idea_nonce'], 'submit_idea_nonce_action')) {
        if (!is_user_logged_in()) {
            wp_redirect(home_url('/login?submit_status=not_logged_in'));
            exit;
        }

        $user_role = ideanet_get_user_role();
        if ($user_role !== 'idea_owner') {
            wp_redirect(home_url('/dashboard?submit_status=access_denied'));
            exit;
        }

        $idea_title       = sanitize_text_field($_POST['idea_title']);
        $idea_excerpt     = sanitize_textarea_field($_POST['idea_excerpt']);
        $idea_description = sanitize_textarea_field($_POST['idea_description']);
        $security_level   = sanitize_text_field($_POST['security-level']);
        $idea_category    = isset($_POST['idea_category']) ? sanitize_text_field($_POST['idea_category']) : '';

        // اگر عنوان ایده خالی بود
        if (empty($idea_title)) {
            wp_redirect(add_query_arg('submit_status', 'failed', home_url('/submit-idea')));
            exit;
        }

        $new_idea_post = array(
            'post_title'   => $idea_title,
            'post_content' => $idea_description,
            'post_excerpt' => $idea_excerpt,
            'post_status'  => 'pending', // ایده‌ها ابتدا در وضعیت "در انتظار" قرار می‌گیرند
            'post_type'    => 'idea',
            'post_author'  => get_current_user_id(),
        );

        $post_id = wp_insert_post($new_idea_post);
        if (!is_wp_error($post_id)) {
            // اضافه کردن فیلدهای سفارشی برای سطح امنیتی
            update_post_meta($post_id, '_ideanet_security_level', $security_level);

            // تنظیم دسته‌بندی
            if (!empty($idea_category)) {
                wp_set_object_terms($post_id, $idea_category, 'idea_category');
            }

            wp_redirect(add_query_arg('submit_status', 'success', home_url('/dashboard')));
            exit;
        } else {
            wp_redirect(add_query_arg('submit_status', 'failed', home_url('/submit-idea')));
            exit;
        }
    }
}
add_action('init', 'ideanet_handle_idea_submission');

// تابع برای مدیریت NDA
function ideanet_handle_nda_agreement() {
    if (isset($_POST['nda_agreement_nonce']) && wp_verify_nonce($_POST['nda_agreement_nonce'], 'nda_agreement_action')) {
        if (!is_user_logged_in()) {
            // اگر کاربر وارد نشده باشد
            echo json_encode(array('success' => false, 'message' => 'User not logged in.'));
            wp_die();
        }

        $current_user_id = get_current_user_id();
        $idea_id         = isset($_POST['idea_id']) ? intval($_POST['idea_id']) : 0;

        if ($idea_id > 0) {
            // در دنیای واقعی، اینجا باید یک رکورد در دیتابیس ذخیره شود
            // که نشان دهد کاربر فعلی، NDA ایده با شناسه $idea_id را امضا کرده است.
            $signed_ideas = get_user_meta($current_user_id, '_signed_nda_ideas', true);
            if (!is_array($signed_ideas)) {
                $signed_ideas = [];
            }
            if (!in_array($idea_id, $signed_ideas)) {
                $signed_ideas[] = $idea_id;
                update_user_meta($current_user_id, '_signed_nda_ideas', $signed_ideas);
            }

            echo json_encode(array('success' => true, 'redirect_url' => get_permalink($idea_id)));
        } else {
            echo json_encode(array('success' => false, 'message' => 'Invalid idea ID.'));
        }
    }
    wp_die();
}
add_action('wp_ajax_ideanet_handle_nda_agreement', 'ideanet_handle_nda_agreement');
add_action('wp_ajax_nopriv_ideanet_handle_nda_agreement', 'ideanet_handle_nda_agreement'); // برای کاربران لاگین نکرده

// تابعی برای نمایش پیام‌های وضعیت در داشبورد
function ideanet_display_status_message_dashboard() {
    $status  = isset($_GET['submit_status']) ? sanitize_text_field($_GET['submit_status']) : '';
    $message = '';
    $class   = '';

    if ($status === 'success') {
        $message = 'ایده شما با موفقیت ثبت شد و پس از بررسی توسط تیم ادمین، تأیید و نمایش داده خواهد شد.';
        $class   = 'bg-green-100 border-green-500 text-green-700';
    } elseif ($status === 'failed') {
        $message = 'ثبت ایده با مشکل مواجه شد. لطفا دوباره تلاش کنید.';
        $class   = 'bg-red-100 border-red-500 text-red-700';
    } elseif ($status === 'not_logged_in') {
        $message = 'شما برای ثبت ایده باید وارد حساب کاربری خود شوید.';
        $class   = 'bg-yellow-100 border-yellow-500 text-yellow-700';
    } elseif ($status === 'access_denied') {
        $message = 'شما مجوز لازم برای دسترسی به این بخش را ندارید.';
        $class   = 'bg-red-100 border-red-500 text-red-700';
    }

    if ($message) {
        echo '<div class="my-6 p-4 rounded-lg border-r-4 ' . $class . '" role="alert">';
        echo ' <p class="text-sm">' . $message . '</p>';
        echo '</div>';
    }
}
add_action('ideanet_dashboard_messages', 'ideanet_display_status_message_dashboard');

function ideanet_register_problems_cpt() {
$labels = array(
'name' => 'مشکلات',
'singular_name' => 'مشکل',
'add_new' => 'اضافه کردن مشکل',
'add_new_item' => 'اضافه کردن مشکل جدید',
'edit_item' => 'ویرایش مشکل',
'new_item' => 'مشکل جدید',
'view_item' => 'مشاهده مشکل',
'search_items' => 'جستجوی مشکلات',
'not_found' => 'مشکلی یافت نشد',
'not_found_in_trash' => 'مشکلی در سطل زباله یافت نشد',
);


$args = array(
'labels' => $labels,
'public' => true,
'has_archive' => true,
'menu_position' => 5,
'menu_icon' => 'dashicons-lightbulb',
'supports' => array('title', 'editor'),
'show_in_rest' => true,
);


register_post_type('problem', $args);
}
add_action('init', 'ideanet_register_problems_cpt');



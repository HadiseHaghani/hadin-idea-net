<?php
/*
Template Name: ایده‌های من (IdeaNet)
*/

// بررسی اینکه آیا کاربر وارد شده است یا خیر
// اگر کاربر وارد نشده باشد، به صفحه ورود هدایت می‌شود.
if (!is_user_logged_in()) {
    wp_redirect(home_url('/login'));
    exit;
}

get_header();

$current_user = wp_get_current_user();
$user_role = ideanet_get_user_role();

// بررسی اینکه آیا کاربر صاحب ایده است یا خیر
// اگر نقش کاربر idea_owner نباشد، دسترسی را محدود می‌کند.
if ($user_role !== 'idea_owner') {
    echo '<div class="text-center p-10 mt-20 bg-white rounded-lg shadow-md max-w-lg mx-auto">
            <h1 class="text-3xl font-bold mb-4">دسترسی محدود</h1>
            <p>شما مجاز به مشاهده این صفحه نیستید.</p>
          </div>';
    get_footer();
    exit;
}

// آرگومان‌های کوئری برای دریافت ایده‌های کاربر فعلی
$args = array(
    'post_type'      => 'idea',
    'post_status'    => 'any', // 'any' برای نمایش ایده‌های در حال بررسی و منتشر شده
    'author'         => $current_user->ID,
    'posts_per_page' => -1, // نمایش همه ایده‌ها
);

// اجرای کوئری
$my_ideas_query = new WP_Query($args);
?>

<main id="primary" class="site-main py-10">
    <div class="container mx-auto px-4 md:px-0">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h1 class="text-3xl font-bold text-primary mb-6 text-center md:text-right">ایده‌های من</h1>
            <p class="text-gray-600 mb-8 text-center md:text-right">
                در این بخش می‌توانید ایده‌هایی که ثبت کرده‌اید را مدیریت و پیگیری کنید.
            </p>
            
            <?php if ($my_ideas_query->have_posts()) : ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php while ($my_ideas_query->have_posts()) : $my_ideas_query->the_post(); ?>
                        <div class="bg-gray-50 p-6 rounded-lg shadow-inner flex flex-col items-start text-right border-r-4 border-accent hover:shadow-xl transition-shadow duration-300">
                            <h2 class="text-xl font-bold text-text mb-2">
                                <?php the_title(); ?>
                            </h2>
                            <p class="text-gray-600 text-sm mb-4">
                                ثبت‌شده در: <?php echo get_the_date('j F Y'); ?>
                            </p>
                            <div class="text-gray-700 text-sm leading-relaxed mb-4 flex-1">
                                <?php the_excerpt(); ?>
                            </div>
                            <div class="flex justify-between items-center w-full mt-auto pt-4 border-t border-gray-200">
                                <span class="text-sm font-semibold px-3 py-1 rounded-full
                                    <?php
                                        $status = get_post_status(get_the_ID());
                                        if ($status === 'publish') {
                                            echo 'bg-green-100 text-green-700';
                                        } elseif ($status === 'pending') {
                                            echo 'bg-red-100 text-red-700';
                                        } else {
                                            echo 'bg-yellow-100 text-yellow-700';
                                        }
                                    ?>
                                ">
                                    <?php
                                        // نمایش وضعیت به صورت فارسی
                                        if ($status === 'publish') {
                                            echo 'تأیید شده';
                                        } elseif ($status === 'pending') {
                                            echo 'در حال بررسی';
                                        } else {
                                            echo 'پیش‌نویس';
                                        }
                                    ?>
                                </span>
                                <a href="<?php the_permalink(); ?>" class="text-secondary font-bold hover:underline">مشاهده جزئیات →</a>
                            </div>
                        </div>
                    <?php endwhile; wp_reset_postdata(); ?>
                </div>
            <?php else : ?>
                <div class="text-center py-10 bg-gray-50 rounded-lg">
                    <p class="text-lg font-bold text-primary mb-2">شما هنوز ایده‌ای ثبت نکرده‌اید.</p>
                    <p class="text-gray-600 mb-4">برای شروع، ایده جدید خود را ثبت کنید.</p>
                    <a href="<?php echo home_url('/submit-idea'); ?>" class="inline-block px-6 py-3 bg-secondary text-white rounded-lg font-bold hover:bg-secondary/90 transition-colors">ثبت ایده جدید</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php get_footer(); ?>

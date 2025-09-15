<?php
// این فایل مسئول نمایش لیست ایده‌ها (آرشیو ایده‌ها) است.
get_header();

// دریافت مقادیر جستجو از URL
$search_query       = isset($_GET['s']) ? sanitize_text_field($_GET['s']) : '';
$category           = isset($_GET['idea_category']) ? sanitize_text_field($_GET['idea_category']) : '';
$post_status_filter = isset($_GET['post_status']) ? sanitize_text_field($_GET['post_status']) : 'publish';

// آرگومان‌های کوئری برای نمایش ایده‌ها
$args = array(
    'post_type'   => 'idea',
    'post_status' => $post_status_filter,
    's'           => $search_query, // اعمال جستجو
);

// اعمال فیلتر دسته‌بندی اگر انتخاب شده باشد
if (!empty($category)) {
    $args['tax_query'] = array(
        array(
            'taxonomy' => 'idea_category',
            'field'    => 'slug',
            'terms'    => $category,
        ),
    );
}

// نمایش فقط ایده‌های کاربر جاری برای نقش Idea Owner
if (is_user_logged_in() && ideanet_get_user_role() === 'idea_owner') {
    $current_user    = wp_get_current_user();
    $args['author']  = $current_user->ID;
}

$ideas_query = new WP_Query($args);
?>

<div class="container mx-auto py-8 px-4 md:px-0">
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-3xl font-bold text-[#003049] mb-6 text-center md:text-right">
            جستجو و کشف ایده‌ها
        </h1>
        <p class="text-gray-600 mb-8 text-center md:text-right">
            ایده‌های نوآورانه را بر اساس عنوان، کلیدواژه یا دسته‌بندی مورد علاقه خود پیدا کنید.
        </p>

        <!-- فرم جستجو و فیلتر -->
        <form class="flex flex-col md:flex-row gap-4 mb-8" role="search" method="get">
            <input
                type="text"
                name="s"
                value="<?php echo esc_attr($search_query); ?>"
                placeholder="جستجو در ایده‌ها..."
                class="flex-1 p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#c1121f] transition-all"
            >

            <?php
            // دریافت تمام دسته‌بندی‌های 'idea_category'
            $categories = get_terms(array(
                'taxonomy'   => 'idea_category',
                'hide_empty' => true,
            ));

            if (!empty($categories) && !is_wp_error($categories)) :
            ?>
                <select
                    name="idea_category"
                    class="p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#c1121f] transition-all"
                >
                    <option value="">همه دسته‌بندی‌ها</option>
                    <?php foreach ($categories as $cat) : ?>
                        <option value="<?php echo esc_attr($cat->slug); ?>" <?php selected($category, $cat->slug); ?>>
                            <?php echo esc_html($cat->name); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            <?php endif; ?>

            <button
                type="submit"
                class="p-3 bg-secondary text-white rounded-lg font-bold hover:bg-[#a61019] transition-colors duration-300"
            >
                جستجو
            </button>
        </form>

        <!-- لیست ایده‌ها -->
        <?php if ($ideas_query->have_posts()) : ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php while ($ideas_query->have_posts()) : $ideas_query->the_post(); ?>
                    <div class="bg-gray-50 p-6 rounded-lg shadow-md border border-gray-200 hover:shadow-xl transition-shadow duration-300 transform hover:scale-105">
                        <h2 class="text-xl font-bold text-[#003049] mb-2 text-right">
                            <a href="<?php the_permalink(); ?>" class="hover:text-[#c1121f] transition duration-200">
                                <?php the_title(); ?>
                            </a>
                        </h2>
                        <p class="text-gray-600 text-sm mb-4 text-right">
                            <?php echo get_the_date('j F Y'); ?>
                        </p>
                        <div class="text-gray-700 text-right leading-relaxed mb-4">
                            <?php the_excerpt(); ?>
                        </div>
                        <a href="<?php the_permalink(); ?>" class="text-[#c1121f] font-bold hover:underline text-right block">
                            مشاهده جزئیات →
                        </a>
                    </div>
                <?php endwhile; wp_reset_postdata(); ?>
            </div>
        <?php else : ?>
            <div class="text-center py-10 bg-gray-100 rounded-lg">
                <p class="text-lg font-bold text-[#003049]">
                    متاسفانه ایده‌ای با این مشخصات یافت نشد.
                </p>
                <p class="text-gray-600 mt-2">
                    لطفاً جستجوی خود را تغییر دهید یا فیلترها را حذف کنید.
                </p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php get_footer(); ?>

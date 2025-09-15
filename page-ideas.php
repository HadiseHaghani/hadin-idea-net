<?php
/*
Template Name: کشف ایده‌ها (IdeaNet)
*/

get_header();

// دریافت مقادیر جستجو از URL
$search_query = isset($_GET['s']) ? sanitize_text_field($_GET['s']) : '';
$category     = isset($_GET['idea_category']) ? sanitize_text_field($_GET['idea_category']) : '';
$user_role    = ideanet_get_user_role(); // تابع کمکی برای دریافت نقش کاربر

// آرگومان‌های کوئری برای نمایش ایده‌ها
$args = array(
    'post_type'   => 'idea',
    'post_status' => 'publish',
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

$ideas_query = new WP_Query($args);
?>

<main id="primary" class="site-main py-8">
    <div class="container mx-auto px-4 md:px-0">
        <div class="bg-white p-6 rounded-lg shadow-md">
            
            <h1 class="text-3xl font-bold text-[#003049] mb-4 text-center md:text-right">
                کشف ایده‌های نوآورانه
            </h1>
            <p class="text-gray-600 mb-8 text-center md:text-right">
                ایده‌ها را جستجو کنید و آن‌ها را بر اساس دسته‌بندی فیلتر کنید.
            </p>

            <!-- فرم جستجو و فیلتر -->
            <form method="GET" action="<?php echo esc_url(home_url('/ideas')); ?>" class="flex flex-col md:flex-row gap-4 mb-8">
                <input
                    type="text"
                    name="s"
                    placeholder="جستجو در ایده‌ها..."
                    value="<?php echo esc_attr($search_query); ?>"
                    class="flex-1 p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#c1121f] transition-all duration-300 text-right"
                />
                
                <select name="idea_category" class="p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#c1121f] transition-all duration-300">
                    <option value="">همه دسته‌بندی‌ها</option>
                    <?php
                    $categories = get_terms(array(
                        'taxonomy'   => 'idea_category',
                        'hide_empty' => false,
                    ));
                    
                    if (!is_wp_error($categories) && !empty($categories)) {
                        foreach ($categories as $cat) {
                            $selected = ($cat->slug === $category) ? 'selected' : '';
                            echo '<option value="' . esc_attr($cat->slug) . '" ' . $selected . '>' . esc_html($cat->name) . '</option>';
                        }
                    }
                    ?>
                </select>

                <button
                    type="submit"
                    class="p-3 bg-secondary text-white rounded-lg font-bold hover:bg-primary transition-colors duration-300 transform hover:scale-105"
                >
                    اعمال فیلتر
                </button>
            </form>

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
                                <span class="text-gray-500 ml-1">تاریخ انتشار:</span>
                                <?php echo get_the_date('j F Y'); ?>
                            </p>
                            <?php 
                            $categories = get_the_terms(get_the_ID(), 'idea_category');
                            if (!empty($categories) && !is_wp_error($categories)) {
                                $category_names = wp_list_pluck($categories, 'name');
                                echo '<div class="text-xs text-[#669bbc] font-semibold mb-4 text-right">دسته‌بندی: ' . implode(', ', $category_names) . '</div>';
                            }
                            ?>
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
                    <p class="text-lg font-bold text-[#003049]">متاسفانه ایده‌ای با این مشخصات یافت نشد.</p>
                    <p class="text-gray-600 mt-2">لطفا جستجوی خود را تغییر دهید یا فیلترها را حذف کنید.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php get_footer(); ?>

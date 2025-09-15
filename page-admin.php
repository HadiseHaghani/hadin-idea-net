<?php
/*
Template Name: پنل مدیریت ایده‌ها (Admin)
*/

// Check if user is logged in and has admin privileges
if (!current_user_can('manage_options')) {
    wp_redirect(home_url('/'));
    exit;
}

get_header();

// Fetch ideas based on status
$status_filter = isset($_GET['status']) ? sanitize_text_field($_GET['status']) : 'pending';

$args = array(
    'post_type'      => 'idea',
    'post_status'    => $status_filter,
    'posts_per_page' => -1,
);

$ideas_query = new WP_Query($args);
?>

<main id="primary" class="site-main py-8">
    <div class="container mx-auto px-4 md:px-0">
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h1 class="text-3xl font-bold text-[#003049] mb-4 text-center md:text-right">پنل مدیریت ایده‌ها</h1>
            <p class="text-gray-600 mb-8 text-center md:text-right">
                در این بخش می‌توانید ایده‌های ثبت شده را مدیریت کنید.
            </p>

            <!-- Status filter buttons -->
            <div class="flex flex-wrap justify-center md:justify-start gap-4 mb-8">
                <a href="<?php echo esc_url(add_query_arg('status', 'pending', get_permalink())); ?>" 
                   class="px-4 py-2 rounded-lg font-bold <?php echo ($status_filter === 'pending') ? 'bg-primary text-white' : 'bg-gray-200 text-gray-700'; ?>">
                   در انتظار بررسی
                </a>
                <a href="<?php echo esc_url(add_query_arg('status', 'publish', get_permalink())); ?>" 
                   class="px-4 py-2 rounded-lg font-bold <?php echo ($status_filter === 'publish') ? 'bg-primary text-white' : 'bg-gray-200 text-gray-700'; ?>">
                   تأیید شده
                </a>
                <a href="<?php echo esc_url(add_query_arg('status', 'archived', get_permalink())); ?>" 
                   class="px-4 py-2 rounded-lg font-bold <?php echo ($status_filter === 'archived') ? 'bg-primary text-white' : 'bg-gray-200 text-gray-700'; ?>">
                   آرشیو شده
                </a>
            </div>

            <!-- Display ideas -->
            <?php if ($ideas_query->have_posts()) : ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php while ($ideas_query->have_posts()) : $ideas_query->the_post(); ?>
                        <div class="bg-gray-50 p-6 rounded-lg shadow-md border border-gray-200 hover:shadow-xl transition-shadow duration-300 transform hover:scale-105">
                            <h2 class="text-xl font-bold text-[#003049] mb-2 text-right">
                                <a href="<?php echo esc_url(get_permalink()); ?>" class="hover:text-[#c1121f] transition duration-200"><?php the_title(); ?></a>
                            </h2>
                            <p class="text-gray-600 text-sm mb-4 text-right">تاریخ ثبت: <?php echo get_the_date('j F Y'); ?></p>
                            <p class="text-gray-600 text-sm mb-4 text-right">نویسنده: <?php echo get_the_author(); ?></p>
                            <div class="text-gray-700 text-right leading-relaxed mb-4">
                                <?php the_excerpt(); ?>
                            </div>
                            <a href="<?php echo esc_url(get_permalink()); ?>" class="text-[#c1121f] font-bold hover:underline text-right block">مشاهده جزئیات →</a>
                        </div>
                    <?php endwhile; wp_reset_postdata(); ?>
                </div>
            <?php else : ?>
                <div class="text-center py-10 bg-gray-100 rounded-lg">
                    <p class="text-lg font-bold text-[#003049]">متاسفانه ایده‌ای با این مشخصات یافت نشد.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const forms = document.querySelectorAll('form[data-action-type]');

        // تابع نمایش مدال سفارشی
        function showModal(title, message, isError = false) {
            const modal = document.createElement('div');
            modal.className = 'fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full flex items-center justify-center z-50';
            const titleColor = isError ? 'text-red-600' : 'text-green-600';
            const buttonColor = isError ? 'bg-red-500' : 'bg-green-500';
            
            modal.innerHTML = `
                <div class="bg-white p-6 rounded-lg shadow-xl max-w-sm mx-auto text-center">
                    <p class="text-lg font-bold ${titleColor} mb-4">${title}</p>
                    <p class="text-gray-700">${message}</p>
                    <button onclick="this.parentNode.parentNode.remove()" class="mt-4 px-4 py-2 ${buttonColor} text-white rounded-lg">بستن</button>
                </div>
            `;
            document.body.appendChild(modal);
        }

        forms.forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(form);
                const actionType = form.dataset.actionType;
                const button = form.querySelector('button[type="submit"]');

                if (button) {
                    button.disabled = true;
                    button.classList.add('opacity-50', 'cursor-not-allowed');
                }

                fetch('<?php echo esc_url(admin_url('admin-post.php')); ?>', {
                    method: 'POST',
                    body: formData,
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showModal('موفقیت', 'وضعیت ایده با موفقیت به‌روز شد.');
                        window.location.reload(); 
                    } else {
                        showModal('خطا', 'خطا در به‌روزرسانی وضعیت ایده: ' + data.data, true);
                        if (button) {
                            button.disabled = false;
                            button.classList.remove('opacity-50', 'cursor-not-allowed');
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showModal('خطا', 'خطا در ارتباط با سرور. لطفاً مجدداً تلاش کنید.', true);
                    if (button) {
                        button.disabled = false;
                        button.classList.remove('opacity-50', 'cursor-not-allowed');
                    }
                });
            });
        });
    });
</script>

<?php get_footer(); ?>

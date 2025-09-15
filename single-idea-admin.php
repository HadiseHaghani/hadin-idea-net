<?php
/*
Template Name: صفحه مدیریت ایده (IdeaNet)
*/

// بررسی اینکه آیا کاربر وارد شده و نقش 'administrator' دارد
if (!is_user_logged_in() || !current_user_can('manage_options')) {
    wp_redirect(home_url('/'));
    exit;
}

get_header();

if (have_posts()) : while (have_posts()) : the_post();
    $idea_title = get_the_title();
    $idea_content = get_the_content();
    $idea_id = get_the_ID();
    $current_status = get_post_status($idea_id);
    $security_level = get_post_meta($idea_id, '_idea_security_level', true);
?>

<main id="primary" class="site-main py-8">
    <div class="container mx-auto px-4 md:px-0">
        <div class="bg-white p-6 rounded-lg shadow-md max-w-4xl mx-auto">
            <h1 class="text-3xl font-bold text-[#003049] mb-4 text-center md:text-right">مدیریت ایده: "<?php echo esc_html($idea_title); ?>"</h1>

            <div class="mb-6 p-4 bg-gray-50 rounded-lg shadow-inner">
                <p class="font-bold text-lg text-[#003049] mb-2">وضعیت کنونی ایده:
                    <?php
                        if ($current_status === 'pending') {
                            echo '<span class="text-yellow-600">در انتظار بررسی</span>';
                        } elseif ($current_status === 'publish') {
                            echo '<span class="text-green-600">تأیید شده</span>';
                        } elseif ($current_status === 'draft') {
                            echo '<span class="text-gray-600">پیش‌نویس</span>';
                        } elseif ($current_status === 'archived') {
                             echo '<span class="text-gray-600">آرشیو شده</span>';
                        }
                    ?>
                </p>
                <p class="font-bold text-lg text-[#003049] mb-2">سطح دسترسی ایده:
                    <?php
                        if ($security_level === 'public') {
                            echo '<span class="text-green-600">عمومی</span>';
                        } elseif ($security_level === 'nda') {
                            echo '<span class="text-yellow-600">قرارداد NDA</span>';
                        } elseif ($security_level === 'private') {
                            echo '<span class="text-red-600">خصوصی</span>';
                        }
                    ?>
                </p>
            </div>
            
            <div class="prose max-w-none text-right">
                <h2 class="text-2xl font-bold text-[#c1121f] mb-2">خلاصه ایده</h2>
                <?php echo $idea_content; ?>
            </div>

            <hr class="my-6 border-gray-300">

            <div class="mt-6">
                <h2 class="text-2xl font-bold text-[#c1121f] mb-4 text-center md:text-right">تغییر وضعیت ایده</h2>
                <div class="flex flex-wrap justify-center md:justify-start gap-4">
                    <form class="idea-status-form" data-idea-id="<?php echo esc_attr($idea_id); ?>" data-new-status="publish">
                        <?php wp_nonce_field('idea_status_nonce_action_' . $idea_id, 'idea_status_nonce'); ?>
                        <input type="hidden" name="action" value="ideanet_update_idea_status" />
                        <input type="hidden" name="idea_id" value="<?php echo esc_attr($idea_id); ?>" />
                        <input type="hidden" name="new_status" value="publish" />
                        <button type="submit" class="px-6 py-3 bg-green-600 text-white rounded-lg font-bold hover:bg-green-700 transition-colors transform hover:scale-105">
                            تأیید ایده
                        </button>
                    </form>
                    <form class="idea-status-form" data-idea-id="<?php echo esc_attr($idea_id); ?>" data-new-status="archived">
                        <?php wp_nonce_field('idea_status_nonce_action_' . $idea_id, 'idea_status_nonce'); ?>
                        <input type="hidden" name="action" value="ideanet_update_idea_status" />
                        <input type="hidden" name="idea_id" value="<?php echo esc_attr($idea_id); ?>" />
                        <input type="hidden" name="new_status" value="archived" />
                        <button type="submit" class="px-6 py-3 bg-gray-600 text-white rounded-lg font-bold hover:bg-gray-700 transition-colors transform hover:scale-105">
                            آرشیو کردن
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const forms = document.querySelectorAll('.idea-status-form');

    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(form);
            const button = form.querySelector('button[type="submit"]');
            const originalText = button.textContent;
            
            // تابع نمایش مدال
            function showModal(title, message, isError = false) {
                const messageBox = document.createElement('div');
                messageBox.className = 'fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full flex items-center justify-center z-50';
                const titleColor = isError ? 'text-red-600' : 'text-green-600';
                const buttonColor = isError ? 'bg-red-500' : 'bg-green-500';
                messageBox.innerHTML = `
                    <div class="bg-white p-6 rounded-lg shadow-xl max-w-sm mx-auto text-center">
                        <p class="text-lg font-bold ${titleColor} mb-4">${title}</p>
                        <p class="text-gray-700">${message}</p>
                        <button onclick="this.parentNode.parentNode.remove()" class="mt-4 px-4 py-2 ${buttonColor} text-white rounded-lg">بستن</button>
                    </div>
                `;
                document.body.appendChild(messageBox);
            }

            button.disabled = true;
            button.textContent = 'در حال ارسال...';
            button.classList.add('opacity-50', 'cursor-not-allowed');

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
                    showModal('خطا', 'خطا در به‌روزرسانی وضعیت ایده: ' + (data.data || 'یک خطای ناشناخته رخ داد.'), true);
                    button.disabled = false;
                    button.textContent = originalText;
                    button.classList.remove('opacity-50', 'cursor-not-allowed');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showModal('خطا', 'خطا در ارتباط با سرور. لطفا مجددا تلاش کنید.', true);
                button.disabled = false;
                button.textContent = originalText;
                button.classList.remove('opacity-50', 'cursor-not-allowed');
            });
        });
    });
});
</script>

<?php
endwhile;
else :
    // اگر ایده‌ای یافت نشد
    echo '<div class="text-center p-10 mt-20 bg-white rounded-lg shadow-md max-w-lg mx-auto">
            <h1 class="text-3xl font-bold mb-4">ایده‌ای یافت نشد</h1>
            <p>این ایده وجود ندارد یا دسترسی به آن محدود است.</p>
          </div>';
endif;

get_footer();
?>

<?php
/*
Template Name: ثبت ایده جدید (IdeaNet)
*/

// بررسی اینکه آیا کاربر وارد شده است یا خیر
if (!is_user_logged_in()) {
    wp_redirect(home_url('/login'));
    exit;
}

get_header();

// نقش کاربری فعلی را دریافت می‌کند
// (این تابع را قبلاً در functions.php تعریف کرده‌اید)
$user_role = ideanet_get_user_role();

// اگر کاربر صاحب ایده نبود، دسترسی را محدود می‌کند
if ($user_role !== 'idea_owner') {
    echo '<main id="primary" class="site-main flex items-center justify-center min-h-screen py-10">';
    echo ' <div class="text-center p-10 mt-20 bg-white rounded-lg shadow-md max-w-lg mx-auto">';
    echo '     <h1 class="text-3xl font-bold mb-4 text-primary">دسترسی محدود</h1>';
    echo '     <p class="text-text">شما برای ثبت ایده جدید مجوز لازم را ندارید.</p>';
    echo ' </div>';
    echo '</main>';
    get_footer();
    exit;
}
?>

<main id="primary" class="site-main py-10">
    <div class="container mx-auto px-4 md:px-0">
        <div class="max-w-3xl mx-auto bg-white p-8 md:p-12 rounded-2xl shadow-2xl">
            <h1 class="text-3xl font-bold text-primary mb-6 text-center md:text-right">ثبت ایده جدید</h1>
            <p class="text-text mb-8 text-center md:text-right">
                جزئیات ایده خود را در فرم زیر وارد کنید تا به سرمایه‌گذاران و متخصصان نمایش داده شود.
            </p>

            <!-- فرم به آدرس فعلی خودش ارسال می‌شود -->
            <!-- این کار باعث می‌شود تابع ideanet_handle_new_idea_submission در functions.php فعال شود -->
            <form id="submit-idea-form" action="" method="post" class="space-y-6">
                <!-- فیلد عنوان ایده -->
                <div>
                    <label for="idea-title" class="block text-text font-bold mb-2 text-right">
                        عنوان ایده <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="idea-title" name="idea-title" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent transition-colors">
                </div>

                <!-- فیلد توضیحات ایده -->
                <div>
                    <label for="idea-content" class="block text-text font-bold mb-2 text-right">
                        توضیحات کامل <span class="text-red-500">*</span>
                    </label>
                    <textarea id="idea-content" name="idea-content" rows="8" required
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent transition-colors"></textarea>
                </div>

                <!-- فیلد دسته‌بندی ایده -->
                <div>
                    <label for="idea-category" class="block text-text font-bold mb-2 text-right">
                        دسته‌بندی <span class="text-red-500">*</span>
                    </label>
                    <select id="idea-category" name="idea-category" required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-2 focus:ring-accent transition-colors">
                        <option value="">انتخاب کنید...</option>
                        <option value="software">نرم‌افزار</option>
                        <option value="hardware">سخت‌افزار</option>
                        <option value="biotech">بیوتکنولوژی</option>
                        <option value="fintech">فین‌تک</option>
                        <option value="edtech">آموزش</option>
                        <option value="other">سایر</option>
                    </select>
                </div>

                <!-- فیلد سطح دسترسی -->
                <div class="flex flex-col">
                    <label class="block text-text font-bold mb-2 text-right">سطح دسترسی</label>
                    <div class="flex flex-col md:flex-row md:space-y-0 md:space-x-4 md:space-x-reverse">
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="radio" name="security-level" value="public" class="form-radio text-primary h-4 w-4" checked>
                            <span class="mr-2 text-gray-700">عمومی (قابل مشاهده برای همه)</span>
                        </label>
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="radio" name="security-level" value="nda" class="form-radio text-primary h-4 w-4">
                            <span class="mr-2 text-gray-700">قرارداد NDA (محدود به سرمایه‌گذاران و متخصصان)</span>
                        </label>
                        <label class="inline-flex items-center cursor-pointer">
                            <input type="radio" name="security-level" value="private" class="form-radio text-primary h-4 w-4">
                            <span class="mr-2 text-gray-700">خصوصی (فقط برای صاحب ایده)</span>
                        </label>
                    </div>
                </div>

                <!-- دکمه ثبت ایده -->
                <?php wp_nonce_field('submit_idea_nonce_action', 'submit_idea_nonce'); ?>
                <button type="submit"
                        class="w-full bg-secondary text-white font-bold py-3 px-6 rounded-lg hover:bg-secondary/90 transition-colors transform hover:scale-105">
                    ثبت ایده
                </button>
            </form>
        </div>
    </div>
</main>

<?php get_footer(); ?>

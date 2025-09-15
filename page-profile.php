<?php
/* Template Name: پروفایل کاربر (IdeaNet) */

// Check if user is logged in
if (!is_user_logged_in()) {
    wp_redirect(home_url('/login'));
    exit;
}

get_header();

$current_user = wp_get_current_user();
$user_role = ideanet_get_user_role();

// Mock data for user profile
$mock_data = [
    'idea_owner' => [
        'name'   => 'سعید رضایی',
        'bio'    => 'کارآفرین مشتاق با بیش از ۵ سال تجربه در حوزه فناوری. به دنبال حل مشکلات روزمره با ایده‌های نوآورانه هستم.',
        'skills' => ['برنامه‌نویسی', 'طراحی محصول', 'بازاریابی دیجیتال'],
        'socials' => [
            'linkedin' => '#',
            'twitter'  => '#',
        ],
    ],
    'investor' => [
        'name'   => 'فاطمه احمدی',
        'bio'    => 'سرمایه‌گذار خطرپذیر در حوزه استارتاپ‌های فناوری. به دنبال ایده‌هایی با پتانسیل رشد بالا در زمینه فین‌تک و سلامت دیجیتال.',
        'investment_focus' => ['فین‌تک', 'سلامت دیجیتال', 'هوش مصنوعی'],
        'socials' => [
            'linkedin' => '#',
        ],
    ],
    'specialist' => [
        'name'   => 'مهندس کریمی',
        'bio'    => 'متخصص هوش مصنوعی و یادگیری ماشین با تمرکز بر راه‌حل‌های بهینه‌سازی صنعتی و تحلیل داده.',
        'expertise_areas' => ['هوش مصنوعی', 'یادگیری ماشین', 'تحلیل داده'],
        'socials' => [
            'linkedin' => '#',
            'github'   => '#',
        ],
    ],
];

$profile_data = $mock_data[$user_role] ?? $mock_data['idea_owner']; // Fallback
?>

<main id="primary" class="site-main py-10">
    <div class="container mx-auto px-4 md:px-0">
        <div class="bg-white p-8 rounded-lg shadow-md max-w-2xl mx-auto text-center md:text-right">
            <h1 class="text-3xl font-bold text-primary mb-6">پروفایل کاربری</h1>

            <div class="flex flex-col md:flex-row items-center md:items-start md:space-x-8 md:space-x-reverse">
                <!-- User Avatar/Image -->
                <div class="w-32 h-32 rounded-full overflow-hidden mb-6 md:mb-0">
                    <img src="https://placehold.co/128x128/c1121f/ffffff?text=<?php echo substr($profile_data['name'], 0, 1); ?>" alt="User Avatar" class="w-full h-full object-cover">
                </div>

                <!-- User Info -->
                <div class="flex-1">
                    <h2 class="text-2xl font-bold text-text mb-2"><?php echo esc_html($profile_data['name']); ?></h2>
                    <p class="text-gray-500 mb-4">
                        <?php echo esc_html($user_role === 'idea_owner' ? 'صاحب ایده' : ($user_role === 'investor' ? 'سرمایه‌گذار' : 'متخصص')); ?>
                    </p>
                    <p class="text-gray-700 leading-relaxed mb-6">
                        <?php echo nl2br(esc_html($profile_data['bio'])); ?>
                    </p>

                    <!-- Details based on role -->
                    <?php if ($user_role === 'idea_owner') : ?>
                        <div class="mb-6">
                            <h3 class="font-semibold text-lg text-primary mb-2">مهارت‌ها</h3>
                            <div class="flex flex-wrap gap-2">
                                <?php foreach ($profile_data['skills'] as $skill) : ?>
                                    <span class="bg-gray-200 text-gray-800 px-3 py-1 rounded-full text-sm font-medium"><?php echo esc_html($skill); ?></span>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php elseif ($user_role === 'investor') : ?>
                        <div class="mb-6">
                            <h3 class="font-semibold text-lg text-primary mb-2">حوزه سرمایه‌گذاری</h3>
                            <div class="flex flex-wrap gap-2">
                                <?php foreach ($profile_data['investment_focus'] as $focus) : ?>
                                    <span class="bg-gray-200 text-gray-800 px-3 py-1 rounded-full text-sm font-medium"><?php echo esc_html($focus); ?></span>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php elseif ($user_role === 'specialist') : ?>
                        <div class="mb-6">
                            <h3 class="font-semibold text-lg text-primary mb-2">زمینه‌های تخصص</h3>
                            <div class="flex flex-wrap gap-2">
                                <?php foreach ($profile_data['expertise_areas'] as $area) : ?>
                                    <span class="bg-gray-200 text-gray-800 px-3 py-1 rounded-full text-sm font-medium"><?php echo esc_html($area); ?></span>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- Social Media Links -->
                    <?php if (!empty($profile_data['socials'])) : ?>
                        <div class="flex justify-center md:justify-start space-x-4 space-x-reverse">
                            <?php if (isset($profile_data['socials']['linkedin'])) : ?>
                                <a href="<?php echo esc_url($profile_data['socials']['linkedin']); ?>" target="_blank" class="text-gray-400 hover:text-blue-600 transition-colors duration-200">
                                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.768s.784-1.767 1.75-1.767 1.75.79 1.75 1.767c0 .978-.784 1.768-1.75 1.768zm13.5 12.268h-3v-5.604c0-3.368-4.172-3.238-4.172 0v5.604h-3v-11h3v1.765c1.396-2.586 7.172-2.722 7.172 2.503v6.732z"/></svg>
                                </a>
                            <?php endif; ?>

                            <?php if (isset($profile_data['socials']['twitter'])) : ?>
                                <a href="<?php echo esc_url($profile_data['socials']['twitter']); ?>" target="_blank" class="text-gray-400 hover:text-blue-400 transition-colors duration-200">
                                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.585 0-6.49 2.905-6.49 6.49 0 .508.058 1.002.169 1.478-5.397-.27-10.198-2.868-13.403-6.811-.563.961-.888 2.083-.888 3.255 0 2.246 1.144 4.223 2.875 5.383-.672-.02-1.303-.205-1.859-.513v.081c0 3.167 2.26 5.8 5.25 6.401-.555.151-1.137.232-1.742.232-.427 0-.84-.041-1.246-.118.835 2.618 3.254 4.524 6.136 4.577-2.235 1.752-5.07 2.808-8.113 2.808-.528 0-1.05-.031-1.565-.091 2.887 1.852 6.305 2.943 9.944 2.943 11.92 0 18.232-9.886 18.232-18.49 0-.281-.007-.562-.02-.843.996-.723 1.868-1.625 2.555-2.657z"/></svg>
                                </a>
                            <?php endif; ?>

                            <?php if (isset($profile_data['socials']['github'])) : ?>
                                <a href="<?php echo esc_url($profile_data['socials']['github']); ?>" target="_blank" class="text-gray-400 hover:text-gray-800 transition-colors duration-200">
                                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.809 1.305 3.492.997.108-.775.418-1.305.76-1.605-2.665-.3-5.466-1.332-5.466-5.932 0-1.312.465-2.388 1.235-3.23-.125-.3-.538-1.527.12-3.185 0 0 1.008-.323 3.3 1.23.957-.267 1.983-.4 3.003-.404 1.02.004 2.046.137 3.003.404 2.29-1.553 3.297-1.23 3.297-1.23.658 1.658.245 2.885.12 3.185.77.842 1.235 1.918 1.235 3.23 0 4.61-2.802 5.626-5.474 5.924.43.37.818 1.102.818 2.22 0 1.606-.015 2.899-.015 3.284 0 .308.194.673.801.576 4.765-1.589 8.202-6.086 8.202-11.386 0-6.627-5.373-12-12-12z"/></svg>
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</main>

<?php get_footer(); ?>

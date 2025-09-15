<?php
// این فایل هدر قالب وردپرس رو شامل می‌شه.
// تمامی تگ‌های head و بخش شروع بدنه در این فایل قرار می‌گیرن.
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> dir="rtl">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">

    <!-- اینجا TailwindCSS رو از طریق CDN فراخوانی می‌کنیم. -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- تنظیمات سفارشی Tailwind برای استفاده از پالت رنگی Fiery Ocean -->
    <style>
        @layer base {
            :root {
                --color-primary: #780000;
                --color-secondary: #c1121f;
                --color-background: #fdf0d5;
                --color-text: #003049;
                --color-accent: #669bbc;
            }
        }

        body {
            background-color: var(--color-background);
            font-family: 'IRANSans', sans-serif;
        }

        .text-primary { color: var(--color-primary); }
        .bg-primary { background-color: var(--color-primary); }
        .text-secondary { color: var(--color-secondary); }
        .bg-secondary { background-color: var(--color-secondary); }
        .text-background { color: var(--color-background); }
        .bg-background { background-color: var(--color-background); }
        .text-text { color: var(--color-text); }
        .bg-text { background-color: var(--color-text); }
        .text-accent { color: var(--color-accent); }
        .bg-accent { background-color: var(--color-accent); }
    </style>

    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="bg-white shadow-lg sticky top-0 z-50">
    <div class="container mx-auto px-4 py-4 flex justify-between items-center">
        <!-- لوگوی سایت -->
        <a href="<?php echo home_url(); ?>" class="flex items-center space-x-2 space-x-reverse">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo-dark.png" alt="لوگو IdeaNet" class="h-10">
            <span class="text-xl font-bold text-text hidden md:inline">IdeaNet</span>
        </a>

        <!-- منوی اصلی (فقط در دسکتاپ) -->
        <nav class="hidden lg:flex items-center space-x-6 space-x-reverse">
            <a href="<?php echo home_url(); ?>" class="text-text hover:text-accent transition-colors duration-300 font-medium">صفحه اصلی</a>
            <a href="<?php echo home_url('/ideas'); ?>" class="text-text hover:text-accent transition-colors duration-300 font-medium">کشف ایده‌ها</a>
            <a href="<?php echo home_url('/about-us'); ?>" class="text-text hover:text-accent transition-colors duration-300 font-medium">درباره ما</a>
            <a href="<?php echo home_url('/contact'); ?>" class="text-text hover:text-accent transition-colors duration-300 font-medium">تماس با ما</a>
        </nav>

        <!-- دکمه‌های ورود/ثبت‌نام/داشبورد (دسکتاپ) -->
        <div class="hidden lg:flex items-center space-x-4 space-x-reverse">
            <?php if (is_user_logged_in()) : ?>
                <a href="<?php echo home_url('/dashboard'); ?>" class="px-6 py-2 bg-accent text-white rounded-lg font-bold hover:bg-opacity-90 transition-all duration-300 transform hover:scale-105">داشبورد</a>
                <a href="<?php echo wp_logout_url(home_url()); ?>" class="px-6 py-2 bg-secondary text-white rounded-lg font-bold hover:bg-opacity-90 transition-all duration-300 transform hover:scale-105">خروج</a>
            <?php else : ?>
                <a href="<?php echo home_url('/login'); ?>" class="px-6 py-2 bg-accent text-white rounded-lg font-bold hover:bg-opacity-90 transition-all duration-300 transform hover:scale-105">ورود</a>
                <a href="<?php echo home_url('/register'); ?>" class="px-6 py-2 bg-secondary text-white rounded-lg font-bold hover:bg-opacity-90 transition-all duration-300 transform hover:scale-105">ثبت‌نام</a>
            <?php endif; ?>
        </div>

        <!-- دکمه منوی موبایل -->
        <div class="lg:hidden flex items-center">
            <button id="mobile-menu-button" class="text-text text-2xl focus:outline-none">
                <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 6h16M4 12h16m-7 6h7"></path>
                </svg>
            </button>
        </div>
    </div>

    <!-- منوی موبایل (مخفی به صورت پیش‌فرض) -->
    <div id="mobile-menu" class="hidden lg:hidden bg-white shadow-inner p-4">
        <nav class="flex flex-col items-center text-center space-y-4">
            <a href="<?php echo home_url(); ?>" class="text-text hover:text-accent transition-colors duration-300 py-2">صفحه اصلی</a>
            <a href="<?php echo home_url('/ideas'); ?>" class="text-text hover:text-accent transition-colors duration-300 py-2">کشف ایده‌ها</a>
            <a href="<?php echo home_url('/about-us'); ?>" class="text-text hover:text-accent transition-colors duration-300 py-2">درباره ما</a>
            <a href="<?php echo home_url('/contact'); ?>" class="text-text hover:text-accent transition-colors duration-300 py-2">تماس با ما</a>

            <div class="mt-4 flex flex-col space-y-2">
                <?php if (is_user_logged_in()) : ?>
                    <a href="<?php echo home_url('/dashboard'); ?>" class="px-6 py-2 bg-accent text-white rounded-lg hover:bg-opacity-90 transition-all duration-300 transform hover:scale-105">داشبورد</a>
                    <a href="<?php echo wp_logout_url(home_url()); ?>" class="px-6 py-2 bg-secondary text-white rounded-lg hover:bg-opacity-90 transition-all duration-300 transform hover:scale-105">خروج</a>
                <?php else : ?>
                    <a href="<?php echo home_url('/login'); ?>" class="px-6 py-2 bg-accent text-white rounded-lg hover:bg-opacity-90 transition-all duration-300 transform hover:scale-105">ورود</a>
                    <a href="<?php echo home_url('/register'); ?>" class="px-6 py-2 bg-secondary text-white rounded-lg hover:bg-opacity-90 transition-all duration-300 transform hover:scale-105">ثبت‌نام</a>
                <?php endif; ?>
            </div>
        </nav>
    </div>
</header>

<script>
    // اسکریپت ساده برای نمایش/مخفی کردن منوی موبایل
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    mobileMenuButton.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
    });
</script>

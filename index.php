<?php
// این فایل نقطه شروع و اصلی قالب وردپرس ماست.
// با فراخوانی get_header() و get_footer()، تمامی بخش‌های ثابت سایت رو نمایش می‌ده.

// فراخوانی هدر
get_header();
?>

<!-- محتوای اصلی صفحه در این بخش قرار می‌گیره. -->
<main id="primary" class="site-main">

    <!-- بخش هیرو (Hero Section) -->
    <section class="relative overflow-hidden bg-background py-20 lg:py-32">
        <div class="container mx-auto px-4 text-center">

            <!-- تصویر پس‌زمینه -->
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/hero-image.png"
                 alt="تصویر گرافیکی"
                 class="absolute inset-0 w-full h-full object-cover opacity-10">

            <div class="relative z-10 max-w-4xl mx-auto">
                <!-- عنوان اصلی -->
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-primary mb-4 leading-tight">
                    ایده‌های شما،
                    <span class="text-secondary block">فرصت‌های رشد و سرمایه‌گذاری</span>
                </h1>

                <!-- توضیحات -->
                <p class="text-lg md:text-xl text-text mb-8 max-w-2xl mx-auto">
                    پلتفرم هوشمند IdeaNet، بهترین بستر برای اتصال صاحبان ایده‌های نوآورانه
                    به سرمایه‌گذاران و متخصصان حرفه‌ای است.
                </p>

                <!-- دکمه‌ها -->
                <div class="flex flex-col sm:flex-row justify-center items-center gap-4">
                    <a href="<?php echo home_url('/submit-idea'); ?>"
                       class="w-full sm:w-auto px-8 py-4 bg-secondary text-white rounded-lg font-bold text-lg hover:bg-primary transition-all duration-300 transform hover:scale-105 shadow-lg">
                        ایده‌ات رو ثبت کن
                    </a>
                    <a href="<?php echo home_url('/ideas'); ?>"
                       class="w-full sm:w-auto px-8 py-4 bg-accent text-white rounded-lg font-bold text-lg hover:bg-primary transition-all duration-300 transform hover:scale-105 shadow-lg">
                        کشف ایده‌ها
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- بخش مشکلات و راه‌حل‌ها -->
    <section class="container mx-auto py-16 px-4">
        <div class="max-w-4xl mx-auto text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-primary mb-4">مشکلات موجود در اکوسیستم نوآوری</h2>
            <p class="text-text text-lg">پلتفرم ما برای حل این چالش‌ها طراحی شده است:</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

            <!-- کارت اول -->
            <div class="bg-white p-8 rounded-2xl shadow-xl flex flex-col justify-start items-center text-center hover:shadow-2xl transition-shadow duration-300">
                <svg class="w-16 h-16 text-primary mb-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                          d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                          clip-rule="evenodd"></path>
                </svg>
                <h3 class="font-bold text-2xl text-secondary mb-2">مشکل: پیدا کردن سرمایه‌گذار و متخصص</h3>
                <p class="text-text leading-relaxed">
                    راه‌حل: یک بازار آنلاین که در آن ایده‌ها با سرمایه‌گذاران و متخصصان
                    به صورت هدفمند و مستقیم ارتباط برقرار می‌کنند.
                </p>
            </div>

            <!-- کارت دوم -->
            <div class="bg-white p-8 rounded-2xl shadow-xl flex flex-col justify-start items-center text-center hover:shadow-2xl transition-shadow duration-300">
                <svg class="w-16 h-16 text-primary mb-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                          d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                          clip-rule="evenodd"></path>
                </svg>
                <h3 class="font-bold text-2xl text-secondary mb-2">مشکل: عدم اطمینان به اطلاعات</h3>
                <p class="text-text leading-relaxed">
                    راه‌حل: سیستم تأیید هویت و امکان امضای قرارداد NDA.
                </p>
            </div>

        </div>
    </section>

</main>

<?php
// فراخوانی فوتر
get_footer();
?>

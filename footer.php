<?php 
// این فایل فوتر قالب وردپرس رو شامل می‌شه.
// تمامی تگ‌های بسته شدن بدنه و HTML در این فایل قرار می‌گیرن.
?>

<!-- بخش فوتر سایت با استفاده از flexbox و کلاس‌های Tailwind برای ساختاردهی و ریسپانسیو بودن -->
<footer class="bg-text text-background py-8 mt-16">
  <div class="container mx-auto px-4 grid grid-cols-1 md:grid-cols-4 gap-8">

    <!-- ستون اول: اطلاعات کلی -->
    <div>
      <!-- لوگو در فوتر -->
      <a href="<?php echo home_url(); ?>">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo-white.png" alt="لوگو IdeaNet" class="h-10 mb-4">
      </a>
      <p class="text-sm leading-relaxed">
        پلتفرمی امن و هوشمند برای اتصال صاحبان ایده به سرمایه‌گذاران و متخصصان. ایده‌های شما اینجا رشد می‌کنند.
      </p>
    </div>

    <!-- ستون دوم: لینک‌های سریع -->
    <div>
      <h3 class="font-bold text-lg mb-4">لینک‌های سریع</h3>
      <ul>
        <li class="mb-2"><a href="<?php echo home_url(); ?>" class="hover:text-accent transition-colors duration-300">صفحه اصلی</a></li>
        <li class="mb-2"><a href="<?php echo home_url('/ideas'); ?>" class="hover:text-accent transition-colors duration-300">کشف ایده‌ها</a></li>
        <li class="mb-2"><a href="<?php echo home_url('/about-us'); ?>" class="hover:text-accent transition-colors duration-300">درباره ما</a></li>
        <li class="mb-2"><a href="<?php echo home_url('/contact'); ?>" class="hover:text-accent transition-colors duration-300">تماس با ما</a></li>
      </ul>
    </div>

    <!-- ستون سوم: منابع آموزشی -->
    <div>
      <h3 class="font-bold text-lg mb-4">منابع</h3>
      <ul>
        <li class="mb-2"><a href="<?php echo home_url('/education'); ?>" class="hover:text-accent transition-colors duration-300">منابع آموزشی</a></li>
        <li class="mb-2"><a href="#" class="hover:text-accent transition-colors duration-300">وبلاگ</a></li>
        <li class="mb-2"><a href="#" class="hover:text-accent transition-colors duration-300">راهنما</a></li>
      </ul>
    </div>

    <!-- ستون چهارم: شبکه‌های اجتماعی -->
    <div>
      <h3 class="font-bold text-lg mb-4">شبکه‌های اجتماعی</h3>
      <div class="flex space-x-4 space-x-reverse">
        <a href="https://github.com/hadin-group" class="text-gray-400 hover:text-white transition-colors duration-300">
          <img src="<?php echo get_template_directory_uri(); ?>/assets/images/github-icon.png" alt="Github" class="h-6 w-6 filter invert">
        </a>
        <a href="https://linkedin.com/company/hadin-group" class="text-gray-400 hover:text-white transition-colors duration-300">
          <img src="<?php echo get_template_directory_uri(); ?>/assets/images/linkedin-icon.png" alt="LinkedIn" class="h-6 w-6 filter invert">
        </a>
        <a href="https://instagram.com/hadin-group" class="text-gray-400 hover:text-white transition-colors duration-300">
          <img src="<?php echo get_template_directory_uri(); ?>/assets/images/instagram-icon.png" alt="Instagram" class="h-6 w-6 filter invert">
        </a>
        <a href="https://t.me/hadin-group" class="text-gray-400 hover:text-white transition-colors duration-300">
          <img src="<?php echo get_template_directory_uri(); ?>/assets/images/telegram-icon.png" alt="Telegram" class="h-6 w-6 filter invert">
        </a>
      </div>
    </div>

  </div>

  <!-- بخش کپی‌رایت -->
  <div class="container mx-auto px-4 mt-8 pt-8 border-t border-gray-700 text-center">
    <p class="text-sm">
      تمامی حقوق برای <strong>گروه حدین</strong> محفوظ است. © <?php echo date('Y'); ?>
    </p>
  </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>

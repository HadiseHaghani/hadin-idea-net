<?php
/* Template Name: صفحه مشکلات کاربران (IdeaNet) */
get_header();
?>
<div class="container mx-auto py-10 px-4 md:px-0">
<h1 class="text-3xl font-bold text-primary mb-6 text-center">مشکلات اصلی کاربران</h1>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
<?php
$args = array('post_type' => 'problem', 'posts_per_page' => -1);
$problem_query = new WP_Query($args);
if ($problem_query->have_posts()) :
while ($problem_query->have_posts()) : $problem_query->the_post(); ?>
<div class="bg-white p-6 rounded-lg shadow-md">
<h2 class="text-xl font-bold text-text mb-2"><?php the_title(); ?></h2>
<div class="text-gray-700 text-sm leading-relaxed"><?php the_content(); ?></div>
</div>
<?php endwhile;
wp_reset_postdata();
else : ?>
<p class="text-center text-gray-500">هنوز هیچ مشکلی ثبت نشده است.</p>
<?php endif; ?>
</div>
</div>
<?php get_footer(); ?>
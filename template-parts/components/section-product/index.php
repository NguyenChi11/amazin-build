<?php
$page_id = get_queried_object_id();
$materials_title = get_post_meta($page_id, 'materials_title', true);
$materials_description = get_post_meta($page_id, 'materials_description', true);

$items = [];
$query = new WP_Query(array(
    'post_type' => 'material',
    'posts_per_page' => 4,
    'orderby' => 'date',
    'order' => 'DESC',
    'post_status' => 'publish',
    'no_found_rows' => true,
));
if ($query->have_posts()) {
    while ($query->have_posts()) {
        $query->the_post();
        $post_id = get_the_ID();
        $image_url = get_the_post_thumbnail_url($post_id, 'large');
        $title = get_the_title($post_id);
        $price = get_post_meta($post_id, 'price_material', true);
        if ($price === '' || $price === null) {
            $price = get_post_meta($post_id, 'material_price', true);
        }
        $items[] = array(
            'id' => $post_id,
            'title' => $title,
            'image' => $image_url,
            'price' => $price,
            'link' => get_permalink($post_id),
        );
    }
    wp_reset_postdata();
}
?>
<section class="section-product">
    <div class="section-product__header">
        <h2 class="section-product__title" data-has-meta="<?php echo $materials_title !== '' ? '1' : '0'; ?>">
            <?php echo esc_html($materials_title ?: 'MATERIALS'); ?>
        </h2>
        <p class="section-product__description"
            data-has-meta="<?php echo $materials_description !== '' ? '1' : '0'; ?>">
            <?php echo esc_html($materials_description ?: ''); ?>
        </p>
    </div>
    <div class="section-product__list">
        <?php foreach ($items as $item): ?>
        <a class="section-product__item" href="<?php echo esc_url($item['link']); ?>">
            <div class="section-product__item-image">
                <?php if (!empty($item['image'])): ?>
                <img src="<?php echo esc_url($item['image']); ?>" alt="<?php echo esc_attr($item['title']); ?>">
                <?php endif; ?>
            </div>
            <div class="section-product__item-content">
                <h3 class="section-product__item-title"><?php echo esc_html($item['title']); ?></h3>
                <div class="section-product__item-bottom">
                    <p class="section-product__item-price">
                        <span>$</span><?php echo esc_html($item['price']); ?><span>/ton</span>
                    </p>
                    <button class="section-product__item-cta">Request a Quote</button>
                </div>
            </div>
        </a>
        <?php endforeach; ?>
    </div>
    <?php if (empty($items)): ?>
    <script src="<?php echo esc_url(get_theme_file_uri('/assets/data/product-data.js')); ?>"></script>
    <?php endif; ?>
</section>
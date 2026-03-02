<?php
$pid = get_the_ID();
if (!(class_exists('WooCommerce') || function_exists('wc_get_product'))) {
    return;
}
if (!$pid || get_post_type($pid) !== 'product') {
    return;
}
$product = wc_get_product($pid);
$title = get_the_title($pid);
$featured_id = get_post_thumbnail_id($pid);
$featured = $featured_id ? wp_get_attachment_image($featured_id, 'large') : '';
$gallery_ids = $product->get_gallery_image_ids();
$price_html = $product->get_price_html();
$regular_price = $product->get_regular_price();
$sale_price = $product->get_sale_price();
$sku = $product->get_sku();
$in_stock = $product->is_in_stock();
$stock_status = $product->get_stock_status();
$stock_qty = $product->get_stock_quantity();
$short_desc = $product->get_short_description();
$desc = $product->get_description();
$cats = wc_get_product_category_list($pid);
$tags = wc_get_product_tag_list($pid);
$type = $product->get_type();
$avg_rating = $product->get_average_rating();
$review_count = $product->get_review_count();
$length = $product->get_length();
$width = $product->get_width();
$height = $product->get_height();
$weight = $product->get_weight();
$shipping_class = $product->get_shipping_class();
$downloads = $product->get_downloads();
$attributes = $product->get_attributes();
$typical_range = get_post_meta($pid, 'typical_range', true);
?>
<article class="single-product-detail" id="product-<?php echo esc_attr($pid); ?>">
    <header class="single-product__header">
        <h1 class="single-product__title"><?php echo esc_html($title); ?></h1>
        <div class="single-product__meta">
            <span class="single-product__sku"><?php echo esc_html($sku ? 'SKU: ' . $sku : ''); ?></span>
            <span class="single-product__stock"><?php echo esc_html($in_stock ? 'Còn hàng' : 'Hết hàng'); ?></span>
            <?php if ($stock_qty !== null) : ?>
                <span class="single-product__stock-qty"><?php echo esc_html('SL: ' . (int)$stock_qty); ?></span>
            <?php endif; ?>
            <?php if ($avg_rating) : ?>
                <span
                    class="single-product__rating"><?php echo esc_html($avg_rating . ' / 5 (' . (int)$review_count . ' đánh giá)'); ?></span>
            <?php endif; ?>
        </div>
    </header>
    <div class="single-product__top">
        <div class="single-product__images">
            <?php if (!empty($featured)) : ?>
                <div class="single-product__image-featured"><?php echo $featured; ?></div>
            <?php endif; ?>
            <?php if (!empty($gallery_ids)) : ?>
                <div class="single-product__gallery">
                    <?php foreach ($gallery_ids as $gid) :
                        $img = wp_get_attachment_image($gid, 'large');
                        if (!$img) continue;
                    ?>
                        <div class="single-product__gallery-item"><?php echo $img; ?></div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
        <div class="single-product__summary">
            <div class="single-product__price">
                <?php
                if (!empty($price_html)) {
                    echo wp_kses_post($price_html);
                } else {
                    $display_price = $product->get_price();
                    if ($display_price !== '') {
                        echo wp_kses_post(wc_price($display_price));
                    } elseif ($sale_price !== '') {
                        echo wp_kses_post(wc_price($sale_price));
                    } elseif ($regular_price !== '') {
                        echo wp_kses_post(wc_price($regular_price));
                    }
                }
                ?>
            </div>
            <?php if (!empty($short_desc)) : ?>
                <div class="single-product__short-desc"><?php echo wp_kses_post(wpautop($short_desc)); ?></div>
            <?php endif; ?>
            <?php if (!empty($cats)) : ?>
                <div class="single-product__cats"><?php echo wp_kses_post($cats); ?></div>
            <?php endif; ?>
            <?php if (!empty($tags)) : ?>
                <div class="single-product__tags"><?php echo wp_kses_post($tags); ?></div>
            <?php endif; ?>
            <?php if (!empty($typical_range)) : ?>
                <div class="single-product__typical"><?php echo esc_html('Typical Range: ' . $typical_range); ?></div>
            <?php endif; ?>
        </div>
    </div>
    <?php if (!empty($attributes)) : ?>
        <section class="single-product__attributes">
            <h2>Thông số</h2>
            <div class="single-product__attr-list">
                <?php foreach ($attributes as $attr) :
                    if ($attr->is_taxonomy()) {
                        $taxonomy = $attr->get_name();
                        $terms = wc_get_product_terms($pid, $taxonomy, array('fields' => 'names'));
                        $value = implode(', ', $terms);
                        $label = wc_attribute_label($taxonomy);
                    } else {
                        $label = $attr->get_name();
                        $options = $attr->get_options();
                        $value = implode(', ', array_map('sanitize_text_field', (array)$options));
                    }
                    if ($label === '' && $value === '') continue;
                ?>
                    <div class="single-product__attr-item">
                        <span class="single-product__attr-name"><?php echo esc_html($label); ?></span>
                        <span class="single-product__attr-value"><?php echo esc_html($value); ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    <?php endif; ?>
    <section class="single-product__specs">
        <h2>Thông tin kỹ thuật</h2>
        <div class="single-product__spec-list">
            <?php if ($length || $width || $height) : ?>
                <div class="single-product__spec-item"><span>Kích
                        thước</span><span><?php echo esc_html(trim(($length ? $length . ' × ' : '') . ($width ? $width . ' × ' : '') . ($height ? $height : ''))); ?></span>
                </div>
            <?php endif; ?>
            <?php if ($weight) : ?>
                <div class="single-product__spec-item"><span>Khối lượng</span><span><?php echo esc_html($weight); ?></span>
                </div>
            <?php endif; ?>
            <?php if ($shipping_class) : ?>
                <div class="single-product__spec-item"><span>Shipping
                        class</span><span><?php echo esc_html($shipping_class); ?></span></div>
            <?php endif; ?>
            <div class="single-product__spec-item"><span>Loại sản phẩm</span><span><?php echo esc_html($type); ?></span>
            </div>
            <div class="single-product__spec-item"><span>Trạng thái
                    kho</span><span><?php echo esc_html($stock_status); ?></span></div>
        </div>
    </section>
    <?php if (!empty($downloads)) : ?>
        <section class="single-product__downloads">
            <h2>Tệp tải về</h2>
            <ul class="single-product__download-list">
                <?php foreach ($downloads as $d) :
                    $name = $d->get_name();
                    $url = $d->get_file();
                ?>
                    <li><a href="<?php echo esc_url($url); ?>" target="_blank"
                            rel="noopener"><?php echo esc_html($name ?: $url); ?></a></li>
                <?php endforeach; ?>
            </ul>
        </section>
    <?php endif; ?>
    <section class="single-product__description">
        <?php if (!empty($desc)) : ?>
            <div class="single-product__desc-content"><?php echo wp_kses_post(wpautop($desc)); ?></div>
        <?php endif; ?>
    </section>
</article>
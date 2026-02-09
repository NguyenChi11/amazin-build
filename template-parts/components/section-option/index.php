<?php
$section_option_items = [];
$page_id = get_queried_object_id();
$rows = get_theme_mod('buildpro_option_items', array());
if (!is_array($rows) || empty($rows)) {
    $rows = get_post_meta($page_id, 'buildpro_option_items', true);
}
if ($rows && is_array($rows)) {
    foreach ($rows as $row) {
        $icon_id = isset($row['icon_id']) ? (int)$row['icon_id'] : 0;
        $text = isset($row['text']) ? $row['text'] : '';
        $description = isset($row['description']) ? $row['description'] : '';
        $section_option_items[] = [
            'icon_id'     => $icon_id,
            'text'        => $text,
            'description' => $description,
        ];
    }
}
$assets_base = get_theme_file_uri('/assets/images/icon/');
$min_count = 6;
$count = count($section_option_items);
if ($count > 0 && $count < $min_count) {
    $duplicated = $section_option_items;
    while (count($duplicated) < $min_count) {
        foreach ($section_option_items as $item) {
            $duplicated[] = $item;
            if (count($duplicated) >= $min_count) {
                break;
            }
        }
    }
    $section_option_items = $duplicated;
}
?>

<section class="section-option">
    <div class="swiper section-option__swiper">
        <div class="swiper-wrapper section-option__swiper-wrapper">
            <?php foreach ($section_option_items as $section_option_item): ?>
                <div class="swiper-slide section-option__swiper-item">
                    <div class="section-option__item">
                        <div class="section-option__item-icon">
                            <?php
                            $icon_src = !empty($section_option_item['icon_id'])
                                ? wp_get_attachment_image_url($section_option_item['icon_id'], 'full')
                                : (isset($section_option_item['icon_url']) ? $section_option_item['icon_url'] : '');
                            ?>
                            <?php if ($icon_src): ?>
                                <img src="<?php echo esc_url($icon_src); ?>" class="section-option__item-icon-image" alt="Icon">
                            <?php endif; ?>
                        </div>
                        <h3 class="section-option__item-text"><?php echo $section_option_item['text']; ?></h3>
                        <p class="section-option__item-description"><?php echo $section_option_item['description']; ?>
                        </p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php if (empty($section_option_items)): ?>
        <script src="<?php echo esc_url(get_theme_file_uri('/assets/data/option-data.js')); ?>"></script>
    <?php endif; ?>
</section>

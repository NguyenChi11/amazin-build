<?php
$page_id = get_queried_object_id();
$service_title = get_post_meta($page_id, 'buildpro_service_title', true);
$service_desc = get_post_meta($page_id, 'buildpro_service_desc', true);
$service_items = [];
$rows = get_post_meta($page_id, 'buildpro_service_items', true);
if ($rows && is_array($rows)) {
    foreach ($rows as $row) {
        $icon_id = isset($row['icon_id']) ? (int)$row['icon_id'] : 0;
        $title = isset($row['title']) ? $row['title'] : '';
        $description = isset($row['description']) ? $row['description'] : '';
        $link_url = isset($row['link_url']) ? $row['link_url'] : '';
        $link_title = isset($row['link_title']) ? $row['link_title'] : '';
        $link_target = isset($row['link_target']) ? $row['link_target'] : '';
        $service_items[] = [
            'icon_id' => $icon_id,
            'title' => $title,
            'description' => $description,
            'link_url' => $link_url,
            'link_title' => $link_title,
            'link_target' => $link_target,
        ];
    }
}
$icon_right = 212;
?>
<section class="section-services">
    <div class="section-services__header">
        <h2 class="section-services__title" data-has-meta="<?php echo $service_title !== '' ? '1' : '0'; ?>">
            <?php echo esc_html($service_title ?: 'CORE SERVICES'); ?>
        </h2>
        <p class="section-services__description" data-has-meta="<?php echo $service_desc !== '' ? '1' : '0'; ?>">
            <?php echo esc_html($service_desc ?: 'Comprehensive construction solutions tailored to your unique requirements.'); ?>
        </p>
    </div>
    <div class="section-services__container">
        <?php foreach ($service_items as $item): ?>
            <div class="section-services__item">
                <div class="section-services__item-icon">
                    <?php
                    $icon_url = $item['icon_id'] ? wp_get_attachment_image_url($item['icon_id'], 'full') : '';
                    ?>
                    <?php if ($icon_url): ?>
                        <img src="<?php echo esc_url($icon_url); ?>" alt="<?php echo esc_attr($item['title']); ?>"
                            class="section-services__item-icon-image">
                    <?php endif; ?>
                </div>
                <h3 class="section-services__item-title"><?php echo esc_html($item['title']); ?></h3>
                <p class="section-services__item-description"><?php echo esc_html($item['description']); ?></p>
                <?php if (!empty($item['link_url'])): ?>
                    <?php
                    $target_attr = !empty($item['link_target']) ? ' target="' . esc_attr($item['link_target']) . '"' : '';
                    $rel_attr = (!empty($item['link_target']) && $item['link_target'] === '_blank') ? ' rel="noopener"' : '';
                    ?>
                    <a class="section-services__item-link" href="<?php echo esc_url($item['link_url']); ?>"
                        <?php echo $target_attr . $rel_attr; ?>>
                        <?php echo esc_html('View Details'); ?>
                        <img src="<?php echo esc_url(get_theme_file_uri('/assets/images/icon/Arrow_Right_blue.png')); ?>"
                            alt="right arrow" class="section-services__item-link-icon">
                    </a>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
    <?php if (empty($service_items)): ?>
        <script src="<?php echo esc_url(get_theme_file_uri('/assets/data/service-data.js')); ?>"></script>
    <?php endif; ?>
</section>
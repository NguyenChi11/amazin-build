<?php
$page_id = get_queried_object_id();
$evaluate_text = get_theme_mod('buildpro_evaluate_text', '');
if ($evaluate_text === '') {
    $evaluate_text = get_post_meta($page_id, 'buildpro_evaluate_text', true);
}
$evaluate_title = get_theme_mod('buildpro_evaluate_title', '');
if ($evaluate_title === '') {
    $evaluate_title = get_post_meta($page_id, 'buildpro_evaluate_title', true);
}
$evaluate_description = get_theme_mod('buildpro_evaluate_desc', '');
if ($evaluate_description === '') {
    $evaluate_description = get_post_meta($page_id, 'buildpro_evaluate_desc', true);
}

$evaluate_items = [];
$rows = get_theme_mod('buildpro_evaluate_items', array());
if (!is_array($rows) || empty($rows)) {
    $rows = get_post_meta($page_id, 'buildpro_evaluate_items', true);
}
$rows = is_array($rows) ? $rows : [];
foreach ($rows as $row) {
    $description = isset($row['description']) ? $row['description'] : '';
    $name = isset($row['name']) ? $row['name'] : '';
    $position = isset($row['position']) ? $row['position'] : '';
    $avatar_id = isset($row['avatar_id']) ? (int)$row['avatar_id'] : 0;
    $evaluate_items[] = [
        'description' => $description,
        'name' => $name,
        'position' => $position,
        'avatar_id' => $avatar_id,
    ];
}
?>
<section class="section-evaluate">
    <div class="section-evaluate-container">
        <div class="section-evaluate-left">
            <p class="section-evaluate__text" data-has-meta="<?php echo $evaluate_text !== '' ? '1' : '0'; ?>">
                <?php echo esc_html($evaluate_text ?: ''); ?>
            </p>
            <h2 class="section-evaluate__title" data-has-meta="<?php echo $evaluate_title !== '' ? '1' : '0'; ?>">
                <?php echo esc_html($evaluate_title ?: ''); ?>
            </h2>
            <p class="section-evaluate__description"
                data-has-meta="<?php echo $evaluate_description !== '' ? '1' : '0'; ?>">
                <?php echo esc_html($evaluate_description ?: ''); ?>
            </p>
        </div>
        <div class="section-evaluate-right">
            <div class="swiper section-evaluate__swiper swiper-container_evaluate">
                <div class="swiper-wrapper swiper-wrapper_evaluate ">
                    <?php foreach ($evaluate_items as $item): ?>
                    <div class="swiper-slide section-evaluate__swiper-slide">
                        <div class="section-evaluate__item">
                            <p class="section-evaluate__item-description"><?php echo esc_html($item['description']); ?>
                            </p>
                            <div class="section-evaluate__item-content">
                                <div class="section-evaluate__item-avatar">
                                    <?php
                                        $avatar_url = $item['avatar_id'] ? wp_get_attachment_image_url($item['avatar_id'], 'thumbnail') : '';
                                        ?>
                                    <?php if ($avatar_url): ?>
                                    <img src="<?php echo esc_url($avatar_url); ?>"
                                        alt="<?php echo esc_attr($item['name']); ?>">
                                    <?php endif; ?>
                                </div>
                                <div class="section-evaluate__item-info">
                                    <h3 class="section-evaluate__item-name"><?php echo esc_html($item['name']); ?></h3>
                                    <p class="section-evaluate__item-position">
                                        <?php echo esc_html($item['position']); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </div>
    <?php if (empty($evaluate_items)): ?>
    <script src="<?php echo esc_url(get_theme_file_uri('/assets/data/evaluate-date.js')); ?>"></script>
    <?php endif; ?>
</section>
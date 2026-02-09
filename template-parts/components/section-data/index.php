<?php
$section_data_items = [];
$page_id = get_queried_object_id();
$rows = get_theme_mod('buildpro_data_items', array());
if (!is_array($rows) || empty($rows)) {
    $rows = get_post_meta($page_id, 'buildpro_data_items', true);
}
if ($rows && is_array($rows)) {
    foreach ($rows as $row) {
        $number = isset($row['number']) ? $row['number'] : '';
        $text = isset($row['text']) ? $row['text'] : '';
        $section_data_items[] = [
            'number' => $number,
            'text'   => $text,
        ];
    }
}
?>
<section class="section-data">
    <div class="section-data-container">
        <?php foreach ($section_data_items as $item): ?>
        <div class="section-data__item">
            <h3 class="section-data__item-number"><?php echo $item['number']; ?></h3>
            <p class="section-data__item-text"><?php echo $item['text']; ?></p>
        </div>
        <?php endforeach; ?>
    </div>
    <?php if (empty($section_data_items)): ?>
    <script src="<?php echo esc_url(get_theme_file_uri('/assets/data/data-items.js')); ?>"></script>
    <?php endif; ?>
</section>

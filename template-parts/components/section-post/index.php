<?php
$title = get_theme_mod('title_post', '');
$desc = get_theme_mod('description_post', '');
if ($title === '') {
    $title = get_post_meta(get_the_ID(), 'title_post', true);
}
if ($desc === '') {
    $desc = get_post_meta(get_the_ID(), 'description_post', true);
}

$posts = [];
$query = new WP_Query(array(
    'post_type' => 'post',
    'posts_per_page' => 3,
    'orderby' => 'date',
    'order' => 'DESC',
    'post_status' => 'publish',
    'no_found_rows' => true,
));
if ($query->have_posts()) {
    while ($query->have_posts()) {
        $query->the_post();
        $id = get_the_ID();
        $posts[] = array(
            'id' => $id,
            'title' => get_the_title($id),
            'image' => get_the_post_thumbnail_url($id, 'large'),
            'date' => get_the_date('', $id),
            'link' => get_permalink($id),
        );
    }
    wp_reset_postdata();
}
?>
<section class="section-post">
    <div class="section-post__header">
        <h2 class="section-post__title" id="section-post-title"><?php echo esc_html($title ?: ''); ?></h2>
        <p class="section-post__description" id="section-post-desc"><?php echo esc_html($desc ?: ''); ?></p>
    </div>
    <div class="section-post__list">
        <?php foreach ($posts as $p): ?>
        <a class="section-post__item" href="<?php echo esc_url($p['link']); ?>">
            <div class="section-post__item-image">
                <?php if (!empty($p['image'])): ?>
                <img src="<?php echo esc_url($p['image']); ?>" alt="<?php echo esc_attr($p['title']); ?>">
                <?php endif; ?>
            </div>
            <div class="section-post__item-content">
                <div class="section-post__item-top">
                    <?php echo buildpro_svg_icon('calendar-days', 'regular', 'section-post__item-icon'); ?>
                    <p class="section-post__item-date"><?php echo esc_html($p['date']); ?></p>
                </div>
                <h3 class="section-post__item-title"><?php echo esc_html($p['title']); ?></h3>
                <p class="section-post__item-desc">
                    <?php echo esc_html(get_post_meta($p['id'], 'buildpro_post_description', true)); ?>
                </p>
            </div>
            <div class="section-post__item-bottom">
                <p class="section-post__item-readmore">Read more
                    <img src="<?php echo esc_url(get_theme_file_uri('/assets/images/icon/Arrow_Right_blue.png')); ?>"
                        alt="right arrow" class="section-services__item-link-icon">
                </p>
            </div>
        </a>
        <?php endforeach; ?>
    </div>
</section>
<script>
(function() {
    function setDefaults() {
        var t = document.getElementById('section-post-title');
        var d = document.getElementById('section-post-desc');
        var hasTitle = t && t.textContent && t.textContent.trim().length > 0;
        var hasDesc = d && d.textContent && d.textContent.trim().length > 0;
        var pd = window.postsData || null;
        if (!hasTitle && pd && pd.postsTitle) {
            t.textContent = pd.postsTitle;
        }
        if (!hasDesc && pd && pd.postsDescription) {
            d.textContent = pd.postsDescription;
        }
    }

    function renderFallbackPosts() {
        var list = document.querySelector('.section-post__list');
        if (!list) {
            return;
        }
        var existing = list.querySelectorAll('.section-post__item').length;
        var pd = window.postsData || null;
        if (existing === 0 && pd && Array.isArray(pd.items)) {
            function parseDate(x) {
                var t = Date.parse(x);
                return isNaN(t) ? 0 : t;
            }
            var items = pd.items.slice().sort(function(a, b) {
                return parseDate(b.date) - parseDate(a.date);
            }).slice(0, 3);
            items.forEach(function(item) {
                var a = document.createElement('a');
                a.className = 'section-post__item';
                a.href = item.link || '#';
                var imgWrap = document.createElement('div');
                imgWrap.className = 'section-post__item-image';
                if (item.image) {
                    var img = document.createElement('img');
                    img.src = item.image;
                    img.alt = item.title || '';
                    imgWrap.appendChild(img);
                }
                var content = document.createElement('div');
                content.className = 'section-post__item-content';
                var top = document.createElement('div');
                top.className = 'section-post__item-top';
                var date = document.createElement('p');
                date.className = 'section-post__item-date';
                date.textContent = item.date || '';
                top.appendChild(date);
                var h3 = document.createElement('h3');
                h3.className = 'section-post__item-title';
                h3.textContent = item.title || '';
                var p = document.createElement('p');
                p.className = 'section-post__item-desc';
                p.textContent = item.description || '';
                content.appendChild(top);
                content.appendChild(h3);
                content.appendChild(p);
                var bottom = document.createElement('div');
                bottom.className = 'section-post__item-bottom';
                var rm = document.createElement('p');
                rm.className = 'section-post__item-readmore';
                rm.textContent = 'Read more';
                var arrow = document.createElement('img');
                arrow.src = '/wp-content/themes/buildpro/assets/images/icon/Arrow_Right_blue.png';
                arrow.alt = 'right arrow';
                arrow.className = 'section-services__item-link-icon';
                rm.appendChild(arrow);
                bottom.appendChild(rm);
                a.appendChild(imgWrap);
                a.appendChild(content);
                a.appendChild(bottom);
                list.appendChild(a);
            });
        }
    }
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            setDefaults();
            renderFallbackPosts();
        });
    } else {
        setDefaults();
        renderFallbackPosts();
    }
})();
</script>
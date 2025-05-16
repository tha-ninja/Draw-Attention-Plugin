<?php
// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Function to render the hotspots-interaction section
function render_hotspots_interaction_section($settings) {
    ob_start(); ?>
    <div class="hotspots-interaction">
        <?php
        if ($settings['urls_only']) {
            require plugin_dir_path(__FILE__) . 'public/views/image_template.php';
        } else {
            require plugin_dir_path(__FILE__) . 'public/views/more_info_template.php';
            require plugin_dir_path(__FILE__) . 'public/views/image_template.php';
        }
        ?>
    </div>
    <map name="hotspots-image-<?php echo $settings['image_id']; ?>" class="hotspots-map">
        <?php foreach ($settings['hotspots'] as $key => $hotspot) : ?>
            <?php
            $coords = $hotspot['coordinates'];
            $target = !empty($hotspot['action']) ? $hotspot['action'] : '';
            $new_window = !empty($hotspot['action-url-open-in-window']) ? $hotspot['action-url-open-in-window'] : '';
            $target_window = $new_window == 'on' ? '_new' : '';
            $target_url = !empty($hotspot['action-url-url']) ? $hotspot['action-url-url'] : '';
            $rel = !empty($hotspot['rel']) ? $hotspot['rel'] : '';
            $area_class = $target == 'url' ? 'url-area' : 'more-info-area';
            $href = $target == 'url' ? $target_url : '#hotspot-' . $settings['spot_id'] . '-' . $key;
            $href = !empty($href) ? $href : '#';
            $title = !empty($hotspot['title']) ? $hotspot['title'] : '';
            $hotspot['description'] = $hotspot['description'] ?? '';
            $color_scheme = empty($settings['img_settings']['_da_has_multiple_styles']['0']) || $settings['img_settings']['_da_has_multiple_styles']['0'] != 'on' || empty($hotspot['style']) ? '' : $hotspot['style'];
            ?>
            <area
                shape="<?php echo (!empty($hotspot['shape']) && $hotspot['shape'] == 'circle') ? 'circle' : 'polygon'; ?>"
                coords="<?php echo $coords; ?>"
                href="<?php echo $href; ?>"
                rel="<?php echo $rel; ?>"
                title="<?php echo esc_attr($title); ?>"
                alt="<?php echo esc_attr($title); ?>"
                data-action="<?php echo $target; ?>"
                data-color-scheme="<?php echo $color_scheme; ?>"
                target="<?php echo $target_window; ?>"
                class="<?php echo $area_class; ?>"
            >
        <?php endforeach; ?>
    </map>
    <?php return ob_get_clean();
}
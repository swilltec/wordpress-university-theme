
<?php

function university_files()
{

    wp_enqueue_style('google_fonts', "//fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i");
    wp_enqueue_style('font_awesome', "//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css");

    if (strstr($_SERVER['SERVER_NAME'], 'localhost')) {
        wp_enqueue_script('university_main_js', 'http://localhost:3000/bundled.js', NULL, '1.0', true);
    } else {
        wp_enqueue_script('university_vendors_js', get_theme_file_uri('/bundled-assets/vendors~scripts.8c97d901916ad616a264.js'), NULL, '1.0', true);
        wp_enqueue_script('university_bundled_js', get_theme_file_uri('/bundled-assets/scripts.7c107d9b1f23736f45a8.js'), NULL, '1.0', true);
        wp_enqueue_style('university_main_styles', get_theme_file_uri('/bundled-assets/styles.7c107d9b1f23736f45a8.css'));
    }
};

add_action('wp_enqueue_scripts', 'university_files');


function university_features()
{
    register_nav_menu('headerMenuLocation', 'Header Menu Location');
    register_nav_menu('footerMenuLocationOne', 'Footer Menu Location One');
    register_nav_menu('footerMenuLocationTwo', 'Footer Menu Location Two');
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
}
add_action('after_setup_theme', 'university_features');


function university_queries($query)
{
    if (!is_admin() and is_post_type_archive('program') and $query->is_main_query()) {
        $today = date('Ymd');
        $query->set('orderby', 'meta_value_num');
        $query->set('order', 'ASC');
        $query->set('postorder', 'ASC');
        $query->set('posts_per_page', -1);
    }

    if (!is_admin() and is_post_type_archive('event') and $query->is_main_query()) {
        $today = date('Ymd');
        $query->set('meta_key', 'event_date');
        $query->set('orderby', 'meta_value_num');
        $query->set('order', 'ASC');
        $query->set('meta_query', array(
            array(
                'key' => 'event_date',
                'compare' => '>=',
                'value' => $today,
                'type' => 'numeric'
            )
        ));
    }
}

add_action('pre_get_posts', 'university_queries');

?>
<?php
/* CUSTOM POST TYPE NAME: SONG */

/* Create custom post type: song */
add_action("init", "register_song_cpt");
function register_song_cpt() {
    $labels = array(
        'name' => 'Songs',
        'singular_label' => 'Song',
        'menu_name' => 'Songs',
        'name_admin_bar' => 'Song'
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'capability_type' => 'post',
        'taxonomies' => array('genre'),
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 26,
        'hierarchical' => false,
        'rewrite' => array('slug' => 'songs'),
        'supports' => array('title', 'editor')
    );

    register_post_type('fav_songs', $args);
}

/* SONG META BOXES */
add_action('add_meta_boxes', 'song_meta_boxes');
function song_meta_boxes() {
    /*
    add_meta_box('song_artist', 'Artist', 'song_artist_callback', 'fav_songs');
    add_meta_box('song_genre', 'Genre', 'song_genre_callback', 'fav_songs');
    add_meta_box('song_pub_year', 'Year of Publication', 'song_pub_year_callback', 'fav_songs');
    */
    add_meta_box('song_meta_info', 'Song Information', 'song_meta_box_callback', 'fav_songs', 'side');
    //add_meta_box('song_genre', 'Genre', 'song_meta_box_callback', 'fav_songs');
    //add_meta_box('song_pub_year', 'Year of Publication', 'song_meta_box_callback', 'fav_songs');
}

function song_meta_box_callback($post) {
    wp_nonce_field('song_save_meta', 'song_meta_box_nonce');
    $artist = get_post_meta($post->ID, '_song_artist_key', true);
    $genre = get_post_meta($post->ID, '_song_genre_key', true);
    $pub_year = get_post_meta($post->ID, '_song_pub_year_key', true);
    $youtube_url = get_post_meta($post->ID, '_song_url_key', true);

    echo '<div><label>Artist: </label><input type="text" name="txt_song_artist" id="txt_song_artist" maxlength="70" style="width:100%;" value="' . esc_attr($artist) . '" /></div>';
    echo '<div><label>Genre: </label><input type="text" name="txt_song_genre" id="txt_song_genre" maxlength="70" style="width:100%;" value="' . esc_attr($genre) . '" /></div>';
    echo '<div><label>Yr. of Publication: </label><input type="text" name="txt_song_pub_year" id="txt_song_pub_year" maxlength="70" style="width:100%;" value="' . esc_attr($pub_year) . '" /></div>';
    echo '<div><label>Youtube URL: </label><input type="text" name="txt_song_youtube_url" id="txt_song_youtube_url" maxlength="200" style="width:100%;" value="' . esc_attr($youtube_url) . '" /></div>';
}

/*
function song_artist_callback($post) {
    wp_nonce_field('song_save_artist', 'song_artist_metabox_nonce');
    $value = get_post_meta($post->ID, '_song_artist_key', true);

    echo '<input type="text" id="txt_song_artist maxlength="70" value="' . esc_attr($value) . '" />';
}

function song_genre_callback($post) {
    wp_nonce_field('song_save_genre', 'song_genre_metabox_nonce');
    $value = get_post_meta($post->ID, '_song_genre_key', true);

    echo '<input type="text" id="txt_song_genre" maxlength="15" value="' . esc_attr($value) . '" />';
}

function song_pub_year_callback($post) {
    wp_nonce_field('song_save_pub_year', 'song_pub_year_metabox_nonce');
    $value = get_post_meta($post->ID, '_song_pub_year_key', true);

    echo '<input type="number" id="txt_song_pub_year" maxlength="4" value="' . esc_attr($value) . '" />';
}*/

//Saving Metaboxes
//Question to ask: How do I tell WP that this action should only be triggered for FAV_SONGS CPT
add_action('save_post', 'song_save_meta');
function song_save_meta($post_id) {
    if(!isset($_POST['song_meta_box_nonce'])){
        return;
    }

    if(!wp_verify_nonce($_POST['song_meta_box_nonce'], 'song_save_meta')) {
        return;
    }

    if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if(!current_user_can('edit_post', $post_id)) {
        return;
    }

    if(!isset($_POST['txt_song_artist']) || !isset($_POST['txt_song_genre']) || !isset($_POST['txt_song_pub_year'])) {
        return;
    }

    //Safe to SAVE meta data now...
    //Question to ask - How to run a loop inside ALL KEYS and SAVE each meta in one go...

    $artist = sanitize_text_field($_POST['txt_song_artist']);
    $genre = sanitize_text_field($_POST['txt_song_genre']);
    $pub_year = sanitize_text_field($_POST['txt_song_pub_year']);
    $youtube_url = sanitize_text_field($_POST['txt_song_youtube_url']);

    update_post_meta($post_id, '_song_artist_key', $artist);
    update_post_meta($post_id, '_song_genre_key', $genre);
    update_post_meta($post_id, '_song_pub_year_key', $pub_year);
    update_post_meta($post_id, '_song_url_key', $youtube_url);
}

/* ENDS: SONGS CPT */

?>
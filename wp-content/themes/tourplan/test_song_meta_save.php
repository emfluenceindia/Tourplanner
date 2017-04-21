<?php
/* Template Name: Song Entry Form */
get_header();

if(content_restricted()) return;

if($_POST['post_submit'] == 'Submit') {
    $genre = $_POST['song_genre'];
    $args = array(
        'post_title' => $_POST['post_title'],
        'post_content' => $_POST['post_desc'],
        'tax_input' => array($genre),
        'post_type' => 'fav_songs',
        'post_status' => 'publish',
        'comment_status' => 'closed',
        'ping_status' => 'closed'
    );

    $pid = wp_insert_post($args);
    add_post_meta($pid, "_song_artist_key", $_POST['post_artist']);
    wp_set_object_terms($pid, array((int)$genre), 'genre');
}

?>



<form id="post_entry" name="post_entry" method="post" action="<?php echo get_page_link("354") ?>">
<p>
        <label>Title</label><br />
        <input type="text" id="post_title" name="post_title" /></p>
    <p>
        <label>Description</label><br />
        <input type="text" id="post_desc" name="post_desc" />
    </p>
    <p>
        <label>Artist</label><br />
        <input type="text" id="post_artist" name="post_artist" />
        <input type="hidden" name="post_type" id="post_type" value="post_songs" />
        <input type="hidden" id="post_action" name="post_action" value="post_action" />
    </p>
    <p>
        <label>Genre</label><br />
        <?php $args = array(
            'show_option_all'    => '',
            'show_option_none'   => 'Select one',
            'option_none_value'  => '',
            'orderby'            => 'Name',
            'order'              => 'ASC',
            'show_count'         => 0,
            'hide_empty'         => 1,
            'child_of'           => 0,
            'exclude'            => '1',
            'include'            => '',
            'echo'               => 1,
            'selected'           => 0,
            'hierarchical'       => 0,
            'name'               => 'song_genre',
            'id'                 => 'song_genre',
            'class'              => 'postform',
            'depth'              => 0,
            'tab_index'          => 0,
            'taxonomy'           => 'genre',
            'hide_if_empty'      => false,
            'value_field'	     => 'term_id',
        ); ?>
        <?php
            $terms = get_terms('genre', array(
                'orderby' => 'name',
                'hide_empty' => 0
            ));

            echo '<select name="song_genre" id="song_genre">';
            echo '<option value="">--</option>';

            foreach($terms as $term) {
                printf('<option value="%s">%s</option>', $term->term_id, $term->name);
            }

            echo '</select>';
        ?>
    </p>
    <p>
        <input type="submit" name="post_submit" value="Submit" />
    </p>
    <?php wp_nonce_field( 'new_song_nonce' ); ?>
</form>

<?php
add_shortcode('new-travelog', 'create_front_end_layout');
function create_front_end_layout() {
    return "this is our front end layout...";
}

get_footer();
?>
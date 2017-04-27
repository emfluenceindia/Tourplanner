<?php
/*
 * Template name: Latest Travel stories
 */
$request = wp_remote_get( 'http://local.tourplanner.com/wp-json/wp/v2/api/trips?per_page=3' );

if( is_wp_error( $request ) ) {
    return false; // Bail early
}
$body = wp_remote_retrieve_body( $request );
//var_dump($body);

$data = json_decode($body);
foreach($data as $item) {
    echo $item->id . ' ' . $item->date  . ' ' . $item->link  . ' ' . $item->title->rendered .   '<br />';
}
?>
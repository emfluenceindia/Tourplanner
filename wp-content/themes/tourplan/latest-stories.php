<?php
/*
 * Template name: Latest Travel stories
 */
$request = wp_remote_get( 'http://local.tourplanner.com/wp-json/wp/v2/api/travelog?per_page=2' );
//$request = wp_remote_get('https://jsonplaceholder.typicode.com/posts/1');

if( is_wp_error( $request ) ) {
    return false; // Bail early
}
$body = wp_remote_retrieve_body( $request );
//var_dump($body);

$data = json_decode( $body, true );
//var_dump($data);
foreach ($data as $key => $value) {
    echo $value["id"] . ", " . $value["title"] . "<br>";
}

/*var_dump($data[0]);

echo $data[0]->title->rendered;*/

/*foreach($data as $obj) {
    echo $obj->title;
}*/
//echo $data;

/*
if( ! empty( $data ) ) {

    //echo '<ul>';
    foreach( $data as $story ) {
        $title = $story->title;
        echo $title;

        echo '<li>';
        echo '<a href="' . esc_url( $story->info->link ) . '">' . $product->info->title . '</a>';
        echo '</li>';

    }
    //echo '</ul>';
}
*/

?>
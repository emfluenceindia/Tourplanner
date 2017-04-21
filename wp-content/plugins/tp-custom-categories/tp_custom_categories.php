<?php
/*
 * Plugin Name: Tourplanner Custom Taxonomy
 * Description: Creates Custom Taxonomy and Terms for Tourplanner
 * Version: 1.0
 * Author: Subrata Sarkar
 */

class tp_category_genre {

    function __construct() {
        register_activation_hook(__FILE__, array($this, 'activate'));
        add_action('init', array($this, 'create_taxonomies'));
    }

    function activate() {
        $this->create_taxonomies();
        $this->register_new_terms();
    }

    function create_taxonomies() {
        $args = array(
            'hierarchical'                      => true,
            'labels' => array(
                'name'                          => _x('Genre', 'genre general name' ),
                'singular_name'                 => _x('Genre', 'genre singular name'),
                'search_items'                  => __('Genre'),
                'popular_items'                 => __('Popular Genre'),
                'all_items'                     => __('All Genre'),
                'edit_item'                     => __('Edit Genre'),
                'edit_item'                     => __('Edit Genre'),
                'update_item'                   => __('Update Genre'),
                'add_new_item'                  => __('Add New Genre'),
                'new_item_name'                 => __('New Genre Name'),
                'separate_items_with_commas'    => __('Separate Genre with Commas'),
                'add_or_remove_items'           => __('Add or Remove Genre'),
                'choose_from_most_used'         => __('Choose from Most Used Genre')
            ),
            'query_var'                         => true,
            'rewrite'                           => array('slug' =>'genre')
        );
        register_taxonomy( 'genre', array( 'post' ), $args );
    }

    function register_new_terms() {
        $this->taxonomy = 'genre';
        $this->terms = array(
            '0' => array(
                'name' => 'Blues',
                'slug' => 'blues-music',
                'description' => ''
            ),
            '1' => array(
                'name' => 'Hip hop',
                'slug' => 'hip-hop',
                'description' => ''
            ),
            '2' => array(
                'name' => 'Country Music',
                'slug' => 'country-music',
                'description' => ''
            ),
            '3' => array(
                'name' => 'Ambient Music',
                'slug' => 'ambient-music',
                'description' => ''
            ),
            '4' => array(
                'name' => 'Rock',
                'slug' => 'rock-music',
                'description' => ''
            ),
            '5' => array(
                'name' => 'Jazz',
                'slug' => 'jazz-music',
                'description' => ''
            ),
            '6' => array(
                'name' => 'Opera Music',
                'slug' => 'opera-music',
                'description' => ''
            ),
            '7' => array(
                'name' => 'Folk Music',
                'slug' => 'folk-music',
                'description' => ''
            ),
            '8' => array(
                'name' => 'Pop Music',
                'slug' => 'pop-music',
                'description' => ''
            ),
            '9' => array(
                'name' => 'Gospel Music',
                'slug' => 'gospel-music',
                'description' => ''
            ),
            '10' => array(
                'name' => 'Carol Music',
                'slug' => 'carol-music',
                'description' => ''
            ),
            '11' => array(
                'name' => 'Classical',
                'slug' => 'classical-music',
                'description' => ''
            )
        );

        foreach ( $this->terms as $term_key=>$term) {
            wp_insert_term(
                $term['name'],
                $this->taxonomy,
                array(
                    'description'   => $term['description'],
                    'slug'          => $term['slug'],
                )
            );
            unset( $term );
        }
    }
}

$Genre = new tp_category_genre();

class tp_category_hotel_type {
    function __construct() {
        register_activation_hook(__FILE__, array($this, 'activate'));
        add_action('init', array($this, 'create_taxonomies'));
    }

    function activate() {
        $this->create_taxonomies();
        $this->register_new_terms();
    }

    function create_taxonomies() {
        $args = array(
            'hierarchical' => true,
            'labels' => array(
                'name'                          => _x('Hotel Type', 'Hotel Type general name' ),
                'singular_name'                 => _x('Hotel Type', 'Hotel Type singular name'),
                'search_items'                  => __('Hotel Type'),
                'popular_items'                 => __('Popular Hotel Type'),
                'all_items'                     => __('All Hotel Types'),
                'edit_item'                     => __('Edit Hotel Type'),
                'update_item'                   => __('Update Hotel Type'),
                'add_new_item'                  => __('Add New Hotel Type'),
                'new_item_name'                 => __('New Hotel Type Name'),
                'separate_items_with_commas'    => __('Separate Hotel Type with Commas'),
                'add_or_remove_items'           => __('Add or Remove Hotel Type'),
                'choose_from_most_used'         => __('Choose from Most Used Hotel Type')
            ),
            'query_var' => true,
            'rewrite' => array('slug' => 'hotel-types'),
            'show_in_menu' => true,
            'show_in_nav_menus' => false,
            'show_tagcloud' => false,
            'show_in_quick_edit' => true,
        );

        register_taxonomy('hotel_type', array('post'), $args);
    }

    function register_new_terms() {
        $this->taxonomy = 'hotel_type';
        $this->terms = array(
            '0' => array(
                'name' => 'Budget',
                'slug' => 'budget-hotel',
                'description' => ''
            ),
            '1' => array(
                'name' => 'Standard',
                'slug' => 'standard-hotel',
                'description' => ''
            ),
            '2' => array(
                'name' => 'Deluxe',
                'slug' => 'deluxe-hotel',
                'description' => ''
            ),
            '3' => array(
                'name' => 'Luxury',
                'slug' => 'luxury-hotel',
                'description' => ''
            ),
            '4' => array(
                'name' => 'Holiday Resort',
                'slug' => 'holiday-resort',
                'description' => ''
            ),
            '5' => array(
                'name' => 'Heritage Hotel',
                'slug' => 'heritage-hotel',
                'description' => ''
            ),
            '6' => array(
                'name' => 'Condo',
                'slug' => 'condo',
                'description' => ''
            ),
            '7' => array(
                'name' => 'Lodge',
                'slug' => 'holiday-lodge',
                'description' => ''
            ),
            '8' => array(
                'name' => 'Holiday Home',
                'slug' => 'holiday-home',
                'description' => ''
            ),
        );

        foreach ( $this->terms as $term_key=>$term) {
            wp_insert_term(
                $term['name'],
                $this->taxonomy,
                array(
                    'description'   => $term['description'],
                    'slug'          => $term['slug'],
                )
            );
            unset( $term );
        }
    }
}

$HotelTypes = new tp_category_hotel_type();

class tp_category_amenities {
    function __construct() {
        register_activation_hook(__FILE__, array($this, 'activate'));
        add_action('init', array($this, 'create_taxonomies'));
    }

    function activate() {
        $this->create_taxonomies();
        $this->register_new_terms();
    }

    function create_taxonomies() {
        $args = array(
            'hierarchical' => true,
            'labels' => array(
                'name'                          => _x('Amenities', 'Hotel Amenities general name' ),
                'singular_name'                 => _x('Amenities', 'Hotel Amenities singular name'),
                'search_items'                  => __('Amenities'),
                'popular_items'                 => __('Popular Amenities'),
                'all_items'                     => __('All Amenities'),
                'edit_item'                     => __('Edit Amenity'),
                'update_item'                   => __('Update Amenity'),
                'add_new_item'                  => __('Add New Amenity'),
                'new_item_name'                 => __('New Amenity Name'),
                'separate_items_with_commas'    => __('Separate Amenities with Commas'),
                'add_or_remove_items'           => __('Add or Remove Amenity'),
                'choose_from_most_used'         => __('Choose from Most Used Amenities')
            ),
            'query_var' => true,
            'rewrite' => array('slug' => 'hotel-amenities')
        );

        register_taxonomy('amenities', array('post'), $args);
    }

    function register_new_terms() {
        $this->taxonomy = 'amenities';
        $this->terms = array(
            '0' => array(
                'name' => 'Kitchen Facility',
                'slug' => 'kitchen-facility',
                'description' => ''
            ),
            '1' => array(
                'name' => 'In-room Dining',
                'slug' => 'in-room-dining',
                'description' => ''
            ),
            '2' => array(
                'name' => 'Television',
                'slug' => 'television',
                'description' => ''
            ),
            '4' => array(
                'name' => 'Room Service',
                'slug' => 'room-service',
                'description' => ''
            ),
            '5' => array(
                'name' => 'Laundry Facility',
                'slug' => 'laundry-service',
                'description' => ''
            ),
            '6' => array(
                'name' => 'Free WiFi',
                'slug' => 'free-wifi',
                'description' => ''
            ),
            '7' => array(
                'name' => 'Intercom',
                'slug' => 'intercom',
                'description' => ''
            ),
            '8' => array(
                'name' => 'Telephone',
                'slug' => 'telephone',
                'description' => ''
            ),
            '9' => array(
                'name' => 'Hair Drier',
                'slug' => 'hair-drier',
                'description' => ''
            ),
            '10' => array(
                'name' => 'Vending',
                'slug' => 'vending',
                'description' => ''
            ),
            '11' => array(
                'name' => 'FnB',
                'slug' => 'f-n-b',
                'description' => ''
            ),
            '12' => array(
                'name' => 'Gym',
                'slug' => 'gym',
                'description' => ''
            ),
            '13' => array(
                'name' => 'Bar and Restaurant',
                'slug' => 'bar-and-restaurant',
                'description' => ''
            ),
            '14' => array(
                'name' => 'Recreation',
                'slug' => 'recreation',
                'description' => ''
            ),
            '15' => array(
                'name' => 'Swimming Pool',
                'slug' => 'swimming-pool',
                'description' => ''
            ),
            '16' => array(
                'name' => 'Car Parking',
                'slug' => 'car-parking',
                'description' => ''
            ),
            '17' => array(
                'name' => 'Pick up and Drop',
                'slug' => 'pickup-and-drop',
                'description' => ''
            ),
            '18' => array(
                'name' => 'Complementary Breakfast',
                'slug' => 'complementary-breakfast',
                'description' => ''
            ),
            '19' => array(
                'name' => 'Welcome Kit',
                'slug' => 'welcome-kit',
                'description' => ''
            ),
            '20' => array(
                'name' => 'Doctor On Call',
                'slug' => 'doctor-on-call',
                'description' => ''
            ),
            '21' => array(
                'name' => 'First Aid',
                'slug' => 'first-aid',
                'description' => ''
            ),
        );

        foreach ( $this->terms as $term_key=>$term) {
            wp_insert_term(
                $term['name'],
                $this->taxonomy,
                array(
                    'description'   => $term['description'],
                    'slug'          => $term['slug'],
                )
            );
            unset( $term );
        }
    }
}

$Amenities = new tp_category_amenities();

class tp_category_room_type {
    function __construct() {
        register_activation_hook(__FILE__, array($this, 'activate'));
        add_action('init', array($this, 'create_taxonomies'));
    }

    function activate() {
        $this->create_taxonomies();
        $this->register_new_terms();
    }

    function create_taxonomies() {
        $args = array(
            'hierarchical' => true,
            'labels' => array(
                'name'                          => _x('Available Room Types', 'Room Type general name' ),
                'singular_name'                 => _x('Room Type', 'Room Type singular name'),
                'search_items'                  => __('Room Type'),
                'popular_items'                 => __('Popular Room Type'),
                'all_items'                     => __('All Room Types'),
                'edit_item'                     => __('Edit Room Type'),
                'edit_item'                     => __('Edit Room Type'),
                'update_item'                   => __('Update Room Type'),
                'add_new_item'                  => __('Add New Room Type'),
                'new_item_name'                 => __('New Room Type Name'),
                'separate_items_with_commas'    => __('Separate Room Type with Commas'),
                'add_or_remove_items'           => __('Add or Remove Room Type'),
                'choose_from_most_used'         => __('Choose from Most Used Room Type')
            ),
            'query_vars' => true,
            'rewrite' => array('slug' => 'room-types')
        );

        register_taxonomy('room_type', array('post'), $args);
    }

    function register_new_terms() {
        $this->taxonomy = 'room_type';
        $this->terms = array(
            '0' => array(
                'name' => 'Non-AC Standard Double Bed',
                'slug' => 'non-ac-standard-double-bed',
                'description' => ''
            ),
            '1' => array(
                'name' => 'AC Standard Double Bed',
                'slug' => 'ac-standard-double-bed',
                'description' => ''
            ),
            '2' => array(
                'name' => 'Non-AC Deluxe Double Bed',
                'slug' => 'non-ac-deluxe-double-bed',
                'description' => ''
            ),
            '3' => array(
                'name' => 'AC Deluxe Double Bed',
                'slug' => 'ac-deluxe-double-bed',
                'description' => ''
            ),
            '4' => array(
                'name' => 'Non-AC Triple Bed',
                'slug' => 'non-ac-triple-bed',
                'description' => ''
            ),
            '5' => array(
                'name' => 'AC Triple Bed',
                'slug' => 'ac-triple-bed',
                'description' => ''
            ),
            '6' => array(
                'name' => 'Non-AC Suite',
                'slug' => 'non-ac-suite',
                'description' => ''
            ),
            '7' => array(
                'name' => 'AC Suite',
                'slug' => 'ac-suite',
                'description' => ''
            ),
            '8' => array(
                'name' => 'Family Room',
                'slug' => 'family-room',
                'description' => ''
            ),
            '9' => array(
                'name' => '12-Bed Dormitory',
                'slug' => '12-bed-dormitory',
                'description' => ''
            ),
            '10' => array(
                'name' => '8-Bed Dormitory',
                'slug' => '8-bed-dormitory',
                'description' => ''
            ),
            '11' => array(
                'name' => '6-Bed Dormitory',
                'slug' => '6-bed-dormitory',
                'description' => ''
            ),
            '12' => array(
                'name' => 'AC Single Room',
                'slug' => 'ac-single-room',
                'description' => ''
            ),
            '13' => array(
                'name' => 'Non-AC Single Room',
                'slug' => 'non-ac-single-room',
                'description' => ''
            ),
        );

        foreach ( $this->terms as $term_key=>$term) {
            wp_insert_term(
                $term['name'],
                $this->taxonomy,
                array(
                    'description'   => $term['description'],
                    'slug'          => $term['slug'],
                )
            );
            unset( $term );
        }
    }
}

$RoomTypes = new tp_category_room_type();

class tp_category_story_type {
    function __construct() {
        register_activation_hook(__FILE__, array($this, 'activate'));
        add_action('init', array($this, 'create_taxonomies'));
    }

    function activate() {
        $this->create_taxonomies();
        $this->register_new_terms();
    }

    function create_taxonomies() {
        $args = array(
            'hierarchical'                      => true,
            'labels' => array(
                'name'                          => _x('Story Type', 'Story Type general name' ),
                'singular_name'                 => _x('Story Type', 'Story Type singular name'),
                'search_items'                  => __('Story Type'),
                'popular_items'                 => __('Popular Story Type'),
                'all_items'                     => __('All Story Types'),
                'edit_item'                     => __('Edit Story Type'),
                'update_item'                   => __('Update Story Type'),
                'add_new_item'                  => __('Add New Story Type'),
                'new_item_name'                 => __('New Story Type Name'),
                'separate_items_with_commas'    => __('Separate Story Type with Commas'),
                'add_or_remove_items'           => __('Add or Remove Story Type'),
                'choose_from_most_used'         => __('Choose from Most Used Story Type')
            ),
            'query_var'                         => true,
            'rewrite'                           => array('slug' =>'story-type')
        );
        register_taxonomy( 'story-type', array( 'post' ), $args );
    }

    function register_new_terms() {
        $this->taxonomy = 'story-type';
        $this->terms = array(
            '0' => array(
                'name' => 'Travel and Lifestyle',
                'slug' => 'travel-and-lifestyle',
                'description' => ''
            ),
            '1' => array(
                'name' => 'Luxury Travel Stories',
                'slug' => 'luxury-travel',
                'description' => ''
            ),
            '2' => array(
                'name' => 'Special Interest Article',
                'slug' => 'special-interest-article',
                'description' => ''
            )
        );

        foreach ( $this->terms as $term_key=>$term) {
            wp_insert_term(
                $term['name'],
                $this->taxonomy,
                array(
                    'description'   => $term['description'],
                    'slug'          => $term['slug'],
                )
            );
            unset( $term );
        }
    }
}

$TourTypes = new tp_category_story_type();

class tp_hotel_location {
    function __construct() {
        register_activation_hook(__FILE__, array($this, 'activate'));
        add_action('init', array($this, 'create_taxonomies'));
    }

    function activate() {
        $this->create_taxonomies();
        $this->register_new_terms();
    }

    function create_taxonomies() {
        $args = array(
            'hierarchical'                      => true,
            'labels' => array(
                'name'                          => _x('Hotel Location', 'Hotel Location' ),
                'singular_name'                 => _x('Hotel Location', 'Hotel Location singular name'),
                'search_items'                  => __('Hotel Location'),
                'popular_items'                 => __('Popular Hotel Location'),
                'all_items'                     => __('All Hotel Locations'),
                'edit_item'                     => __('Edit Hotel Location'),
                'update_item'                   => __('Update Hotel Location'),
                'add_new_item'                  => __('Add New Hotel Location'),
                'new_item_name'                 => __('New Hotel Location Name'),
                'separate_items_with_commas'    => __('Separate Hotel Location with Commas'),
                'add_or_remove_items'           => __('Add or Remove Hotel Location'),
                'choose_from_most_used'         => __('Choose from Most Used Hotel Location')
            ),
            'query_var'                         => true,
            'rewrite'                           => array('slug' =>'hotel-location')
        );
        register_taxonomy( 'hotel_location', array( 'post' ), $args );
    }

    function register_new_terms() {
        $this->taxonomy = 'hotel_location';
        $this->terms = array(
            '0' => array(
                'name' => 'Goa',
                'slug' => 'goa',
                'description' => ''
            ),
            '1' => array(
                'name' => 'Haridwar',
                'slug' => 'haridwar',
                'description' => ''
            ),
            '2' => array(
                'name' => 'Rishikesh',
                'slug' => 'rishikesh',
                'description' => ''
            ),
            '3' => array(
                'name' => 'Shimla',
                'slug' => 'shimla',
                'description' => ''
            ),
            '4' => array(
                'name' => 'Manali',
                'slug' => 'manali',
                'description' => ''
            ),
            '5' => array(
                'name' => 'Kulu',
                'slug' => 'kulu',
                'description' => ''
            ),
            '6' => array(
                'name' => 'Lava and Lolegaon',
                'slug' => 'lava-and-lolegaon',
                'description' => ''
            ),
            '7' => array(
                'name' => 'Darjeeling',
                'slug' => 'darjeeling',
                'description' => ''
            ),
            '8' => array(
                'name' => 'Joshimath',
                'slug' => 'joshimath',
                'description' => ''
            ),
            '9' => array(
                'name' => 'Rudraprayag',
                'slug' => 'rudraprayag',
                'description' => ''
            ),
            '10' => array(
                'name' => 'Auli',
                'slug' => 'auli',
                'description' => ''
            ),
            '11' => array(
                'name' => 'Nanital',
                'slug' => 'nainital',
                'description' => ''
            ),
            '12' => array(
                'name' => 'Kausani',
                'slug' => 'kausani',
                'description' => ''
            ),
            '13' => array(
                'name' => 'Almorah',
                'slug' => 'almorah',
                'description' => ''
            ),
            '14' => array(
                'name' => 'Ranikhet',
                'slug' => 'ranikhet',
                'description' => ''
            ),
            '15' => array(
                'name' => 'Bolpur Shantiniketan',
                'slug' => 'bolpur-shantiniketan',
                'description' => ''
            ),
            '16' => array(
                'name' => 'Sillery Gaon',
                'slug' => 'sillery gaon',
                'description' => ''
            ),
            '17' => array(
                'name' => 'Reshi Khola',
                'slug' => 'reshi-khola',
                'description' => ''
            ),
            '18' => array(
                'name' => 'Rishyop',
                'slug' => 'rishyop',
                'description' => ''
            ),
            '19' => array(
                'name' => 'Puri',
                'slug' => 'puri',
                'description' => ''
            ),
            '20' => array(
                'name' => 'Digha',
                'slug' => 'digha',
                'description' => ''
            ),
            '21' => array(
                'name' => 'Auli',
                'slug' => 'auli',
                'description' => ''
            ),
        );

        foreach ( $this->terms as $term_key=>$term) {
            wp_insert_term(
                $term['name'],
                $this->taxonomy,
                array(
                    'description'   => $term['description'],
                    'slug'          => $term['slug'],
                )
            );
            unset( $term );
        }
    }
}

$HotelLocations = new tp_hotel_location();

?>
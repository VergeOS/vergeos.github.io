<?php
function deep_demo_plugins( $slug ) {
    $main_plugins = array(
        'elementor',
        'contact-form-7',
    );
    $plugins_array = array(
        // Agency2
        'agency2free' => array_merge( $main_plugins, array( 'wp-pagenavi', 'deeper-comments' ) ),
        // Magazine
        'magazine-free' => array_merge( $main_plugins, array( 'post-ratings', 'wp-cloudy', 'wp-pagenavi', 'deeper-comments' ) ),
        // personal-blog-free
        'personal-blog-free' => array_merge( $main_plugins, array( 'wp-pagenavi', 'deeper-comments' ) ),
        // minimal-blog-free
        'minimal-blog-free'	=> array_merge( $main_plugins, array( 'wp-pagenavi', 'deeper-comments' ) ),
        // modern-business
        'modern-business' => array_merge( $main_plugins, array( 'deeper-comments' ) ),
        // modern-shop-free
        'modern-shop-free'  => array_merge( $main_plugins, array( 'woocommerce' ) ),
        // conference-free
        'conference-free' => array_merge( $main_plugins, array( 'deeper-comments' ) ),
        // SPA Free
        'spa-free' => array_merge( $main_plugins, array( 'deeper-comments' ) ),
        // corporate-free
        'corporate-free' => array_merge( $main_plugins, array( 'deeper-comments' ) ),
        // corporate2-free
        'corporate2-free' => array_merge( $main_plugins, array( 'deeper-comments' ) ),
        // events-free
        'events-free' => array_merge( $main_plugins, array( 'modern-events-calendar-lite', 'deeper-comments' ) ),
        // church-free
        'church-free' => array_merge( $main_plugins, array( 'modern-events-calendar-lite', 'deeper-comments' ) ),
        // real-estate-free
        'real-estate-free' => array_merge( $main_plugins, array( 'deeper-comments' ) ),
        // freelancer-free
        'freelancer-free' => array_merge( $main_plugins, array( 'deeper-comments' ) ),
        // language-school-free
        'language-school-free' => array_merge( $main_plugins, array( 'modern-events-calendar-lite', 'deeper-comments' ) ),
        // business-free
        'business-free'	=> array_merge( $main_plugins, array( 'deeper-comments' ) ),
        // lawyer-free
        'lawyer-free' => array_merge( $main_plugins, array( 'deeper-comments' ) ),
        // dentist-free
        'dentist-free' => array_merge( $main_plugins, array( 'deeper-comments' ) ),
        // startup-free
        'startup-free' => array_merge( $main_plugins, array( 'deeper-comments' ) ),
        // wedding-free
        'wedding-free' => array_merge( $main_plugins, array( 'deeper-comments' ) ),
        // insurance-free
        'insurance-free' => array_merge( $main_plugins, array( 'deeper-comments' ) ),
        // yoga-free
        'yoga-free'	=> array_merge( $main_plugins, array( 'deeper-comments' ) ),
        // mechanic-free
        'mechanic-free'	=> array_merge( $main_plugins, array( 'deeper-comments' ) ),
        // portfolio-free
        'portfolio-free' => array_merge( $main_plugins, array( 'deeper-comments' ) ),
        // dietitian-free
        'dietitian-free' => array_merge( $main_plugins, array( 'deeper-comments' ) ),
        // software-free
        'software-free'	=> array_merge( $main_plugins, array( 'deeper-comments' ) ),
        // beauty-free
        'beauty-free' => array_merge( $main_plugins, array( 'deeper-comments' ) ),
        // consulting-free
        'consulting-free' => array_merge( $main_plugins, array( 'deeper-comments' ) ),
        // crypto-free
        'crypto-free' => array_merge( $main_plugins, array( 'deeper-comments' ) ),
    );
    return $plugins_array[ $slug ];
}

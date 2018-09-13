<?php
// Shortcodes for RG-Instagram

// Add shortcodes
add_shortcode('rg-instagram', 'show_ig');

//shortcodes in widgets
add_filter('widget_text', 'do_shortcode');
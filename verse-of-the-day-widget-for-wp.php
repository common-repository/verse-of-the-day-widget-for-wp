<?php
/*
Plugin Name: Verse of the Day Widget for WP
Description: Discover daily inspiration with the "Verse of the Day Widget for WP" plugin! Each day, you'll receive a randomly selected verse from the King James Version (KJV) Bible, sourced from the latest trending searches on Google. Each verse is beautifully overlaid on a carefully curated, random photo, providing a visually uplifting experience to start your day on a positive note.
Version: 7.3.14
Author: Allen Floyd
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
// Function to check if a specific shortcode is present in the post content
function votd_has_shortcode($shortcode = '') {
    global $post;
    if (empty($shortcode) || !is_singular() || !isset($post)) {
        return false;
    }
    return has_shortcode($post->post_content, $shortcode);
}

// Enqueue scripts and styles conditionally
function votd_enqueue_scripts() {
   if (is_active_widget(false, false, 'verse_of_the_day_widget_for_wp', true) || votd_has_shortcode('votd_verse_of_the_day_widget_for_wp')) {

       wp_enqueue_script('votd-header-widget-js', plugin_dir_url(__FILE__) . 'js/header-widget.js', array(), filemtime(plugin_dir_path(__FILE__) . 'js/header-widget.js'), true);

       wp_enqueue_style('styles-css', plugin_dir_url(__FILE__) . 'css/styles.css', array(), filemtime(plugin_dir_path(__FILE__) . 'css/styles.css') );

       // Retrieve options from the WordPress database
       $votd_location = get_option('votd_location');
       $votd_language = get_option('votd_language');

       // Pass the settings to the JavaScript file
       wp_localize_script('votd-header-widget-js', 'votdvars', array(
           'pluginUrl'  => plugin_dir_url(__FILE__),
           'language'   => $votd_language,
       ));
   }
}

add_action('wp_enqueue_scripts', 'votd_enqueue_scripts');


// Enqueue admin scripts and styles
function votd_enqueue_admin_scripts($hook) {
    if ($hook != 'settings_page_verse-of-the-day-widget-for-wp') {
        return;
    }
    
    wp_enqueue_script('votd-admin-settings-js', plugin_dir_url(__FILE__) . 'js/admin-settings.js', array(), filemtime(plugin_dir_path(__FILE__) . 'js/admin-settings.js'), true );

    wp_enqueue_style('votd-admin-styles-css', plugin_dir_url(__FILE__) . 'css/admin-styles.css', array(), filemtime(plugin_dir_path(__FILE__) . 'css/admin-styles.css') );

    // Retrieve options from the WordPress database
    $votd_location = get_option('votd_location');
    $votd_language = get_option('votd_language');

    // Pass the settings to the JavaScript file
    wp_localize_script('votd-header-widget-js', 'votdvars', array(
        'pluginUrl'  => plugin_dir_url(__FILE__),
        'language'   => $votd_language,
    ));

}
add_action('admin_enqueue_scripts', 'votd_enqueue_admin_scripts');

function votd_display_verse_widget($args, $instance) {
    ob_start();

    // Detect if the widget is placed in the sidebar or header area
    if (isset($args['id']) && strpos($args['id'], 'header-widget') !== false && file_exists(plugin_dir_path(__FILE__) . 'header-widget.html')) {
        // Load header-specific HTML if placed in the header area
        include plugin_dir_path(__FILE__) . 'header-widget.html';

    } elseif (isset($args['id']) && strpos($args['id'], 'sidebar') !== false && file_exists(plugin_dir_path(__FILE__) . 'sidebar-widget.html')) {
        // Load sidebar-specific HTML if placed in the sidebar area
        include plugin_dir_path(__FILE__) . 'sidebar-widget.html';

    } else {
        // Fallback to default header-widget.html if other files do not exist or if placement is unclear
        if (file_exists(plugin_dir_path(__FILE__) . 'header-widget.html')) {
            include plugin_dir_path(__FILE__) . 'header-widget.html';
        } else {
            echo "Fallback header widget HTML file not found.";
        }
    }

    echo ob_get_clean();
}

// Function specifically for handling shortcodes
function votd_display_verse_widget_shortcode($atts = array()) {
    $atts = shortcode_atts(array(), $atts); // Extract shortcode attributes, if any
    ob_start();

    // Load header-specific HTML for the shortcode
    if (file_exists(plugin_dir_path(__FILE__) . 'header-widget.html')) {
        include plugin_dir_path(__FILE__) . 'header-widget.html';
    } else {
        echo "Header widget HTML file not found.";
    }

    return ob_get_clean();
}

// Register the shortcode handler with a dedicated function
add_shortcode('votd_verse_of_the_day_widget_for_wp', 'votd_display_verse_widget_shortcode');

// Add settings link on plugin page
function votd_add_settings_link($links) {
    $settings_link = '<a href="options-general.php?page=verse-of-the-day-widget-for-wp">Settings</a>';
    array_unshift($links, $settings_link);
    return $links;
}
add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'votd_add_settings_link');

// Register settings page
function votd_register_settings_page() {
    add_options_page(
        'Verse of the Day Widget for WP Settings',
        'Verse of the Day',
        'manage_options',
        'verse-of-the-day-widget-for-wp',
        'votd_settings_page_html'
    );
}
add_action('admin_menu', 'votd_register_settings_page');

// Settings page HTML
function votd_settings_page_html() {
  if (!current_user_can('manage_options')) {
      return;
  }
  ?>

  <div class="wrap">
      <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
      <form method="post" action="options.php">
          <?php
          // Output security fields for the registered setting
          settings_fields('votd_settings_group');

          // Output setting sections and their fields
          do_settings_sections('votd_settings_group');

          // Output save settings button
          submit_button();
          ?>

          <h2>Widget Settings</h2>
          
          <p>
            <!-- get_option returns either votd_language set to true or false if votd_language hasn't been set yet -->   
            <?php $saved_language = get_option('votd_language'); ?>
            <p>Preferred Language for Verse Display:</p>
            <select name="votd_language" id="votd_language">
                <option value="" disabled>Select a language</option>
                <option value="af" <?php selected($saved_language, 'af'); ?>>Afrikaans</option>
                <option value="sq" <?php selected($saved_language, 'sq'); ?>>Albanian</option>
                <option value="am" <?php selected($saved_language, 'am'); ?>>Amharic</option>
                <option value="ar" <?php selected($saved_language, 'ar'); ?>>Arabic</option>
                <option value="hy" <?php selected($saved_language, 'hy'); ?>>Armenian</option>
                <option value="az" <?php selected($saved_language, 'az'); ?>>Azerbaijani</option>
                <option value="eu" <?php selected($saved_language, 'eu'); ?>>Basque</option>
                <option value="be" <?php selected($saved_language, 'be'); ?>>Belarusian</option>
                <option value="bn" <?php selected($saved_language, 'bn'); ?>>Bengali</option>
                <option value="bs" <?php selected($saved_language, 'bs'); ?>>Bosnian</option>
                <option value="bg" <?php selected($saved_language, 'bg'); ?>>Bulgarian</option>
                <option value="ca" <?php selected($saved_language, 'ca'); ?>>Catalan</option>
                <option value="ceb" <?php selected($saved_language, 'ceb'); ?>>Cebuano</option>
                <option value="ny" <?php selected($saved_language, 'ny'); ?>>Chichewa</option>
                <option value="zh-CN" <?php selected($saved_language, 'zh-CN'); ?>>Chinese (Simplified)</option>
                <option value="zh-TW" <?php selected($saved_language, 'zh-TW'); ?>>Chinese (Traditional)</option>
                <option value="co" <?php selected($saved_language, 'co'); ?>>Corsican</option>
                <option value="hr" <?php selected($saved_language, 'hr'); ?>>Croatian</option>
                <option value="cs" <?php selected($saved_language, 'cs'); ?>>Czech</option>
                <option value="da" <?php selected($saved_language, 'da'); ?>>Danish</option>
                <option value="nl" <?php selected($saved_language, 'nl'); ?>>Dutch</option>
                <option value="en" <?php selected($saved_language, 'en'); ?>>English</option>
                <option value="eo" <?php selected($saved_language, 'eo'); ?>>Esperanto</option>
                <option value="et" <?php selected($saved_language, 'et'); ?>>Estonian</option>
                <option value="tl" <?php selected($saved_language, 'tl'); ?>>Filipino</option>
                <option value="fi" <?php selected($saved_language, 'fi'); ?>>Finnish</option>
                <option value="fr" <?php selected($saved_language, 'fr'); ?>>French</option>
                <option value="fy" <?php selected($saved_language, 'fy'); ?>>Frisian</option>
                <option value="gl" <?php selected($saved_language, 'gl'); ?>>Galician</option>
                <option value="ka" <?php selected($saved_language, 'ka'); ?>>Georgian</option>
                <option value="de" <?php selected($saved_language, 'de'); ?>>German</option>
                <option value="el" <?php selected($saved_language, 'el'); ?>>Greek</option>
                <option value="gu" <?php selected($saved_language, 'gu'); ?>>Gujarati</option>
                <option value="ht" <?php selected($saved_language, 'ht'); ?>>Haitian Creole</option>
                <option value="ha" <?php selected($saved_language, 'ha'); ?>>Hausa</option>
                <option value="haw" <?php selected($saved_language, 'haw'); ?>>Hawaiian</option>
                <option value="iw" <?php selected($saved_language, 'iw'); ?>>Hebrew</option>
                <option value="hi" <?php selected($saved_language, 'hi'); ?>>Hindi</option>
                <option value="hmn" <?php selected($saved_language, 'hmn'); ?>>Hmong</option>
                <option value="hu" <?php selected($saved_language, 'hu'); ?>>Hungarian</option>
                <option value="is" <?php selected($saved_language, 'is'); ?>>Icelandic</option>
                <option value="ig" <?php selected($saved_language, 'ig'); ?>>Igbo</option>
                <option value="id" <?php selected($saved_language, 'id'); ?>>Indonesian</option>
                <option value="ga" <?php selected($saved_language, 'ga'); ?>>Irish</option>
                <option value="it" <?php selected($saved_language, 'it'); ?>>Italian</option>
                <option value="ja" <?php selected($saved_language, 'ja'); ?>>Japanese</option>
                <option value="jw" <?php selected($saved_language, 'jw'); ?>>Javanese</option>
                <option value="kn" <?php selected($saved_language, 'kn'); ?>>Kannada</option>
                <option value="kk" <?php selected($saved_language, 'kk'); ?>>Kazakh</option>
                <option value="km" <?php selected($saved_language, 'km'); ?>>Khmer</option>
                <option value="rw" <?php selected($saved_language, 'rw'); ?>>Kinyarwanda</option>
                <option value="ko" <?php selected($saved_language, 'ko'); ?>>Korean</option>
                <option value="ku" <?php selected($saved_language, 'ku'); ?>>Kurdish (Kurmanji)</option>
                <option value="ky" <?php selected($saved_language, 'ky'); ?>>Kyrgyz</option>
                <option value="lo" <?php selected($saved_language, 'lo'); ?>>Lao</option>
                <option value="la" <?php selected($saved_language, 'la'); ?>>Latin</option>
                <option value="lv" <?php selected($saved_language, 'lv'); ?>>Latvian</option>
                <option value="lt" <?php selected($saved_language, 'lt'); ?>>Lithuanian</option>
                <option value="lb" <?php selected($saved_language, 'lb'); ?>>Luxembourgish</option>
                <option value="mk" <?php selected($saved_language, 'mk'); ?>>Macedonian</option>
                <option value="mg" <?php selected($saved_language, 'mg'); ?>>Malagasy</option>
                <option value="ms" <?php selected($saved_language, 'ms'); ?>>Malay</option>
                <option value="ml" <?php selected($saved_language, 'ml'); ?>>Malayalam</option>
                <option value="mt" <?php selected($saved_language, 'mt'); ?>>Maltese</option>
                <option value="mi" <?php selected($saved_language, 'mi'); ?>>Maori</option>
                <option value="mr" <?php selected($saved_language, 'mr'); ?>>Marathi</option>
                <option value="mn" <?php selected($saved_language, 'mn'); ?>>Mongolian</option>
                <option value="my" <?php selected($saved_language, 'my'); ?>>Myanmar (Burmese)</option>
                <option value="ne" <?php selected($saved_language, 'ne'); ?>>Nepali</option>
                <option value="no" <?php selected($saved_language, 'no'); ?>>Norwegian</option>
                <option value="or" <?php selected($saved_language, 'or'); ?>>Odia (Oriya)</option>
                <option value="ps" <?php selected($saved_language, 'ps'); ?>>Pashto</option>
                <option value="fa" <?php selected($saved_language, 'fa'); ?>>Persian</option>
                <option value="pl" <?php selected($saved_language, 'pl'); ?>>Polish</option>
                <option value="pt" <?php selected($saved_language, 'pt'); ?>>Portuguese</option>
                <option value="pa" <?php selected($saved_language, 'pa'); ?>>Punjabi</option>
                <option value="ro" <?php selected($saved_language, 'ro'); ?>>Romanian</option>
                <option value="ru" <?php selected($saved_language, 'ru'); ?>>Russian</option>
                <option value="sm" <?php selected($saved_language, 'sm'); ?>>Samoan</option>
                <option value="gd" <?php selected($saved_language, 'gd'); ?>>Scots Gaelic</option>
                <option value="sr" <?php selected($saved_language, 'sr'); ?>>Serbian</option>
                <option value="st" <?php selected($saved_language, 'st'); ?>>Sesotho</option>
                <option value="sn" <?php selected($saved_language, 'sn'); ?>>Shona</option>
                <option value="sd" <?php selected($saved_language, 'sd'); ?>>Sindhi</option>
                <option value="si" <?php selected($saved_language, 'si'); ?>>Sinhala</option>
                <option value="sk" <?php selected($saved_language, 'sk'); ?>>Slovak</option>
                <option value="sl" <?php selected($saved_language, 'sl'); ?>>Slovenian</option>
                <option value="so" <?php selected($saved_language, 'so'); ?>>Somali</option>
                <option value="es" <?php selected($saved_language, 'es'); ?>>Spanish</option>
                <option value="su" <?php selected($saved_language, 'su'); ?>>Sundanese</option>
                <option value="sw" <?php selected($saved_language, 'sw'); ?>>Swahili</option>
                <option value="sv" <?php selected($saved_language, 'sv'); ?>>Swedish</option>
                <option value="tg" <?php selected($saved_language, 'tg'); ?>>Tajik</option>
                <option value="ta" <?php selected($saved_language, 'ta'); ?>>Tamil</option>
                <option value="tt" <?php selected($saved_language, 'tt'); ?>>Tatar</option>
                <option value="te" <?php selected($saved_language, 'te'); ?>>Telugu</option>
                <option value="th" <?php selected($saved_language, 'th'); ?>>Thai</option>
                <option value="tr" <?php selected($saved_language, 'tr'); ?>>Turkish</option>
                <option value="tk" <?php selected($saved_language, 'tk'); ?>>Turkmen</option>
                <option value="uk" <?php selected($saved_language, 'uk'); ?>>Ukrainian</option>
                <option value="ur" <?php selected($saved_language, 'ur'); ?>>Urdu</option>
                <option value="ug" <?php selected($saved_language, 'ug'); ?>>Uyghur</option>
                <option value="uz" <?php selected($saved_language, 'uz'); ?>>Uzbek</option>
                <option value="vi" <?php selected($saved_language, 'vi'); ?>>Vietnamese</option>
                <option value="cy" <?php selected($saved_language, 'cy'); ?>>Welsh</option>
                <option value="xh" <?php selected($saved_language, 'xh'); ?>>Xhosa</option>
                <option value="yi" <?php selected($saved_language, 'yi'); ?>>Yiddish</option>
                <option value="yo" <?php selected($saved_language, 'yo'); ?>>Yoruba</option>
                <option value="zu" <?php selected($saved_language, 'zu'); ?>>Zulu</option>
            </select>
 

          </p>

          <h2>Shortcode</h2>
          <p>Use the following shortcode to display the verse of the day widget:</p>
          <input type="text" id="votd_shortcode" value="[votd_verse_of_the_day_widget_for_wp]" readonly />
          <button class="button" onclick="votdcopyShortcode(event)">Copy Shortcode</button>
      </form>
  </div>

  <?php
}



// Widget Class
class Verse_Of_The_Day_Widget_For_WP extends WP_Widget {

    // Constructor
    public function __construct() {
        parent::__construct(
            'verse_of_the_day_widget_for_wp', // Base ID
            'Verse of the Day Widget', // Name
            array( 'description' => __( 'A Widget to Display Verse of the Day', 'text_domain' ) ) // Args
        );
    }

    // Front-end display of widget
    public function widget( $args, $instance ) {
        echo $args['before_widget'];
        votd_display_verse_widget($args, $instance); // Call the widget display function
        echo $args['after_widget'];
    }

    // Back-end widget form (optional)
    public function form( $instance ) {
        // Admin form for customizing widget options (if needed)
    }

    // Updating widget (optional)
    public function update( $new_instance, $old_instance ) {
        $instance = array();
        return $instance; // Update widget options
    }
}

// Register the widget
function register_verse_widget() {
   register_widget( 'Verse_Of_The_Day_Widget_For_WP' );
}
add_action( 'widgets_init', 'register_verse_widget' );

function votd_register_settings() {
    register_setting('votd_settings_group', 'votd_location');
    register_setting('votd_settings_group', 'votd_language');
}
add_action('admin_init', 'votd_register_settings');


$sidebar_widgets = wp_get_sidebars_widgets();

// Debugging: Print out all the active widgets
// echo "<script>console.log(" . json_encode($sidebar_widgets) . ");</script>" ; 



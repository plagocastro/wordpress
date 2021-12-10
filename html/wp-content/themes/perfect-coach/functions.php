<?php
// Exit if accessed directly
if (!defined('ABSPATH')) exit;

/**
 * After setup theme hook
 */
function perfect_coach_theme_setup(){
    /*
     * Make child theme available for translation.
     * Translations can be filed in the /languages/ directory.
     */
    load_child_theme_textdomain('perfect-coach', get_stylesheet_directory() . '/languages');
}
add_action('after_setup_theme', 'perfect_coach_theme_setup', 100);

function perfect_coach_customize_script(){

    $my_theme = wp_get_theme();
    $version = $my_theme['Version'];
    wp_enqueue_script('perfect-coach-customize', get_stylesheet_directory_uri() . '/js/child-customize.js', array('jquery', 'customize-controls'), $version, true);

}
add_action('customize_controls_enqueue_scripts', 'perfect_coach_customize_script');

/**
 * Load assets.
 */
function perfect_coach_enqueue_styles(){
    $my_theme = wp_get_theme();
    $version = $my_theme['Version'];

    wp_enqueue_style( 'blossom-coach', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'perfect-coach', get_stylesheet_directory_uri() . '/style.css', array('blossom-coach'), $version );
}
add_action('wp_enqueue_scripts', 'perfect_coach_enqueue_styles', 10);

function feminine_fashion_remove_parent_filters()
{
    remove_action('wp_head', 'blossom_coach_dynamic_css', 99);
}
add_action('init', 'feminine_fashion_remove_parent_filters');

/**
 * Layout Settings
 */
function perfect_coach_customizer_register($wp_customize){

    $wp_customize->add_section( 'theme_info', array(
		'title'       => __( 'Demo & Documentation' , 'perfect-coach' ),
		'priority'    => 6,
	) );
    
    /** Important Links */
	$wp_customize->add_setting( 'theme_info_theme',
        array(
            'default' => '',
            'sanitize_callback' => 'wp_kses_post',
        )
    );
    
    $theme_info = '<p>';
	$theme_info .= sprintf( __( 'Demo Link: %1$sClick here.%2$s', 'perfect-coach' ),  '<a href="' . esc_url( 'https://blossomthemes.com/theme-demo/?theme=perfect-coach' ) . '" target="_blank">', '</a>' );
    $theme_info .= '</p><p>';
    $theme_info .= sprintf( __( 'Documentation Link: %1$sClick here.%2$s', 'perfect-coach' ),  '<a href="' . esc_url( 'https://docs.blossomthemes.com/perfect-coach/' ) . '" target="_blank">', '</a>' );
    $theme_info .= '</p>';

	$wp_customize->add_control( new Blossom_Coach_Note_Control( $wp_customize,
        'theme_info_theme', 
            array(
                'section'     => 'theme_info',
                'description' => $theme_info
            )
        )
    );

    /** Header Layout Settings */
    $wp_customize->add_section(
        'header_layout_section',
        array(
            'priority' => 5,
            'title' => __('Header Layout', 'perfect-coach'),
            'panel' => 'layout_settings',
        )
    );

    $wp_customize->add_setting(
        'header_menu_layout',
        array(
            'default' => 'nine',
            'sanitize_callback' => 'blossom_coach_sanitize_radio'
        )
    );

    $wp_customize->add_control(
        new Blossom_Coach_Radio_Image_Control(
            $wp_customize,
            'header_menu_layout',
            array(
                'section' => 'header_layout_section',
                'label' => __('Header Layout', 'perfect-coach'),
                'description' => __('Choose the layout of the header for your site.', 'perfect-coach'),
                'choices' => array(
                    'one'  => get_stylesheet_directory_uri() . '/images/header/one.png',
                    'nine' => get_stylesheet_directory_uri() . '/images/header/nine.png',
                )
            )
        )
    );

    $wp_customize->add_setting(
        'header_settings_text',
        array(
            'default' => '',
            'sanitize_callback' => 'wp_kses_post'
        )
    );

    $wp_customize->add_control(
        new Blossom_Coach_Note_Control(
            $wp_customize,
            'header_settings_text',
            array(
                'section'       => 'header_layout_section',
                'description'   => sprintf(__('%1$sClick here%2$s to configure header layout settings', 'perfect-coach'), '<span class="text-inner-link header_settings_text">', '</span>'),
            )
        )
    );

    /** Banner Options */
    $wp_customize->add_setting(
        'ed_banner_section',
        array(
            'default'           => 'static_banner',
            'sanitize_callback' => 'blossom_coach_sanitize_select'
        )
    );

    $wp_customize->add_control(
        new Blossom_Coach_Select_Control(
            $wp_customize,
            'ed_banner_section',
            array(
                'label'         => __('Banner Options', 'perfect-coach'),
                'description'   => __('Choose banner as static image/video or as a slider.', 'perfect-coach'),
                'section'       => 'header_image',
                'choices'       => array(
                    'no_banner'         => __('Disable Banner Section', 'perfect-coach'),
                    'static_banner'     => __('Static/Video CTA Banner', 'perfect-coach'),
                    'static_nl_banner'  => __('Static/Video Newsletter Banner', 'perfect-coach'),
                    'slider_banner'     => __('Banner as Slider', 'perfect-coach'),
                ),
                'priority' => 5
            )
        )
    );

    /** Typography */
    $wp_customize->add_section(
        'typography_settings',
        array(
            'title'      => __('Typography', 'perfect-coach'),
            'priority'   => 20,
            'panel'      => 'appearance_settings',
        )
    );

    /** Secondary Font */
    $wp_customize->add_setting(
        'secondary_font',
        array(
            'default'           => 'DM Sans',
            'sanitize_callback' => 'blossom_coach_sanitize_select'
        )
    );

    $wp_customize->add_control(
        new Blossom_Coach_Select_Control(
            $wp_customize,
            'secondary_font',
            array(
                'label'         => __('Secondary Font', 'perfect-coach'),
                'description'   => __('Secondary font of the site.', 'perfect-coach'),
                'section'       => 'typography_settings',
                'choices'       => blossom_coach_get_all_fonts(),
            )
        )
    );

    /** Move Background Image section to appearance panel */
    $wp_customize->get_section('colors')->panel = 'appearance_settings';
    $wp_customize->get_section('colors')->priority = 10;
    $wp_customize->get_section('background_image')->panel = 'appearance_settings';
    $wp_customize->get_section('background_image')->priority = 15;

    $wp_customize->add_setting(
        'header_getting_started_button',
        array(
            'default' => '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport' => 'postMessage'
        )
    );

    $wp_customize->add_control(
        'header_getting_started_button',
        array(
            'label' => __('Header Getting Started Button', 'perfect-coach'),
            'description' => __('This button shows only second header layout', 'perfect-coach'),
            'section' => 'header_settings',
            'type' => 'text',
            'active_callback' => 'perfect_coach_get_contact_ac',
        )
    );

    $wp_customize->selective_refresh->add_partial('header_getting_started_button', array(
        'selector' => '.site-header .button-wrap .btn-1',
        'render_callback' => 'perfect_coach_get_getting_started_button',
    ));

    $wp_customize->add_setting(
        'header_getting_started_url',
        array(
            'default' => '',
            'sanitize_callback' => 'esc_url_raw',
        )
    );

    $wp_customize->add_control(
        'header_getting_started_url',
        array(
            'label' => __('Header Getting Started Link', 'perfect-coach'),
            'section' => 'header_settings',
            'type' => 'url',
            'active_callback' => 'perfect_coach_get_contact_ac',
        )
    );

    $wp_customize->add_setting(
        'header_layout_text',
        array(
            'default' => '',
            'sanitize_callback' => 'wp_kses_post'
        )
    );

    $wp_customize->add_control(
        new Blossom_Coach_Note_Control(
            $wp_customize,
            'header_layout_text',
            array(
                'section' => 'header_settings',
                'description' => sprintf(__('%1$sClick here%2$s to configure header layout settings', 'perfect-coach'), '<span class="text-inner-link header_layout_text">', '</span>'),
            )
        )
    );

    /** Subtitle */
    $wp_customize->add_setting(
        'banner_subtitle',
        array(
            'default' => '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport' => 'postMessage'
        )
    );

    $wp_customize->add_control(
        'banner_subtitle',
        array(
            'label' => __('Subtitle', 'perfect-coach'),
            'section' => 'header_image',
            'type' => 'text',
            'active_callback' => 'blossom_coach_banner_ac',

        )
    );

    $wp_customize->selective_refresh->add_partial('banner_subtitle', array(
        'selector' => '.site-banner .banner-caption .banner-wrap .subtitle',
        'render_callback' => 'perfect_coach_get_banner_subtitle',
    ));

    /** Title */
    $wp_customize->add_setting(
        'banner_title',
        array(
            'default' => '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport' => 'postMessage'
        )
    );

    $wp_customize->add_control(
        'banner_title',
        array(
            'label' => __('Title', 'perfect-coach'),
            'section' => 'header_image',
            'type' => 'text',
            'active_callback' => 'blossom_coach_banner_ac',
        )
    );

    $wp_customize->selective_refresh->add_partial('banner_title', array(
        'selector' => '.site-banner .banner-caption .banner-wrap .banner-title',
        'render_callback' => 'perfect_coach_get_banner_title',
    ));

    /** Content */
    $wp_customize->add_setting(
        'banner_text',
        array(
            'default' => '',
            'sanitize_callback' => 'wp_kses_post',
            'transport' => 'postMessage'
        )
    );

    $wp_customize->add_control(
        'banner_text',
        array(
            'label' => __('Description', 'perfect-coach'),
            'section' => 'header_image',
            'type' => 'textarea',
            'active_callback' => 'blossom_coach_banner_ac',
        )
    );

    $wp_customize->selective_refresh->add_partial('banner_text', array(
        'selector' => '.site-banner .banner-caption .banner-wrap .b-content',
        'render_callback' => 'perfect_coach_get_banner_text',
    ));

    /** Banner Label */
    $wp_customize->add_setting(
        'banner_label',
        array(
            'default' => '',
            'sanitize_callback' => 'sanitize_text_field',
            'transport' => 'postMessage'
        )
    );

    $wp_customize->add_control(
        'banner_label',
        array(
            'label' => __('Banner Button Label', 'perfect-coach'),
            'section' => 'header_image',
            'type' => 'text',
            'active_callback' => 'blossom_coach_banner_ac',
        )
    );

    $wp_customize->selective_refresh->add_partial('banner_label', array(
        'selector' => '.site-banner .banner-caption .banner-wrap .banner-link',
        'render_callback' => 'perfect_coach_get_banner_label',
    ));

    /** Banner Link */
    $wp_customize->add_setting(
        'banner_link',
        array(
            'default' => '',
            'sanitize_callback' => 'esc_url_raw',
        )
    );

    $wp_customize->add_control(
        'banner_link',
        array(
            'label' => __('Button Link', 'perfect-coach'),
            'section' => 'header_image',
            'type' => 'text',
            'active_callback' => 'blossom_coach_banner_ac',
        )
    );

    $wp_customize->add_setting(
        'banner_link_new_tab',
        array(
            'default' => false,
            'sanitize_callback' => 'blossom_coach_sanitize_checkbox',
        )
    );

    $wp_customize->add_control(
        new Blossom_Coach_Toggle_Control(
            $wp_customize,
            'banner_link_new_tab',
            array(
                'section' => 'header_image',
                'label' => __('Open Banner link in new tab', 'perfect-coach'),
                'description' => __('Enable to open  banner link in new tab.', 'perfect-coach'),
                'active_callback' => 'blossom_coach_banner_ac',
            )
        )
    );

}
add_action('customize_register', 'perfect_coach_customizer_register', 40);

/**
 * Partial Refresh for child theme
 */
if (!function_exists('perfect_coach_get_getting_started_button')) :
/**
 * Get Banner Button label
 */
function perfect_coach_get_getting_started_button()
{
    return esc_html(get_theme_mod('header_getting_started_button'));
}
endif;

if (!function_exists('perfect_coach_get_banner_title')) :
/**
 * Get Banner Title
 */
function perfect_coach_get_banner_title()
{
    return esc_html(get_theme_mod('banner_title'));
}
endif;

if (!function_exists('perfect_coach_get_banner_subtitle')) :
/**
 * Get Banner subtitle
 */
function perfect_coach_get_banner_subtitle()
{
    return esc_html(get_theme_mod('banner_subtitle'));
}
endif;

if (!function_exists('perfect_coach_get_banner_text')) :
/**
 * Get Banner Content
 */
function perfect_coach_get_banner_text()
{
    return esc_html(get_theme_mod('banner_text'));
}
endif;

if (!function_exists('perfect_coach_get_banner_label')) :
/**
 * Get Banner Button Label
 */
function perfect_coach_get_banner_label()
{
    return esc_html(get_theme_mod('banner_label'));
}
endif;

if (!function_exists('perfect_coach_get_contact_ac')) :
/**
 * Active Callback for Header
 */
function perfect_coach_get_contact_ac($control)
{
    $header = $control->manager->get_setting('header_menu_layout')->value();
    $control_id = $control->id;

    if ($control_id == 'header_getting_started_button' && $header == 'nine') return true;
    if ($control_id == 'header_getting_started_url' && $header == 'nine') return true;

    return false;
}
endif;

if (!function_exists('blossom_coach_banner_ac')) :
/**
 * Active Callback for Banner
 */
function blossom_coach_banner_ac($control)
{
    $banner = $control->manager->get_setting('ed_banner_section')->value();
    $slider_type = $control->manager->get_setting('slider_type')->value();
    $control_id = $control->id;

    if ($control_id == 'header_image' && ($banner == 'static_nl_banner' || $banner == 'static_banner')) return true;
    if ($control_id == 'header_video' && ($banner == 'static_nl_banner' || $banner == 'static_banner')) return true;
    if ($control_id == 'external_header_video' && ($banner == 'static_nl_banner' || $banner == 'static_banner')) return true;
    if ($control_id == 'banner_newsletter' && $banner == 'static_nl_banner') return true;

    if ($control_id == 'slider_type' && $banner == 'slider_banner') return true;
    if ($control_id == 'slider_animation' && $banner == 'slider_banner') return true;

    if ($control_id == 'slider_cat' && $banner == 'slider_banner' && $slider_type == 'cat') return true;
    if ($control_id == 'no_of_slides' && $banner == 'slider_banner' && $slider_type == 'latest_posts') return true;

    if ($control_id == 'banner_title' && $banner == 'static_banner') return true;
    if ($control_id == 'banner_subtitle' && $banner == 'static_banner') return true;
    if ($control_id == 'banner_text' && $banner == 'static_banner') return true;
    if ($control_id == 'banner_label' && $banner == 'static_banner') return true;
    if ($control_id == 'banner_link' && $banner == 'static_banner') return true;
    if ($control_id == 'banner_link_new_tab' && $banner == 'static_banner') return true;

    return false;
}
endif;

/**
 * header search
 */
function perfect_coach_header_search()
{ ?>
    <div class="header-search">
        <button aria-label="<?php esc_attr_e('search form toggle', 'perfect-coach'); ?>" data-toggle-target=".search-modal" data-toggle-body-class="showing-search-modal" data-set-focus=".search-modal .search-field" aria-expanded="false">
            <i class="fa fa-search"></i>
        </button>
        <div class="header-search-form search-modal cover-modal" data-modal-target-string=".search-modal">
            <div class="header-search-inner-wrap">
                <?php get_search_form(); ?>
                <button aria-label="<?php esc_attr_e('search form close', 'perfect-coach'); ?>" class="close" data-toggle-target=".search-modal" data-toggle-body-class="showing-search-modal" data-set-focus=".search-modal .search-field" aria-expanded="false"></button>
            </div>
        </div>
    </div>
<?php 
}

/**
 * Site Branding
 */
function perfect_coach_site_branding()
{
    $site_title         = get_bloginfo('name');
    $site_description   = get_bloginfo('description', 'display');
    $header_text        = get_theme_mod('header_text', 1);

    if (has_custom_logo() && ($site_title || $site_description) && $header_text) {
        $branding_class = ' icon-text';
    } else {
        $branding_class = '';
    }
    if (has_custom_logo() || $site_title || $site_description || $header_text) : ?>
        <div class="site-branding<?php echo esc_attr($branding_class); ?>" itemscope itemtype="http://schema.org/Organization">
            <?php 
            if (has_custom_logo()) {
                echo '<div class="site-logo">';
                the_custom_logo();
                echo '</div><!-- .site-logo -->';
            }
            ?>
            <?php if ($site_title || $site_description) :
                if ($branding_class) echo '<div class="site-title-wrap">';
            if (is_front_page()) : ?>
                    <h1 class="site-title" itemprop="name"><a href="<?php echo esc_url(home_url('/')); ?>" rel="home" itemprop="url"><?php bloginfo('name'); ?></a></h1>
                <?php else : ?>
                    <p class="site-title" itemprop="name"><a href="<?php echo esc_url(home_url('/')); ?>" rel="home" itemprop="url"><?php bloginfo('name'); ?></a></p>
                <?php endif;
                $description = get_bloginfo('description', 'display');
                if ($description || is_customize_preview()) { ?>
                    <p class="site-description"><?php echo esc_html($description); ?></p>
                <?php

            }
            if ($branding_class) echo '</div>';
            endif; ?>
        </div><!-- .site-branding -->
    <?php endif;
}

/**
 * Getting Started Button 
 */
function perfect_coach_getting_started_button()
{
    $header_getting_started_button = get_theme_mod('header_getting_started_button');
    $header_getting_started_url = get_theme_mod('header_getting_started_url');
    if ($header_getting_started_button && $header_getting_started_url) : ?>
        <div class="button-wrap">
            <a href="<?php echo esc_url($header_getting_started_url); ?>" class="btn-cta btn-1"><?php echo esc_html($header_getting_started_button); ?></a>
        </div>
    <?php
    endif;
}

/**
 * Site Navigation
 */
function perfect_coach_site_navigation()
{ ?>
    <nav id="site-navigation" class="main-navigation" itemscope itemtype="http://schema.org/SiteNavigationElement">
        <button type="button" class="toggle-button" data-toggle-target=".main-menu-modal" data-toggle-body-class="showing-main-menu-modal" aria-expanded="false" data-set-focus=".close-main-nav-toggle" aria-label="<?php esc_attr_e('Mobile Navigation', 'perfect-coach'); ?>">
            <span class="toggle-bar"></span>
            <span class="toggle-bar"></span>
            <span class="toggle-bar"></span>
        </button>
        <div class="primary-menu-list main-menu-modal cover-modal" data-modal-target-string=".main-menu-modal">
            <button class="close close-main-nav-toggle" data-toggle-target=".main-menu-modal" data-toggle-body-class="showing-main-menu-modal" aria-expanded="false" data-set-focus=".main-menu-modal" aria-label="<?php esc_attr_e('Mobile Navigation', 'perfect-coach'); ?>"><span></span></button>
            <div class="mobile-menu" aria-label="<?php esc_attr_e('Mobile', 'perfect-coach'); ?>">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'menu_id' => 'primary-menu',
                    'menu_class' => 'menu main-menu-modal',
                    'fallback_cb' => 'blossom_coach_primary_menu_fallback',
                ));
                ?>
            </div>
        </div>
    </nav><!-- #site-navigation -->					
<?php 
}

/**
 * Header Contact
 */
function perfect_coach_header_contact()
{
    $phone = get_theme_mod('phone');
    $email = get_theme_mod('email');

    if ($phone || $email) {
        echo '<div class="top-left">';
        if ($phone) echo '<span><i class="fa fa-phone"></i><a href="tel:' . preg_replace('/[^\d+]/', '', $phone) . '"><span class="phone">' . esc_html($phone) . '</span></a></span>';
        if ($email) echo '<span><i class="fa fa-envelope"></i><a href="' . esc_url('mailto:' . sanitize_email($email)) . '"><span class="email">' . esc_html($email) . '</span></a></span>';
        echo '</div><!-- .top-left -->';
    }
}

/**
 * Header Start
 */
function blossom_coach_header()
{
    $header_layout  = get_theme_mod('header_menu_layout', 'nine');
    $ed_cart        = get_theme_mod('ed_shopping_cart', true);
    $ed_search      = get_theme_mod('ed_header_search', false);
    $phone          = get_theme_mod('phone');
    $email          = get_theme_mod('email');

    if ($header_layout == 'one') { ?>
        <header id="masthead" class="site-header header-lay1" itemscope itemtype="http://schema.org/WPHeader">		
            <?php if ( blossom_coach_social_links(false) || $ed_search || $phone || $email ) { ?>
            <div class="header-t">
                <div class="wrapper">
                    <?php 
                    perfect_coach_header_contact();
                    if (blossom_coach_social_links(false) || $ed_search) {
                        echo '<div class="top-right">';
                        if (blossom_coach_social_links(false)) {
                            echo '<div class="header-social">';
                            blossom_coach_social_links();
                            echo '</div><!-- .header-social -->';
                        }
                        if ($ed_search) perfect_coach_header_search();
                        echo '</div><!-- .top-right -->';
                    }
                    ?>
                </div><!-- .wrapper -->            				 
            </div><!-- .header-t -->
            <?php 
        } ?>
            <div class="main-header">
                <div class="wrapper">
                    <?php perfect_coach_site_branding(); ?>
                    <div class="menu-wrap">
                        <?php 
                        perfect_coach_site_navigation();
                        if (blossom_coach_is_woocommerce_activated() && $ed_cart) blossom_coach_wc_cart_count();
                        ?>
                    </div>
                </div><!-- .wrapper -->
            </div><!-- .main-header -->				
        </header><!-- .site-header -->
    <?php 
} elseif ($header_layout == 'nine') { ?>
        <header id="masthead" class="site-header header-lay9" itemscope itemtype="http://schema.org/WPHeader">
            <?php if( blossom_coach_social_links(false) || $ed_search || $phone || $email || ( blossom_coach_is_woocommerce_activated() && $ed_cart ) ) { ?>
                <div class="header-t desktop">
                    <div class="wrapper">
                        <?php 
                        if (blossom_coach_social_links(false)) {
                            echo '<div class="header-social">';
                            blossom_coach_social_links();
                            echo '</div><!-- .header-social -->';
                        }
                        perfect_coach_header_contact(); ?>
                        <div class="top-right">
                            <?php 
                            if ($ed_search) perfect_coach_header_search();
                            if (blossom_coach_is_woocommerce_activated() && $ed_cart) blossom_coach_wc_cart_count();
                            ?>
                        </div>
                    </div>
                </div> <!-- .header-t -->
            <?php } ?>
            <div class="main-header desktop">
                <?php perfect_coach_site_branding(); ?>
                <div class="wrapper">
                    <div class="menu-wrap">
                        <?php 
                        perfect_coach_site_navigation();
                        perfect_coach_getting_started_button();
                        ?>
                    </div>
                </div>
            </div><!-- .main-header -->              
        </header><!-- .site-header -->
    <?php 
}
}

/**
 * Footer Bottom
 */
function blossom_coach_footer_bottom()
{ ?>
    <div class="bottom-footer">
		<div class="wrapper">
			<div class="copyright">            
            <?php
            blossom_coach_get_footer_copyright();
            echo esc_html__(' Perfect Coach | Developed By ', 'perfect-coach');
            echo '<a href="' . esc_url('https://blossomthemes.com/') . '" rel="nofollow" target="_blank">' . esc_html__('Blossom Themes', 'perfect-coach') . '</a>.';
            printf(esc_html__(' Powered by %s', 'perfect-coach'), '<a href="' . esc_url(__('https://wordpress.org/', 'perfect-coach')) . '" target="_blank">WordPress</a>.');
            if (function_exists('the_privacy_policy_link')) {
                the_privacy_policy_link();
            }
            ?>               
            </div>
		</div><!-- .wrapper -->
	</div><!-- .bottom-footer -->
    <?php

}

function blossom_coach_fonts_url(){
    $fonts_url = '';
    
    $primary_font       = get_theme_mod( 'primary_font', 'Nunito Sans' );
    $ig_primary_font    = blossom_coach_is_google_font( $primary_font );    
    $secondary_font     = get_theme_mod( 'secondary_font', 'DM Sans' );
    $ig_secondary_font  = blossom_coach_is_google_font( $secondary_font );    
    $site_title_font    = get_theme_mod( 'site_title_font', array( 'font-family'=>'Nunito', 'variant'=>'700' ) );
    $ig_site_title_font = blossom_coach_is_google_font( $site_title_font['font-family'] );
        
    /* Translators: If there are characters in your language that are not
    * supported by respective fonts, translate this to 'off'. Do not translate
    * into your own language.
    */
    $primary    = _x( 'on', 'Primary Font: on or off', 'perfect-coach' );
    $secondary  = _x( 'on', 'Secondary Font: on or off', 'perfect-coach' );
    $site_title = _x( 'on', 'Site Title Font: on or off', 'perfect-coach' );
    
    if ( 'off' !== $primary || 'off' !== $secondary || 'off' !== $site_title ) {
        
        $font_families = array();
     
        if ( 'off' !== $primary && $ig_primary_font ) {
            $primary_variant = blossom_coach_check_varient( $primary_font, 'regular', true );
            if( $primary_variant ){
                $primary_var = ':' . $primary_variant;
            }else{
                $primary_var = '';    
            }            
            $font_families[] = $primary_font . $primary_var;
        }
         
        if ( 'off' !== $secondary && $ig_secondary_font ) {
            $secondary_variant = blossom_coach_check_varient( $secondary_font, 'regular', true );
            if( $secondary_variant ){
                $secondary_var = ':' . $secondary_variant;    
            }else{
                $secondary_var = '';
            }
            $font_families[] = $secondary_font . $secondary_var;
        }
        
        if ( 'off' !== $site_title && $ig_site_title_font ) {
            
            if( ! empty( $site_title_font['variant'] ) ){
                $site_title_var = ':' . blossom_coach_check_varient( $site_title_font['font-family'], $site_title_font['variant'] );    
            }else{
                $site_title_var = '';
            }
            $font_families[] = $site_title_font['font-family'] . $site_title_var;
        }
        
        $font_families = array_diff( array_unique( $font_families ), array('') );
        
        $query_args = array(
            'family' => urlencode( implode( '|', $font_families ) ),            
        );
        
        $fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
    }
     
    return esc_url_raw( $fonts_url );
}

function perfect_coach_dynamic_css()
{

    $primary_font = get_theme_mod('primary_font', 'Nunito Sans');
    $primary_fonts = blossom_coach_get_fonts($primary_font, 'regular');
    $secondary_font = get_theme_mod('secondary_font', 'DM Sans');
    $secondary_fonts = blossom_coach_get_fonts($secondary_font, 'regular');

    $site_title_font = get_theme_mod('site_title_font', array('font-family' => 'Nunito', 'variant' => '700'));
    $site_title_fonts = blossom_coach_get_fonts($site_title_font['font-family'], $site_title_font['variant']);
    $site_title_font_size = get_theme_mod('site_title_font_size', 45);

    $custom_css = '';
    $custom_css .= '
    
    :root {
        --primary-font: ' . esc_html( $primary_fonts['font'] ) . ';
        --secondary-font: ' . esc_html( $secondary_fonts['font'] ) . ';
    }
    
    .site-title, 
    .site-title-wrap .site-title{
        font-size   : ' . absint($site_title_font_size) . 'px;
        font-family : ' . esc_html($site_title_fonts['font']) . ';
        font-weight : ' . esc_html($site_title_fonts['weight']) . ';
        font-style  : ' . esc_html($site_title_fonts['style']) . ';
    }';

    wp_add_inline_style('perfect-coach', $custom_css);
}
add_action('wp_enqueue_scripts', 'perfect_coach_dynamic_css', 99);

/**
 * convert hex to rgb
 * @link http://bavotasan.com/2011/convert-hex-color-to-rgb-using-php/
 */
function blossom_coach_hex2rgb($hex)
{
    $hex = str_replace("#", "", $hex);

    if (strlen($hex) == 3) {
        $r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
        $g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
        $b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
    } else {
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));
    }
    $rgb = array($r, $g, $b);
   //return implode(",", $rgb); // returns the rgb values separated by commas
    return $rgb; // returns an array with the rgb values
}

/**
 * Function for sanitizing Hex color 
 */
function blossom_coach_sanitize_hex_color($color)
{
    if ('' === $color)
        return '';

    // 3 or 6 hex digits, or the empty string.
    if (preg_match('|^#([A-Fa-f0-9]{3}){1,2}$|', $color)) {
        return $color;
    } elseif (is_string($color)) {
        if (strpos($color, 'rgba') !== false) {
            return $color;
        }
    }
}

/**
 * Returns Home Sections 
 */
function blossom_coach_get_home_sections()
{
    $ed_banner = get_theme_mod('ed_banner_section', 'slider_banner');
    $sections = array(
        'client' => array('sidebar' => 'client'),
        'about' => array('sidebar' => 'about'),
        'cta' => array('sidebar' => 'cta'),
        'testimonial' => array('sidebar' => 'testimonial'),
        'service' => array('sidebar' => 'service'),
        'blog' => array('section' => 'blog'),
        'simple-cta' => array('sidebar' => 'simple-cta'),
        'contact' => array('sidebar' => 'contact'),
    );

    $enabled_section = array();

    if ($ed_banner == 'static_nl_banner' || $ed_banner == 'slider_banner' || $ed_banner == 'static_banner') array_push($enabled_section, 'banner');

    foreach ($sections as $k => $v) {
        if (array_key_exists('sidebar', $v)) {
            if (is_active_sidebar($v['sidebar'])) array_push($enabled_section, $v['sidebar']);
        } else {
            if (get_theme_mod('ed_' . $v['section'] . '_section', true)) array_push($enabled_section, $v['section']);
        }
    }

    return apply_filters('blossom_coach_home_sections', $enabled_section);
}
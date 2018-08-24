<?php
/**
 * Functions for adding a top-level menu to the WordPress Dashboard,
 * and controls the order of the top level menus.
 *
 * @package      WordPress
 * @subpackage   ASD_Admin
 * Author:       Michael H Fahey
 * Author URI:   https://artisansitedesigns.com/staff/michael-h-fahey
 * Version:      1.201808211
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '' );
}

$this_asd_admin_menu_version = 1.201808211;


if ( ! function_exists( 'unhook_asd_admin_functions_1_201808211' ) ) {
	/** ----------------------------------------------------------------------------
	 *   function unhook_asd_admin_functions_1_201808211()
	 *   if a newer version of asd-admin-menu is detected, this function
	 *   is called to unhook the old version from filters
	 *  ----------------------------------------------------------------------------
	 */
	function unhook_asd_admin_functions_1_201808211() {
		global $asd_admin_menu_version;
		$underscore_asd_admin_menu_version = str_replace( '.', '_', $asd_admin_menu_version );
			remove_action( 'admin_menu', 'asd_admin_menu_' . $underscore_asd_admin_menu_version, 11 );
			remove_action( 'admin_menu', 'asd_category_admin_submenu_' . $underscore_asd_admin_menu_version, 16 );
			remove_filter( 'custom_menu_order', 'asd_custom_menu_order_' . $underscore_asd_admin_menu_version, 12 );
			remove_filter( 'menu_order', 'asd_custom_menu_order_' . $underscore_asd_admin_menu_version, 12 );
	}
}

if ( ! function_exists( 'setup_asd_admin_functions_1_201808211' ) ) {
	/** ----------------------------------------------------------------------------
	 *   function setup_asd_admin_functions_1_201808211()
	 *   groups the functions and their filter hook calls
	 *  --------------------------------------------------------------------------*/
	function setup_asd_admin_functions_1_201808211() {

		if ( ! function_exists( 'asd_admin_menu_1_201808211' ) ) {
			/** ----------------------------------------------------------------------------
			 *   function asd_admin_menu_1_201808211()
			 *   Adds the top-level menu, named Artisan Site Designs
			 *   hooks into the admin_menu action
			 *  --------------------------------------------------------------------------*/
			function asd_admin_menu_1_201808211() {
				add_menu_page(
					'Artisan Site Designs',
					'Artisan Site Designs',
					'manage_options',
					'asd_settings',
					'asd_admin_menu_settings_1_201808211',
					'dashicons-admin-generic',
					'2'
				);
			}
			if ( is_admin() ) {
				add_action( 'admin_menu', 'asd_admin_menu_1_201808211', 11 );
			}
		}

		if ( ! function_exists( 'asd_admin_menu_settings_1_201808211' ) ) {
			/** ----------------------------------------------------------------------------
			 *   function asd_admin_menu_settings()
			 *   Adds a little text to the top-level menu, a little plug.
			 *   This function is a callback in asd_admin_menu()
			 *  --------------------------------------------------------------------------*/
			function asd_admin_menu_settings_1_201808211() {

				echo '<a target="_blank" href="https://artisansitedesigns.com"><h1>Artisan Site Designs</h1></a>';

				info_on_published_plugins_1_201808211();

				echo '<br><br><h5>Library and Version Info:</h5>' . "\r\n";

				global $asd_admin_menu_version;
				echo 'ASD Admin Menu Version = ';
				if ( isset( $asd_admin_menu_version ) ) {
					echo esc_attr( $asd_admin_menu_version ) . "<br>\r\n";
				} else {
					echo "unset<br>\r\n";
				}

				global $asd_register_site_data_version;
				echo 'ASD Register Site Data Version = ';
				if ( isset( $asd_register_site_data_version ) ) {
					echo esc_attr( $asd_register_site_data_version ) . "<br>\r\n";
				} else {
					echo "unset<br>\r\n";
				}

				global $asd_custom_post_version;
				echo 'ASD Parent Custom Post Class Version = ';
				if ( isset( $asd_custom_post_version ) ) {
					echo esc_attr( $asd_custom_post_version ) . "<br>\r\n";
				} else {
					echo "unset<br>\r\n";
				}

				global $asd_addcustom_post_version;
				echo 'ASD Add Custom Post Class Version = ';
				if ( isset( $asd_addcustom_post_version ) ) {
					echo esc_attr( $asd_addcustom_post_version ) . "<br>\r\n";
				} else {
					echo "unset<br>\r\n";
				}

			}
		}

		if ( ! function_exists( 'asd_custom_menu_order_1_201808211' ) ) {
			/** ----------------------------------------------------------------------------
			 *   function asd_custom_menu_order( $menu_ord )
			 *   Sets order of top-level menus
			 *   Hooks into the custom_menu_order and menu_order filters
			 *   returns an array list of links to admin pages
			 *  ----------------------------------------------------------------------------
			 *
			 *   @param Array $menu_ord -  if this is not defined the function returns true.
			 */
			function asd_custom_menu_order_1_201808211( $menu_ord ) {
				if ( ! $menu_ord ) {
					return true;
				}

				$asd_menu_entries = array();

				$asd_menu_entries[] = 'index.php';
				$asd_menu_entries[] = 'admin.php?page=asd_settings';
				$asd_menu_entries[] = 'edit.php?post_type=page';
				$asd_menu_entries[] = 'upload.php';
				$asd_menu_entries[] = 'edit.php';
				$asd_menu_entries[] = 'link-manager.php';
				$asd_menu_entries[] = 'edit-comments.php';
				$asd_menu_entries[] = 'separator2';
				$asd_menu_entries[] = 'themes.php';
				$asd_menu_entries[] = 'plugins.php';
				$asd_menu_entries[] = 'users.php';
				$asd_menu_entries[] = 'tools.php';
				$asd_menu_entries[] = 'options-general.php';
				$asd_menu_entries[] = 'separator-last';

				return $asd_menu_entries;
			}
			if ( is_admin() ) {
				add_filter( 'custom_menu_order', 'asd_custom_menu_order_1_201808211', 12 );
				add_filter( 'menu_order', 'asd_custom_menu_order_1_201808211', 12 );
			}
		}

		if ( ! function_exists( 'asd_category_admin_submenu_1_201808211' ) ) {
			/** ----------------------------------------------------------------------------
			 *   function asd_category_admin_submenu()
			 *   Adds "categories"  to the top-level menu
			 *   hooks into the admin_menu action
			 *  --------------------------------------------------------------------------*/
			function asd_category_admin_submenu_1_201808211() {
				add_submenu_page(
					'asd_settings',
					'Categories',
					'Categories',
					'manage_options',
					'edit-tags.php?taxonomy=category',
					''
				);
			}
			if ( is_admin() ) {
				add_action( 'admin_menu', 'asd_category_admin_submenu_1_201808211', 16 );
			}
		}

		if ( ! function_exists( 'info_on_published_plugins_1_201808211' ) ) {
			/** ----------------------------------------------------------------------------
			 *   function asd_category_admin_submenu()
			 *   Adds "categories"  to the top-level menu
			 *   hooks into the admin_menu action
			 *  --------------------------------------------------------------------------*/
			function info_on_published_plugins_1_201808211() {

				if ( defined( 'ASD_PAGESECTIONS_DIR' ) ) {
					echo '<h4>ASD PageSections:</h4>custom private plugin activated <br>' . "\r\n";
				}

				echo '<h4>ASD Products:</h4> ';
				if ( defined( 'ASD_PRODUCTS_DIR' ) ) {
					echo ' activated <br>' . "\r\n";
				} else {
					echo 'not activated <br>' . "\r\n";
				}
			}
		}

	}
}



if ( ! isset( $asd_admin_menu_version ) ) {
	$asd_admin_menu_version = $this_asd_admin_menu_version;
		setup_asd_admin_functions_1_201808211();
} else {
	if ( $this_asd_admin_menu_version > $asd_admin_menu_version ) {
		unhook_asd_admin_functions_1_201808211();
		setup_asd_admin_functions_1_201808211();
		$asd_admin_menu_version = $this_asd_admin_menu_version;
	}
}

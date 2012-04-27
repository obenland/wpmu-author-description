<?php
/** wpmu-author-description.php
 *
 * Plugin Name:	WPMU Author Description
 * Plugin URI:	http://en.wp.obenland.it/wpmu-author-description/?utm_source=wordpress&utm_medium=plugin&utm_campaign=wpmu-author-description
 * Description:	Retruns the description based on the site.
 * Version:		1.0.0
 * Author:		Konstantin Obenland
 * Author URI:	http://en.wp.obenland.it/?utm_source=wordpress&utm_medium=plugin&utm_campaign=wpmu-author-description
 * Text Domain:	wpmu-author-description
 * Domain Path:	/lang
 * License:		GPLv2
 */

if ( ! is_multisite() ) {
	return;
}

if ( ! class_exists( 'Obenland_Wp_Plugins_v200' ) ) {
	require_once( 'obenland-wp-plugins.php' );
}


class Obenland_WPMU_Author_Description extends Obenland_Wp_Plugins_v200 {
	
	
	/////////////////////////////////////////////////////////////////////////////
	// METHODS, PUBLIC
	/////////////////////////////////////////////////////////////////////////////
	
	/**
	 * Constructor
	 *
	 * Adds all necessary filters
	 *
	 * @author	Konstantin Obenland
	 * @since	1.0.0 - 27.04.2012
	 * @access	public
	 *
	 * @return	Obenland_WPMU_Author_Description
	 */
	public function __construct() {
		
		parent::__construct( array(
			'textdomain'		=>	'wpmu-author-description',
			'plugin_path'		=>	__FILE__,
			'donate_link_id'	=>	'HEXL3UM8D7R6N'
		));
		
		$this->hook( 'get_the_author_description' );
	}
	
	
	/**
	 * Displays the dropdown form
	 *
	 * @author	Konstantin Obenland
	 * @since	1.0
	 * @access	public
	 * 
	 * @param	string	$description	The user description
	 * @param	int		$user_id		The user ID	
	 *
	 * @return	string
	 */
	public function get_the_author_description( $description, $user_id ) {
		return $description;
	}
	
} // End Class Obenland_WPMU_Author_Description


new Obenland_WPMU_Author_Description;


/* End of file wpmu-author-description.php */
/* Location: ./wp-content/plugins/wpmu-author-description/wpmu-author-description.php */
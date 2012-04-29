<?php
/** wpmu-author-description.php
 *
 * Plugin Name:	WPMU Author Description
 * Plugin URI:	http://en.wp.obenland.it/wpmu-author-description/#utm_source=wordpress&utm_medium=plugin&utm_campaign=wpmu-author-description
 * Description:	Specify a unique autor description for each individual site in a network. 
 * Version:		1.0.1
 * Author:		Konstantin Obenland
 * Author URI:	http://en.wp.obenland.it/#utm_source=wordpress&utm_medium=plugin&utm_campaign=wpmu-author-description
 * Text Domain:	wpmu-author-description
 * Domain Path:	/lang
 * Network:		Network
 * License:		GPLv2
 */


if ( ! is_multisite() ) {
	return;
}


if ( ! class_exists( 'Obenland_Wp_Plugins_v300' ) ) {
	require_once( 'obenland-wp-plugins.php' );
}


class Obenland_WPMU_Author_Description extends Obenland_Wp_Plugins_v300 {
	
	
	///////////////////////////////////////////////////////////////////////////
	// METHODS, PUBLIC
	///////////////////////////////////////////////////////////////////////////
	
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
			'donate_link_id'	=>	'RZS8JEXZC6RC4'
		));
		
		$this->hook( 'plugins_loaded' );
	}
	
	
	/**
	 * Hooks the hooks
	 *
	 * @author	Konstantin Obenland
	 * @since	1.0.0 - 29.04.2012
	 * @access	public
	 *
	 * @return	void
	 */
	public function plugins_loaded() {
		$this->hook( 'pre_user_description', 999 );
		$this->hook( 'get_the_author_description' );
		$this->hook( 'edit_description',		'get_the_author_description' );
		$this->hook( 'edit_user_description',	'get_the_author_description' );
	}
	
	
	/**
	 * Saves the author description, based on which blog we are
	 *
	 * @author	Konstantin Obenland
	 * @since	1.0.0 - 27.04.2012
	 * @access	public
	 * @global	$user_id
	 *
	 * @param	string	$description	The user description
	 *
	 * @return	string
	 */
	public function pre_user_description( $description ) {
		global $user_id;
		
		if ( ! $this->is_primary_blog( $user_id ) ) {
			$custom_descriptions = (array) get_user_meta( $user_id, $this->textdomain, true );
			
			if ( $description ) {
				$custom_descriptions[get_current_blog_id()] = $description;
				$description = get_user_meta( $user_id, 'description', true );
			}
			else {
				unset( $custom_descriptions[get_current_blog_id()] );	
			}
			update_user_meta( $user_id, $this->textdomain, $custom_descriptions );
		}
		return $description;
	}
	
	
	/**
	 * Returns the description for this specific blog
	 *
	 * @author	Konstantin Obenland
	 * @since	1.0.0 - 27.04.2012
	 * @access	public
	 * 
	 * @param	string	$description	The user description
	 * @param	int		$user_id		The user ID
	 *
	 * @return	string
	 */
	public function get_the_author_description( $description, $user_id ) {
		
		if ( ! $this->is_primary_blog( $user_id ) ) {
			$descriptions = (array) get_user_meta( $user_id, $this->textdomain, true );
			if ( array_key_exists( get_current_blog_id(), $descriptions) ) {
				$description = $descriptions[get_current_blog_id()];
			}
		}
		return $description;
	}
	
	
	///////////////////////////////////////////////////////////////////////////
	// METHODS, PROTECTED
	///////////////////////////////////////////////////////////////////////////
	
	/**
	 * Determines, whether we are on the primary blog for the user
	 *
	 * @author	Konstantin Obenland
	 * @since	1.0.0 - 28.04.2012
	 * @access	public
	 *
	 * @param	int		$user_id	The user ID
	 *
	 * @return	bool
	 */
	protected function is_primary_blog( $user_id = 0 ) {
		$user_id = (int) $user_id;
	
		if ( ! $user_id ) {
			$user_id = get_current_user_id();
		}
		
		return get_user_meta( $user_id, 'primary_blog', true ) == get_current_blog_id();
	}
	
} // End Class Obenland_WPMU_Author_Description


new Obenland_WPMU_Author_Description;


/* End of file wpmu-author-description.php */
/* Location: ./wp-content/plugins/wpmu-author-description/wpmu-author-description.php */
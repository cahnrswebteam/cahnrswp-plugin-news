<?php
/*
Plugin Name: CAHNRS News
Plugin URI: http://cahnrs.wsu.edu/communications
Description: Adds News Content & Options
Author: cahnrscommunications, Danial Bleile
Author URI: http://cahnrs.wsu.edu/communications
Version: 1.0.0
*/

class CAHNRSWP_Media {
	
	// var@ object $instance Instance of CAHNRS_Media
	private static $instance;
	
	// var@ object $instance of CAHNRSWP_News
	public $news;
	
	/**
	 * Get the current instance or initialize
	 * @return object Instance of CAHNRS_Media
	 */
	public static function get_instance(){
		
		if ( null == self::$instance ) {
            self::$instance = new self;
			self::$instance->init_plugin();
        } // end if
 
        return self::$instance;
		
	} // end get_instance
	
	/**
	 * Called on new instance of CAHNRS_Media.
	 */
	public function init_plugin(){
		
		require_once 'classes/class-cahnrswp-news-save.php';
		
		require_once 'classes/class-cahnrswp-news.php';
		$this->news = new CAHNRSWP_News();
		
	} // end init_plugin
	
	
} // end CAHNRSWP_Media

CAHNRSWP_Media::get_instance();
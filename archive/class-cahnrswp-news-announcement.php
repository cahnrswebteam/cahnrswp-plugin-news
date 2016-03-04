<?php
class CAHNRSWP_News_Announcement {
	
	
	/**
	 * Adds announcement custom post type
	 */
	public function add_post_type(){
		
		$args = array(
			'public'     => true,
      		'label'      => 'Announcement',
			'supports'   => array('title','editor','author','thumbnail','excerpt','revisions'),
			'taxonomies' => array('post_tag','category'),
    	);
		
    	register_post_type( 'announcement', $args );
		
	} // end add_post_type
	
	
}
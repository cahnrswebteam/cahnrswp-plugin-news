<?php
/**
 * Class for saving post meta and other data
 * @author Danial Bleile
 * @version 0.0.1
 */
class CAHNRSWP_News_Save {
	
	/**
	 * Checks if user can save or not
	 * @param int $post_id ID of the post to save
	 * @return bool TRUE if can save otherwise FALSE
	 */
	private function check_can_save( $post_id , $update ){
		
		// If this is an autosave, our form has not been submitted, so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {

			return false;

		} // end if
		
		// If this is an autosave, our form has not been submitted, so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {

			return false;

		} // end if

		// Check the user's permissions.
		if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

			if ( ! current_user_can( 'edit_page', $post_id ) ) {

				return false;

			} // end if

		} else {

			if ( ! current_user_can( 'edit_post', $post_id ) ) {

				return false;

			} // end if

		} // end if
		
		if ( ! isset( $_POST['cahnrs_pagebuilder_key'] ) || ! wp_verify_nonce( $_POST['cahnrs_pagebuilder_key'], 'save_cahnrs_pagebuilder_' .  $post_id ) ) {
		  
			 return false;
		  
		  }
		
		return true;
		
	} // end check_can_save
	
	/**
	 * Clean the field based on supplied type
	 * @param variable $data Data to be cleaned
	 * @param string $type Type of sanitation to be used
	 * @return variable Cleaned data
	 */
	protected function clean_field( $data , $type ){
		
		
		switch( $type ){
			
			case 'text':
				$clean_data = sanitize_text_field( $data );
				break;
				
			default:
				$clean_data = '';
				break;
				
		} // end swtich
		
		return $clean_data;
		
	} // end clean_field
	
}


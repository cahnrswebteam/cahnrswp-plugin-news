<?php
/**
 * Class for the news object
 * @author Danial Bleile
 * @version 0.0.1
 */
class CAHNRSWP_News extends CAHNRSWP_News_Save{
	
	// @var string $post_type Slug for the post type
	protected $post_type = 'news-article';
	
	// @var array $fields 
	protected $fields = array(
			'_cahnrswp_news_article_redirect' => array( 'default' => '' , 'clean_type' => 'text' ),
			'_cahnrswp_news_article_test' => array( 'default' => '' , 'clean_type' => 'text' ),
		); 
	
	/**
	 * Add actions and set up class
	 */
	public function __construct(){
		
		// Add post type
		add_action( 'init' , array( $this , 'add_post_type' ), 11 );
		
		// Add edit form
		add_action( 'edit_form_after_title' , array( $this , 'add_editor_fields' ) );
		
		// Save meta data
		add_action( 'save_post_news-article' , array( $this , 'save' ), 10 , 3 );
		
		add_action( 'template_redirect', array( $this , 'redirect' ), 1 );
		
	} // end __construct
	
	/**
	 * Gets post type
	 * @return string Post_type slug
	 */ 
	public function get_post_type(){ return $this->post_type;}
	
	/**
	 * Get post type fields
	 * @return array Post type fields
	 */
	public function get_fields(){ return $this->fields;}
	
	/**
	 * Register new post type for news
	 */
	public function add_post_type(){
		
		$args = array(
		  'public' => true,
		  'label'  => 'News',
		  'supports' => array( 'title','editor','author','revision','thumbnail' ),
		  'taxonomies' => array( 'category' , 'post_tag' ),
		);
			
		
		register_post_type( $this->get_post_type() , $args );
		
	} // end add_post_type
	
	/**
	 * Adds editing fields to post type
	 * @param object $post WP post object
	 */
	public function add_editor_fields( $post ){
		
		if ( $this->get_post_type() == $post->post_type ){
			
			$settings = $this->get_settings( $post->ID );
		
			$html = '<div id="cahnrswp-news-article-editor">';
			
				$html .= '<div class="cahnrswp-news-field" style="padding: 1rem 0;"><label>Redirect (optional)</label>';
				
				$html .= '<input type="text" style="width:100%; height: 40px; line-height: 40px; text-indent: 0.5rem; font-size: 1.2rem; color: #555" name="_cahnrswp_news_article_redirect" 
							value="' . $settings['_cahnrswp_news_article_redirect'] . '" placeholder="Redirect URL (Including http://)"></div>';
							
				$html .= '<div class="cahnrswp-news-field" style="padding: 1rem 0;"><label>Summary</label><textarea name="excerpt" style="width:100%; height: 6rem;">' . $post->post_excerpt . '</textarea></div>';
			
			$html .= '</div>';
			
			echo $html;
		
		} // end if
		
	} // end add_editor_fields
	
	/**
	 * Saves meta data
	 * @param int $post_id ID of post to save
	 * @param object $post WP Post object
	 * @param bool $update Whether this is an existing post being updated or not.
	 */
	public function save( $post_id , $post , $update ) {
		
		$fields = $this->get_fields();
		
		foreach ( $fields as $key => $field_data ){
			
			if ( isset( $_POST[ $key ] ) ){
				
				$data = $this->clean_field( $_POST[ $key ] , $field_data['clean_type'] );
				
				update_post_meta( $post_id , $key , $data );
				
			} // end if
			
		} //end foreach
		
	} // end save
	
	/**
	 * Get post_type settings
	 * @param string $post_id
	 * @return array Settings for the post_type
	 */
	public function get_settings( $post_id ){
		
		$settings = array();
		
		$fields = $this->get_fields();
		
		foreach( $fields as $key => $field_data ){
			
			$meta = get_post_meta( $post_id , $key , true );
			
			if ( $meta === '' ){
				
				$settings[ $key ] = $field_data['default'];
				
			} else {
				
				$settings[ $key ] = $meta;
				
			} // end if
			
		} // end foreach
		
		return $settings;
		
	} // end get_settings
	
	/**
	 * Redirects page based on field
	 */ 
	public function redirect(){
		
		global $wp_query;
		
		if( is_single() ){
			
			if ( $wp_query->post->post_type == $this->get_post_type() ){
				
				$redirect = get_post_meta( $wp_query->post->ID , '_cahnrswp_news_article_redirect' , true );
				
				if ( $redirect ) {
					
					wp_redirect( $redirect );
					
            		header( 'Status: 302' );
					
            		exit;
					
				} // end if
				
			} // end if
			
		} // end if
		
	} // end redirect
	
} // end CAHNRSWP_News
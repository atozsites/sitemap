<?php

// SECURITY : Exit if accessed directly
if ( !defined('ABSPATH') ) {
	exit;
}


// Get the CPTs (Custom Post Type)
$args = array(
	'public'   => true,
	'_builtin' => false
);
$post_types = get_post_types( $args, 'names' ); 

// Get the Taxonomies
$args = array(
	'public'   => true,
	'_builtin' => false
	);
$taxonomies_names = get_taxonomies( $args );


// inital way to display the posts
$wsp_initial_posts_by_category = '<a href="{permalink}">{title}</a>';
?>
<div class="wrap">
	<form method="post" action="options.php">
		<?php settings_fields('wp-sitemap-page');?>
		
		
		<div id="icon-options-general" class="icon32"></div>
		<h2><?php _e('AtoZ Sitemap', 'AtoZ_sitemap'); ?></h2>
		
		
		<div id="welcome-panel" class="welcome-panel">
			<div class="welcome-panel-content">
				<div class="welcome-panel-column-container">
					<div class="welcome-panel-column">
						<h4><?php _e('Help us', 'AtoZ_sitemap') ?></h4>
						<p class="message"><?php _e('This plugin is freely developped and distrubed to the WordPress community. Plenty of hours were necessary to develop this project.', 'AtoZ_sitemap') ?></p>
						<p><?php _e('If you like this plugin, feel free to rate it 5 stars on the WordPress.org website or to donate.', 'AtoZ_sitemap'); ?></p>
						<p><a href="<?php echo WSP_DONATE_LINK; ?>" class="button button-primary" target="_blank"><?php _e('Donate', 'AtoZ_sitemap'); ?></a></p>
					</div>

					<div class="welcome-panel-column">
						<h4><?php _e('Traditionnal sitemap', 'AtoZ_sitemap') ?></h4>
						<p><?php _e('To display a traditional sitemap, just use [AtoZ_sitemap] on any page or post.', 'AtoZ_sitemap'); ?></p>
					</div>

					<div class="welcome-panel-column">
						<h4><?php _e('Display only some content', 'AtoZ_sitemap') ?></h4>
						<p><?php _e('Display only some kind of content using the following shortcodes.', 'AtoZ_sitemap'); ?></p>
						<ul>
							<li>[AtoZ_sitemap only="post"]</li>
							<li>[AtoZ_sitemap only="page"]</li>
							<li>[AtoZ_sitemap only="category"]</li>
							<li>[AtoZ_sitemap only="tag"]</li>
							<li>[AtoZ_sitemap only="archive"]</li>
							<li>[AtoZ_sitemap only="author"]</li>
							
							<?php
							// list all the CPT
							foreach ( $post_types as $post_type ) :
								
								// extract CPT object
								$cpt = get_post_type_object( $post_type );
								?>
								<li>[AtoZ_sitemap only="<?php echo $cpt->name; ?>"]</li>
							<?php endforeach; ?>
						</ul>
					</div>
				</div>
			</div>
		</div>
		
		
		<?php wsp_show_tabs(); ?>
		
		<div id="poststuff">
			<div id="post-body" class="metabox-holder columns-2">
				<!-- main content -->
				<div id="post-body-content">
					<div class="meta-box-sortables ui-sortable">
						
<?php
$current_tab = wsp_get_current_tab();
switch ($current_tab) {
	// MAIN
	case 'main':
		?>
		
		
		<div class="postbox">
			<h3 class="hndle"><span><?php _e('General settings', 'AtoZ_sitemap'); ?></span></h3>
			<div class="inside">
			<?php
			$wsp_add_nofollow = get_option('wsp_add_nofollow');
			?>
			<label for="wsp_add_nofollow">
				<input type="checkbox" 
					name="wsp_add_nofollow" id="wsp_add_nofollow" 
					value="1" <?php echo ($wsp_add_nofollow==1 ? ' checked="checked"' : ''); ?> />
					<?php _e('Add a nofollow attribute to the links.', 'AtoZ_sitemap'); ?>
			</label>
			<p class="description"><?php _e('Please be advice to avoid this feature as it may hurt your SEO (Search Engine Optimization), if you don\'t know what it is.'); ?></p>
			</div><!-- .inside -->
		</div><!-- .postbox -->
		
		
		<div class="postbox">
			<h3 class="hndle"><span><?php _e('Customize the way to display the posts', 'AtoZ_sitemap'); ?></span></h3>
			<div class="inside">

			<p><?php _e('Please choose how you want to display the posts on the sitemap.', 'AtoZ_sitemap');?></p>
			<ul>
				<li><?php echo sprintf( __('%1$s: title of the post.', 'AtoZ_sitemap'), '<strong>{title}</strong>' );?></li>
				<li><?php echo sprintf( __('%1$s: URL of the post.', 'AtoZ_sitemap'), '<strong>{permalink}</strong>' );?></li>
				<li><?php echo sprintf( __('%1$s: The year of the post, four digits, for example 2004.', 'AtoZ_sitemap'), '<strong>{year}</strong>' );?></li>
				<li><?php echo sprintf( __('%1$s: Month of the year, for example 05.', 'AtoZ_sitemap'), '<strong>{monthnum}</strong>' );?></li>
				<li><?php echo sprintf( __('%1$s: Day of the month, for example 28.', 'AtoZ_sitemap'), '<strong>{day}</strong>' );?></li>
				<li><?php echo sprintf( __('%1$s: Hour of the day, for example 15.', 'AtoZ_sitemap'), '<strong>{hour}</strong>' );?></li>
				<li><?php echo sprintf( __('%1$s: Minute of the hour, for example 43.', 'AtoZ_sitemap'), '<strong>{minute}</strong>' );?></li>
				<li><?php echo sprintf( __('%1$s: Second of the minute, for example 33.', 'AtoZ_sitemap'), '<strong>{second}</strong>' );?></li>
				<li><?php echo sprintf( __('%1$s: The unique ID # of the post, for example 423.', 'AtoZ_sitemap'), '<strong>{post_id}</strong>' );?></li>
				<li><?php echo sprintf( __('%1$s: Category name. Nested sub-categories appear as nested directories in the URI.', 'AtoZ_sitemap'), '<strong>{category}</strong>' );?></li>
			</ul>
			
			<table class="form-table">
				<tbody>
				<tr valign="top">
					<th scope="row">
						<label for="wsp_posts_by_category">
						<?php _e('How to display the posts', 'AtoZ_sitemap');?>
						</label>
					</th>
					<td>
						<?php
						// determine the code to place in the textarea
						$wsp_posts_by_category = get_option('wsp_posts_by_category');
						if ( $wsp_posts_by_category === false ) {
							// this option does not exists
							$wsp_posts_by_category = $wsp_initial_posts_by_category;
							
							// save this option
							add_option( 'wsp_posts_by_category', $textarea );
						} else {
							// this option exists, display it in the textarea
							$textarea = $wsp_posts_by_category;
						}
						?>
						<textarea name="wsp_posts_by_category" id="wsp_posts_by_category" 
							rows="2" cols="50"
							class="large-text code"><?php
							echo $textarea;
							?></textarea>
						<p class="description"><?php printf(__('Initial way to display the content: %1$s', 'AtoZ_sitemap'), htmlentities($wsp_initial_posts_by_category)); ?></p>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<?php _e('Displayed multiple times', 'AtoZ_sitemap'); ?>
					</th>
					<td>
						<?php
						$wsp_is_display_post_multiple_time = get_option('wsp_is_display_post_multiple_time');
						?>
						<label for="wsp_is_display_post_multiple_time">
							<input type="checkbox" 
								name="wsp_is_display_post_multiple_time" id="wsp_is_display_post_multiple_time" 
								value="1" <?php echo ($wsp_is_display_post_multiple_time==1 ? ' checked="checked"' : ''); ?> />
								<?php _e('Displayed in each category if posts are in multiples categories.', 'AtoZ_sitemap'); ?>
						</label>
					</td>
				</tr>
				</tbody>
			</table>

			</div><!-- .inside -->
		</div><!-- .postbox -->
		
		
		<div class="postbox">
			<h3 class="hndle"><span><?php _e('Exclude from traditional sitemap', 'AtoZ_sitemap'); ?></span></h3>
			<div class="inside">
			
			<table class="form-table">
				<tbody>
				<tr>
					<th scope="row">
						<label for="wsp_exclude_pages">
						<?php _e('Exclude pages', 'AtoZ_sitemap'); ?>
						</label>
					</th>
					<td>
						<?php
						// Exclude some pages
						$wsp_exclude_pages = get_option('wsp_exclude_pages');
						?>
						<input type="text" class="large-text code" 
							name="wsp_exclude_pages" id="wsp_exclude_pages" 
							value="<?php echo $wsp_exclude_pages; ?>" />
						<p class="description"><?php _e('Just add the IDs, separated by a comma, of the pages you want to exclude.', 'AtoZ_sitemap'); ?></p>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<?php _e('Exclude Custom Post Type', 'AtoZ_sitemap'); ?>
					</th>
					<td>
						<?php
						// Is this CPT already excluded ?
						$wsp_exclude_cpt_page = get_option('wsp_exclude_cpt_page');
						$wsp_exclude_cpt_post = get_option('wsp_exclude_cpt_post');
						$wsp_exclude_cpt_archive = get_option('wsp_exclude_cpt_archive');
						$wsp_exclude_cpt_author = get_option('wsp_exclude_cpt_author');
						?>
						<div>
							<label for="wsp_exclude_cpt_page">
								<input type="checkbox" 
									name="wsp_exclude_cpt_page" id="wsp_exclude_cpt_page" 
									value="1" <?php echo ($wsp_exclude_cpt_page==1 ? ' checked="checked"' : ''); ?> />
									<?php _e('Page', 'AtoZ_sitemap'); ?>
							</label>
						</div>
						<div>
							<label for="wsp_exclude_cpt_post">
								<input type="checkbox" 
									name="wsp_exclude_cpt_post" id="wsp_exclude_cpt_post" 
									value="1" <?php echo ($wsp_exclude_cpt_post==1 ? ' checked="checked"' : ''); ?> />
									<?php _e('Post', 'AtoZ_sitemap'); ?>
							</label>
						</div>
						<div>
							<label for="wsp_exclude_cpt_archive">
								<input type="checkbox" 
									name="wsp_exclude_cpt_archive" id="wsp_exclude_cpt_archive" 
									value="1" <?php echo ($wsp_exclude_cpt_archive==1 ? ' checked="checked"' : ''); ?> />
									<?php _e('Archive', 'AtoZ_sitemap'); ?>
							</label>
						</div>
						<div>
							<label for="wsp_exclude_cpt_author">
								<input type="checkbox" 
									name="wsp_exclude_cpt_author" id="wsp_exclude_cpt_author" 
									value="1" <?php echo ($wsp_exclude_cpt_author==1 ? ' checked="checked"' : ''); ?> />
									<?php _e('Author', 'AtoZ_sitemap'); ?>
							</label>
						</div>
						<?php
						// list all the CPT
						foreach ( $post_types as $post_type ) {
							
							// extract CPT object
							$cpt = get_post_type_object( $post_type );
							
							// Is this CPT already excluded ?
							$wsp_exclude_cpt = get_option('wsp_exclude_cpt_'.$cpt->name);
							?>
							<div>
								<label for="wsp_exclude_cpt_<?php echo $cpt->name; ?>">
									<input type="checkbox" 
										name="wsp_exclude_cpt_<?php echo $cpt->name; ?>" id="wsp_exclude_cpt_<?php echo $cpt->name; ?>" 
										value="1" <?php echo ($wsp_exclude_cpt=='1' ? ' checked="checked"' : ''); ?> />
										<?php echo $cpt->label; ?>
								</label>
							</div>
							<?php
						}
						?>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<?php _e('Exclude taxonomies', 'AtoZ_sitemap'); ?>
					</th>
					<td>
						<?php
						// list all the taxonomies
						foreach ( $taxonomies_names as $taxonomy_name ) {
							
							// Extract
							$taxonomy_obj = get_taxonomy( $taxonomy_name );
							
							// get some data
							$taxonomy_name = $taxonomy_obj->name;
							$taxonomy_label = $taxonomy_obj->label;
							
							// Is this CPT already excluded ?
							$wsp_exclude_taxonomy = get_option('wsp_exclude_taxonomy_'.$taxonomy_name);
							?>
							<div>
								<label for="wsp_exclude_taxonomy_<?php echo $taxonomy_name; ?>">
									<input type="checkbox" 
										name="wsp_exclude_taxonomy_<?php echo $taxonomy_name; ?>" id="wsp_exclude_taxonomy_<?php echo $taxonomy_name; ?>" 
										value="1" <?php echo ($wsp_exclude_taxonomy=='1' ? ' checked="checked"' : ''); ?> />
										<?php echo $taxonomy_label; ?>
								</label>
							</div>
							<?php
						}
						?>
					</td>
				</tr>
				<tr>
					<th scope="row">
						<?php _e('Password protected', 'AtoZ_sitemap'); ?>
					</th>
					<td>
						<?php
						// Is the pages/posts/CPTs with password should be exclude from the sitemap
						$wsp_is_exclude_password_protected = get_option('wsp_is_exclude_password_protected');
						?>
						<div>
							<label for="wsp_is_exclude_password_protected">
								<input type="checkbox" 
									name="wsp_is_exclude_password_protected" id="wsp_is_exclude_password_protected" 
									value="1" <?php echo ($wsp_is_exclude_password_protected==1 ? ' checked="checked"' : ''); ?> />
									<?php _e('Exclude content protected by password', 'AtoZ_sitemap'); ?>
							</label>
						</div>
					</td>
				</tr>
				</tbody>
			</table>

			</div><!-- .inside -->
		</div><!-- .postbox -->
		
		
		<div class="postbox">
			<h3 class="hndle"><span><?php _e('Display the plugin link', 'AtoZ_sitemap'); ?></span></h3>
			<div class="inside">
			<?php
			$wsp_is_display_copyright = get_option('wsp_is_display_copyright');
			?>
			<label for="wsp_is_display_copyright">
				<input type="checkbox" 
					name="wsp_is_display_copyright" id="wsp_is_display_copyright" 
					value="1" <?php echo ($wsp_is_display_copyright==1 ? ' checked="checked"' : ''); ?> />
					<?php _e('Display the plugin name with a link at the bottom of the sitemap.', 'AtoZ_sitemap'); ?>
			</label>

			</div><!-- .inside -->
		</div><!-- .postbox -->
		
		
		<?php
	break;
	
	// about
	case 'about':
		?>
		
		<div class="postbox">
			<h3 class="hndle"><span><?php _e('How to use', 'AtoZ_sitemap'); ?></span></h3>
			<div class="inside">
			
			<p><?php _e('You can use any of the following shortcodes in the content of your pages (or posts) to display a dynamic sitemap.', 'AtoZ_sitemap'); ?></p>
			
			<ul>
				<li><strong>[AtoZ_sitemap]</strong> <?php _e('To display a traditionnal sitemap', 'AtoZ_sitemap'); ?></li>
				<li><strong>[AtoZ_sitemap only="page"]</strong> <?php _e('To display the pages', 'AtoZ_sitemap'); ?></li>
				<li><strong>[AtoZ_sitemap only="page" sort="menu_order"]</strong> <?php printf(__('To display the pages sorted by menu order. Possible values are: %1$s.', 'AtoZ_sitemap'), '\'post_title\', \'menu_order\', \'post_date\', \'post_modified\', \'ID\', \'post_author\', \'post_name\''); ?></li>
				<li><strong>[AtoZ_sitemap only="post"]</strong> <?php _e('To display the posts by category', 'AtoZ_sitemap'); ?></li>
				<li><strong>[AtoZ_sitemap only="post" sort="count"]</strong> <?php printf(__('To display the posts by category. Categories sorted by number of posts. Possible values are: %1$s', 'AtoZ_sitemap'), '\'id\', \'name\', \'slug\', \'count\', \'term_group\''); ?></li>
				<li><strong>[AtoZ_sitemap only="category"]</strong> <?php _e('To display the categories', 'AtoZ_sitemap'); ?></li>
				<li><strong>[AtoZ_sitemap only="category" sort="count"]</strong> <?php printf(__('To display the categories sorted by number of posts. Possible values are: %1$s', 'AtoZ_sitemap'), '\'id\', \'name\', \'slug\', \'count\', \'term_group\''); ?></li>
				<li><strong>[AtoZ_sitemap only="tag"]</strong> <?php _e('To display the tags', 'AtoZ_sitemap'); ?></li>
				<li><strong>[AtoZ_sitemap only="archive"]</strong> <?php _e('To display the archives', 'AtoZ_sitemap'); ?></li>
				<li><strong>[AtoZ_sitemap only="author"]</strong> <?php _e('To display the authors', 'AtoZ_sitemap'); ?></li>
				<li><strong>[AtoZ_sitemap only="author" sort="post_count"]</strong> <?php printf(__('To display the authors, sorted by number of posts by author. Possible values are: %1$s.', 'AtoZ_sitemap'), '\'name\', \'email\', \'url\', \'registered\', \'id\', \'user_login\', \'post_count\''); ?></li>
				<?php
				// list all the CPT
				foreach ( $post_types as $post_type ) :
					
					// extract CPT object
					$cpt = get_post_type_object( $post_type );
					?>
					<li><strong>[AtoZ_sitemap only="<?php echo $cpt->name; ?>"]</strong> <?php printf(__('To display the %1$s', 'AtoZ_sitemap'), strtolower($cpt->label)); ?></li>
				<?php endforeach; ?>
				<?php
				// list all the taxonomies
				foreach ( $taxonomies_names as $taxonomy_name ) :
					
					// Extract
					$taxonomy_obj = get_taxonomy( $taxonomy_name );
					
					// get some data
					$taxonomy_name = $taxonomy_obj->name;
					$taxonomy_label = $taxonomy_obj->label;
					?>
					<li><strong>[AtoZ_sitemap only="<?php echo $taxonomy_name; ?>"]</strong> <?php printf(__('To display the %1$s', 'AtoZ_sitemap'), strtolower($taxonomy_label)); ?></li>
				<?php endforeach; ?>
				<li><strong>[AtoZ_sitemap display_title="false"]</strong> <?php _e('To display a traditionnal sitemap without the title', 'AtoZ_sitemap'); ?></li>
				<li><strong>[AtoZ_sitemap only_private="true"]</strong> <?php _e('Display only the private page (do not works with other kind of content)', 'AtoZ_sitemap'); ?></li>
			</ul>
			
			</div><!-- .inside -->
		</div><!-- .postbox -->
		
		
		<?php
		break;
		
	// DEFAULT
	default:
		// nothing but do
		break;
}
?>


					</div><!-- .meta-box-sortables .ui-sortable -->
				</div><!-- post-body-content -->
				<!-- sidebar -->
				<div id="postbox-container-1" class="postbox-container">
					<div class="meta-box-sortables">
						<div class="postbox">
						<h3 class="hndle"><span><?php _e('About', 'AtoZ_sitemap'); ?></span></h3>
						<div style="padding:0 5px;">
							<?php
							$fr_lang = array('fr_FR', 'fr_BE', 'fr_CH', 'fr_LU', 'fr_CA');
							// WP Constant WPLANG does not exists anymore
							// https://core.trac.wordpress.org/changeset/29630
							$WPLANG = get_option('WPLANG', '');
							// check if language is in French
							$is_fr = (in_array($WPLANG, $fr_lang) ? true : false);
							// Get the URL author depending on the language
							$url_author = ( $is_fr===true ? 'http://tonyarchambeau.com/' : 'http://en.tonyarchambeau.com/' );
							?>
							<p><img src="<?php echo WSP_USER_PLUGIN_URL; ?>/images/icon-html-code-24.png" alt="" style="vertical-align:middle;" /> <?php printf(__('Developed by <a href="%1$s">Tony Archambeau</a>.', 'AtoZ_sitemap'), $url_author); ?></p>
							<p><img src="<?php echo WSP_USER_PLUGIN_URL; ?>/images/icon-star-24.png" alt="" style="vertical-align:middle;" /> <a href="http://wordpress.org/plugins/wp-sitemap-page/" target="_blank"><?php _e('Rate the plugin on Wordpress.org'); ?></a></p>
							<p><img src="<?php echo WSP_USER_PLUGIN_URL; ?>/images/icon-coin-24.png" alt="" style="vertical-align:middle;" /> <a href="<?php echo WSP_DONATE_LINK; ?>" target="_blank"><?php _e('Donate', 'AtoZ_sitemap'); ?></a></p>
							<?php
							// Display the author for Russian audience
							if ($WPLANG == 'ru_RU') {
								?>
								<p><img src="<?php echo WSP_USER_PLUGIN_URL; ?>/images/icon-html-code-24.png" alt="" style="vertical-align:middle;" /> <?php printf(__('Translated in Russian by <a href="%1$s">skesov.ru</a>.', 'AtoZ_sitemap'), 'http://skesov.ru/'); ?></p>
								<?php
							}
							?>
						</div>
						</div><!-- .postbox -->
					</div><!-- .meta-box-sortables -->
				</div><!-- #postbox-container-1 .postbox-container -->
			</div><!-- #post-body .metabox-holder .columns-2 -->
			<br class="clear" />
			
			<?php if ($current_tab=='main') : ?>
			<div>
				<?php submit_button();?>
			</div>
			<?php endif; ?>
			
		</div><!-- #poststuff -->
		

		
	</form>
</div><!-- .wrap -->

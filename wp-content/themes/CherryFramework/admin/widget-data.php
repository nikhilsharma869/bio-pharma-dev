<?php

	class myWidget_Data {

		var $import_filename;
		
		function __construct() {
			//add_action('admin_menu', array($this, 'add_admin_menus'));
			add_action('admin_enqueue_scripts', array($this, 'add_admin_scripts'));
			add_action('load-tools_page_widget-settings-export', array($this, 'export_widget_settings'));
			add_action('wp_ajax_widget_import_submit', array($this, 'widget_import_submit'));
			add_filter('upload_mimes', array($this, 'json_upload_mimes'));
		}
		
		function add_admin_scripts ($hook) {
			if('tools_page_widget-settings-import' != $hook || 'tools_page_widget-settings-export' != $hook) {
				wp_register_script( 'widget_data', OPTIONS_FRAMEWORK_DIRECTORY.'js/widget_data.js');
				wp_enqueue_script( 'widget_data' );
				$widgets_url = get_admin_url(false, 'widgets.php');
				wp_localize_script( 'widget_data', 'widgets_url', $widgets_url);
			}
		}

		/* function add_admin_menus() {
			// export
			$this->submenu_export = add_submenu_page('tools.php', 'Widget Settings Export', 'Widget Settings Export', 'administrator', 'widget-settings-export',  array(&$this, 'export_settings_page'));
			//import
			$this->submenu_import = add_submenu_page('tools.php', 'Widget Settings Import', 'Widget Settings Import', 'administrator', 'widget-settings-import',  array(&$this, 'import_settings_page'));
		}*/

		function export_settings_page() {
			$sidebar_widgets = $this->order_sidebar_widgets(wp_get_sidebars_widgets());
			?>
			<div class="widget-data export-widget-settings">
				<div class="wrap">
					<h4 class="head"><?php _e( '<span>Step <i>2</i></span> Widget Settings Export', 'cherry' ); ?></h4>	
					<form action="" method="post" id="widget-export-settings">
						<?php wp_nonce_field( 'Widget-Settings-export' ); ?>
						<input type="hidden" name="Widget-Settings-export" value="1" />
						<div style="clear:both;"></div>
						<!--div class="title">
							<p class="widget-selection-error">Please select a widget to continue.</p>
							<h3>Sidebars</h3>
							<div class="clear"></div>
						</div-->
						<div class="sidebars indent-bot">
							<?php
							foreach ($sidebar_widgets as $sidebar_name=>$widget_list) :
								if (count($widget_list) == 0)
									continue;

								$sidebar_info = $this->get_sidebar_info($sidebar_name);?>

								<div class="sidebar">
									<h4><?php echo $sidebar_info['name']; ?></h4>

									<div class="widgets">
										<?php foreach ($widget_list as $widget) :

											$widget_type = trim(substr($widget, 0, strrpos($widget, '-')));
											$widget_type_index = trim(substr($widget, strrpos($widget, '-') + 1));
											$option_name = 'widget_'.$widget_type;
											$widget_options = get_option($option_name);
											$widget_title = isset($widget_options[$widget_type_index]['title']) ? $widget_options[$widget_type_index]['title'] : '';

											?>
											<div class="import-form-row">
												<input class="<?php echo ($sidebar_name == 'wp_inactive_widgets') ? 'inactive' : 'active'; ?>" type="checkbox" name="<?php echo $widget; ?>" id="meta_<?php echo $widget; ?>" <?php echo ($sidebar_name == 'wp_inactive_widgets') ? '' : 'checked'; ?> />
												<label for="meta_<?php echo $widget; ?>">&nbsp;
													<?php
													echo ucfirst($widget_type);

													if (!empty($widget_title)) :
														echo (' - '.$widget_title);
													else :
														echo (' - '.$widget_type_index);
													endif;
													?>
												</label>
											</div>
										<?php endforeach; ?>
									</div> <!-- end widgets -->
								</div> <!-- end sidebar -->
							<?php endforeach;?>
						</div> <!-- end sidebars -->
						<button class="button-primary fnone" type="submit" name="export-widgets" id="export-widgets">Next &raquo;</button>
					</form>
				</div> <!-- end wrap -->
			</div> <!-- end export-widget-settings -->
			<?php
		}
		
		function import_settings_page() {
			?>
			<div class="widget-data import-widget-settings">
					<h4 class="head"><?php _e( '<span>Step <i>2</i></span> Widget Settings Import', 'cherry' ); ?></h4>					
						<?php if (isset($_FILES['upload-file'])) : ?>
						<!-- <div id="notifier"></div> -->
						<div class="import-wrapper">
						<!--div class="left">
							<button class="button-bottom button button-highlighted" type="button" name="SelectAllActive" id="SelectAllActive">Select All Widgets</button>
							<button class="button-bottom button button-highlighted" type="button" name="UnSelectAllActive" id="UnSelectAllActive">Un-Select All Widgets</button>
						</div-->
						<div style="clear:both;"></div>
						<form action="" id="import-widget-data" method="post">
							<?php
							$json = $this->get_widget_settings_json();
							$json_data = json_decode($json[0], true);
							$json_file = $json[1];

							if (!$json_data)
								return;
							?>
							<!--div class="title">
								<p class="widget-selection-error">Please select a widget to continue.</p>
								<h3>Sidebars</h3>
								<div class="clear"></div>
							</div-->
							<div class="sidebars indent-bot">
								<?php
								if (isset ($json_data[0])) :
									foreach ($this->order_sidebar_widgets($json_data[0]) as $sidebar_name=>$widget_list) :
										if (count($widget_list) == 0)
											continue;

										$sidebar_info = $this->get_sidebar_info($sidebar_name);?>

										<?php if ($sidebar_info) : ?>
											<div class="sidebar">
												<h4><?php echo $sidebar_info['name']; ?></h4>

												<div class="widgets">
													<?php foreach ($widget_list as $widget) :
														$widget_options = false;

														$widget_type = trim(substr($widget, 0, strrpos($widget, '-')));
														$widget_type_index = trim(substr($widget, strrpos($widget, '-') + 1));
														$option_name = 'widget_'.$widget_type;
														$widget_type_options = $this->get_option_from_array($widget_type, $json_data[1]);
														if ($widget_type_options) :
															$widget_title = isset($widget_type_options[$widget_type_index]['title']) ? $widget_type_options[$widget_type_index]['title'] : '';
															$widget_options = $widget_type_options[$widget_type_index];
														endif;
														?>
													<div class="import-form-row">
															<input class="<?php echo ($sidebar_name == 'wp_inactive_widgets') ? 'inactive' : 'active'; ?>" type="checkbox" name="widgets[<?php echo $widget_type; ?>][<?php echo $widget_type_index; ?>]" id="meta_<?php echo $widget; ?>" <?php echo ($sidebar_name == 'wp_inactive_widgets') ? '' : 'checked'; ?> />
															<label for="meta_<?php echo $widget; ?>">&nbsp;
																<?php
																echo ucfirst($widget_type);

																if (!empty($widget_title)) :
																	echo (' - '.$widget_title);
																else :
																	echo (' - '.$widget_type_index);
																endif;
																?>
															</label>
													</div>
													<?php endforeach; ?>
												</div> <!-- end widgets -->
											</div> <!-- end sidebar -->
										<?php endif; ?>
									<?php endforeach; ?>
								<?php endif; ?>
								<input type="hidden" name="import_file" value="<?php echo $json_file; ?>"/>
								<input type="hidden" name="action" value="widget_import_submit"/>
							</div> <!-- end sidebars -->
								<input class="button-primary" type="submit" name="import-widgets" id="import-widgets" value="<?php _e( 'Import Settings', 'cherry' ); ?>">
							</form>
						</div>
						<?php else : ?>
							<form action="" id="upload-widget-data" method="post" enctype="multipart/form-data">
								<div class="indent-bot">
									<p class="text-style">Select the file that contains Widget Settings (e.g. <b>widgets.json</b>)</p>
										<!-- <div id="output-text" style="float:left;"></div>
										<div id="upload-button" class="button-secondary" style="width:135px; float:left;">Click here to select a file</div> -->
										<input type="file" name="upload-file" id="upload-file" size="25">
									</div>
								<input type="submit" name="button-upload" class="button-primary" value="<?php _e( 'Show Widget Settings', 'cherry' ); ?>" disabled="disabled">
							</form>
						<?php endif; ?>
			</div> <!-- end import-widget-settings -->
			<?php
		}
		
	function parse_export_data($posted_array){
			$sidebars_array = get_option('sidebars_widgets');
			$sidebar_export = array();
			foreach($sidebars_array as $sidebar=>$widgets){
				if(!empty($widgets) && is_array($widgets)) {
					foreach($widgets as $sidebar_widget){
						if(in_array($sidebar_widget, array_keys($posted_array))) {
							$sidebar_export[$sidebar][] = $sidebar_widget;
						}
					}			
				}
			}
			$widgets = array();
			foreach($posted_array as $k=>$v) {
				$widget = array();
				$widget['type'] = trim(substr($k, 0, strrpos($k, '-')));
				$widget['type-index'] = trim(substr($k, strrpos($k, '-') + 1));
				$widget['export_flag'] = ($v == 'on') ? true : false;
				$widgets[] = $widget;
			}
			$widgets_array = array();
			foreach($widgets as $widget) {
				$widget_val = get_option('widget_'.$widget['type']);
				$multiwidget_val = $widget_val['_multiwidget'];
				$widgets_array[$widget['type']][$widget['type-index']] = $widget_val[$widget['type-index']];
				if(isset($widgets_array[$widget['type']]['_multiwidget'])) {
					unset($widgets_array[$widget['type']]['_multiwidget']);
				}
				$widgets_array[$widget['type']]['_multiwidget'] = $multiwidget_val;
			}
			unset($widgets_array['export']);
			$export_array = array($sidebar_export, $widgets_array);
			$json = json_encode($export_array);
			return $json;
		}
		
		function parse_import_data($import_array){
			$sidebars_data = $import_array[0];
			$widget_data = $import_array[1];
			$current_sidebars = get_option('sidebars_widgets');
			$new_widgets = array();

			foreach($sidebars_data as $import_sidebar=>$import_widgets) :

				foreach ($import_widgets as $import_widget) :
					//if the sidebar exists
					if (isset($current_sidebars[$import_sidebar])) :
						$title = trim(substr($import_widget, 0, strrpos($import_widget, '-')));
						$index = trim(substr($import_widget, strrpos($import_widget, '-') + 1));
						$current_widget_data = get_option('widget_'.$title);
						$new_widget_name = $this->get_new_widget_name($title, $index);
						$new_index = trim(substr($new_widget_name, strrpos($new_widget_name, '-') + 1));

						if(is_array($new_widgets[$title])) {
							while(array_key_exists($new_index, $new_widgets[$title])) {
								$new_index++;
							}
						}
						$current_sidebars[$import_sidebar][] = $title.'-'.$new_index;
						if(array_key_exists($title, $new_widgets)){
							$new_widgets[$title][$new_index] = $widget_data[$title][$index];
							$multiwidget = $new_widgets[$title]['_multiwidget'];
							unset($new_widgets[$title]['_multiwidget']);
							$new_widgets[$title]['_multiwidget'] = $multiwidget;
						} else {
							$current_widget_data[$new_index] = $widget_data[$title][$index];
							$current_multiwidget = $current_widget_data['_multiwidget'];
							$new_multiwidget = $widget_data[$title]['_multiwidget'];
							$multiwidget = ($current_multiwidget != $new_multiwidget) ? $current_multiwidget : 1;
							unset($current_widget_data['_multiwidget']);
							$current_widget_data['_multiwidget'] = $multiwidget;
							$new_widgets[$title] = $current_widget_data;
						}

						//Going to use for future functionality
					//if the sidebar does not exist, put the widget in the in-active
	//				else :
	//
	//					if(isset($sidebars_data['wp_inactive_widgets'])){ //if wp_inactive_widgets is set on the import
	//						foreach($sidebars_data[$import_sidebar] as $widget){ // just append all that sidebars widgets to the array
	//							$sidebars_data['wp_inactive_widets'][] = $widget;
	//					}
	//					} else { // if the wp_inactive_widets is not defined
	//						$sidebars_data['wp_inactive_widgets'] = $sidebars_data[$import_sidebar]; // just set the old array as the wp_inactive_widgets array
	//					}
	//					unset($sidebars_data[$import_sidebar]);  // remove old sidebar array in the import data

					endif;
				endforeach;
			endforeach;

			if(isset($new_widgets) && isset($current_sidebars)){
				update_option('sidebars_widgets', $current_sidebars);
				foreach($new_widgets as $title=>$content){
					update_option('widget_'.$title, $content);
				}

				return true;
			} else { return false; }
		}
		
		function export_widget_settings() {
			if($_POST) {
				header("Content-Description: File Transfer");
				header("Content-Disposition: attachment; filename=widgets.json");
				header("Content-Type: application/octet-stream");
				echo $json = $this->parse_export_data($_POST);
				exit();
			}
		}
		
		function widget_import_submit() {
			$widgets = $_POST['widgets'];
			$json_data = file_get_contents($_POST['import_file']);
			$json_data = json_decode($json_data, true);
			$sidebar_data = $json_data[0];
			$widget_data = $json_data[1];
			$remove_array = array();
			$sidebar_array = array();
			foreach($sidebar_data as $title=>&$sidebar){
				$count = count($sidebar);
				for($i=0;$i<$count;$i++){
					$widget = array();
					$widget['type'] = trim(substr($sidebar[$i], 0, strrpos($sidebar[$i], '-')));
					$widget['type-index'] = trim(substr($sidebar[$i], strrpos($sidebar[$i], '-') + 1));
					if(!isset($widgets[$widget['type']][$widget['type-index']])){
						unset($sidebar_data[$title][$i]);
					}
				}
				$sidebar_data[$title] = array_values($sidebar_data[$title]);
			}
			
			foreach($widgets as $widget_title=>$widget_value){
				foreach($widget_value as $k=>$v){
					$widgets[$widget_title][$k] = $widget_data[$widget_title][$k];
				}
			}
			
			$sidebar_data = array_filter($sidebar_data);
			$new_array = array($sidebar_data, $widgets);
			if($this->parse_import_data($new_array)){
				echo "SUCCESS";
			} else {
				echo "ERROR";
			}
			
			die(); // this is required to return a proper result
		}
		
		function get_widget_settings_json() {
			$widget_settings = $this->upload_widget_settings_file();
			$file_contents = file_get_contents($widget_settings['file']);
			return array($file_contents, $widget_settings['file']);
		}

		function upload_widget_settings_file() {
			if (isset($_FILES['upload-file'])) {
				$overrides = array('test_form' => false);
				$upload = wp_handle_upload($_FILES['upload-file'],$overrides);

				return $upload;
			}

			return false;
		}

		function get_new_widget_name($widget_name, $widget_index){
			$current_sidebars = get_option('sidebars_widgets');
			$all_widget_array = array();
			foreach($current_sidebars as $sidebar=>$widgets){
				if(!empty($widgets) && is_array($widgets) && $sidebar != 'wp_inactive_widgets') {
					foreach($widgets as $w){
						$all_widget_array[] = $w;
					}
				}
			}
			while(in_array($widget_name.'-'.$widget_index, $all_widget_array)){
				$widget_index++;
			}
			$new_widget_name = $widget_name.'-'.$widget_index;
			return $new_widget_name;
		}

		function get_option_from_array($option_name, $array_options) {
			foreach ($array_options as $name=>$option) :
				if ($name == $option_name)
					return $option;
			endforeach;

			return false;
		}

		function get_sidebar_info($sidebar_id) {
			global $wp_registered_sidebars;

			//since wp_inactive_widget is only used in widgets.php
			if ($sidebar_id == 'wp_inactive_widgets') :
				return array('name'=>'Inactive Widgets', 'id'=>'wp_inactive_widgets');
			endif;

			foreach ($wp_registered_sidebars as $sidebar) :
				if (isset ($sidebar['id']) && $sidebar['id'] == $sidebar_id) :
					return $sidebar;
				endif;
			endforeach;

			return false;
		}
		
		function get_widget_info($widget){
			global $wp_registered_widgets;
			if(isset($wp_registered_widgets[$widget])){
				return true;
			} else {
				return false;
			}
		}

		function order_sidebar_widgets($sidebar_widgets) {
			$inactive_widgets = false;

			//seperate inactive widget sidebar from other sidebars so it can be moved to the end of the array, if it exists
			if (isset($sidebar_widgets['wp_inactive_widgets'])) :
				$inactive_widgets = $sidebar_widgets['wp_inactive_widgets'];
				unset($sidebar_widgets['wp_inactive_widgets']);
				$sidebar_widgets['wp_inactive_widgets'] = $inactive_widgets;
			endif;

			return $sidebar_widgets;
		}
		
		function json_upload_mimes ( $existing_mimes=array() ) {
			$existing_mimes['json'] = 'application/json';
			return $existing_mimes;
		}

	}

	add_action('init', create_function('', 'new Widget_Data();'));
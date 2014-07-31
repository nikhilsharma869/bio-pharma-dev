<?php
/*
Plugin Name:Social Login for wordpress  
Plugin URI: http://www.LoginRadius.com
Description: Add Social Login and Social Sharing to your WordPress website and also get accurate User Profile Data and Social Analytics.
Version: 5.6.1
Author: LoginRadius Team
Author URI: http://www.LoginRadius.com
License: GPL2+
*/
$loginRadiusLoginIsBpActive = false;
require_once( 'LoginRadiusSDK.php' );
$loginRadiusObject = new LoginRadius();
require_once( 'LoginRadius-function.php' );
require_once( 'LoginRadius-widget.php' );
require_once( 'LoginRadius-admin.php' );

/**
 * This class handles the overall process of plugin.
 */
class Login_Radius_Social_Login
{
	// plugin database update version
	private static $loginRadiusVersion = '4.0';
	private static $loginRadiusProfileData;

	/**
	 * Load necessary scripts and CSS.
	 */
	public static function login_radius_init(){
		global $wpdb;
		if ( get_option( 'loginradius_version' ) != self::$loginRadiusVersion ) {
			$wpdb->query( "update " . $wpdb->usermeta . " set meta_key = 'loginradius_provider_id' where meta_key = 'id'" );
			$wpdb->query( "update " . $wpdb->usermeta . " set meta_key = 'loginradius_thumbnail' where meta_key = 'thumbnail'" );
			$wpdb->query( "update " . $wpdb->usermeta . " set meta_key = 'loginradius_verification_key' where meta_key = 'loginRadiusVkey'" );
			$wpdb->query( "update " . $wpdb->usermeta . " set meta_key = 'loginradius_isVerified' where meta_key = 'loginRadiusVerified'" );
			update_option( 'loginradius_version', self::$loginRadiusVersion );
		}
		add_action( 'parse_request', array( get_class(), 'login_radius_connect' )  );
		add_action( 'wp_enqueue_scripts', array( get_class(), 'login_radius_front_end_css' )  );
		if ( login_radius_scripts_in_footer_enabled() ) {
			add_action( 'wp_footer', array( get_class(), 'login_radius_front_end_scripts' ) );
			add_action( 'login_footer', array( get_class(), 'login_radius_front_end_scripts' ) );
		}else {
			add_action( 'wp_enqueue_scripts', array( get_class(), 'login_radius_front_end_scripts' )  );
		}
		add_filter( 'LR_logout_url', array( get_class(), 'log_out_url' ) , 20, 2 );
		add_action( 'login_head', 'wp_enqueue_scripts', 1 );
	}

	/**
	 * Include necessary scripts at front end
	 */
	public static function login_radius_front_end_scripts(){
		global $loginRadiusSettings;
		if ( ! wp_script_is( 'jquery' )  ) {
			@wp_deregister_script( 'jquery' );
			@wp_register_script( 'jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js', false, '1.7.1' );
			wp_enqueue_script( 'jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js', false, '1.7.1' );
		}
		if ( !is_user_logged_in() ) {
			login_radius_login_script();
		}
		?>
		<script>
		/**
		 * Call functions on window.onload
		 */
		function loginRadiusLoadEvent(func){
			var oldOnLoad = window.onload;
			if(typeof window.onload != 'function'){
				window.onload = func;
			}else{            
				window.onload = function(){
					oldOnLoad();
					func();
				}
			}
		}
		</script>
		<?php
		if ( ! isset( $loginRadiusSettings['LoginRadius_dummyemail'] ) || $loginRadiusSettings['LoginRadius_dummyemail'] == "notdummyemail" ) {
			global $wpdb;
			wp_enqueue_script('thickbox');
			wp_enqueue_style('thickbox');
			if ( isset( $_GET['lrid'] ) && trim( $_GET['lrid'] ) != '' && ! isset( $_POST['LoginRadius_popupSubmit'] ) ) {
				if ( isset( $_GET['LoginRadiusMessage'] ) ) {
					$key = trim( $_GET['lrid'] );
					$message = trim( $loginRadiusSettings['msg_existemail'] );
				} else {
					$loginRadiusTempUniqueId = $wpdb->get_var( $wpdb->prepare( "SELECT user_id FROM " . $wpdb->usermeta . " WHERE meta_key='tmpsession' AND meta_value = %s", trim( $_GET['lrid'] )  )  );
					if ( ! empty( $loginRadiusTempUniqueId )  ) {
						$key = trim( $_GET['lrid'] );
						$message = trim( $loginRadiusSettings['msg_email'] );
					}
				}
				$ajaxUrl = add_query_arg( 
					array(
						'height' => 1,
						'width' => 1,
						'action' => 'login_radius_email_popup',
						'key' => $key,
						'message' => urlencode($message),
					), 
					'admin-ajax.php'
				);
				//echo '<br/>'.admin_url().$ajaxUrl; die;
				?>
				<script>
				// show thickbox on window load
				loginRadiusLoadEvent(function(){
					tb_show('Email required', '<?php echo admin_url().$ajaxUrl; ?>');
				});
				
				// get trim() worked in IE 
				if(typeof String.prototype.trim !== 'function') {
					  String.prototype.trim = function() {
						return this.replace(/^\s+|\s+$/g, ''); 
					  }
				}
				var loginRadiusPopupSubmit = true;
				function loginRadiusValidateEmail(){
					if(!loginRadiusPopupSubmit){
						return true;
					}
					var email = document.getElementById('loginRadiusEmail').value.trim();
					var loginRadiusErrorDiv = document.getElementById('loginRadiusError');
					var atPosition = email.indexOf("@");
					var dotPosition = email.lastIndexOf(".");
					if(email == '' || atPosition < 1 || dotPosition < atPosition+2 || dotPosition+2>=email.length){
						loginRadiusErrorDiv.innerHTML = "<?php echo trim($loginRadiusSettings['msg_existemail']) != "" ? trim($loginRadiusSettings['msg_existemail']) : __('The email you have entered is either already registered or invalid. Please enter a valid email address.'); ?>";
						loginRadiusErrorDiv.style.backgroundColor = "rgb(255, 235, 232)";
						loginRadiusErrorDiv.style.border = "1px solid rgb(204, 0, 0)";
						loginRadiusErrorDiv.style.padding = "2px 5px";
						loginRadiusErrorDiv.style.width = "94%";
						loginRadiusErrorDiv.style.textAlign = "left";
						return false;
					}
					return true;
				}
				</script>
				<?php
			}
		}
		// message popup - "please verify your email by clicking the confirmation link....."
		if ( isset( $_GET['lrNotVerified'] ) && isset( $_GET['loginRadiusKey'] ) ) {
			$message = get_user_meta( $_GET['loginRadiusKey'], 'loginradius_tmpKey', true );
			$redirection = get_user_meta( $_GET['loginRadiusKey'], 'loginradius_tmpRedirection', true );
			delete_user_meta( $_GET['loginRadiusKey'], 'loginradius_tmpKey' );
			delete_user_meta( $_GET['loginRadiusKey'], 'loginradius_tmpRedirection' );
			if ( $message != '' ) {
				//self::login_radius_notify( __( $message, 'LoginRadius' ) , false );
				$args = array(
						'height' => 1,
						'width' => 1,
						'action' => 'login_radius_notification_popup',
						'key' => '',
						'message' => urlencode($message),
					);
				if ( $redirection != '' ) {
					$args['redirection'] = $redirection;
				}
				$ajaxUrl = add_query_arg( $args, 'admin-ajax.php' );
				?>
				<style type="text/css">
					#TB_window{
						margin-top: -45px !important;
					}
				</style>
				<script>
				// show thickbox on window load
				loginRadiusLoadEvent(function(){
					tb_show('Message', '<?php echo admin_url().$ajaxUrl; ?>');
				});
				</script>
				<?php
			}
		}
	}

	/**
	 * Include necessary stylesheets at front end.
	 */	
	public static function login_radius_front_end_css(){
		wp_register_style( 'LoginRadius-plugin-frontpage-css', plugins_url( 'css/loginRadiusStyle.css', __FILE__ ) , array(), '4.0.0', 'all' );
		wp_enqueue_style( 'LoginRadius-plugin-frontpage-css' );
	}

	/**
	 * Function that uses for logout.
	 */
	public static function log_out_url(){
		$redirect = get_permalink();
		$link     = '<a href="' . wp_logout_url( $redirect ) . '" title="' . _e( 'Logout', 'LoginRadius' ) . '">' . _e( 'Logout', 'LoginRadius' ) . '</a>';
		echo apply_filters( 'Login_Radius_log_out_url', $link );
	}

	/**
	 * Verify user after clicking confirmation link.
	 */
	private static function login_radius_verify(){
		global $wpdb, $loginRadiusSettings;
		$verificationKey = mysql_real_escape_string( trim( $_GET['loginRadiusVk'] )  );
		if ( isset( $_GET['loginRadiusProvider'] ) && trim( $_GET['loginRadiusProvider'] ) != '' ) {
			$provider = mysql_real_escape_string( trim( $_GET['loginRadiusProvider'] )  );
			$providerCheck = true;
		}else {
			$providerCheck = false;
		}
		if ( $providerCheck ) {
			$userId = $wpdb->get_var( $wpdb->prepare( "SELECT user_id FROM " . $wpdb->usermeta . " WHERE meta_key = '".$provider."LoginRadiusVkey' and meta_value = %s", $verificationKey )  );
		}else {
			$userId = $wpdb->get_var( $wpdb->prepare( "SELECT user_id FROM " . $wpdb->usermeta . " WHERE meta_key = 'loginradius_verification_key' and meta_value = %s", $verificationKey )  );
		}
		if ( ! empty( $userId )  ) {
			if ( $providerCheck ) {
				update_user_meta( $userId, $provider.'LrVerified', '1' );
				delete_user_meta( $userId, $provider.'LoginRadiusVkey', $verificationKey );
			}else {
				update_user_meta( $userId, 'loginradius_isVerified', '1' );
				delete_user_meta( $userId, 'loginradius_verification_key', $verificationKey );
			}
			// new user notification
			if ( isset( $loginRadiusSettings['LoginRadius_sendemail'] ) && $loginRadiusSettings['LoginRadius_sendemail'] == 'sendemail' ) {
				$userPassword = wp_generate_password();
				wp_update_user( array( 'ID' => $userId, 'user_pass' => $userPassword )  );
				wp_new_user_notification( $userId, $userPassword );
			}else {
				// notification to admin
				self::login_radius_send_verification_email( trim( get_option( 'admin_email' )  ) , '', '', 'admin notification', $userId );
			}
			if ( get_user_meta( $userId, 'loginradius_status', true ) === '0' ) {
				self::login_radius_notify( __( 'Your account is currently inactive. You will be notified through email, once Administrator activates your account.', 'LoginRadius' )  );
			}else {
				self::login_radius_notify( __( 'Your email has been successfully verified. Now you can login into your account.', 'LoginRadius' )  );
			}
		}else {
			wp_redirect( site_url() );
			exit();
		}
		return;
	}

	/**
	 * Link accountassociated with existing email to Social login.
	 */
	private static function login_radius_link_account( $userId, $socialId, $thumbnail, $provider ) {
		add_user_meta( $userId, 'loginradius_provider_id', $socialId );
		add_user_meta( $userId, 'loginradius_mapped_provider', $provider ); 
		add_user_meta( $userId, 'loginradius_'.$provider.'_id', $socialId );
		if ( $thumbnail != '' ) {
			add_user_meta( $userId, 'loginradius_'.$socialId.'_thumbnail', $thumbnail );
		}
	}

	/**
	 * Update user's verification status in the database and send verification email.
	 */
	private static function login_radius_update_status( $userId, $provider, $socialId, $email ) {
		$loginRadiusKey = $userId.time().mt_rand();
		update_user_meta( $userId, $provider.'Lrid', $socialId );
		update_user_meta( $userId, $provider.'LrVerified', '0' );
		update_user_meta( $userId, $provider.'LoginRadiusVkey', $loginRadiusKey );
		self::login_radius_send_verification_email( $email, $loginRadiusKey, $provider );
		self::login_radius_notify( __( 'Confirmation link has been sent to your email address. Please verify your email by clicking on confirmation link.', 'LoginRadius' )  );
	}
	
	/**
	 * Check if user accountassociated with the ID passed is verified or not.
	 */
	private static function login_radius_check_verification_status( $socialId, $provider ) {
		global $wpdb;
		$userId = $wpdb->get_var( $wpdb->prepare( "SELECT user_id FROM " . $wpdb->usermeta . " WHERE meta_key='".$provider."Lrid' AND meta_value = %s", $socialId )  );
		if ( ! empty( $userId )  ) {     // id exists
			return $userId;
		}else {					 // id doesn't exist
			return false;
		}
	}

	/**
	 * Update user profile data
	 */	
	public static function login_radius_update_profile_data( $userId ) {
		// create username, firstname and lastname
		$usernameFirstnameLastname = explode( '|LR|', self::login_radius_create_username( self::$loginRadiusProfileData )  );
		$username = $usernameFirstnameLastname[0];
		$firstName = $usernameFirstnameLastname[1];
		$lastName = $usernameFirstnameLastname[2];
		// fields going to be updated
		$profileData = array( 
			'ID' => $userId,
			'first_name' => $firstName,
			'last_name' => $lastName,
			'description' => self::$loginRadiusProfileData['Bio'],
			'user_url' => self::$loginRadiusProfileData['ProfileUrl'],
		);
		if ( wp_update_user( $profileData )  ) {
			update_user_meta( $userId, 'loginradius_thumbnail', self::$loginRadiusProfileData['Thumbnail'] );
			update_user_meta( $userId, 'loginradius_picture', self::$loginRadiusProfileData['PictureUrl'] );
		}
	}

	/**
	 * Login and redirect user
	 */	
	public static function login_radius_login_user( $userId, $socialId, $firstLogin = false, $register = false ) {
		if ( get_user_meta( $userId, 'loginradius_status', true ) === '0' ) {
			self::login_radius_notify( __( 'Your account is currently inactive. You will be notified through email, once Administrator activates your account.', 'LoginRadius' )  );
			return;
		}
		// update user profile data if option is set
		if ( ! $firstLogin ) {
			global $loginRadiusSettings;
			if ( isset( $loginRadiusSettings['profileDataUpdate'] ) && $loginRadiusSettings['profileDataUpdate'] == '1' ) {
				self::login_radius_update_profile_data( $userId );
			}
		}
		// set the current social login id
		update_user_meta( $userId, 'loginradius_current_id', $socialId );
		self::login_radius_set_cookies( $userId );
		// WP login hook
		$_user = get_user_by( 'id', $userId );
		do_action( 'wp_login', $_user->user_login, $_user );
		login_radius_redirect( $userId, $register );
	}
	
	/**
	 * Check for the query string variables and authenticate user.
	 */	
	public static function login_radius_connect(){
		global $wpdb, $loginRadiusSettings, $loginRadiusObject;
		// Social linking redirection
		if ( isset( $_GET['loginradius_linking'] ) && isset( $_REQUEST['token'] )  ) {
			if ( login_radius_mapping_status() === true ) {
				$linked = 1;
			}elseif ( login_radius_mapping_status() === false ) {
				$linked = 0;
			}
			
			$redirectionUrl = login_radius_get_protocol(). $_SERVER['HTTP_HOST'] . remove_query_arg( 'lrlinked' );
			if ( strpos( $redirectionUrl, '?' ) !== false ) {
				$redirectionUrl .= '&lrlinked=' . $linked;
			}else {
				$redirectionUrl .= '?lrlinked=' . $linked;
			}
			?>
			<script type="text/javascript">
				if ( window.opener ) {
					window.opener.location.href="<?php echo $redirectionUrl; ?>";
					window.close();
				}else {
					window.location.href="<?php echo $redirectionUrl; ?>";
				}
			</script>
			<?php
			die;
		}
		
		// email popup
		/*
		if ( isset( $_GET['lrid'] ) && trim( $_GET['lrid'] ) != '' && ! isset( $_POST['LoginRadius_popupSubmit'] )  ) {
			$loginRadiusTempUniqueId = $wpdb->get_var( $wpdb->prepare( "SELECT user_id FROM " . $wpdb->usermeta . " WHERE meta_key='tmpsession' AND meta_value = %s", trim( $_GET['lrid'] )  )  );
			if ( ! empty( $loginRadiusTempUniqueId )  ) {
				self::login_radius_display_popup( array( 'Provider' => $provider, 'UniqueId' => trim( $_GET['lrid'] )  ) , htmlspecialchars( trim( $loginRadiusSettings['msg_email'] )  )  );
				return;
			}
		}
		*/
		// notification
		/*
		if ( isset( $_GET['lrNotVerified'] ) && isset( $_GET['loginRadiusKey'] ) ) {
			$message = get_user_meta( $_GET['loginRadiusKey'], 'loginradius_tmpKey', true );
			delete_user_meta( $_GET['loginRadiusKey'], 'loginradius_tmpKey' );
			if ( $message != '' ) {
				self::login_radius_notify( __( $message, 'LoginRadius' ) , false );
			}
			return;
		}
		*/
		// email verification
		if ( isset( $_GET['loginRadiusVk'] ) && trim( $_GET['loginRadiusVk'] ) != '' ) {
			self::login_radius_verify();
		}
		$loginRadiusSecret = isset( $loginRadiusSettings['LoginRadius_secret'] ) ? $loginRadiusSettings['LoginRadius_secret'] : '';
		$dummyEmail = isset( $loginRadiusSettings['LoginRadius_dummyemail'] ) ? $loginRadiusSettings['LoginRadius_dummyemail'] : '';
		$profileData = array();
		global $loginRadiusObject;
		$userProfileObject = $loginRadiusObject -> login_radius_get_userprofile_data( $loginRadiusSecret );
		if ( $loginRadiusObject -> IsAuthenticated == true && ! is_user_logged_in() && ! is_admin() ) {
			self::$loginRadiusProfileData = self::login_radius_validate_profiledata( $userProfileObject );
			// check for social id in the database 
			// check if already verified or pending
			$loginRadiusProvider = self::$loginRadiusProfileData['Provider'];
			$userId = self::login_radius_check_verification_status( self::$loginRadiusProfileData['SocialId'], $loginRadiusProvider );
			if ( $userId != false ) {
				$isVerified = get_user_meta( $userId, $loginRadiusProvider.'LrVerified', true );
				if ( $isVerified == '1' ) {											// Check if lrid is the same that verified email.
					self::login_radius_login_user( $userId, self::$loginRadiusProfileData['SocialId'] );					// login user
					return;
				}else {															// Notify user to verify email
					self::login_radius_notify( __( 'Please verify your email by clicking the confirmation link sent to you.', 'LoginRadius' )  );
					return;
				}
			}
			// check if id already exists.
			$loginRadiusUserId = $wpdb->get_var( $wpdb->prepare( "SELECT user_id FROM " . $wpdb->usermeta . " WHERE meta_key='loginradius_provider_id' AND meta_value = %s", self::$loginRadiusProfileData['SocialId'] )  );
			if ( ! empty( $loginRadiusUserId )  ) {										// id exists
				$tempUserId = $wpdb->get_var( $wpdb->prepare( "SELECT user_id FROM " . $wpdb->usermeta . " WHERE user_id = %d and meta_key='loginradius_isVerified'", $loginRadiusUserId )  );
				if ( ! empty( $tempUserId )  ) { 
					// check if verification field exists.
					$isVerified = $wpdb->get_var( $wpdb->prepare( "SELECT meta_value FROM " . $wpdb->usermeta . " WHERE user_id = %d and meta_key='loginradius_isVerified'", $loginRadiusUserId )  );
					if ( $isVerified == '1' ) {								// if email is verified
						self::login_radius_login_user( $loginRadiusUserId, self::$loginRadiusProfileData['SocialId'] );
						return;
					}else {
						self::login_radius_notify( __( 'Please verify your email by clicking the confirmation link sent to you.', 'LoginRadius' )  );
						return;
					}
				}else {
					self::login_radius_login_user( $loginRadiusUserId, self::$loginRadiusProfileData['SocialId'] );
					return;
				}
			}else {															// id doesn't exist
				if ( empty( self::$loginRadiusProfileData['Email'] )  ) {							// email is empty
					if ( $dummyEmail == 'dummyemail' ) {						// email not required
						self::$loginRadiusProfileData['Email'] = self::login_radius_get_random_email( self::$loginRadiusProfileData );
						if ( ! self::login_radius_allow_registration() ) {
							return;
						}
						self::login_radius_create_user( self::$loginRadiusProfileData );
						return;
					}else {													// email required
						if ( ! self::login_radius_allow_registration() ) {
							return;	
						}
						$lrUniqueId = self::login_radius_store_temporary_data( self::$loginRadiusProfileData );
						login_radius_close_window( $lrUniqueId );
						// save data temporarily
						self::login_radius_display_popup( self::$loginRadiusProfileData, htmlspecialchars( trim( $loginRadiusSettings['msg_email'] ) ) );	// show popup
					}
				}else {															// email is not empty
					$userObject = get_user_by( 'email', self::$loginRadiusProfileData['Email'] );
					$loginRadiusUserId = is_object( $userObject ) ? $userObject->ID : '';
					if ( ! empty( $loginRadiusUserId )  ) {								// email exists
						$isVerified = $wpdb->get_var( $wpdb->prepare( "SELECT meta_value FROM " . $wpdb->usermeta . " WHERE user_id = %d and meta_key='loginradius_isVerified'", $loginRadiusUserId )  );
						if ( ! empty( $isVerified )  ) { 
							if ( $isVerified == '1' ) {	
								// social linking
								self::login_radius_link_account( $loginRadiusUserId, self::$loginRadiusProfileData['SocialId'], self::$loginRadiusProfileData['Thumbnail'], self::$loginRadiusProfileData['Provider'] );
								// Login user
								self::login_radius_login_user( $loginRadiusUserId, self::$loginRadiusProfileData['SocialId'] );
								return;
							}else {
								if ( ! self::login_radius_allow_registration() ) {
									return;	
								}
								$directorySeparator = DIRECTORY_SEPARATOR;
								require_once( getcwd().$directorySeparator.'wp-admin'.$directorySeparator.'includes'.$directorySeparator.'user.php' );
								wp_delete_user( $loginRadiusUserId );
								self::login_radius_create_user( self::$loginRadiusProfileData );
							}
						}else {
							if ( get_user_meta( $loginRadiusUserId, 'loginradius_provider_id', true ) != false ) {
								// social linking
								self::login_radius_link_account( $loginRadiusUserId, self::$loginRadiusProfileData['SocialId'], self::$loginRadiusProfileData['Thumbnail'], self::$loginRadiusProfileData['Provider'] );
							}else {
								// traditional account					
								// social linking
								if ( isset( $loginRadiusSettings['LoginRadius_socialLinking'] ) && ( $loginRadiusSettings['LoginRadius_socialLinking'] == 1 )  ) {
									self::login_radius_link_account( $loginRadiusUserId, self::$loginRadiusProfileData['SocialId'], self::$loginRadiusProfileData['Thumbnail'], self::$loginRadiusProfileData['Provider'] );
								}
							}
							// Login user
							self::login_radius_login_user( $loginRadiusUserId, self::$loginRadiusProfileData['SocialId'] );
							return;
						}
					}else {
						if ( ! self::login_radius_allow_registration() ) {
							return;	
						}
						self::login_radius_create_user( self::$loginRadiusProfileData );						// create new user
					}
				}
			}
		} // Authentication ends
		
		// check if "email required" popup has been submitted
		if ( isset( $_POST['LoginRadius_popupSubmit'] )  ) {
			if ( $_POST['LoginRadius_popupSubmit'] == 'Submit' ) {
				$loginRadiusEmail = mysql_real_escape_string( trim( $_POST['email'] )  );
				if ( ! is_email( $loginRadiusEmail )  ) {
					// If email not in correct format.
					$loginRadiusMessage = '<p style=\'color:red;\'>' . trim( strip_tags( $loginRadiusSettings['msg_existemail'] )  ) . '</p>';
					$profileData['UniqueId'] = trim( $_POST['session'] );
					//self::login_radius_display_popup( $profileData, $loginRadiusMessage );
					$redirectUrl = add_query_arg( 
						array(
							'lrid' => $profileData['UniqueId'],
							'LoginRadiusMessage' => urlencode( 'invalid email' ),
						), 
						site_url()
					);
					wp_redirect( $redirectUrl );
					die;
				}else {
					// Email is in correct format.
					$profileData = array();
					$loginRadiusTempUserId   = $wpdb->get_var( $wpdb->prepare( 'SELECT user_id FROM ' . $wpdb->usermeta . ' WHERE meta_key=\'tmpsession\' AND meta_value = %s', $_POST['session'] )  );
					$profileData['UniqueId'] = get_user_meta( $loginRadiusTempUserId, 'tmpsession', true );
					if ( isset( $profileData['UniqueId'] ) && isset( $_POST['session'] ) && $profileData['UniqueId'] == $_POST['session'] ) {
						// if email exists.
						if ( $loginRadiusUserId = email_exists( $loginRadiusEmail ) ) {
							$loginRadiusProvider = get_user_meta( $loginRadiusTempUserId, 'tmpProvider', true );
							$loginRadiusId = get_user_meta( $loginRadiusTempUserId, 'tmpid', true );
							// Check if email is verified for this provider.
							if ( get_user_meta( $loginRadiusUserId, 'loginradius_provider', true ) == $loginRadiusProvider && get_user_meta( $loginRadiusUserId, 'loginradius_isVerified', true ) == '1' ) {
								// Email is already registered.
								$loginRadiusMessage = '<p style=\'color:red;\'>' . trim( strip_tags( $loginRadiusSettings['msg_existemail'] )  ) . '</p>';
								$profileData['UniqueId'] = $_POST['session'];
								//self::login_radius_display_popup( $profileData, $loginRadiusMessage );
								//return;
								$redirectUrl = add_query_arg( 
									array(
										'lrid' => $profileData['UniqueId'],
										'LoginRadiusMessage' => urlencode( 'invalid email' ),
									), 
									site_url()
								);
								wp_redirect( $redirectUrl );
								die;
							}elseif ( get_user_meta( $loginRadiusUserId, 'loginradius_provider', true ) == $loginRadiusProvider ) {
								$directorySeparator = DIRECTORY_SEPARATOR;
								require_once( getcwd().$directorySeparator.'wp-admin'.$directorySeparator.'includes'.$directorySeparator.'user.php' );
								wp_delete_user( $loginRadiusUserId );
								// New user.
								$profileData['UniqueId']    = get_user_meta( $loginRadiusTempUserId, 'tmpsession', true );
								$profileData['SocialId']    = get_user_meta( $loginRadiusTempUserId, 'tmpid', true );
								$profileData['FullName']    = get_user_meta( $loginRadiusTempUserId, 'tmpFullName', true );
								$profileData['ProfileName'] = get_user_meta( $loginRadiusTempUserId, 'tmpProfileName', true );
								$profileData['NickName']    = get_user_meta( $loginRadiusTempUserId, 'tmpNickName', true );
								$profileData['FirstName']   = get_user_meta( $loginRadiusTempUserId, 'tmpFname', true );
								$profileData['LastName']    = get_user_meta( $loginRadiusTempUserId, 'tmpLname', true );
								$profileData['Provider']    = get_user_meta( $loginRadiusTempUserId, 'tmpProvider', true );
								$profileData['Thumbnail']   = get_user_meta( $loginRadiusTempUserId, 'tmpthumbnail', true );
								$profileData['Bio']         = get_user_meta( $loginRadiusTempUserId, 'tmpaboutme', true );
								$profileData['ProfileUrl']  = get_user_meta( $loginRadiusTempUserId, 'tmpwebsite', true );
								$profileData['Email'] = mysql_real_escape_string( trim( $_POST['email'] )  );
								if ( ! self::login_radius_allow_registration() ) {
									return;	
								}
								self::login_radius_create_user( $profileData, true );
								return;
							}
							$loginRadiusUserID = $wpdb->get_var( $wpdb->prepare( "SELECT user_id FROM " . $wpdb->usermeta . " WHERE user_id=%d and meta_key='".$loginRadiusProvider."LrVerified' AND meta_value = '1'", $loginRadiusUserId ) );
							if ( ! empty( $loginRadiusUserID )  ) {
								// if email is verified for this provider.
								$loginRadiusTempUserID = $wpdb->get_var( $wpdb->prepare( "SELECT user_id FROM " . $wpdb->usermeta . " WHERE user_id=%d and meta_key='".$loginRadiusProvider."Lrid' AND meta_value = %s", $loginRadiusUserId, $loginRadiusId ) );
								if ( ! empty( $loginRadiusTempUserID )  ) {
									// If the user is the one who verified email, login user.
									self::login_radius_login_user( $loginRadiusTempUserID, $profileData['SocialId'] );
								}else {
									// This is not the user who verified email.
									$loginRadiusMessage = '<p style=\'color:red;\'>' . trim( strip_tags( $loginRadiusSettings['msg_existemail'] )  ) . '</p>';
									$profileData['UniqueId'] = $_POST['session'];
									self::login_radius_display_popup( $profileData, $loginRadiusMessage );
								}
							}else {
								// Check if verification is pending for this provider.
								$loginRadiusUnverifiedId = $wpdb->get_var( $wpdb->prepare( "SELECT user_id FROM " . $wpdb->usermeta . " WHERE user_id=%d and meta_key='".$loginRadiusProvider."LrVerified' AND meta_value = '0'", $loginRadiusUserId )  );
								if ( ! empty( $loginRadiusUnverifiedId )  ) {
									// Verification pending.
									$loginRadiusProviderId = get_user_meta( $loginRadiusUserId, $loginRadiusProvider.'Lrid', true );
									if ( $loginRadiusProviderId == $loginRadiusId ) {
										// If verification pending for this login radius id, show notification.
										self::login_radius_notify( __( 'Please verify your email by clicking the confirmation link sent to you.', 'LoginRadius' )  );
									}else {
										self::login_radius_update_status( $loginRadiusUserId, $loginRadiusProvider, $loginRadiusId, $loginRadiusEmail );
									}
								}else {
									self::login_radius_update_status( $loginRadiusUserId, $loginRadiusProvider, $loginRadiusId, $loginRadiusEmail );
								}
							}
						}else {	 												// existing email check ends
							// New user.
							$profileData['UniqueId']    = get_user_meta( $loginRadiusTempUserId, 'tmpsession', true );
							$profileData['SocialId']    = get_user_meta( $loginRadiusTempUserId, 'tmpid', true );
							$profileData['FullName']    = get_user_meta( $loginRadiusTempUserId, 'tmpFullName', true );
							$profileData['ProfileName'] = get_user_meta( $loginRadiusTempUserId, 'tmpProfileName', true );
							$profileData['NickName']    = get_user_meta( $loginRadiusTempUserId, 'tmpNickName', true );
							$profileData['FirstName']   = get_user_meta( $loginRadiusTempUserId, 'tmpFname', true );
							$profileData['LastName']    = get_user_meta( $loginRadiusTempUserId, 'tmpLname', true );
							$profileData['Provider']    = get_user_meta( $loginRadiusTempUserId, 'tmpProvider', true );
							$profileData['Thumbnail']   = get_user_meta( $loginRadiusTempUserId, 'tmpthumbnail', true );
							$profileData['Bio']         = get_user_meta( $loginRadiusTempUserId, 'tmpaboutme', true );
							$profileData['ProfileUrl']  = get_user_meta( $loginRadiusTempUserId, 'tmpwebsite', true );
							$profileData['Email'] = mysql_real_escape_string( trim( $_POST['email'] )  );
							if ( ! self::login_radius_allow_registration() ) {
								return;	
							}
							self::login_radius_create_user( $profileData, true );
						}
					}
				}
			}else {
				self::login_radius_delete_temporary_data( array( 'UniqueId' => trim( $_POST['session'] )  )  );
				wp_redirect( site_url() );
				exit();
			}
		}
	} //connect ends

	/**
	 * check if new user registration is allowed
	 */
	private static function login_radius_allow_registration(){
		global $loginRadiusSettings;
		if ( isset( $loginRadiusSettings['LoginRadius_disableRegistration'] ) && $loginRadiusSettings['LoginRadius_disableRegistration'] == '1' ) {
			wp_redirect( site_url( '/wp-login.php?registration=disabled' ) );
			exit();
		}
		return true;
	}

	/**
	 * Create username, firstname and lastname.
	 */
	private static function login_radius_create_username( $profileData ) {
		$username  = '';
		$firstName = '';
		$lastName  = '';
		if ( ! empty( $profileData['FirstName'] ) && ! empty( $profileData['LastName'] )  ) {
			$username  = $profileData['FirstName'] . ' ' . $profileData['LastName'];
			$firstName = $profileData['FirstName'];
			$lastName  = $profileData['LastName'];
		}elseif ( ! empty( $profileData['FullName'] )  ) {
			$username  = $profileData['FullName'];
			$firstName = $profileData['FullName'];
		}
		elseif ( ! empty( $profileData['ProfileName'] )  ) {
			$username  = $profileData['ProfileName'];
			$firstName = $profileData['ProfileName'];
		}
		elseif ( ! empty( $profileData['NickName'] )  ) {
			$username  = $profileData['NickName'];
			$firstName = $profileData['NickName'];
		}elseif ( ! empty( $email )  ) {
			$user_name = explode( '@', $email );
			$username  = $user_name[0];
			$firstName = str_replace( '_', ' ', $user_name[0] );
		}else {
			$username  = $profileData['SocialId'];
			$firstName = $profileData['SocialId'];
		}
		return $username . '|LR|' . $firstName . '|LR|' . $lastName;
	}
	/**
	 * Create new user.
	 */
	private static function login_radius_create_user( $profileData, $loginRadiusPopup = false ) {
		global $wpdb, $loginRadiusSettings; 
		$dummyEmail   = $loginRadiusSettings['LoginRadius_dummyemail'];
		$userPassword = wp_generate_password();
		$bio          = $profileData['Bio'];
		$profileUrl   = $profileData['ProfileUrl'];
		$socialId     = $profileData['SocialId'];
		$thumbnail    = $profileData['Thumbnail'];
		if ( isset( $socialId ) && ! empty( $socialId )  ) {
			if ( ! empty( $profileData['Email'] )  ) {
				$email = $profileData['Email'];
			}
			// create username, firstname and lastname
			$usernameFirstnameLastname = explode( '|LR|', self::login_radius_create_username( $profileData ) );
			$username = $usernameFirstnameLastname[0];
			$firstName = $usernameFirstnameLastname[1];
			$lastName = $usernameFirstnameLastname[2];
			
			$role       = get_option( 'default_role' );
			$sendemail = $loginRadiusSettings['LoginRadius_sendemail'];
			//look for user with username match	
			$nameexists = true;
			$index      = 0;
			$username   = str_replace( ' ', '-', $username );
			$userName   = $username;
			while ( $nameexists == true ) {
				if ( username_exists( $userName ) != 0 ) {
					$index++;
					$userName = $username.$index;
				}else {
					$nameexists = false;
				}
			}
			$username = $userName;
			$userdata = array( 
				'user_login' => $username,
				'user_pass' => $userPassword,
				'user_nicename' => sanitize_title( $firstName ),
				'user_email' => $email,
				'display_name' => $firstName,
				'nickname' => $firstName,
				'first_name' => $firstName,
				'last_name' => $lastName,
				'description' => $bio,
				'user_url' => $profileUrl,
				'role' => $role,
			);
			$user_id = wp_insert_user( $userdata );
			// check if error due to empty user_login
			if ( isset( $user_id -> errors ) && isset( $user_id -> errors['empty_user_login'] ) ) {
				$userdata['user_login'] = strtoupper( $profileData['Provider'] ) . $socialId;
				$user_id = wp_insert_user( $userdata );
			}
			self::login_radius_delete_temporary_data( $profileData );
			if ( ! is_wp_error( $user_id )  ) {
				if ( ! empty( $socialId )  ) {
					update_user_meta( $user_id, 'loginradius_provider_id', $socialId );
				}
				if ( ! empty( $thumbnail )  ) {
					update_user_meta( $user_id, 'loginradius_thumbnail', $thumbnail );
				}
				if ( ! empty( $profileData['PictureUrl'] ) ) {
					update_user_meta( $user_id, 'loginradius_picture', $profileData['PictureUrl'] );
				}
				if ( ! empty( $profileData['Provider'] )  ) {
					update_user_meta( $user_id, 'loginradius_provider', $profileData['Provider'] );
				}
				if ( $loginRadiusPopup ) {
					$loginRadiusKey = $user_id.time().mt_rand();
					update_user_meta( $user_id, 'loginradius_verification_key', $loginRadiusKey );
					update_user_meta( $user_id, 'loginradius_isVerified', '0' );
					self::login_radius_send_verification_email( $email, $loginRadiusKey );
					// set status
					if ( isset( $loginRadiusSettings['LoginRadius_defaultUserStatus'] ) && $loginRadiusSettings['LoginRadius_defaultUserStatus'] == '0' ) {
						update_user_meta( $user_id, 'loginradius_status', '0' );
					}else {
						update_user_meta( $user_id, 'loginradius_status', '1' );
					}
					self::login_radius_notify( __( 'Confirmation link has been sent to your email address. Please verify your email by clicking on confirmation link.', 'LoginRadius' )  );
					return;
				}
				if (  ( $sendemail == 'sendemail' )  ) {
					if (  ( $dummyEmail == 'notdummyemail' ) && ( $loginRadiusPopup == true )  ) {
					}else {
						wp_new_user_notification( $user_id, $userPassword );
					}
				}else {
					// notification to admin
					self::login_radius_send_verification_email( trim( get_option( 'admin_email' )  ) , '', '', 'admin notification', $user_id );
				}
				// set status if option is enabled
				if ( isset( $loginRadiusSettings['LoginRadius_enableUserActivation'] ) && $loginRadiusSettings['LoginRadius_enableUserActivation'] == '1' ) {
					if ( isset( $loginRadiusSettings['LoginRadius_defaultUserStatus'] ) && $loginRadiusSettings['LoginRadius_defaultUserStatus'] == '0' ) {
						update_user_meta( $user_id, 'loginradius_status', '0' );
						self::login_radius_notify( __( 'Your account is currently inactive. You will be notified through email, once Administrator activates your account.', 'LoginRadius' )  );
						return;
					}else {
						update_user_meta( $user_id, 'loginradius_status', '1' );
					}
				}
				self::login_radius_login_user( $user_id, $socialId, true, true );
			}else {
				login_radius_redirect( $user_id );
			}
		}
	}

	/**
	 * Function that verify new wp user.
	 */
	public static function login_radius_send_verification_email( $loginRadiusEmail, $loginRadiusKey, $loginRadiusProvider = '', $emailType = '', $username = '' ) {
		if ( $emailType == 'activation' ) {
			$loginRadiusSubject = '[' . htmlspecialchars( trim( get_option( 'blogname' )  )  ) . '] AccountActivation';
			$loginRadiusMessage = 'Hi ' . $username . ", \r\n".
								'Your account has been activated at ' . site_url() . '. Now you can login to your account.';
		}elseif ( $emailType == 'admin notification' ) {
			$user = get_userdata( $username );
			$loginRadiusSubject = '[' . htmlspecialchars( trim( get_option( 'blogname' )  )  ) . '] New User Registration';
			$loginRadiusMessage = 'New user registration on your site ' . htmlspecialchars( trim( get_option( 'blogname' )  )  )  . ": \r\n".
				'Username: ' . $user->user_login . " \r\n".
				'E-mail: ' . $user->user_email . '';
		}else {
			$loginRadiusSubject = '[' . htmlspecialchars( trim( get_option( 'blogname' )  )  ) . '] Email Verification';
			$loginRadiusUrl     = site_url() . '?loginRadiusVk=' . $loginRadiusKey;
			if ( ! empty( $loginRadiusProvider )  ) {
				$loginRadiusUrl .= '&loginRadiusProvider='.$loginRadiusProvider;
			}
			$loginRadiusMessage = "Please click on the following link or paste it in browser to verify your email \r\n".$loginRadiusUrl;
		}
		$headers = "MIME-Version: 1.0\n" .
		"Content-Type: text/plain; charset='" .
		get_option( 'blog_charset' )  . "\"\n" . 
		'From: <no-reply@loginradius.com>';
		wp_mail( $loginRadiusEmail, $loginRadiusSubject, $loginRadiusMessage, $headers );
	}

	/**
	 * Function that asking for enter email.
	 */
	private static function login_radius_display_popup( $profileData, $loginRadiusMessage ) {
		$output = '<div class="LoginRadius_overlay" id="fade"><div id="popupouter"><div id="popupinner"><div id="textmatter">';
		if ( $loginRadiusMessage ) {
			$output .= '<b>' . $loginRadiusMessage . '</b>';
		}
		$output .= '</div><form method="post" action=\'\'><div><input type="text" name="email" id="email" class="loginRadiusInputTxt"/></div><div><input type="submit" id="LoginRadius_popupSubmit" name="LoginRadius_popupSubmit" value="Submit" class="inputbutton"><input type="Submit" name="LoginRadius_popupSubmit" value="Cancel" class="inputbutton" /> <input type="hidden" value="'.$profileData['UniqueId'].'" name = "session"/> <input type="hidden" value="'.$profileData['Provider'].'" name = "lrProvider"/>';
		$output .= '</div></form></div></div></div>';
		print $output;
	}

	/**
	 * Function that asking for enter email.
	 */
	private static function login_radius_notify( $loginRadiusMsg, $closeWindow = true, $redirection = '' ) {
		if ( $closeWindow ) {
			// save the notification in database
			$key = mt_rand();
			update_user_meta( $key, 'loginradius_tmpKey', $loginRadiusMsg );
			if ( $redirection ) {
				update_user_meta( $key, 'loginradius_tmpRedirection', $redirection );
			}
			login_radius_close_window( '', 'lrNotVerified', $key );
		}	
		/*
		$output  = '<div class="LoginRadius_overlay" id="fade"><div id="popupouter"><div id="popupinner"><div id="textmatter">';
		$output .= '<b> ' . $loginRadiusMsg . ' </b>';
		if ( $redirection ) {
			$output .= '</div><form method="post" action=\'\'><div><input type="button" value="OK" class="inputbutton" onclick="location.href = \''.$redirection.'\'"></div></form></div></div></div>';
		}else {
			$output .= '</div><form method="post" action="'.remove_query_arg( array( 'lrNotVerified', 'lrid', 'loginRadiusKey' )  ) .'"><div><input type="submit" value="OK" class="inputbutton"></div></form></div></div></div>';
		}
		print $output;
		*/
		$queryString = '?lrNotVerified=1&loginRadiusKey=' . $key;
		wp_redirect( site_url() . $queryString );
		die; 
	}

	/**
	 * Set cookies.
	 */
	private static function login_radius_set_cookies( $userId = 0, $remember = true ) {
		wp_clear_auth_cookie();
		wp_set_auth_cookie( $userId, $remember );
		wp_set_current_user( $userId );
		return true;
	}

	/**
	 * Store temporary data in database.
	 */
	private static function login_radius_store_temporary_data( $profileData ) {
		$tmpdata = array();
		$tmpdata['tmpsession']     = $profileData['UniqueId'];
		$tmpdata['tmpid']          = $profileData['SocialId'];
		$tmpdata['tmpFullName']    = $profileData['FullName'];
		$tmpdata['tmpProfileName'] = $profileData['ProfileName'];
		$tmpdata['tmpNickName']    = $profileData['NickName'];
		$tmpdata['tmpFname']       = $profileData['FirstName'];
		$tmpdata['tmpLname']       = $profileData['LastName'];
		$tmpdata['tmpProvider']    = $profileData['Provider'];
		$tmpdata['tmpthumbnail']   = $profileData['Thumbnail'];
		$tmpdata['tmpaboutme']     = $profileData['Bio'];
		$tmpdata['tmpwebsite']     = $profileData['ProfileUrl'];
		$tmpdata['tmpEmail']       = $profileData['Email'];
		$uni_id    = $tmpdata['tmpsession'];
		$uniqu_id  = explode( '.',$uni_id );
		$unique_id = $uniqu_id[1];
		if ( ! is_numeric( $unique_id )  ) {
			$unique_id = rand();
		}
		foreach ( $tmpdata as $key => $value ) {
			update_user_meta( $unique_id, $key, $value );
		}
		return $profileData['UniqueId'];
	}

	/**
	 * Delete temporary data from database.
	 */
	private static function login_radius_delete_temporary_data( $profileData ) {
		$uni_id    = $profileData['UniqueId'];
		$uniqu_id  = explode( '.',$uni_id );
		$unique_id = $uniqu_id[1];
		$keys = array( 'tmpid', 'tmpsession', 'tmpEmail', 'tmpFullName', 'tmpProfileName', 'tmpNickName', 'tmpFname', 'tmpLname', 'tmpProvider', 'tmpthumbnail', 'tmpaboutme', 'tmpwebsite' ); 
		foreach ( $keys as $key ) {
			delete_user_meta( $unique_id, $key );
		}
	}

	/**
	 * Filter the data fetched from LoginRadius.
	 */
	private static function login_radius_validate_profiledata( $userProfileObject ) {
		$profileData['SocialId']    = ( ! empty( $userProfileObject->ID ) ? $userProfileObject->ID : '' );
		$profileData['UniqueId']    = uniqid( 'LoginRadius_', true );
		$profileData['Email']       = isset( $userProfileObject->Email[0]->Value ) ? $userProfileObject->Email[0]->Value : '';
		$profileData['FullName']    = ( ! empty( $userProfileObject->FullName ) ? $userProfileObject->FullName : '' );
		$profileData['ProfileName'] = ( ! empty( $userProfileObject->ProfileName ) ? $userProfileObject->ProfileName : '' );
		$profileData['NickName']    = ( ! empty( $userProfileObject->NickName ) ? $userProfileObject->NickName : '' );
		$profileData['FirstName']   = ( ! empty( $userProfileObject->FirstName ) ? $userProfileObject->FirstName : '' );
		$profileData['LastName']    = ( ! empty( $userProfileObject->LastName ) ? $userProfileObject->LastName : '' );
		$profileData['Provider']    = ( ! empty( $userProfileObject->Provider ) ? $userProfileObject->Provider : '' );
		$profileData['Thumbnail']   = ( ! empty( $userProfileObject->ThumbnailImageUrl ) ? trim( $userProfileObject->ThumbnailImageUrl ) : '' );
		$profileData['PictureUrl']   = ( ! empty( $userProfileObject->ImageUrl ) ? trim( $userProfileObject->ImageUrl ) : '' );
		if ( empty( $profileData['Thumbnail'] ) && $profileData['Provider'] == 'facebook' ) {
			$profileData['Thumbnail'] = 'http://graph.facebook.com/' . $profileData['SocialId'] . '/picture?type=square';
		}
		$profileData['Bio'] = ( ! empty( $userProfileObject->About ) ? $userProfileObject->About : '' );
		$profileData['ProfileUrl'] = ( ! empty( $userProfileObject->ProfileUrl ) ? $userProfileObject->ProfileUrl : '' );
		return $profileData;
	}

	/**
	 * Generate a dummy email.
	 */
	private static function login_radius_get_random_email( $profileData ) {
		switch ( $profileData['Provider'] ) {
			case 'twitter':
				$profileData['Email'] = $profileData['SocialId'] . '@' . $profileData['Provider'] . '.com';
				break;
			case 'linkedin':
				$profileData['Email'] = $profileData['SocialId'] . '@' . $profileData['Provider'] . '.com';
				break;
			case 'renren':
				$profileData['Email'] = $profileData['SocialId'] . '@' . $profileData['Provider'] . '.com';
				break;
			default:
				$email = substr( $profileData['SocialId'], 7 );
				$tempEmail = str_replace( '/', '_', $email );
				$profileData['Email'] = str_replace( '.', '_', $tempEmail ) . '@' . $profileData['Provider'] . '.com';
			break;
		}
		return $profileData['Email'];
	}
}// Class ends.
add_action( 'init', array( 'Login_Radius_Social_Login', 'login_radius_init' )  );

/**
 * Replace default avatar with social avatar
 */
function login_radius_social_avatar( $avatar, $avuser, $size, $default, $alt = '' ) {
	global $loginRadiusSettings;
	$userId = null;
	if ( is_numeric( $avuser )  ) {
		if ( $avuser > 0 ) {
			$userId = $avuser;
		}
	}elseif ( is_object( $avuser )  ) {
		if ( property_exists( $avuser, 'user_id' ) AND is_numeric( $avuser -> user_id )  ) {
			$userId = $avuser -> user_id;
		}
	}
	if ( ! empty( $userId )  ) {
		$avatarType = 'thumbnail';
		if ( $loginRadiusSettings['LoginRadius_socialavatar'] == 'largeavatar' ) {
			$avatarType = 'picture';
		}
		
		$currentSocialId = get_user_meta( $userId, 'loginradius_current_id', true );
		if (  ( $userAvatar = get_user_meta( $userId, 'loginradius_'.$currentSocialId.'_'.$avatarType, true )  ) !== false && strlen( trim( $userAvatar )  ) > 0 ) {
			return '<img alt="' . esc_attr( $alt ) . '" src="' . $userAvatar . '" class="avatar avatar-' . $size . ' " height="' . $size . '" width="' . $size . '" />';
		}elseif (  ( $userAvatar = get_user_meta( $userId, 'loginradius_'.$avatarType, true )  ) !== false && strlen( trim( $userAvatar )  ) > 0 ) {
			return '<img alt="' . esc_attr( $alt ) . '" src="' . $userAvatar . '" class="avatar avatar-' . $size . ' " height="' . $size . '" width="' . $size . '" />';
		}
	}
	return $avatar;
}
if ( isset( $loginRadiusSettings['LoginRadius_socialavatar'] ) && ( $loginRadiusSettings['LoginRadius_socialavatar'] == 'socialavatar' || $loginRadiusSettings['LoginRadius_socialavatar'] == 'largeavatar' ) ) {
	add_filter( 'get_avatar', 'login_radius_social_avatar', 10, 5 );
}

/**
 * Load the plugin's translated scripts
 */
function login_radius_init_locale(){
	load_plugin_textdomain( 'LoginRadius', false, basename( dirname( __FILE__ )  ) . '/i18n' );
}
add_filter( 'init', 'login_radius_init_locale' );

/**
 * Add the LoginRadius menu in the left sidebar in the admin
 */
function login_radius_admin_menu(){
	$page = @add_menu_page( 'LoginRadius', '<b>LoginRadius</b>', 'manage_options', 'LoginRadius', 'login_radius_option_page', plugins_url( 'images/favicon.ico', __FILE__ )  );
	@add_action( 'admin_print_scripts-' . $page, 'login_radius_options_page_scripts' );
	@add_action( 'admin_print_styles-' . $page, 'login_radius_options_page_style' );
	@add_action( 'admin_print_styles-' . $page, 'login_radius_admin_css_custom_page' );
}
@add_action( 'admin_menu', 'login_radius_admin_menu' );

/**
 * Register LoginRadius_settings and its sanitization callback.
 */
function login_radius_meta_setup(){
	global $post;
	$postType = $post -> post_type;
	$lrMeta   = get_post_meta( $post->ID, '_login_radius_meta', true );
	?>
	<p>
		<label for="login_radius_sharing">
			<input type="checkbox" name="_login_radius_meta[sharing]" id="login_radius_sharing" value='1' <?php checked( '1', @$lrMeta['sharing'] ); ?> />
			<?php _e( 'Disable Social Sharing on this '.$postType, 'LoginRadius' ) ?>
		</label>
	</p>
	<?php
	// custom nonce for verification later
	echo '<input type="hidden" name="login_radius_meta_nonce" value="' . wp_create_nonce( __FILE__ ) . '" />';
}

/**
 * Save login radius meta fields.
 */
function login_radius_save_meta( $postId ) {
	// make sure data came from our meta box
	if ( ! isset( $_POST['login_radius_meta_nonce'] ) || ! wp_verify_nonce( $_POST['login_radius_meta_nonce'], __FILE__ )  ) {
		return $postId;
	}
	// check user permissions
	if ( $_POST['post_type'] == 'page' ) {
		if ( ! current_user_can( 'edit_page', $postId )  ) {
			return $postId;
		}
	}else {
		if ( ! current_user_can( 'edit_post', $postId )  ) {
			return $postId;
		}
	}

	if ( isset( $_POST['_login_radius_meta'] ) ) {
		$newData = $_POST['_login_radius_meta'];
	}else{
		$newData = array( 'sharing' => 0 );
	}
	update_post_meta( $postId, '_login_radius_meta', $newData );
	return $postId;
}

/**
 * Register LoginRadius_settings and its sanitization callback. Add Login Radius meta box to pages and posts.
 */
function login_radius_options_init(){
	global $pagenow;
	register_setting( 'LoginRadius_setting_options', 'LoginRadius_settings', 'login_radius_validate_options' );
	// show sharing and counter meta fields on pages and posts
	foreach ( array( 'post', 'page' ) as $type ) {
		add_meta_box( 'login_radius_meta', 'LoginRadius', 'login_radius_meta_setup', $type );
	}
	// add a callback function to save any data a user enters in
	add_action( 'save_post', 'login_radius_save_meta' );
	if ( $pagenow == 'profile.php' ) {
		// redirect after accountlinking 
		if ( isset( $_REQUEST['token'] )  ) {
			// function call
			if ( login_radius_mapping_status() === true ) {
				$linked = 1;
			}elseif ( login_radius_mapping_status() === false ) {
				$linked = 0;
			}
			
			$redirectionUrl = login_radius_get_protocol(). $_SERVER['HTTP_HOST'] . remove_query_arg( 'lrlinked' );
			if ( strpos( $redirectionUrl, '?' ) !== false ) {
				$redirectionUrl .= '&lrlinked=' . $linked;
			}else {
				$redirectionUrl .= '?lrlinked=' . $linked;
			}
			?>
			<script type="text/javascript">
				if ( window.opener ) {
					window.opener.location.href="<?php echo $redirectionUrl; ?>";
					window.close();
				}else {
					window.location.href="<?php echo $redirectionUrl; ?>";
				}
			</script>
			<?php
			die;
		}
	}
}
add_action( 'admin_init', 'login_radius_options_init' );

/**
 * Get wordpress version.
 */
function login_radius_get_wp_version(){
	return ( float ) substr( get_bloginfo( 'version' ) , 0, 3 );
}

/**
 * Add js for enabling preview.
 */
function login_radius_options_page_scripts(){
	$script = ( login_radius_get_wp_version() >= 3.2 ) ? 'loginradius-options-page32.js' : 'loginradius-options-page29.js';
	$scriptLocation = apply_filters( 'LoginRadius_files_uri', plugins_url( 'js/' . $script.'?t=4.0.0', __FILE__ )  );
	wp_enqueue_script( 'LoginRadius_options_page_script', $scriptLocation, array( 'jquery-ui-tabs', 'thickbox' )  );
	wp_enqueue_script( 'LoginRadius_options_page_script2', plugins_url( 'js/loginRadiusAdmin.js?t=4.0.0', __FILE__ ) , array(), false, false );
}

/**

 * Add option Settings css.
 */
function login_radius_options_page_style(){
	?>
	<!--[if IE]>
		<link href="<?php echo plugins_url( 'css/loginRadiusOptionsPageIE.css', __FILE__ ) ?>" rel="stylesheet" type="text/css" />
	<![endif]-->
	<?php
	$styleLocation = apply_filters( 'LoginRadius_files_uri', plugins_url( 'css/loginRadiusOptionsPage.css', __FILE__ )  );
	wp_enqueue_style( 'login_radius_options_page_style', $styleLocation.'?t=4.0.0' );
	wp_enqueue_style( 'thickbox' );
}

/**
 * Add custom page Settings css.
 */
function login_radius_admin_css_custom_page(){
	wp_register_style( 'LoginRadius-plugin-page-css', plugins_url( 'css/loginRadiusStyle.css', __FILE__ ) , array(), '4.0.0', 'all' );
	wp_enqueue_style( 'LoginRadius-plugin-page-css' );
}

/**
 * Update message, used in the admin panel to show messages to users.
 */
function login_radius_message( $message ) {
	echo "<div id=\"message\" class=\"updated fade\"><p>$message</p></div>\n";
}

/**
 * Add a settings link to the Plugins page, so people can go straight from the plugin page to the
 * settings page.
 */
function login_radius_filter_plugin_actions( $links, $file ) {
	static $thisPlugin;
	if ( ! $thisPlugin ) {
		$thisPlugin = plugin_basename( __FILE__ );
	}
	if ( $file == $thisPlugin ) {
		$settingsLink = '<a href="options-general.php?page=LoginRadius">' . __( 'Settings' ) . '</a>';
		array_unshift( $links, $settingsLink ); // before other links
	}
	return $links;
}
add_filter( 'plugin_action_links', 'login_radius_filter_plugin_actions', 10, 2 );

/**
 * Set Default options when plugin is activated first time.
 */
function login_radius_activation(){
	global $wpdb;
	$options = array(
						'LoginRadius_loginform' => '1',
						'LoginRadius_regform' => '1',
						'LoginRadius_regformPosition' => 'embed',
						'LoginRadius_commentEnable' => '1',
						'LoginRadius_sharingTheme' => 'horizontal',
						'LoginRadius_counterTheme' => 'horizontal',
						'LoginRadius_shareEnable' => '1',
						'horizontal_shareEnable' => '1',
						'horizontal_shareTop' => '1',
						'horizontal_shareBottom' => '1',
						'horizontal_sharehome' => '1',
						'horizontal_sharepost' => '1',
						'horizontal_sharepage' => '1',
						'vertical_shareEnable' => '1',
						'verticalSharing_theme' => 'counter_vertical',
						'vertical_sharehome' => '1',
						'vertical_sharepost' => '1',
						'vertical_sharepage' => '1',
						'sharing_offset' => '200',
						'LoginRadius_noProvider' => '0',
						'LoginRadius_enableUserActivation' => '1',
						'LoginRadius_defaultUserStatus' => '1',
						'scripts_in_footer' => '0',
						'delete_options' => '1',
						'username_separator' => 'dash',
						'LoginRadius_redirect' => 'samepage',
						'LoginRadius_regRedirect' => 'samepage',
						'LoginRadius_loutRedirect' => 'homepage',
						'LoginRadius_socialavatar' => 'socialavatar',
						'sameWindow' => 1,
					);
	// Set plugin default options
	add_option( 'LoginRadius_settings', $options );
}
register_activation_hook( __FILE__, 'login_radius_activation' );

/**
 * Replace buddypress default avatar with social avatar.
 */
function login_radius_bp_avatar( $text, $args ) {
	global $loginRadiusSettings;
	//Check arguments
	if ( is_array( $args )  ) {
		if ( ! empty( $args['object'] ) && strtolower( $args['object'] ) == 'user' ) {
			if ( ! empty( $args['item_id'] ) && is_numeric( $args['item_id'] )  ) {
				if (  ( $userData = get_userdata( $args['item_id'] )  ) !== false ) {
					$currentSocialId = get_user_meta( $args['item_id'], 'loginradius_current_id', true );
					$avatar = '';
					if (  ( $userAvatar = get_user_meta( $args['item_id'], 'loginradius_'.$currentSocialId.'_thumbnail', true )  ) !== false && strlen( trim( $userAvatar )  ) > 0 ) {
						$avatar = $userAvatar;
					}elseif (  ( $userAvatar = get_user_meta( $args['item_id'], 'loginradius_thumbnail', true )  ) !== false && strlen( trim( $userAvatar )  ) > 0 ) {
						$avatar = $userAvatar;
					}
					if ( $avatar != '' ) {
							$imgAlt    = ( ! empty( $args['alt'] ) ? 'alt="'.esc_attr( $args['alt'] ) .'" ' : '' );
							$imgAlt    = sprintf( $imgAlt, htmlspecialchars( $userData->user_login ) );
							$imgClass  = ( 'class="'. ( ! empty( $args['class'] ) ? ( $args['class'].' ' ) : '' ) .'avatar-social-login" ' );
							$imgWidth  = ( ! empty( $args['width'] ) ? 'width="'.$args['width'].'" ' : 'width="50"' );
							$imgHeight = ( ! empty( $args['height'] ) ? 'height="'.$args['height'].'" ' : 'height="50"' );
							$text = preg_replace( '#<img[^>]+>#i', '<img src="'.$avatar.'" '.$imgAlt.$imgClass.$imgHeight.$imgWidth.' style="float:left; margin-right:10px" />', $text );
					}
				}
			}
		}
	}
	return $text;
}

if ( isset( $loginRadiusSettings['LoginRadius_socialavatar'] ) && $loginRadiusSettings['LoginRadius_socialavatar'] == 'socialavatar' ) {
	add_filter( 'bp_core_fetch_avatar', 'login_radius_bp_avatar', 10, 2 );
}
// show social login interface on the custom hook call
add_action( 'login_radius_social_login', 'login_radius_connect_button' );

// verify API connection method
function login_radius_api_connection(){
	global $loginRadiusObject;
	if ( in_array( 'curl', get_loaded_extensions() ) ) {
		$iframe = $loginRadiusObject->login_radius_check_connection( $method = 'curl' );
		if ( $iframe == 'ok' ) {
			die( 'curl' );
		}elseif ( $iframe == 'service connection timeout' ) {
			die( 'service connection timeout' );
		}elseif ( $iframe == 'connection error' ) {
			die( 'connection error' );
		}elseif ( $iframe == 'timeout' ) {
			die( 'timeout' );
		}
	}elseif ( ini_get( 'allow_url_fopen' ) == 1 ) {
		$iframe = $loginRadiusObject->login_radius_check_connection( $method = 'fopen' );
		if ( $iframe == 'ok' ) {
			die( 'fsock' );
		}elseif ( $iframe == 'service connection timeout' ) {
			die( 'service connection timeout' );
		}elseif ( $iframe == 'connection error' ) {
			die( 'connection error' );
		}elseif ( $iframe == 'timeout' ) {
			die( 'timeout' );
		}
	}else {
		die( 'lrerror' );
	}
}
// ajax for connection handler detection
add_action( 'wp_ajax_login_radius_api_connection', 'login_radius_api_connection' );

// verify API Key/Secret
function login_radius_verify_keys(){
	$key    = trim( $_POST['key'] );
	$secret = trim( $_POST['secret'] );
	if ( empty( $key ) || ! preg_match( '/^\{?[A-Z0-9]{8}-[A-Z0-9]{4}-[A-Z0-9]{4}-[A-Z0-9]{4}-[A-Z0-9]{12}\}?$/i', $key ) ) { 
		die( 'key' ); 
	}elseif ( empty( $secret ) || ! preg_match( '/^\{?[A-Z0-9]{8}-[A-Z0-9]{4}-[A-Z0-9]{4}-[A-Z0-9]{4}-[A-Z0-9]{12}\}?$/i', $secret ) ) {
		die( 'secret' );
	}elseif ( $key == $secret ) {
		die( 'same' );
	}else {
		die( 'working' );
	}
}
// ajax for key verification
add_action( 'wp_ajax_login_radius_verify_keys', 'login_radius_verify_keys' );

// change user status
function login_radius_change_user_status(){
	$currentStatus = $_POST['current_status'];
	$userId = $_POST['user_id'];
	if ( $currentStatus == '1' ) {
		update_user_meta( $userId, 'loginradius_status', '0' );
		die( 'done' ); 
	}elseif ( $currentStatus == '0' ) { 
		update_user_meta( $userId, 'loginradius_status', '1' );
		$user     = get_userdata( $userId );
		$username = $user->display_name != '' ? $user->display_name : $user->user_nicename;
		$username = $username != '' ? ucfirst( $username ) : ucfirst( $user->user_login );
		try{
			Login_Radius_Social_Login::login_radius_send_verification_email( $user->user_email, '', '', 'activation', $username );
		}catch ( Exception $e ) {
			die( 'error' );
		}
		die( 'done' );
	}
}
// ajax for key verification
add_action( 'wp_ajax_login_radius_change_user_status', 'login_radius_change_user_status' );

function login_radius_bp_check(){
	global $loginRadiusLoginIsBpActive;
	$loginRadiusLoginIsBpActive = true;
}
add_action( 'bp_include', 'login_radius_bp_check' );

/**
 * Close current ( social login popup ) window
 */
function login_radius_close_window( $uniqueId, $param = '', $key = '' ) {
	if ( $uniqueId != '' ) {
		$queryString = '?lrid='.$uniqueId;
	}elseif ( $param != '' ) {
		$queryString = '?' . $param . '=1&loginRadiusKey=' . $key;
	}
	?>
	<script>
	if ( window.opener ) {
		window.opener.location.href = '<?php echo site_url().$queryString ?>';
		window.close();
	} else {
		window.location.href = '<?php echo site_url().$queryString ?>';
	}
	</script>
	<?php
	die;
}

/**
 * Function that asking for enter email.
 */
function login_radius_email_popup() {
	if ( isset( $_GET['key'] ) && $_GET['key'] != '' ) {
		//$redirectionUrl = login_radius_get_protocol(). $_SERVER['HTTP_HOST'] . remove_query_arg( array( 'lrid', 'LoginRadiusMessage' ) );
		?>
		<div class="LoginRadius_overlay" id="fade"><div id="popupouter"><div id="popupinner"><div id="loginRadiusError"></div><div id="textmatter">
		<?php
		if ( isset( $_GET['message'] ) && $_GET['message'] != '' ) {
			?>	
			<b><?php echo $_GET['message']; ?></b>
			<?php
		}
		?>
		</div><form method="post" action='' onsubmit='return loginRadiusValidateEmail()'><div><input type="text" name="email" id="loginRadiusEmail" class="loginRadiusInputTxt"/></div><div><input type="submit" id="LoginRadius_popupSubmit" name="LoginRadius_popupSubmit" value="Submit" class="inputbutton"><input type="Submit" onClick="loginRadiusPopupSubmit = false" name="LoginRadius_popupSubmit" value="Cancel" class="inputbutton" /> <input type="hidden" value="<?php echo $_GET['key'] ?>" name = "session"/></div></form></div></div></div>
		<?php
	}
	die;
}
add_action('wp_ajax_nopriv_login_radius_email_popup', 'login_radius_email_popup');

/**
 * Function that asking for enter email.
 */
function login_radius_notification_popup() {
	?>
	<div class="LoginRadius_overlay" id="fade"><div id="popupouter"><div id="popupinner"><div id="textmatter">
	<?php
	if ( isset( $_GET['message'] ) && $_GET['message'] != '' ) {
		?>	
		<b><?php echo $_GET['message']; ?></b>
		<?php
	}
	if ( isset( $_GET['redirection'] ) && $_GET['redirection'] != '' ) {
		?>
		</div><form method="post" action=''><div><input type="button" value="OK" class="inputbutton" onclick="location.href = '<?php echo $_GET['redirection'] ?>'></div></form></div></div></div>';
		<?php
	}else {
		?>
		</div><form method="post" action="<?php echo site_url() ?>"><div><input type="submit" value="OK" class="inputbutton"></div></form></div></div></div>
		<?php
	}
	die;
}
add_action('wp_ajax_nopriv_login_radius_notification_popup', 'login_radius_notification_popup');
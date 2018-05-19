<?php
$g_hostname				= 'localhost';
$g_db_username			= 'root';
$g_db_password			= '';
$g_database_name		= 'bugtracker';
$g_db_type				= 'mysqli';
$g_dsn = '';
$g_db_table_prefix = 'mantis';
$g_db_table_suffix = '_table';
$g_db_table_plugin_prefix	= 'plugin';
$g_absolute_path = dirname( __FILE__ ) . DIRECTORY_SEPARATOR;
$g_core_path = $g_absolute_path . 'core' . DIRECTORY_SEPARATOR;
$g_class_path = $g_core_path . 'classes' . DIRECTORY_SEPARATOR;
$g_library_path = $g_absolute_path . 'library' . DIRECTORY_SEPARATOR;
$g_vendor_path = $g_absolute_path . 'vendor' . DIRECTORY_SEPARATOR;
$g_language_path = $g_absolute_path . 'lang' . DIRECTORY_SEPARATOR;
$t_local_config = getenv( 'MANTIS_CONFIG_FOLDER' );
if( $t_local_config && is_dir( $t_local_config ) ) {
	$g_config_path = $t_local_config;
} else {
	$g_config_path = $g_absolute_path . 'config' . DIRECTORY_SEPARATOR;
}

unset( $t_local_config );
$t_protocol = 'http';
$t_host = 'localhost';
if( isset ( $_SERVER['SCRIPT_NAME'] ) ) {
	$t_protocol = http_is_protocol_https() ? 'https' : 'http';

	# $_SERVER['SERVER_PORT'] is not defined in case of php-cgi.exe
	if( isset( $_SERVER['SERVER_PORT'] ) ) {
		$t_port = ':' . $_SERVER['SERVER_PORT'];
		if( ( ':80' == $t_port && 'http' == $t_protocol )
		  || ( ':443' == $t_port && 'https' == $t_protocol )) {
			$t_port = '';
		}
	} else {
		$t_port = '';
	}

	if( isset( $_SERVER['HTTP_X_FORWARDED_HOST'] ) ) { # Support ProxyPass
		$t_hosts = explode( ',', $_SERVER['HTTP_X_FORWARDED_HOST'] );
		$t_host = $t_hosts[0];
	} else if( isset( $_SERVER['HTTP_HOST'] ) ) {
		$t_host = $_SERVER['HTTP_HOST'];
	} else if( isset( $_SERVER['SERVER_NAME'] ) ) {
		$t_host = $_SERVER['SERVER_NAME'] . $t_port;
	} else if( isset( $_SERVER['SERVER_ADDR'] ) ) {
		$t_host = $_SERVER['SERVER_ADDR'] . $t_port;
	}

	if( !isset( $_SERVER['SCRIPT_NAME'] )) {
		echo 'Invalid server configuration detected. Please set $g_path manually in ' . $g_config_path . 'config_inc.php.';
		if( isset( $_SERVER['SERVER_SOFTWARE'] ) && ( stripos($_SERVER['SERVER_SOFTWARE'], 'nginx') !== false ) )
			echo ' Please try to add "fastcgi_param SCRIPT_NAME $fastcgi_script_name;" to the nginx server configuration.';
		die;
	}
	$t_self = filter_var( $_SERVER['SCRIPT_NAME'], FILTER_SANITIZE_STRING );
	$t_path = str_replace( basename( $t_self ), '', $t_self );
	switch( basename( $t_path ) ) {
		case 'admin':
			$t_path = rtrim( dirname( $t_path ), '/\\' ) . '/';
			break;
		case 'check':		# admin checks dir
		case 'soap':
		case 'rest':
			$t_path = rtrim( dirname( dirname( $t_path ) ), '/\\' ) . '/';
			break;
		case 'swagger':
			$t_path = rtrim( dirname( dirname( dirname( $t_path ) ) ), '/\\' ) . '/';
			break;
		case '':
			$t_path = '/';
			break;
	}
	if( strpos( $t_path, '&#' ) ) {
		echo 'Can not safely determine $g_path. Please set $g_path manually in ' . $g_config_path . 'config_inc.php';
		die;
	}
} else {
	$t_path = 'mantisbt/';
}

$g_path	= $t_protocol . '://' . $t_host . $t_path;
$g_short_path = $t_path;
$g_manual_url = 'doc/en-US/Admin_Guide/html-desktop/';
$g_session_save_path = false;
$g_session_validation = ON;
$g_form_security_validation = ON;
$g_crypto_master_salt = '';
$g_allow_signup	= ON;
$g_max_failed_login_count = OFF;
$g_notify_new_user_created_threshold_min = ADMINISTRATOR;
$g_send_reset_password	= ON;
$g_signup_use_captcha = OFF;
$g_system_font_folder	= '';
$g_lost_password_feature = ON;
$g_max_lost_password_in_progress_count = 3;
$g_antispam_max_event_count = 10;
$g_antispam_time_window_in_seconds = 3600;
$g_webmaster_email		= 'webmaster@example.com';
$g_from_email			= 'noreply@example.com';
$g_from_name			= 'Mantis Bug Tracker';
$g_return_path_email	= 'admin@example.com';
$g_enable_email_notification	= ON;
$g_email_notifications_verbose = OFF;

$g_default_notify_flags = array(
	'reporter'      => ON,
	'handler'       => ON,
	'monitor'       => ON,
	'bugnotes'      => ON,
	'category'      => ON,
	'explicit'      => ON,
	'threshold_min' => NOBODY,
	'threshold_max' => NOBODY
);

$g_notify_flags['new'] = array(
	'bugnotes' => OFF,
	'monitor'  => OFF
);

$g_notify_flags['monitor'] = array(
	'reporter'      => OFF,
	'handler'       => OFF,
	'monitor'       => OFF,
	'bugnotes'      => OFF,
	'explicit'      => ON,
	'threshold_min' => NOBODY,
	'threshold_max' => NOBODY
);

$g_email_receive_own = OFF;
$g_validate_email = ON;
$g_email_login_enabled = OFF;
$g_email_ensure_unique = ON;
$g_check_mx_record = OFF;
$g_allow_blank_email = OFF;
$g_limit_email_domains = array();
$g_show_user_email_threshold = NOBODY;
$g_show_user_realname_threshold = NOBODY;
$g_phpMailer_method = PHPMAILER_METHOD_MAIL;
$g_smtp_host = 'localhost';
$g_smtp_username = '';
$g_smtp_password = '';
$g_smtp_connection_mode = '';
$g_smtp_port = 25;
$g_email_dkim_enable = OFF;
$g_email_dkim_domain = 'example.com';
$g_email_dkim_private_key_file_path = '';
$g_email_dkim_private_key_string = '';
$g_email_dkim_selector = 'mail.example';
$g_email_dkim_passphrase = '';
$g_email_dkim_identity = 'noreply@example.com';
$g_email_send_using_cronjob = OFF;
$g_email_separator1 = str_pad('', 70, '=');
$g_email_separator2 = str_pad('', 70, '-');
$g_email_padding_length	= 28;
$g_email_retry_in_days = 7;
$g_show_version = OFF;
$g_version_suffix = '';
$g_copyright_statement = '';
$g_default_language = 'auto';
$g_language_choices_arr = array(
	'auto',
	'afrikaans',
	'amharic',
	'arabic',
	'arabicegyptianspoken',
	'asturian',
	'basque',
	'belarusian_tarask',
	'breton',
	'bulgarian',
	'catalan',
	'chinese_simplified',
	'chinese_traditional',
	'croatian',
	'czech',
	'danish',
	'dutch',
	'english',
	'estonian',
	'finnish',
	'french',
	'galician',
	'georgian',
	'german',
	'greek',
	'hebrew',
	'hungarian',
	'icelandic',
	'interlingua',
	'italian',
	'japanese',
	'korean',
	'latvian',
	'lithuanian',
	'luxembourgish',
	'macedonian',
	'norwegian_bokmal',
	'norwegian_nynorsk',
	'occitan',
	'persian',
	'polish',
	'portuguese_brazil',
	'portuguese_standard',
	'ripoarisch',
	'romanian',
	'russian',
	'serbian',
	'serbian_latin',
	'slovak',
	'slovene',
	'spanish',
	'swedish',
	'swissgerman',
	'tagalog',
	'turkish',
	'ukrainian',
	'urdu',
	'vietnamese',
	'volapuk',
	'zazaki',
);

$g_language_auto_map = array(
	'af' => 'afrikaans',
	'am' => 'amharic',
	'ar' => 'arabic',
	'arz' => 'arabicegyptianspoken',
	'ast' => 'asturian',
	'eu' => 'basque',
	'be-tarask' => 'belarusian_tarask',
	'bg' => 'bulgarian',
	'br' => 'breton',
	'ca' => 'catalan',
	'zh-cn, zh-sg, zh' => 'chinese_simplified',
	'zh-hk, zh-tw' => 'chinese_traditional',
	'hr' => 'croatian',
	'cs' => 'czech',
	'da' => 'danish',
	'nl-be, nl' => 'dutch',
	'en-us, en-gb, en-au, en' => 'english',
	'et' => 'estonian',
	'fi' => 'finnish',
	'fr-ca, fr-be, fr-ch, fr' => 'french',
	'gl' => 'galician',
	'de-de, de-at, de-ch, de' => 'german',
	'he' => 'hebrew',
	'hu' => 'hungarian',
	'is' => 'icelandic',
	'ia' => 'interlingua',
	'it-ch, it' => 'italian',
	'ja' => 'japanese',
	'ka' => 'georgian',
	'ko' => 'korean',
	'lv' => 'latvian',
	'lt' => 'lithuanian',
	'lb' => 'luxembourgish',
	'mk' => 'macedonian',
	'no' => 'norwegian_bokmal',
	'nn' => 'norwegian_nynorsk',
	'oc' => 'occitan',
	'fa' => 'persian',
	'pl' => 'polish',
	'pt-br' => 'portuguese_brazil',
	'pt' => 'portuguese_standard',
	'ksh' => 'ripoarisch',
	'ro-mo, ro' => 'romanian',
	'ru-mo, ru-ru, ru-ua, ru' => 'russian',
	'sr' => 'serbian',
	'sr-latn' => 'serbian_latin',
	'sk' => 'slovak',
	'sl' => 'slovene',
	'es-mx, es-co, es-ar, es-cl, es-pr, es' => 'spanish',
	'sv-fi, sv' => 'swedish',
	'gsw' => 'swissgerman',
	'tl' => 'tagalog',
	'tr' => 'turkish',
	'uk' => 'ukrainian',
	'vi' => 'vietnamese',
	'vo' => 'volapuk',
	'diq' => 'zazaki',
);

$g_fallback_language = 'english';
$g_font_family = 'Open Sans';
$g_font_family_choices = array(
	'Amiko',
	'Architects Daughter',
	'Archivo Narrow',
	'Arvo',
	'Bitter',
	'Cabin',
	'Cinzel',
	'Comfortaa',
	'Courgette',
	'Droid Sans',
	'Gloria Hallelujah',
	'Inconsolata',
	'Josefin Sans',
	'Kadwa',
	'Karla',
	'Kaushan Script',
	'Lato',
	'Montserrat',
	'Open Sans',
	'Orbitron',
	'Oregano',
	'Palanquin',
	'Poppins',
	'Raleway',
	'Rhodium Libre',
	'Sarala',
	'Scope One',
	'Secular One',
	'Ubuntu',
	'Vollkorn'
);

$g_font_family_choices_local = array(
	'Montserrat',
	'Open Sans',
	'Poppins'
);

$g_window_title = 'MantisBT';
$g_search_title = '%window_title%';
$g_admin_checks = ON;
$g_favicon_image = 'images/favicon.ico';
$g_logo_image = 'images/mantis_logo.png';
$g_logo_url = '%default_home_page%';
$g_enable_project_documentation = OFF;
$g_show_project_menu_bar = OFF;
$g_show_assigned_names = ON;
$g_show_priority_text = OFF;
$g_priority_significant_threshold = HIGH;
$g_severity_significant_threshold = MAJOR;
$g_view_issues_page_columns = array(
	'selection', 'edit', 'priority', 'id', 'sponsorship_total',
	'bugnotes_count', 'attachment_count', 'category_id', 'severity', 'status',
	'last_updated', 'summary'
);

$g_print_issues_page_columns = array(
	'selection', 'priority', 'id', 'sponsorship_total', 'bugnotes_count',
	'attachment_count', 'category_id', 'severity', 'status', 'last_updated',
	'summary'
);

$g_csv_columns = array(
	'id', 'project_id', 'reporter_id', 'handler_id', 'priority',
	'severity', 'reproducibility', 'version', 'projection', 'category_id',
	'date_submitted', 'eta', 'os', 'os_build', 'platform', 'view_state',
	'last_updated', 'summary', 'status', 'resolution', 'fixed_in_version'
);

$g_excel_columns = array(
	'id', 'project_id', 'reporter_id', 'handler_id', 'priority', 'severity',
	'reproducibility', 'version', 'projection', 'category_id',
	'date_submitted', 'eta', 'os', 'os_build', 'platform', 'view_state',
	'last_updated', 'summary', 'status', 'resolution', 'fixed_in_version'
);

$g_show_bug_project_links = ON;
$g_filter_position = FILTER_POSITION_TOP;
$g_action_button_position = POSITION_BOTTOM;
$g_show_product_version = AUTO;
$g_show_version_dates_threshold = NOBODY;
$g_show_realname = OFF;
$g_sort_by_last_name = OFF;
$g_show_avatar = OFF;
$g_show_avatar_threshold = DEVELOPER;
$g_show_changelog_dates = ON;
$g_show_roadmap_dates = ON;
$g_cookie_time_length = 60 * 60 * 24 * 365;
$g_allow_permanent_cookie = ON;
$g_long_process_timeout = 0;
$g_short_date_format = 'Y-m-d';
$g_normal_date_format = 'Y-m-d H:i';
$g_complete_date_format = 'Y-m-d H:i T';
$g_datetime_picker_format = 'Y-MM-DD HH:mm';
$g_default_timezone = '';
$g_news_enabled = OFF;
$g_news_limit_method = BY_LIMIT;
$g_news_view_limit = 7;
$g_news_view_limit_days = 30;
$g_private_news_threshold = DEVELOPER;
$g_default_new_account_access_level = REPORTER;
$g_default_project_view_status = VS_PUBLIC;
$g_default_bug_view_status = VS_PUBLIC;
$g_default_bug_description = '';
$g_default_bug_steps_to_reproduce = '';
$g_default_bug_additional_info = '';
$g_default_bugnote_view_status = VS_PUBLIC;
$g_default_bug_resolution = OPEN;
$g_default_bug_severity = MINOR;
$g_default_bug_priority = NORMAL;
$g_default_bug_reproducibility = REPRODUCIBILITY_HAVENOTTRIED;
$g_default_bug_projection = PROJECTION_NONE;
$g_default_bug_eta = ETA_NONE;
$g_default_bug_relationship_clone = BUG_REL_NONE;
$g_allow_parent_of_unresolved_to_close = OFF;
$g_default_bug_relationship = BUG_RELATED;
$g_default_category_for_moves = 1;
$g_default_limit_view = 50;
$g_default_show_changed = 6;
$g_hide_status_default = CLOSED;
$g_show_sticky_issues = ON;
$g_min_refresh_delay = 10;
$g_default_refresh_delay = 30;
$g_default_redirect_delay = 2;
$g_default_bugnote_order = 'ASC';
$g_default_email_on_new = ON;
$g_default_email_on_assigned = ON;
$g_default_email_on_feedback = ON;
$g_default_email_on_resolved = ON;
$g_default_email_on_closed = ON;
$g_default_email_on_reopened = ON;
$g_default_email_on_bugnote = ON;
$g_default_email_on_status = 0;
$g_default_email_on_priority = 0;
$g_default_email_on_new_minimum_severity = OFF;
$g_default_email_on_assigned_minimum_severity = OFF;
$g_default_email_on_feedback_minimum_severity = OFF;
$g_default_email_on_resolved_minimum_severity = OFF;
$g_default_email_on_closed_minimum_severity = OFF;
$g_default_email_on_reopened_minimum_severity = OFF;
$g_default_email_on_bugnote_minimum_severity = OFF;
$g_default_email_on_status_minimum_severity = OFF;
$g_default_email_on_priority_minimum_severity = OFF;
$g_default_email_bugnote_limit = 0;
$g_reporter_summary_limit = 10;
$g_date_partitions = array( 1, 2, 3, 7, 30, 60, 90, 180, 365);
$g_summary_category_include_project = OFF;
$g_view_summary_threshold = MANAGER;
$g_severity_multipliers = array(
	FEATURE => 1,
	TRIVIAL => 2,
	TEXT    => 3,
	TWEAK   => 2,
	MINOR   => 5,
	MAJOR   => 8,
	CRASH   => 8,
	BLOCK   => 10
);

$g_resolution_multipliers = array(
	UNABLE_TO_REPRODUCE => 2,
	NOT_FIXABLE         => 1,
	DUPLICATE           => 3,
	NOT_A_BUG           => 5,
	SUSPENDED           => 1,
	WONT_FIX            => 1
);

$g_bugnote_order = 'DESC';
$g_history_default_visible = ON;
$g_history_order = 'ASC';
$g_store_reminders = ON;
$g_reminder_recipients_monitor_bug = ON;
$g_default_reminder_view_status = VS_PUBLIC;
$g_reminder_receive_threshold = DEVELOPER;
$g_mentions_enabled = ON;
$g_mentions_tag = '@';
$g_enable_sponsorship = OFF;
$g_sponsorship_currency = 'US$';
$g_view_sponsorship_total_threshold = VIEWER;
$g_view_sponsorship_details_threshold = VIEWER;
$g_sponsor_threshold = REPORTER;
$g_handle_sponsored_bugs_threshold = DEVELOPER;
$g_assign_sponsored_bugs_threshold = MANAGER;
$g_minimum_sponsorship_amount = 5;
$g_allow_file_upload = ON;
$g_file_upload_method = DATABASE;
$g_dropzone_enabled = ON;
$g_attachments_file_permissions = 0400;
$g_max_file_size = 5000000;
$g_file_upload_max_num = 10;
$g_allowed_files = '';
$g_disallowed_files = '';
$g_document_files_prefix = 'doc';
$g_absolute_path_default_upload_folder = '';
$g_file_download_xsendfile_enabled = OFF;
$g_file_download_xsendfile_header_name = 'X-Sendfile';
$g_html_make_links = LINKS_SAME_WINDOW;
$g_html_valid_tags = 'p, li, ul, ol, br, pre, i, b, u, em, strong';
$g_html_valid_tags_single_line = 'i, b, u, em, strong';
$g_max_dropdown_length = 40;
$g_wrap_in_preformatted_text = ON;
$g_login_method = MD5;
$g_reauthentication = ON;
$g_reauthentication_expiry = TOKEN_EXPIRY_AUTHENTICATED;
$g_ldap_server = 'ldaps://ldap.example.com/';
$g_ldap_root_dn = 'dc=example,dc=com';
$g_ldap_organization = '';
$g_ldap_protocol_version = 0;
$g_ldap_network_timeout = 0;
$g_ldap_follow_referrals = ON;
$g_ldap_bind_dn = '';
$g_ldap_bind_passwd = '';
$g_ldap_uid_field = 'uid';
$g_ldap_realname_field = 'cn';
$g_use_ldap_realname = OFF;
$g_use_ldap_email = OFF;
$g_ldap_simulation_file_path = '';
$g_bug_submit_status = NEW_;
$g_bug_assigned_status = ASSIGNED;
$g_bug_reopen_status = FEEDBACK;
$g_bug_feedback_status = FEEDBACK;
$g_reassign_on_feedback = ON;
$g_bug_reopen_resolution = REOPENED;
$g_bug_duplicate_resolution = DUPLICATE;
$g_bug_readonly_status_threshold = RESOLVED;
$g_bug_resolved_status_threshold = RESOLVED;
$g_bug_resolution_fixed_threshold = FIXED;
$g_bug_resolution_not_fixed_threshold = UNABLE_TO_REPRODUCE;
$g_bug_closed_status_threshold = CLOSED;
$g_auto_set_status_to_assigned	= ON;
$g_status_enum_workflow = array();
$g_fileinfo_magic_db_file = '';
$g_preview_attachments_inline_max_size = 256 * 1024;
$g_preview_text_extensions = array(
	'', 'txt', 'diff', 'patch'
);

$g_preview_image_extensions = array(
	'bmp', 'png', 'gif', 'jpg', 'jpeg'
);

$g_preview_max_width = 0;
$g_preview_max_height = 250;
$g_view_attachments_threshold = VIEWER;
$g_download_attachments_threshold = VIEWER;
$g_delete_attachments_threshold = DEVELOPER;
$g_allow_view_own_attachments = ON;
$g_allow_download_own_attachments = ON;
$g_allow_delete_own_attachments = OFF;
$g_enable_eta = OFF;
$g_enable_projection = OFF;
$g_enable_product_build = OFF;
$g_bug_report_page_fields = array(
	'additional_info',
	'attachments',
	'category_id',
	'due_date',
	'handler',
	'os',
	'os_version',
	'platform',
	'priority',
	'product_build',
	'product_version',
	'reproducibility',
	'severity',
	'steps_to_reproduce',
	'tags',
	'target_version',
	'view_state',
);

$g_bug_view_page_fields = array(
	'additional_info',
	'attachments',
	'category_id',
	'date_submitted',
	'description',
	'due_date',
	'eta',
	'fixed_in_version',
	'handler',
	'id',
	'last_updated',
	'os',
	'os_version',
	'platform',
	'priority',
	'product_build',
	'product_version',
	'project',
	'projection',
	'reporter',
	'reproducibility',
	'resolution',
	'severity',
	'status',
	'steps_to_reproduce',
	'summary',
	'tags',
	'target_version',
	'view_state',
);

$g_bug_update_page_fields = array(
	'additional_info',
	'category_id',
	'date_submitted',
	'description',
	'due_date',
	'eta',
	'fixed_in_version',
	'handler',
	'id',
	'last_updated',
	'os',
	'os_version',
	'platform',
	'priority',
	'product_build',
	'product_version',
	'project',
	'projection',
	'reporter',
	'reproducibility',
	'resolution',
	'severity',
	'status',
	'steps_to_reproduce',
	'summary',
	'target_version',
	'view_state',
);

$g_bug_change_status_page_fields = array(
	'additional_info',
	'attachments',
	'category_id',
	'date_submitted',
	'description',
	'due_date',
	'eta',
	'fixed_in_version',
	'handler',
	'id',
	'last_updated',
	'os',
	'os_version',
	'platform',
	'priority',
	'product_build',
	'product_version',
	'project',
	'projection',
	'reporter',
	'reproducibility',
	'resolution',
	'severity',
	'status',
	'steps_to_reproduce',
	'summary',
	'tags',
	'target_version',
	'view_state',
);

$g_report_bug_threshold = REPORTER;
$g_update_bug_threshold = UPDATER;
$g_view_bug_threshold = VIEWER;
$g_monitor_bug_threshold = REPORTER;
$g_monitor_add_others_bug_threshold = DEVELOPER;
$g_monitor_delete_others_bug_threshold = DEVELOPER;
$g_private_bug_threshold = DEVELOPER;
$g_handle_bug_threshold = DEVELOPER;
$g_update_bug_assign_threshold = '%handle_bug_threshold%';
$g_private_bugnote_threshold = DEVELOPER;
$g_view_handler_threshold = VIEWER;
$g_view_history_threshold = VIEWER;
$g_bug_reminder_threshold = DEVELOPER;
$g_bug_revision_drop_threshold = MANAGER;
$g_upload_project_file_threshold = MANAGER;
$g_upload_bug_file_threshold = REPORTER;
$g_add_bugnote_threshold = REPORTER;
$g_update_bugnote_threshold = DEVELOPER;
$g_view_proj_doc_threshold = VIEWER;
$g_manage_site_threshold = MANAGER;
$g_admin_site_threshold = ADMINISTRATOR;
$g_manage_project_threshold = MANAGER;
$g_manage_news_threshold = MANAGER;
$g_delete_project_threshold = ADMINISTRATOR;
$g_create_project_threshold = ADMINISTRATOR;
$g_private_project_threshold = ADMINISTRATOR;
$g_project_user_threshold = MANAGER;
$g_manage_user_threshold = ADMINISTRATOR;
$g_impersonate_user_threshold = ADMINISTRATOR;
$g_delete_bug_threshold = DEVELOPER;
$g_delete_bugnote_threshold = '%delete_bug_threshold%';
$g_move_bug_threshold = DEVELOPER;
$g_set_view_status_threshold = REPORTER;
$g_change_view_status_threshold = UPDATER;
$g_show_monitor_list_threshold = DEVELOPER;
$g_stored_query_use_threshold = REPORTER;
$g_stored_query_create_threshold = DEVELOPER;
$g_stored_query_create_shared_threshold = MANAGER;
$g_update_readonly_bug_threshold = MANAGER;
$g_view_changelog_threshold = VIEWER;
$g_timeline_view_threshold = VIEWER;
$g_roadmap_view_threshold = VIEWER;
$g_roadmap_update_threshold = DEVELOPER;
$g_update_bug_status_threshold = DEVELOPER;
$g_reopen_bug_threshold = DEVELOPER;
$g_report_issues_for_unreleased_versions_threshold = DEVELOPER;
$g_set_bug_sticky_threshold = MANAGER;
$g_development_team_threshold = DEVELOPER;
$g_set_status_threshold = array( NEW_ => REPORTER );
$g_bugnote_user_edit_threshold = '%update_bugnote_threshold%';
$g_bugnote_user_delete_threshold = '%delete_bugnote_threshold%';
$g_bugnote_user_change_view_state_threshold = '%change_view_status_threshold%';
$g_allow_no_category = OFF;
$g_limit_reporters = OFF;
$g_allow_reporter_close	 = OFF;
$g_allow_reporter_reopen = ON;
$g_allow_reporter_upload = ON;
$g_allow_account_delete = OFF;
$g_allow_anonymous_login = OFF;
$g_anonymous_account = '';
$g_bug_link_tag = '#';
$g_bugnote_link_tag = '~';
$g_bug_count_hyperlink_prefix = 'view_all_set.php?type=1&amp;temporary=y';
$g_user_login_valid_regex = '/^([a-z\d\-.+_ ]+(@[a-z\d\-.]+\.[a-z]{2,4})?)$/i';
$g_default_manage_user_prefix = 'ALL';
$g_default_manage_tag_prefix = 'ALL';
$g_csv_separator = ',';
$g_manage_configuration_threshold = MANAGER;
$g_view_configuration_threshold = ADMINISTRATOR;
$g_set_configuration_threshold = ADMINISTRATOR;
$g_status_colors = array(
	'new'          => '#fcbdbd', # red    (scarlet red #ef2929)
	'feedback'     => '#e3b7eb', # purple (plum        #75507b)
	'acknowledged' => '#ffcd85', # orange (orango      #f57900)
	'confirmed'    => '#fff494', # yellow (butter      #fce94f)
	'assigned'     => '#c2dfff', # blue   (sky blue    #729fcf)
	'resolved'     => '#d2f5b0', # green  (chameleon   #8ae234)
	'closed'       => '#c9ccc4'  # grey   (aluminum    #babdb6)
);

$g_display_project_padding = 3;
$g_display_bug_padding = 7;
$g_display_bugnote_padding = 7;
$g_cookie_path = '/';
$g_cookie_domain = '';
$g_cookie_prefix = 'MANTIS';
$g_string_cookie = '%cookie_prefix%_STRING_COOKIE';
$g_project_cookie = '%cookie_prefix%_PROJECT_COOKIE';
$g_view_all_cookie = '%cookie_prefix%_VIEW_ALL_COOKIE';
$g_manage_users_cookie		= '%cookie_prefix%_MANAGE_USERS_COOKIE';
$g_manage_config_cookie		= '%cookie_prefix%_MANAGE_CONFIG_COOKIE';
$g_logout_cookie = '%cookie_prefix%_LOGOUT_COOKIE';
$g_bug_list_cookie = '%cookie_prefix%_BUG_LIST_COOKIE';
$g_filter_by_custom_fields = ON;
$g_filter_custom_fields_per_row = 8;
$g_view_filters = SIMPLE_DEFAULT;
$g_use_dynamic_filters = ON;
$g_create_permalink_threshold = DEVELOPER;
$g_create_short_url = 'http://tinyurl.com/create.php?url=%s';
$g_access_levels_enum_string = '10:viewer,25:reporter,40:updater,55:developer,70:manager,90:administrator';
$g_project_status_enum_string = '10:development,30:release,50:stable,70:obsolete';
$g_project_view_state_enum_string = '10:public,50:private';
$g_view_state_enum_string = '10:public,50:private';
$g_priority_enum_string = '10:none,20:low,30:normal,40:high,50:urgent,60:immediate';
$g_severity_enum_string = '10:feature,20:trivial,30:text,40:tweak,50:minor,60:major,70:crash,80:block';
$g_reproducibility_enum_string = '10:always,30:sometimes,50:random,70:have not tried,90:unable to duplicate,100:N/A';
$g_status_enum_string = '10:new,20:feedback,30:acknowledged,40:confirmed,50:assigned,80:resolved,90:closed';
$g_resolution_enum_string = '10:open,20:fixed,30:reopened,40:unable to duplicate,50:not fixable,60:duplicate,70:not a bug,80:suspended,90:wont fix';
$g_projection_enum_string = '10:none,30:tweak,50:minor fix,70:major rework,90:redesign';
$g_eta_enum_string = '10:none,20:< 1 day,30:2-3 days,40:< 1 week,50:< 1 month,60:> 1 month';
$g_sponsorship_enum_string = '0:Unpaid,1:Requested,2:Paid';
$g_custom_field_type_enum_string = '0:string,1:numeric,2:float,3:enum,4:email,5:checkbox,6:list,7:multiselection list,8:date,9:radio,10:textarea';
$g_compress_html = ON;
$g_use_persistent_connections = OFF;
$g_bottom_include_page = '%absolute_path%';
$g_top_include_page = '%absolute_path%';
$g_css_include_file = 'default.css';
$g_css_rtl_include_file = 'rtl.css';
$g_cdn_enabled = OFF;
$g_default_home_page = 'my_view_page.php';
$g_logout_redirect_page = AUTH_PAGE_USERNAME;
$g_custom_headers = array();
$g_manage_custom_fields_threshold = ADMINISTRATOR;
$g_custom_field_link_threshold = MANAGER;
$g_custom_field_edit_after_create = ON;
$g_main_menu_custom_options = array();

$g_file_type_icons = array(
	''		=> 'fa-file-text-o',
	'7z'	=> 'fa-file-archive-o',
	'ace'	=> 'fa-file-archive-o',
	'arj'	=> 'fa-file-archive-o',
	'bz2'	=> 'fa-file-archive-o',
	'c'		=> 'fa-file-code-o',
	'chm'	=> 'fa-file-o',
	'cpp'	=> 'fa-file-code-o',
	'css'	=> 'fa-file-code-o',
	'csv'	=> 'fa-file-text-o',
	'cxx'	=> 'fa-file-code-o',
	'diff'	=> 'fa-file-text-o',
	'doc'	=> 'fa-file-word-o',
	'docx'	=> 'fa-file-word-o',
	'dot'	=> 'fa-file-word-o',
	'eml'	=> 'fa-envelope-o',
	'htm'	=> 'fa-file-code-o',
	'html'	=> 'fa-file-code-o',
	'gif'	=> 'fa-file-image-o',
	'gz'	=> 'fa-file-archive-o',
	'jpe'	=> 'fa-file-image-o',
	'jpg'	=> 'fa-file-image-o',
	'jpeg'	=> 'fa-file-image-o',
	'log'	=> 'fa-file-text-o',
	'lzh'	=> 'fa-file-archive-o',
	'mhtml'	=> 'fa-file-code-o',
	'mid'	=> 'fa-file-audio-o',
	'midi'	=> 'fa-file-audio-o',
	'mov'	=> 'fa-file-movie-o',
	'msg'	=> 'fa-envelope-o',
	'one'	=> 'fa-file-o',
	'patch'	=> 'fa-file-text-o',
	'pcx'	=> 'fa-file-image-o',
	'pdf'	=> 'fa-file-pdf-o',
	'png'	=> 'fa-file-image-o',
	'pot'	=> 'fa-file-word-o',
	'pps'	=> 'fa-file-powerpoint-o',
	'ppt'	=> 'fa-file-powerpoint-o',
	'pptx'	=> 'fa-file-powerpoint-o',
	'pub'	=> 'fa-file-o',
	'rar'	=> 'fa-file-archive-o',
	'reg'	=> 'fa-file',
	'rtf'	=> 'fa-file-word-o',
	'tar'	=> 'fa-file-archive-o',
	'tgz'	=> 'fa-file-archive-o',
	'txt'	=> 'fa-file-text-o',
	'uc2'	=> 'fa-file-archive-o',
	'vsd'	=> 'fa-file-o',
	'vsl'	=> 'fa-file-o',
	'vss'	=> 'fa-file-o',
	'vst'	=> 'fa-file-o',
	'vsu'	=> 'fa-file-o',
	'vsw'	=> 'fa-file-o',
	'vsx'	=> 'fa-file-o',
	'vtx'	=> 'fa-file-o',
	'wav'	=> 'fa-file-audio-o',
	'wbk'	=> 'fa-file-word-o',
	'wma'	=> 'fa-file-audio-o',
	'wmv'	=> 'fa-file-movie-o',
	'wri'	=> 'fa-file-word-o',
	'xlk'	=> 'fa-file-excel-o',
	'xls'	=> 'fa-file-excel-o',
	'xlsx'	=> 'fa-file-excel-o',
	'xlt'	=> 'fa-file-excel-o',
	'xml'	=> 'fa-file-code-o',
	'zip'	=> 'fa-file-archive-o',
	'?'	=> 'fa-file-o' );

$g_file_download_content_type_overrides = array(
	'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
	'dotx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.template',
	'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
	'ppsx' => 'application/vnd.openxmlformats-officedocument.presentationml.slideshow',
	'potx' => 'application/vnd.openxmlformats-officedocument.presentationml.template',
	'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
	'xltx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.template'
);

$g_status_icon_arr = array(
	NONE      => '',
	LOW       => 'fa-chevron-down fa-lg green',
	NORMAL    => 'fa-minus fa-lg orange2',
	HIGH      => 'fa-chevron-up fa-lg red',
	URGENT    => 'fa-arrow-up fa-lg red',
	IMMEDIATE => 'fa-exclamation-triangle fa-lg red'
);

$g_sort_icon_arr = array(
	ASCENDING  => 'fa-caret-up',
	DESCENDING => 'fa-caret-down'
);

$g_my_view_bug_count = 10;

$g_my_view_boxes = array(
	'assigned'      => '1',
	'unassigned'    => '2',
	'reported'      => '3',
	'resolved'      => '4',
	'recent_mod'    => '5',
	'monitored'     => '6',
	'feedback'      => '0',
	'verify'        => '0',
	'my_comments'   => '0'
);

$g_my_view_boxes_fixed_position = ON;
$g_rss_enabled = ON;
$g_relationship_graph_enable = OFF;
$g_dot_tool = '/usr/bin/dot';
$g_neato_tool = '/usr/bin/neato';
$g_relationship_graph_fontname = 'Arial';
$g_relationship_graph_fontsize = 8;
$g_relationship_graph_orientation = 'horizontal';
$g_relationship_graph_max_depth = 2;
$g_relationship_graph_view_on_click = OFF;
$g_backward_year_count = 4;
$g_forward_year_count = 4;
$g_custom_group_actions = array();
$g_wiki_enable = OFF;
$g_wiki_engine = '';
$g_wiki_root_namespace = 'mantis';
$g_wiki_engine_url = '';
$g_recently_visited_count = 5;
$g_tag_separator = ',';
$g_tag_view_threshold = VIEWER;
$g_tag_attach_threshold = REPORTER;
$g_tag_detach_threshold = DEVELOPER;
$g_tag_detach_own_threshold = REPORTER;
$g_tag_create_threshold = REPORTER;
$g_tag_edit_threshold = DEVELOPER;
$g_tag_edit_own_threshold = REPORTER;
$g_time_tracking_enabled = OFF;
$g_time_tracking_with_billing = OFF;
$g_time_tracking_stopwatch = OFF;
$g_time_tracking_view_threshold = DEVELOPER;
$g_time_tracking_edit_threshold = DEVELOPER;
$g_time_tracking_reporting_threshold = MANAGER;
$g_time_tracking_without_note = ON;
$g_time_tracking_billing_rate = 0;
$g_enable_profiles = ON;
$g_add_profile_threshold = REPORTER;
$g_manage_global_profile_threshold = MANAGER;
$g_allow_freetext_in_profile_fields = ON;
$g_plugins_enabled = ON;
$g_plugin_path = $g_absolute_path . 'plugins' . DIRECTORY_SEPARATOR;
$g_manage_plugin_threshold = ADMINISTRATOR;
$g_plugin_mime_types = array(
	    'css' => 'text/css',
	    'js'  => 'text/javascript',
	    'gif' => 'image/gif',
	    'png' => 'image/png',
	    'jpg' => 'image/jpeg',
	    'jpeg' => 'image/jpeg'
);

$g_plugins_force_installed = array();
$g_due_date_update_threshold = NOBODY;
$g_due_date_view_threshold = NOBODY;
$g_due_date_default = '';
$g_subprojects_enabled = ON;
$g_subprojects_inherit_categories = ON;
$g_subprojects_inherit_versions = ON;
$g_show_timer = OFF;
$g_show_memory_usage = OFF;
$g_debug_email = '';
$g_show_queries_count = OFF;
$g_display_errors = array();

if( isset( $_SERVER['SERVER_NAME'] ) &&
	( strcasecmp( $_SERVER['SERVER_NAME'], 'localhost' ) == 0 ||
	  $_SERVER['SERVER_NAME'] == '127.0.0.1' ) ) {
	$g_display_errors[E_USER_WARNING] = DISPLAY_ERROR_HALT;
	$g_display_errors[E_WARNING] = DISPLAY_ERROR_HALT;
	$g_display_errors[E_ALL] = DISPLAY_ERROR_INLINE;
}

$g_show_detailed_errors = OFF;
$g_stop_on_errors = OFF;
$g_log_level = LOG_NONE;
$g_log_destination = '';
$g_show_log_threshold = ADMINISTRATOR;

$g_global_settings = array(
	'global_settings', 'admin_checks', 'allow_signup', 'allow_anonymous_login',
	'anonymous_account', 'compress_html', 'allow_permanent_cookie',
	'cookie_time_length', 'cookie_path', 'cookie_domain',
	'cookie_prefix', 'string_cookie', 'project_cookie', 'view_all_cookie',
	'manage_config_cookie', 'logout_cookie',
	'bug_list_cookie', 'crypto_master_salt', 'custom_headers',
	'database_name', 'db_username', 'db_password', 'db_type',
	'db_table_prefix','db_table_suffix', 'display_errors', 'form_security_validation',
	'hostname','html_valid_tags', 'html_valid_tags_single_line', 'default_language',
	'language_auto_map', 'fallback_language', 'login_method', 'plugins_enabled',
	'session_save_path', 'session_validation', 'show_detailed_errors', 'show_queries_count',
	'stop_on_errors', 'version_suffix', 'debug_email',
	'fileinfo_magic_db_file', 'css_include_file', 'css_rtl_include_file',
	'file_type_icons', 'path', 'short_path', 'absolute_path', 'core_path',
	'class_path','library_path', 'language_path', 'absolute_path_default_upload_folder',
	'ldap_simulation_file_path', 'plugin_path', 'bottom_include_page', 'top_include_page',
	'default_home_page', 'logout_redirect_page', 'manual_url', 'logo_url', 'wiki_engine_url',
	'cdn_enabled', 'public_config_names', 'email_login_enabled', 'email_ensure_unique',
	'impersonate_user_threshold', 'email_retry_in_days'
);

$g_public_config_names = array(
	'access_levels_enum_string',
	'action_button_position',
	'add_bugnote_threshold',
	'add_profile_threshold',
	'admin_site_threshold',
	'allow_account_delete',
	'allow_anonymous_login',
	'allow_blank_email',
	'allow_delete_own_attachments',
	'allow_download_own_attachments',
	'allow_file_upload',
	'allow_freetext_in_profile_fields',
	'allow_no_category',
	'allow_parent_of_unresolved_to_close',
	'allow_permanent_cookie',
	'allow_reporter_close',
	'allow_reporter_reopen',
	'allow_reporter_upload',
	'allow_signup',
	'allowed_files',
	'anonymous_account',
	'antispam_max_event_count',
	'antispam_time_window_in_seconds',
	'assign_sponsored_bugs_threshold',
	'auto_set_status_to_assigned',
	'backward_year_count',
	'bottom_include_page',
	'bug_assigned_status',
	'bug_change_status_page_fields',
	'bug_closed_status_threshold',
	'bug_count_hyperlink_prefix',
	'bug_duplicate_resolution',
	'bug_feedback_status',
	'bug_link_tag',
	'bug_list_cookie',
	'bug_readonly_status_threshold',
	'bug_reminder_threshold',
	'bug_reopen_resolution',
	'bug_reopen_status',
	'bug_report_page_fields',
	'bug_resolution_fixed_threshold',
	'bug_resolution_not_fixed_threshold',
	'bug_resolved_status_threshold',
	'bug_revision_drop_threshold',
	'bug_submit_status',
	'bug_update_page_fields',
	'bug_view_page_fields',
	'bugnote_link_tag',
	'bugnote_order',
	'bugnote_user_change_view_state_threshold',
	'bugnote_user_delete_threshold',
	'bugnote_user_edit_threshold',
	'cdn_enabled',
	'change_view_status_threshold',
	'check_mx_record',
	'complete_date_format',
	'compress_html',
	'cookie_prefix',
	'cookie_time_length',
	'copyright_statement',
	'create_permalink_threshold',
	'create_project_threshold',
	'create_short_url',
	'css_include_file',
	'css_rtl_include_file',
	'csv_columns',
	'csv_separator',
	'custom_field_edit_after_create',
	'custom_field_link_threshold',
	'custom_field_type_enum_string',
	'custom_group_actions',
	'custom_headers',
	'date_partitions',
	'datetime_picker_format',
	'default_bug_additional_info',
	'default_bug_description',
	'default_bug_eta',
	'default_bug_priority',
	'default_bug_projection',
	'default_bug_relationship_clone',
	'default_bug_relationship',
	'default_bug_reproducibility',
	'default_bug_resolution',
	'default_bug_severity',
	'default_bug_steps_to_reproduce',
	'default_bug_view_status',
	'default_bugnote_order',
	'default_bugnote_view_status',
	'default_category_for_moves',
	'default_email_bugnote_limit',
	'default_email_on_assigned_minimum_severity',
	'default_email_on_assigned',
	'default_email_on_bugnote_minimum_severity',
	'default_email_on_bugnote',
	'default_email_on_closed_minimum_severity',
	'default_email_on_closed',
	'default_email_on_feedback_minimum_severity',
	'default_email_on_feedback',
	'default_email_on_new_minimum_severity',
	'default_email_on_new',
	'default_email_on_priority_minimum_severity',
	'default_email_on_priority',
	'default_email_on_reopened_minimum_severity',
	'default_email_on_reopened',
	'default_email_on_resolved_minimum_severity',
	'default_email_on_resolved',
	'default_email_on_status_minimum_severity',
	'default_email_on_status',
	'default_home_page',
	'default_language',
	'default_limit_view',
	'default_manage_tag_prefix',
	'default_manage_user_prefix',
	'default_new_account_access_level',
	'default_notify_flags',
	'default_project_view_status',
	'default_redirect_delay',
	'default_refresh_delay',
	'default_reminder_view_status',
	'default_show_changed',
	'default_timezone',
	'delete_bug_threshold',
	'delete_bugnote_threshold',
	'delete_project_threshold',
	'development_team_threshold',
	'disallowed_files',
	'display_bug_padding',
	'display_bugnote_padding',
	'display_errors',
	'display_project_padding',
	'download_attachments_threshold',
	'due_date_default',
	'due_date_update_threshold',
	'due_date_view_threshold',
	'email_ensure_unique',
	'email_dkim_domain',
	'email_dkim_enable',
	'email_dkim_identity',
	'email_dkim_selector',
	'email_login_enabled',
	'email_notifications_verbose',
	'email_padding_length',
	'email_receive_own',
	'email_separator1',
	'email_separator2',
	'enable_email_notification',
	'enable_eta',
	'enable_product_build',
	'enable_profiles',
	'enable_project_documentation',
	'enable_projection',
	'enable_sponsorship',
	'eta_enum_string',
	'excel_columns',
	'fallback_language',
	'favicon_image',
	'file_download_content_type_overrides',
	'file_type_icons',
	'file_upload_max_num',
	'filter_by_custom_fields',
	'filter_custom_fields_per_row',
	'filter_position',
	'font_family',
	'font_family_choices',
	'font_family_choices_local',
	'forward_year_count',
	'from_email',
	'from_name',
	'handle_bug_threshold',
	'handle_sponsored_bugs_threshold',
	'hide_status_default',
	'history_default_visible',
	'history_order',
	'html_make_links',
	'html_valid_tags_single_line',
	'html_valid_tags',
	'impersonate_user_threshold',
	'issue_activity_note_attachments_seconds_threshold',
	'language_auto_map',
	'language_choices_arr',
	'limit_email_domains',
	'limit_reporters',
	'logo_image',
	'logo_url',
	'logout_cookie',
	'logout_redirect_page',
	'long_process_timeout',
	'lost_password_feature',
	'main_menu_custom_options',
	'manage_config_cookie',
	'manage_configuration_threshold',
	'manage_custom_fields_threshold',
	'manage_global_profile_threshold',
	'manage_news_threshold',
	'manage_plugin_threshold',
	'manage_project_threshold',
	'manage_site_threshold',
	'manage_user_threshold',
	'manage_users_cookie',
	'max_dropdown_length',
	'max_failed_login_count',
	'max_file_size',
	'max_lost_password_in_progress_count',
	'mentions_enabled',
	'mentions_tag',
	'min_refresh_delay',
	'minimum_sponsorship_amount',
	'monitor_add_others_bug_threshold',
	'monitor_bug_threshold',
	'monitor_delete_others_bug_threshold',
	'move_bug_threshold',
	'my_view_boxes',
	'my_view_boxes_fixed_position',
	'my_view_bug_count',
	'news_enabled',
	'news_limit_method',
	'news_view_limit_days',
	'news_view_limit',
	'normal_date_format',
	'notify_flags',
	'notify_new_user_created_threshold_min',
	'plugin_mime_types',
	'plugins_enabled',
	'plugins_force_installed',
	'preview_attachments_inline_max_size',
	'preview_image_extensions',
	'preview_max_height',
	'preview_max_width',
	'preview_text_extensions',
	'print_issues_page_columns',
	'priority_enum_string',
	'priority_significant_threshold',
	'private_bug_threshold',
	'private_bugnote_threshold',
	'private_news_threshold',
	'private_project_threshold',
	'project_cookie',
	'project_status_enum_string',
	'project_user_threshold',
	'project_view_state_enum_string',
	'projection_enum_string',
	'reassign_on_feedback',
	'reauthentication_expiry',
	'reauthentication',
	'recently_visited_count',
	'relationship_graph_enable',
	'relationship_graph_fontname',
	'relationship_graph_fontsize',
	'relationship_graph_max_depth',
	'relationship_graph_orientation',
	'relationship_graph_view_on_click',
	'reminder_receive_threshold',
	'reminder_recipients_monitor_bug',
	'reopen_bug_threshold',
	'report_bug_threshold',
	'report_issues_for_unreleased_versions_threshold',
	'reporter_summary_limit',
	'reproducibility_enum_string',
	'resolution_enum_string',
	'resolution_multipliers',
	'return_path_email',
	'roadmap_update_threshold',
	'roadmap_view_threshold',
	'rss_enabled',
	'search_title',
	'set_bug_sticky_threshold',
	'set_configuration_threshold',
	'set_status_threshold',
	'set_view_status_threshold',
	'severity_enum_string',
	'severity_multipliers',
	'severity_significant_threshold',
	'short_date_format',
	'show_assigned_names',
	'show_avatar_threshold',
	'show_avatar',
	'show_bug_project_links',
	'show_changelog_dates',
	'show_detailed_errors',
	'show_log_threshold',
	'show_memory_usage',
	'show_monitor_list_threshold',
	'show_priority_text',
	'show_product_version',
	'show_project_menu_bar',
	'show_queries_count',
	'show_realname',
	'show_roadmap_dates',
	'show_sticky_issues',
	'show_timer',
	'show_user_email_threshold',
	'show_user_realname_threshold',
	'show_version_dates_threshold',
	'show_version',
	'signup_use_captcha',
	'sort_by_last_name',
	'sort_icon_arr',
	'sponsor_threshold',
	'sponsorship_currency',
	'sponsorship_enum_string',
	'status_colors',
	'status_enum_string',
	'status_enum_workflow',
	'status_icon_arr',
	'stop_on_errors',
	'store_reminders',
	'stored_query_create_shared_threshold',
	'stored_query_create_threshold',
	'stored_query_use_threshold',
	'string_cookie',
	'subprojects_enabled',
	'subprojects_inherit_categories',
	'subprojects_inherit_versions',
	'summary_category_include_project',
	'tag_attach_threshold',
	'tag_create_threshold',
	'tag_detach_own_threshold',
	'tag_detach_threshold',
	'tag_edit_own_threshold',
	'tag_edit_threshold',
	'tag_separator',
	'tag_view_threshold',
	'time_tracking_billing_rate',
	'time_tracking_edit_threshold',
	'time_tracking_enabled',
	'time_tracking_reporting_threshold',
	'time_tracking_stopwatch',
	'time_tracking_view_threshold',
	'time_tracking_with_billing',
	'time_tracking_without_note',
	'timeline_view_threshold',
	'top_include_page',
	'update_bug_assign_threshold',
	'update_bug_status_threshold',
	'update_bug_threshold',
	'update_bugnote_threshold',
	'update_readonly_bug_threshold',
	'upload_bug_file_threshold',
	'upload_project_file_threshold',
	'use_dynamic_filters',
	'user_login_valid_regex',
	'validate_email',
	'version_suffix',
	'view_all_cookie',
	'view_attachments_threshold',
	'view_bug_threshold',
	'view_changelog_threshold',
	'view_configuration_threshold',
	'view_filters',
	'view_handler_threshold',
	'view_history_threshold',
	'view_issues_page_columns',
	'view_proj_doc_threshold',
	'view_sponsorship_details_threshold',
	'view_sponsorship_total_threshold',
	'view_state_enum_string',
	'view_summary_threshold',
	'webmaster_email',
	'webservice_admin_access_level_threshold',
	'webservice_error_when_version_not_found',
	'webservice_eta_enum_default_when_not_found',
	'webservice_priority_enum_default_when_not_found',
	'webservice_projection_enum_default_when_not_found',
	'webservice_readonly_access_level_threshold',
	'webservice_readwrite_access_level_threshold',
	'webservice_resolution_enum_default_when_not_found',
	'webservice_rest_enabled',
	'webservice_severity_enum_default_when_not_found',
	'webservice_specify_reporter_on_add_access_level_threshold',
	'webservice_status_enum_default_when_not_found',
	'webservice_version_when_not_found',
	'wiki_enable',
	'wiki_engine_url',
	'wiki_engine',
	'wiki_root_namespace',
	'window_title',
	'wrap_in_preformatted_text'
);

unset( $t_protocol, $t_host, $t_hosts, $t_port, $t_self, $t_path );
$g_webservice_readonly_access_level_threshold = VIEWER;
$g_webservice_readwrite_access_level_threshold = REPORTER;
$g_webservice_admin_access_level_threshold = MANAGER;
$g_webservice_specify_reporter_on_add_access_level_threshold = DEVELOPER;
$g_webservice_priority_enum_default_when_not_found = 0;
$g_webservice_severity_enum_default_when_not_found = 0;
$g_webservice_status_enum_default_when_not_found = 0;
$g_webservice_resolution_enum_default_when_not_found = 0;
$g_webservice_projection_enum_default_when_not_found = 0;
$g_webservice_eta_enum_default_when_not_found = 0;
$g_webservice_error_when_version_not_found = ON;
$g_webservice_version_when_not_found = '';
$g_webservice_rest_enabled = ON;
$g_issue_activity_note_attachments_seconds_threshold = 3;
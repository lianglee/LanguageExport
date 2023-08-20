<?php
/**
 * Open Source Social Network
 *
 * @package   CDN Storage
 * @author    Engr.Syed Arsalan Hussain Shah
 * @copyright (C) Engr.Syed Arsalan Hussain Shah
 * @license   Open Source Social Network License (OSSN LICENSE)  http://www.opensource-socialnetwork.org/licence
 * @link      https://www.opensource-socialnetwork.org/
 */
 
define('__LanguageExport__', ossn_route()->com . 'LanguageExport/');
require_once(__LanguageExport__ . 'classes/LanguageExport.php');
ossn_register_callback('ossn', 'init', function () {
		if(ossn_isAdminLoggedin()) {												 
			ossn_register_com_panel('LanguageExport', 'settings');
			ossn_register_action('language/export', __LanguageExport__ . 'actions/export.php');	
		}
});
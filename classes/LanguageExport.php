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
class LanguageExport {
		public function __construct($code){
				$this->language_code = $code;	
				$this->temp_dir = ossn_get_userdata('tmp/lang_export/');
		}
		public function generate() {
				$code = $this->language_code;
				$temp = $this->temp_dir;
				
				OssnFile::DeleteDir($temp);

				if(!is_dir($temp)) {
						mkdir($temp, 0755, true);
				}
				//main locale file
				$main_locale_dir = $temp . 'locale/';

				if(!is_dir($main_locale_dir)) {
						mkdir($main_locale_dir, 0755, true);
				}
				copy(ossn_route()->www . "locale/ossn.{$code}.php", $main_locale_dir . "ossn.{$code}.php");

				//components
				$coms = new OssnComponents();
				$list = $coms->getComponents();
				foreach($list as $com) {
						$language_file = ossn_route()->www . 'components/' . $com . '/locale/ossn.' . $code . '.php';
						if(!file_exists($language_file)) {
								continue;
						}
						$newfolder = $temp . 'components/' . $com . '/locale/';
						if(!is_dir($newfolder)) {
								mkdir($newfolder, 0755, true);
						}
						copy($language_file, $newfolder . "ossn.{$code}.php");
				}

				//themes
				$themes = new OssnThemes();
				$list   = $themes->getThemes();
				foreach($list as $theme) {
						$language_file = ossn_route()->www . 'themes/' . $theme . '/locale/ossn.' . $code . '.php';
						if(!file_exists($language_file)) {
								continue;
						}
						$newfolder = $temp . 'themes/' . $theme . '/locale/';
						if(!is_dir($newfolder)) {
								mkdir($newfolder, 0755, true);
						}
						copy($language_file, $newfolder . "ossn.{$code}.php");
				}
		}
		public static function zipDir($folder, $output) {
				$rootPath = realpath($folder);
				if(!is_dir($folder)){
						return false;	
				}
				$zip = new ZipArchive();
				$zip->open($output, ZipArchive::CREATE | ZipArchive::OVERWRITE);

				$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($rootPath), RecursiveIteratorIterator::LEAVES_ONLY);
				foreach($files as $name => $file) {
						if(!$file->isDir()) {
								$filePath     = $file->getRealPath();
								$relativePath = substr($filePath, strlen($rootPath) + 1);
								$relativePath = str_replace('\\', '/', $relativePath);
								$zip->addFile($filePath, $relativePath);
						}
				}
				$zip->close();
		}
		public function genArchive() {
				$this->generate();
				$this->zipDir($this->temp_dir, $this->temp_dir . "langauge-pack-{$this->language_code}.zip");
		}
		public function download(){
				$name = "langauge-pack-{$this->language_code}.zip";
				$file = $this->temp_dir . "langauge-pack-{$this->language_code}.zip";
				$filesize = filesize($file);
				ob_flush();
				header("Content-type: application/zip");
				header('Pragma: public');
				header('Cache-Control: public');
				header("Content-Length: {$filesize}");
				header('Content-Disposition: attachment; filename="'.$name.'"');
				header('Last-Modified: ' . gmdate('D, d M Y H:i:s \G\M\T', time()));
				readfile($file);
				OssnFile::DeleteDir($this->temp_dir);
				exit;
		}
}

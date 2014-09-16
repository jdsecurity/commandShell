<?php
//$dirName = 'e:\kidsDepart\library\CodeIgniterExt';
$dirName = 'e:\kidsDepart\applications';
$dirName = 'E:\kidsDepartPatch\patch_0.02';
$dirName = 'E:\kidsDepart';
$dirName = 'E:\www\github\zf2-source\library\Zend';

$files = Dirs::read($dirName);
$shellContent = '';
$htmlContent = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head><p>';
$i = 0;
foreach ($files as $fileName) {
	$suffixStr = ($i % 5) == 4 ? '</p><br />' : '-----';
	$fileBase = basename($fileName);
	$shellContent .= "/opt/soft/php/bin/php /var/htmlwww/phuml/src/app/phuml -r /var/htmlwww/zf2/library/Zend/{$fileBase} -graphviz -createAssociations false -Neato /var/htmlwww/phuml/html/{$fileBase}.png\n";
	$htmlContent .= "<a href='http://42.96.170.56/phuml/html/{$fileBase}.png' target='_blank'>{$fileBase}</a>{$suffixStr}";
	$i++;
}
$htmlContent = rtrim($htmlContent, '-') . '</p>';
echo $shellContent;
echo $htmlContent;
file_put_contents('shell.txt', $shellContent);
file_put_contents('html.txt', $htmlContent);
exit();

$files = Dirs::read($dirName, true);

foreach ($files as $fileName) {
	if (is_file($fileName) && in_array(Files::extension($fileName), array('php', 'html', 'htm'))) {
		$fileData = Files::read($fileName);
		$fileType = mb_detect_encoding($fileData);//, array('UTF-8', 'GBD', 'LATIN1', 'BIG5'));
		if ($fileType == 'UTF-8') {
			$fileData = file_get_contents($fileName);
			if (preg_match('/^\xEF\xBB\xBF/', $fileData)) {

				while (preg_match('/^\xEF\xBB\xBF/', $fileData)) {
					$fileData = substr($fileData, 3);
				}
				//echo $fileName . '<br />';
				//Files::delete($fileName);
				//copy('E:\kidsDepart\target.php', $fileName);
				if (Files::save($fileName, $fileData)) {
					echo $fileName . '--' . $fileType . ' convert successed';
					echo '<br />';
				}
			}
		}


		continue;
		if ($fileType != 'UTF-8' && empty(strpos($fileName, '/config/'))) {
			echo $fileName . '--' . $fileType . '<br />';
		}
		continue;
		if ($fileType == 'ASCII') {
			$fileData = mb_convert_encoding($fileData, 'utf-8', $fileType);
			Files::delete($fileName);
			copy('E:\kidsDepart\target.php', $fileName);
			if (Files::save($fileName, $fileData)) {
				echo $fileName . '--' . $fileType . ' convert successed';
				echo '<br />';
			}
			//break;
		}
	}
}

class Dirs
{
	public static function read($dirname, $recursive = false)
	{
		static $allInfo;
		$dirname .= subStr($dirname, -1) == '/' ? '' : '/';
		$dirInfo = glob($dirname . '*');
		if ($recursive == false) {
			return $dirInfo;
		} else {
			foreach ($dirInfo as $info) {
				if (is_dir($info)) {
					if (!is_readable($info)) {
						chmod($info, 0777);
					}
					$allInfo[] = $info;
					self::read($info, true);
				} else {
					$allInfo[] = $info;
				}
			}
		}
		return $allInfo;
	}

	public static function rmdir($dirname)
	{
		if (is_dir($dirname) && !is_writeable($dirname)) {
			if (!chmod($dirname, 0666)) {
				return false;
			}
		} elseif (!is_dir($dirname)) {
			return false;
		}
		$dirname .= subStr($dirname, -1) == '/' ? '' : '/';
		$dirInfo = glob($dirname . '*');
		foreach ($dirInfo as $info) {
			if (is_dir($info)) {
				self::rmdir($info);
			} else {
				unlink($info);
			}
		}
		@rmdir($dirname);
	}

	public function mkdir($dir, $mode = 0777)
	{
		if (!is_dir($dir)) {
			$ret = @mkdir($dir, $mode, true);
			if (!$ret) {
				exit('function:mkdir failed');
			}
		}
		return true;
	}
}

class Files
{
	public static function read($filename)
	{
		if (!is_readable($filename)) {
			chmod($filename, 0644);
		}
		return file_get_contents($filename);
	}

	public static function create($filename, $mod = 0666)
	{
		if (!touch($filename) == false) {
			$fp = fopen($filename, 'a+');
			if ($fp) {
				fclose($fp);
			}
		}
		chmod($filename, 0666);
	}

	public static function save($filename, $data, $append = false)
	{
		if (!file_exists($filename)) {
			self::create($filename);
			$append = false;
		}
		if ($append == false) {
			return file_put_contents($filename, $data);
		} else {
			if (!is_writeable($filename)) {
				chmod($filename, 0666);
			}
			return file_put_contents($filename, $data, FILE_APPEND);
		}
	}

	public static function delete($filename)
	{
		if (!is_array($filename)) {
			$filenames = array($filename);
		}
		foreach ($filenames as $filename) {
			if (is_file($filename)) {
				if (!unlink($filename)) {
					chmod($filename, 0666);
					unlink($filename);
				}
			}
		}
	}

	public static function extension($filename)
	{
		return strtolower(pathinfo($filename, PATHINFO_EXTENSION));
	}
}
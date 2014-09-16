<?php
$baseUrl = 'http://localhost/github/shapp/php/yangsh/spider.php';
$basePath = dirname(__FIlE__);
$sourcePath = $basePath . '/source/';
$targetPath = $basePath . '/target/';
$dataPath = $basePath . '/data/';

$action = isset($_GET['action']) ? $_GET['action'] : '';

$currentFile = isset($_GET['file']) ? $_GET['file'] : '';
$currentFileFull = $sourcePath . $currentFile . '.html';
$cacheFile = $dataPath . $currentFile . '.php';
$isForce = false;
switch ($action) {
	case 'fileInfo':
		if (file_exists($cacheFile) && empty($isForce)) {
			exit("File $currentFile is already dealed!");
		}
		
		if (!file_exists($currentFileFull)) {
			exit("File $currentFile is not exists!");
		}
		
		$urls = spider($currentFileFull);
		cacheWrite($cacheFile, $urls);
		break;
	case 'getFile':
		if (!file_exists($cacheFile)) {
			exit("File $currentFile don't get infos!");
		}
		
		$urls = include $cacheFile;
		foreach ($urls as $url) {
			getFile($url);
		}
		break;
	case 'moveFile':
		if (file_exists($currentFileFull) && file_exists($cacheFile)) {
			//copy($currentFileFull, $targetPath . $currentFile . '.html');
			$urls = include $cacheFile;
			$targetUrls = array();
			foreach ($urls as $url) {
				//$fileInfos = pathinfo($url);
				$targetUrl = str_replace('http://www.cndzys.com/', '', $url);
				$targetUrl = str_replace('//', '/', $targetUrl);
				$targetUrl = 'http://localhost/github/shapp/php/yangsh/target/' . ltrim($targetUrl, '/');
				$targetUrls[$url] = $targetUrl;

			}
			$content = file_get_contents($currentFileFull);
			$content = str_replace(array_keys($targetUrls), array_values($targetUrls), $content);
//print_r(array_combine($urls, $targetUrls));
				file_put_contents($targetPath . $currentFile . '.html', $content);
		}
		break;
	default:
		if ($dirHandler = opendir($sourcePath)) {
			while (($elem = readdir($dirHandler)) !== false) {
				$elemFull = $sourcePath . $elem;
				if ($elem == '.' || $elem == '..' || is_dir($elemFull)) {
					continue;
				}
				
				$fileName = substr($elem, 0, strpos($elem, '.'));
				$displayStr .= $elem
						    . '----<a href="' . $baseUrl . '?action=fileInfo&file=' . $fileName . '" target="_blank">获取文件信息</a>'
						    . '----<a href="' . $baseUrl . '?action=getFile&file=' . $fileName . '" target="_blank">获取文件</a>'
							. '----<a href="' . $baseUrl . '?action=moveFile&file=' . $fileName . '" target="_blank">复制文件</a>'
						    . '<br />';		
			}
			closedir($dirHandler);
		}
		echo $displayStr;
		
}

function spider($file)
{
	$content = htmlspecialchars_decode(file_get_contents($file));

	$pattern = '@src=.*"(?P<url>.*)".*@Us';
	$pattern2 = "@src=.*'(?P<url>.*)'.*@Us";
	$pattern3 = '@<link.*href="(?P<css>.*\.css)".*>@Us';
	$pattern4 = "@url\(.*'(?P<images>.*)'.*\)@Us";
	$pattern5 = '@url\(.*"(?P<images>.*)".*\)@Us';
	$pattern6 = '@url\((?P<images>.*)\)@Us';
	preg_match_all($pattern, $content, $url);
	preg_match_all($pattern2, $content, $url2);
	preg_match_all($pattern3, $content, $url3);
	preg_match_all($pattern4, $content, $url4);
	preg_match_all($pattern5, $content, $url5);
	preg_match_all($pattern6, $content, $url6);

	$urls = array_merge($url['url'], $url2['url'], $url3['css'], $url4['images'], $url5['images'], $url6['images']);
	$urls = array_unique($urls);
	
	return $urls;
}

function cacheWrite($cacheFile, $array)
{
	if (!is_array($array)) {
		return false;
	}
	
	$array = "<?php\nreturn " . var_export($array, true) . ";\n?>";
	$strlen = file_put_contents($cacheFile, $array);
	return $strlen;
}

function getFile($url)
{
	global $targetPath, $isForce;
	$url = trim($url);
	echo $url . '====';
	if (empty($url)) {
		return ;
	}	
	$fileInfos = pathinfo($url);
	$validExts = array('css', 'js', 'jpg', 'gif', 'png');
	if (!in_array($fileInfos['extension'], $validExts)) {
		return ;
	}
	
	$baseUrl = 'http://www.cndzys.com/';//themes/moonbasa/';
	if (strpos($url, $baseUrl) === false) {
		$url = $baseUrl . $url;
	}

	$pathInfo = parse_url($url, PHP_URL_PATH);
	echo basename($pathInfo) . '--';
	echo dirname($pathInfo) . '<br />';
	$path = $targetPath . trim(dirname($pathInfo), '/');
	makePath($path);
	$targetFile = $path . '/' . basename($pathInfo);
	echo $targetFile . '==';
	//var_dump(file_exists($targetFile)); var_dump(empty($isForce));
	if (file_exists($targetFile) && empty($isForce)) {
		return ;
	}
	
	$remoteContent = file_get_contents($url);
	file_put_contents($targetFile, $remoteContent);
	return ;
}


function makePath($path)
{
	$basePath = 'E:\www\github\shapp\php\yangsh\target';
	if (is_dir($path) || strpos($path, dirname($basePath)) === false) {
		return true;
	}

	$parentPath = dirname($path);
	if (!is_dir($parentPath)) {
		makePath($parentPath);
	} else {
		mkdir($path);
		return true;
	}
}
/*$str='<a href="test.html">测试页面</a>';
echo html_entity_decode(htmlentities($str));

$str='<a href="test.html">测试页面</a>';
echo htmlspecialchars_decode(htmlspecialchars($str));*/
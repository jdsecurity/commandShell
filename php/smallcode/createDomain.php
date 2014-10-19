<?php
//http://localhost/acanstudio/commandConfigShell/php/domain/createDomain.php?isLocal=is_local
//php /var/htmlwww/acanstudio/commandConfigShell/php/domain/createDomain.php
$isLocal = isset($_GET['isLocal']) ? $_GET['isLocal'] : '';
$isLocal = $isLocal == 'is_local' ? true : false;
$baseInfo = getBaseInfo($isLocal);

$textInfos = getTextInfos($isLocal);
$baseStr = str_replace(array('#PLACE_IP#', '#PLACE_WWW_PATH#', "\r"), array($baseInfo['ip'], $baseInfo['wwwPath'], ''), $textInfos['baseStr']) . "\n";
$domains = getDomains();
$hosts = "127.0.0.1    localhost\n";

foreach ($domains as $domainBase => $infos) {
    $domain = $domainBase . $baseInfo['topDomain'];
    $domainStr = '';
    $isBase = in_array($domainBase, $baseInfo['baseDomain']);
    $domainStr = str_replace(array("\r", '#PLACE_DOMAIN_BASE#'), array('', $domain), $textInfos['baseDomain']) . "\n";
        
    foreach ($infos as $key => $info) {
        $fullDomain = $key . '.' . $domain;
        $hosts .= "127.0.0.1    {$fullDomain}\n";
        $domainStrSub = isset($info['type']) && ($info['type'] == 'node') ? $textInfos['nodeDomain'] : $textInfos['commonDomain'];
        $placeInfos = array("\r", '#PLACE_DOMAIN#', '#PLACE_DOMAIN_PATH#', '#PLACE_HTTP_PATH#', '#PLACE_LOG_PATH#', '#PLACE_NODE_PORT#', '#PLACE_EXT_INFO#');
        $domainPath = isset($info['path']) && !empty($info['path']) ? $info['path'] : $key;
        $trueInfos = array(
            'r' => '',
            'domain' => $fullDomain,
            'domainPath' => $baseInfo['wwwPath'] . $domainPath,
            'httpdPath' => $baseInfo['httpdPath'],
            'logPath' => $baseInfo['logPath'],
            'nodePort' => isset($info['port']) ? $info['port'] : '',
            'extInfo' => isset($info['extInfo']) && isset($textInfos[$info['extInfo']]) ? $textInfos[$info['extInfo']] : '',
        );
        $domainStrSub = str_replace($placeInfos, $trueInfos, $domainStrSub);
        $domainStr .= "\n" . $domainStrSub . "\n";
    }

    if ($isBase) {
        $baseStr .= "\n" . $domainStr;
    } else {
        $file = $baseInfo['httpdPath'] . 'conf/extra/httpd-vhosts-' . $domain . '.conf';
        file_put_contents($file, $domainStr);
    }
    $hosts .= "\n";
} 

$baseFile = $baseInfo['httpdPath'] . 'conf/extra/httpd-vhosts.conf';
file_put_contents($baseFile, $baseStr);
$hostFile = $baseInfo['httpdPath'] . 'conf/hosts';
file_put_contents($hostFile, $hosts);

function getBaseInfo($isLocal)
{

    $local = array(
        'topDomain' => '.biz',
        'baseDomain' => array('iammumu', 'julymom'),
        'ip' => 'localhost',
        'wwwPath' => 'e:/www/',
        'httpdPath' => 'e:/xampp/apache/',
        'logPath' => 'e:/xampp/apache/logs/',
    );

    $online = array(
        'topDomain' => '.com',
        'baseDomain' => array('iammumu', 'julymom'),
        'ip' => '42.96.170.56',
        'wwwPath' => '/var/htmlwww/',
        'httpdPath' => '/opt/soft/httpd/',
        'logPath' => '/var/slog/httpd/logs/',
    );
    
    $baseInfo = $isLocal ? $local : $online;
    return $baseInfo;
}

function getDomains()
{
    //'www' => array('path' => '', 'type' => '', 'port' => '', 'extInfo' => '')
    $domains = array(
        'iammumu' => array(
            'www' => array('path' => 'common', 'extInfo' => 'iammumuExt'),
        ),
        'julymom' => array(
            'www' => array('path' => 'common'),
        ),
        '91zuiai' => array(
            'dev.frame' => array('path' => 'acanstudio/devFrame'),
            'dev.node' => array('path' => 'acanstudio/firstNode', 'type' => 'node'),
            'node' => array('path' => 'wangcan/nodeProject', 'type' => 'node'),
            'dev.zf2' => array('path' => 'wangcan/devZf2'),
            'frame' => array('path' => 'wangcan/lightFrame-demo/public'),
            'zf2' => array('path' => 'wangcan/zf2Project/public'),
            'www' => array('path' => 'common'),
        ),
        'alyee' => array(
            //'*.test' => array('path' => ''),
            'dev.statistic' => array('path' => 'wangcan/ciProject/wwwroot/statistic'),
            'dev.pay' => array('path' => 'wangcan/ciProject/wwwroot/pay'),
            'dev.jzmedia' => array('path' => 'wangcan/ciProject/wwwroot/jzmedia'),
            'dev.passport' => array('path' => 'wangcan/ciProject/wwwroot/passport'),
            'dev.luxury' => array('path' => 'wangcan/ciProject/wwwroot/luxury'),
            'dev.www' => array('path' => 'wangcan/ciProject/wwwroot'),
        ),
        'acanstudio' => array(
            'front' => array('path' => 'acanstudio/webFront'),
            'ucserver' => array('path' => 'common/ucserver'),
            'static' => array('path' => 'common/static'),
            'upload' => array('path' => 'common/upload'),
            'dphp' => array('path' => 'common/dphp'),
            'www' => array('path' => 'common'),
            'docs' => array('path' => 'final/docsold', 'extInfo' => 'rewriteDocs'),
            'blog' => array('path' => 'acanstudio/blog/public'),

            'demo.luxury' => array('path' => 'final/ciProject/wwwroot/luxury'),
            'demo.statistic' => array('path' => 'final/ciProject/wwwroot/statistic'),
            'demo.ucserver' => array('path' => 'final/ciProject/wwwroot/ucserver'),
            'demo.upload' => array('path' => 'final/ciProject/wwwroot/upload'),
            'demo.static' => array('path' => 'final/ciProject/wwwroot/static'),
            'demo.pay' => array('path' => 'final/ciProject/wwwroot/pay'),
            'demo.jzmedia' => array('path' => 'final/ciProject/wwwroot/jzmedia'),
            'demo.passport' => array('path' => 'final/ciProject/wwwroot/passport'),
        ),
    );

    return $domains;
}

function getTextInfos($isLocal)
{

$baseStr = <<<BASESTR
ServerName 127.0.0.1:80

<VirtualHost *:80>
    ServerName #PLACE_IP# 
    DocumentRoot "#PLACE_WWW_PATH#"
</VirtualHost>
BASESTR;

$baseDomain = <<<BASEDOMAIN
<VirtualHost *:80>
    ServerName #PLACE_DOMAIN_BASE#
    RedirectMatch permanent ^/(.*) http://www.#PLACE_DOMAIN_BASE#/$1
</VirtualHost>
BASEDOMAIN;

$virtualDomain = <<<VIRTUALDOMAIN
<VirtualHost *:80>
    ServerName #PLACE_DOMAIN_BASE#
    RedirectMatch permanent ^/(.*) http://www.#PLACE_DOMAIN_BASE#/$1
</VirtualHost>
VIRTUALDOMAIN;

$logStr = $isLocal ? '' : <<<LOGSTR
    ErrorLog "|#PLACE_HTTP_PATH#bin/rotatelogs #PLACE_LOG_PATH#%Y-%m-%d_#PLACE_DOMAIN#-error_log 86400"
    CustomLog "|#PLACE_HTTP_PATH#bin/rotatelogs #PLACE_LOG_PATH#%Y-%m-%d_#PLACE_DOMAIN#-access_log 86400" common
LOGSTR;

$commonDomain = <<<COMMONDOMAIN
<VirtualHost *:80>
    ServerAdmin iamwangcan@163.com
    DocumentRoot "#PLACE_DOMAIN_PATH#"
    ServerName #PLACE_DOMAIN#
{$logStr}
#PLACE_EXT_INFO#
</VirtualHost>
COMMONDOMAIN;

$nodeDomain = <<<NODEDOMAIN
<VirtualHost *:80>
    ServerAdmin iamwangcan@163.com
    ServerName #PLACE_DOMAIN#
    ProxyRequests off

    <Proxy *>
        Order deny,allow
        Allow from all 
    </Proxy>

    <Location />
        ProxyPass http://localhost:#PLACE_NODE_PORT#/
        ProxyPassReverse http://localhost:#PLACE_NODE_PORT#/
    </Location>
</VirtualHost>
NODEDOMAIN;

$iammumuExt = <<<IAMMUMUEXT
    Alias /mumupic "/var/htmlwww/iammumupic"
    <Directory "/var/htmlwww/iammumupic">
        AllowOverride AuthConfig
        AllowOverride All
        Order allow,deny
        Allow from all
        Require all granted
    </Directory>    
IAMMUMUEXT;

$rewriteDocs = <<<REWRITEDOCS
    RewriteEngine on
    RewriteCond $1 !^(zfuml)
    RewriteRule   ^/([^/]+)/?(.*)    /$1/_build/html/$2
REWRITEDOCS;

$textInfos = array('baseStr' => $baseStr, 'baseDomain' => $baseDomain, 'commonDomain' => $commonDomain, 'nodeDomain' => $nodeDomain, 'iammumuExt' => $iammumuExt, 'rewriteDocs' => $rewriteDocs);

return $textInfos;
}

<?php
header("Content-type: text/html; charset=utf-8");

$link = mysql_connect('42.96.170.56', 'duser_remote', 'remote!@#'); 
//$link = mysql_connect('115.29.46.97', 'jzmedia', 'Rmt$%&123'); 
//$link = mysql_connect('182.92.11.176', 'remoteuser', 'ru@123'); 
mysql_query("SET character_set_connection=utf8, character_set_results=utf8, character_set_client=binary", $link);

$menus = array(
    'linkurl' => array('app_code' => 'passport', 'parent_code' => 'passport_plugin_linkurl', 'name' => '友链'),
    'poster' => array('app_code' => 'passport', 'parent_code' => 'passport_plugin_poster', 'name' => '广告'),
    'poster_space' => array('app_code' => 'passport', 'parent_code' => 'passport_plugin_poster', 'name' => '广告位'),
);

$defaultMethods = array(
    'listinfo' => array('name' => '管理', 'display' => 1),
    'add' => array('name' => '添加', 'display' => 2),
    'view' => array('name' => '查看', 'display' => 3),
    'edit' => array('name' => '编辑', 'display' => 3),
    'delete' => array('name' => '删除', 'display' => 3),
);

foreach ($menus as $controller => $menu) {
    $methods = isset($menu['methods']) ? $defaultMethods : $menu['methods'];
    foreach ($methods as $method => $methodInfo) {
        $code = $menu['app_code'] . '_' . $controller . '_' . $method;
        $exitSql = mysql_query
        $data['app_code'] => $menu['app_code'],
        $data['controller'] => $controller,
        $data['method'] => $method,
        $data['display'] => $methodInfo['display'],
        $data['name'] => $method == 'listinfo' ? $methodInfo['name'] . $menu['name'] : $methodInfo['name'],

        mysql_query(
    )
}


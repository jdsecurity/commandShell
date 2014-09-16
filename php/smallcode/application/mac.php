<?php
require_once '/var/htmlwww/products/frame/lib/db.class.php';
$dbhost                 = '192.168.1.188';
$dbuser                 = 'mactest';
$dbpw                   = 'SksdSD434';
$dbcharset              = 'utf8';
$pconnect               = 0;
$dbname                 = 'mac';
$tablepre               = '';

$db = new db();
$db->connect($dbhost, $dbuser, $dbpw, $dbname, $dbcharset, $pconnect, $tablepre);

$db4Path = '/var/htmlwww/products/frame/data/mactable/';
$db4env = new Db4Env();
$db4env->set_data_dir($db4Path);
$db4env->open($db4Path);

$db4 = new Db4($db4env);
$db4->open(null, 'mac_file', 'mac_table');
print_r($db4);
$table = 'contentfinal';
$result = $this->db->query("SELECT id, content FROM `$table` WHERE `status` = 0 LIMIT 10000");
while ($r = $this->db->fetch_array($result)) {
        $mac = $r['mac'];
        //operation($mac);
        $id = $r['id'];
print_r($r);
        //$this->db->query("UPDATE `$table` SET `status` = 1 WHERE `id` = $id");
}

function operation($mac)
{
        global $db4;
        //$counter = $db->get()
        $key = md5($mac) . '_' . $mac;
        $cursor = $db4->cursor();
        $result = $cursor->get($key, $val, DB_SET);
        if ($result) {
                $db4->put($key, $mac);
                $macCounter = $db4->get('macCounter');
                $db4->put('macCounter', $macCounter + 1);
                //$this->isNewMac = true;
        }
}

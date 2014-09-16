<?php
file_put_contents('/root/kao/ri.txt', $argv[2] . $argv[1]);
date_default_timezone_set('UTC');
$TMP_UPDATE_DIR = '/tmp/svntest/games/';

$revpos = $argv[1];// = 70;
$rev = $rev;// = '/home/svn/test/';
$svnlook_log = "/web/svn/bin/svnlook log -r {$rev} {$revpos}";

$svnlook_author = "/web/svn/bin/svnlook author -r {$rev} {$revpos}";

$svn_update = "/web/svn/bin/svn update -r {$rev} {$TMP_UPDATE_DIR}";

$upto_run_managers = array('wangcan', 'user02', 'user03', 'user04');

$update_status_file = "/var/log/svn/status.txt";

$output = array();
exec($svnlook_log, $output);
$log = $output;

$output = array();
exec($svnlook_author, $output);
$author = $output;

function update_to_ssh($update_list)
{
    global $argv, $author_name, $TMP_UPDATE_DIR;
    
    $ssh_update_logfile='/var/log/svn/upload.log';  
    $ssh_root_dir = '/var/www/games/';    

    $log = "";
    $log .= date('Y-m-d H:i:s') . " BEGIN UPDATE TO SSH\n";
    $log .= date('Y-m-d H:i:s') . " Reversion: {$rev}\n";
    $log .= date('Y-m-d H:i:s') . " Author: {$author_name}\n";
    
    $sshid = ssh2_connect('192.168.1.117', 22);
    $ssh_login = ssh2_auth_password($sshid, 'root', 'acanacan');
    $sftpid = ssh2_sftp($sshid);

    if($sshid && $ssh_login){
        $log .= date('Y-m-d H:i:s') . " Connected to SSH Server Success\n";
    }else{
        $log .= date('Y-m-d H:i:s') . " Connected to SSH Server False\n";
        $log .= date('Y-m-d H:i:s') . " UPDATE FALSE\n";
        $log .= date('Y-m-d H:i:s') . " QUIT UPDATE\n\n";
        return false;
    }

    $result = true;
    foreach($update_list as $file_cmd){
        if(substr($file_cmd, 0, 6) == 'Update') continue;        
        $file_cmd = trim($file_cmd);
//echo $file_cmd . "\n";
        $cmd = substr($file_cmd, 0, 1);
        $file = trim(substr($file_cmd, 1));
        $from = $file;
//echo $from . "\n";
        $file = substr($file, strlen($TMP_UPDATE_DIR));    
        //$filename = is_dir($from) ? null : array_pop(explode('/', $file));
//echo $filename;
        $to   = $ssh_root_dir . $file;
//echo $to . "\n";
        $dir = is_dir($from) ? $to : dirname($to);
//echo $dir . "\n";
$test = ssh2_sftp_realpath($sftpid, '/root/test/ppppp');
//$test = ssh2_sftp_readlink($sftpid, "/root/test/f/");
//$test = ssh2_sftp_stat($sftpid, '/root/test/');
//$test = ssh2_exec($sshid, "cdss /root/test/fuck");
//print_r($test);
//echo 'sss'.$test.'ooo';
//exit();
        if(!@ssh2_sftp_readlink($sftpid,"/root/test/$dir")){
//		echo 'yeeee';
            $log .= date('Y-m-d H:i:s') . " SSH_MKD\t{$dir}\n";
            ssh2_sftp_mkdir($sftpid, $dir, true);  
        }
        if(is_dir($from)) continue;

        if($cmd == "U" || $cmd == "A"){
            $result = $result && ssh2_scp_send($sshid, $from, $to);
            $log .= date('Y-m-d H:i:s') . " SSH_SEND\t{$from}\t{$to}" . ($result ? "\tSUCCESS\n" : "\tFALSE\n");

        }else if($cmd == "D"){
            if(is_dir($from)){
                $r = ssh2_sftp_rmdir($sftpid, $to);
                $log .= date('Y-m-d H:i:s') . " SSH_RMD\t{$to}" . ($r ? "\tSUCCESS\n" : "\tFALSE\n");
            }else{
                $result = $result && ssh2_sftp_unlink($sftpid, $to);
                $log .= date('Y-m-d H:i:s') . " SSH_DEL\t{$to}" . ($result ? "\tSUCCESS\n" : "\tFALSE\n");
            }
        }else{
            $log .= date('Y-m-d H:i:s') . " UNKNOWN CMD\t{$cmd}\n";
            continue;
        }

    }
    
    if($result){
        $log .= date('Y-m-d H:i:s') . " UPDATE SUCCESS\n";
    }else{
        $log .= date('Y-m-d H:i:s') . " UPDATE FALSE\n";
    }
    $log .= date('Y-m-d H:i:s') . " END UPDATE\n\n";
    file_put_contents($ssh_update_logfile, $log, FILE_APPEND);

    return $result;
}

$author_name = $author[count($author) -1];
ssh2_connect('192.168.1.117', 22);
if(in_array($author_name, $upto_run_managers)){
//    if(strpos(implode("\n", $log), '[UPTO_RUN_SERVER]') !== false){
        $new_rev = $rev;

        if(!file_exists($update_status_file)){
            file_put_contents($update_status_file, '1|1');
        }
        $update_status = explode('|', file_get_contents($update_status_file));
        
	if($update_status[0] < $update_status[1]){
            $svn_update_r = "/web/svn/bin/svn update -r {$update_status[0]} {$TMP_UPDATE_DIR}";
            exec($svn_update_r);
        }

        $output = array();

        exec($svn_update, $output);
        $update = $output;
/*$update = Array
(
    'D    /tmp/svntest/test',
    'D    /tmp/svntest/install',
    'D    /tmp/svntest/uninstall',
    'A    /tmp/svntest/sindex.php',
    'A    /tmp/svntest/f',
    'A    /tmp/svntest/f/dex.php',
    'U    /tmp/svntest/index.php',
    'A    /tmp/svntest/x.php',
    ' 更新到版本 70。'
);
*/
        $update_success = true;
        $update_success = update_to_ssh($update);

        if($update_success){
            file_put_contents($update_status_file, "{$new_rev}|{$new_rev}");
        }else{            
            file_put_contents($update_status_file, "{$update_status[0]}|{$new_rev}");
        }
//    }
}


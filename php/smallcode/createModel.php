<?php
header("Content-type: text/html; charset=utf-8");

$link = mysql_connect('42.96.170.56', 'duser_remote', 'remote!@#'); 
//$link = mysql_connect('115.29.46.97', 'jzmedia', 'Rmt$%&123'); 
//$link = mysql_connect('182.92.11.176', 'remoteuser', 'ru@123'); 
mysql_query("SET character_set_connection=utf8, character_set_results=utf8, character_set_client=binary", $link);

$templates['controller'] = file_get_contents(__DIR__ . '/template_controller.txt');
$templates['view'] = file_get_contents(__DIR__ . '/template_view.txt');
$templates['model'] = getBaseContent();

$databases = array('workshop_new_luxury', 'workshop_new_pay', 'workshop_new_passport');
foreach ($databases as $database) {
    $tables = getTables($database);
    if (is_array($tables) && !empty($tables)) {
        foreach ($tables as $table) {
            createFiles($database, $table, $templates);
        }
    }
}


function getTables($database)
{
    $tables = array();
    $sql = "SELECT * FROM `information_schema`.`tables` WHERE `TABLE_SCHEMA` = '{$database}'";
    $result = mysql_query($sql);
    while ($row = mysql_fetch_array($result)) {
        $tables[] = $row['TABLE_NAME']; //['comment'] = $row['TABLE_COMMENT'];
    }
    //print_r($tables);
    return $tables;
}

function createFiles($database, $table, $templates)
{
    $tableBase = substr($table, strpos($table, '_') + 1);
    $tableFirst = ucfirst($table);
    foreach ($templates as $template => $contentBase) {
        
        $fieldInfos = getFieldInfos($database, $table);
        $targetStrs = array("\r", '#FIELDINFOS#', '#CLASS#', '#TABLE#');
        $replaceStrs = array('', $fieldInfos, ucfirst($tableBase), $tableBase);
        $content = str_replace($targetStrs, $replaceStrs, $contentBase);
    
        $filePath = __DIR__ . '/data/' . $database . '_' . $template;
        if (!is_dir($filePath)) {
            mkdir($filePath);
        }
        $fileName = $filePath . '/' . $tableBase . 'model.php';
        $fileName = $template == 'model' ? $fileName : str_replace('model', '', $fileName);
        
        echo $fileName . '<br />';
    
        $strlen = file_put_contents($fileName, $content);
    }
}

function getFieldInfos($database, $table)
{
    $sql = "SELECT * FROM `information_schema`.`columns` WHERE `TABLE_SCHEMA` = '{$database}' AND `TABLE_NAME` = '{$table}'";
    $result = mysql_query($sql);
    $fieldInfos = array();
    $string = "        \$fieldInfos['fields'] = array(\n";
    $fieldChange = "        \$fieldInfos['change'] = array(";
    while ($row = mysql_fetch_array($result)) {
        $field = $row['COLUMN_NAME'];
        $comment = empty($row['COLUMN_COMMENT']) ? $field : $row['COLUMN_COMMENT'];
        $string .=  "            '{$field}' => array('name' => '{$comment}'),\n";
        $fieldInfos['fields'][$row['COLUMN_NAME']] = $row['COLUMN_COMMENT'];
        $fieldChange .= $field == 'id' ? '' : "'{$field}', ";
    }
    $fieldChange = rtrim(rtrim($fieldChange), ',') . ');';
    $string .= "        );\n$fieldChange";

    return $string;
}

function getBaseContent()
{
    $baseContent = <<<'BASECONTENT'
<?php
class #CLASS#Model extends ModelBase
{
    public function __construct($data = '')
    {
        $this->table = '#TABLE#';
        parent::__construct($data);
    }

    /**
     * Initial the fields for model
     *
     * @return array the field infos of model
     */
    protected function _fieldInfos()
    {
#FIELDINFOS#

        return $fieldInfos;
    }
}
BASECONTENT;

    return $baseContent;
}

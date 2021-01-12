<?
class Database {

    private $host,
            $user,
            $db_name,
            $pass,
            $pdo;

    public function __construct() {
        try {
            $dbSettings = Settings::initDBSettings();
            $this->pdo = new PDO('mysql:host='.$dbSettings['dbhost'].';dbname='.$dbSettings['dbname'].';charset=utf8', $dbSettings['dbuser'], $dbSettings['dbpass'],array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        } catch (PDOException $e) {
            die('Не могу подключиться к базе данных. <br/> Проверьте данные для подключения в настройках по пути /classes/settings.php<br/><br/>Так же не забудьте импортировать структуру БД из файла <a href="shortify_struct.sql.zip">shortify_struct.sql.zip</a>');
        }
        
    }

    public function getData($from,$what='*',$arParams='') {
        $paramsStr = '';

        if(isset($arParams['JOINS'])) {   
            foreach($arParams['JOINS'] as $join):
                $paramsStr .= $join['TYPE'].' '.$join['TABLE'].' ON '.$join['ON'];
            endforeach;
        }

        if(isset($arParams['WHERE'])) {   
            $paramsStr .= ' WHERE ';   
            if(is_array($arParams['WHERE'])) {   
                foreach($arParams['WHERE'] as $k=>$v):
                    if(strpos($v,'%') === 0)
                        $paramsStr .= $k.' LIKE "'.$v.'%" AND ';
                    else
                        $paramsStr .= $k.'="'.$v.'" AND ';
                endforeach;
                $paramsStr = substr($paramsStr, 0, -5);
            } else $paramsStr .= $arParams['WHERE'];
        }

        if(isset($arParams['ORDER'])) {   
            $paramsStr .= ' ORDER BY ';      
            foreach($arParams['ORDER'] as $k=>$v):
                $paramsStr .= $k.' '.$v.' AND ';
            endforeach;
            $paramsStr = substr($paramsStr, 0, -5);
        }

        if(isset($arParams['DISTINCT'])) {
            $distinctStr = 'DISTINCT '.$arParams['DISTINCT'];
        }

        $what = (isset($distinctStr)) ? $distinctStr : $what;

        $queryStr = "SELECT $what FROM $from $paramsStr";

        $stmt = $this->pdo->prepare($queryStr);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    public function setData($into,$params) {
        $values = [];
        $where = [];
    
        foreach($params as $k=>$v):
            $where[] = "$k";
            $values[] = "'$v'";
        endforeach;
        $where = implode(',',$where);
        $values = implode(',',$values);

        $queryStr = "INSERT INTO $into ($where) VALUES ($values)";

        $stmt = $this->pdo->prepare($queryStr);

        if ($stmt->execute())
            return true;
        
        return true;
    }

    public function updateData($into,$params,$where) {
        $paramsStr = [];
        $whereStr = [];
    
        foreach($params as $k=>$v):
            $paramsStr[] = "$k='$v'";
        endforeach;
        $paramsStr = implode(',',$paramsStr);
    
        foreach($where as $k=>$v):
            $whereStr[] = "$k='$v'";
        endforeach;
        $whereStr = implode(' AND ',$whereStr);

        $queryStr = "UPDATE $into SET $paramsStr WHERE $whereStr";
        
        $stmt = $this->pdo->prepare($queryStr);

        if ($stmt->execute())
            return true;
        
        return true;
    }

    public function deleteData($from,$where='') {
        $whereStr = '';
        if ($where != '') {
            $whereStr = 'WHERE ';
        
            foreach($where as $k=>$v):
                $whereStr .= "$k='$v' AND ";
            endforeach;

            $whereStr = substr($whereStr, 0, -5);
        }

        $queryStr = "DELETE from $from $whereStr";
        
        $stmt = $this->pdo->prepare($queryStr);

        if ($stmt->execute())
            return true;
        
        return true;
    }
  

}
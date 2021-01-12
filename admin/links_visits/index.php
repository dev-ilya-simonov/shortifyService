<?
header('Content-Type: text/html; charset=utf-8');
require($_SERVER['DOCUMENT_ROOT'].'/Connector.php');
$USER = new User();
$db = new Database();

if(isset($_POST['action']) && $_POST['action'] == 'auth'):
    $USER->login($_POST['login'],md5($_POST['pass']));
endif;
if(isset($_GET['action']) && $_GET['action'] == 'logout'):
    $USER->logout();
endif;
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta content="IE=9" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
    <title>Сокращатель | Админка</title>

    <script src="/public/js/jquery.min.js"></script>
    <script src="/admin/assets/js/scripts.js"></script>
    <style>
        input[readonly] {
            border:none;
            cursor:default;
        }

        .full-link {
            width:600px;
        }

        [data-type="delete"] {
            cursor:pointer;
            color:red;
        }
    </style>
</head>
<body>
    
<?if($USER->isAuth()):?><?
            $arFilter = $arParams = [];
            if(isset($_GET['filter']) == 'y'):
                foreach($_GET as $key => $value):
                    if(empty($value)) continue;
                    if(strpos($key,'FILTER') !== false) {
                        $fieldName = explode('FILTER_',$key)[1];
                        switch($fieldName){
                            case 'id':
                                $arFilter[$fieldName] = $value;
                                break;
                            case 'date':
                                $formatDate = date('Y-m-d',strtotime($value));
                                $arFilter[$fieldName] = '%'.$formatDate;
                                break;
                            default:
                                $arFilter[$fieldName] = '%'.$value;
                                break;
                        }
                        
                    }
                endforeach;
            endif;    
            if(!empty($arFilter))
                $arParams['WHERE'] = $arFilter;
        ?>
        <h1>Админка | Переходы</h1>
        <form method="GET">
            <h2>Фильтр</h2>
            <div class="filter-item">
                <label>Дата</label>
                <input type="date" name="FILTER_date" value="<?=(isset($_GET['FILTER_date']) && !empty($_GET['FILTER_date'])) ? $_GET['FILTER_date'] : ''?>" placeholder="<?=date('Y-m-d')?>">
            </div>
            <div class="filter-item">
                <label>IP</label>
                <input type="text" name="FILTER_ip" value="<?=(isset($_GET['FILTER_ip']) && !empty($_GET['FILTER_ip'])) ? $_GET['FILTER_ip'] : ''?>" placeholder="192.168.0.1">
            </div>
            <div class="filter-item">
                <label>Ссылка</label>
                <input type="text" name="FILTER_initial_link" value="<?=(isset($_GET['FILTER_initial_link']) && !empty($_GET['FILTER_initial_link'])) ? $_GET['FILTER_initial_link'] : ''?>" placeholder="Введите часть ссылки">
            </div>
            <input type="hidden" name="filter" value="y"/>
            <button>Фильтровать</button>
        </form>
        <table cellpadding="10" cellspacing="5">
            <tr>
                <td>ID</td>
                <td>Ссылка</td>
                <td>Короткая ссылка</td>
                <td>IP</td>
                <td>Дата</td>
            </tr>
            <?
                $arParams['JOINS'][] = [
                    'TYPE' => 'INNER JOIN',
                    'TABLE' => 'links_visits',
                    'ON' => 'links_visits.link_id=links.id'
                ];
                $links = $db->getData('links','*',$arParams);
                foreach($links as $k => $arItem):
            ?>
                    <tr>
                        <td><?=$arItem['link_id']?></td>
                        <td><p><?=$arItem['initial_link']?><p></td>
                        <td><a href="<?=$arItem['full_short_link']?>"><?=$arItem['full_short_link']?></a></td>
                        <td><p><?=$arItem['ip']?><p></td>
                        <td><p><?=$arItem['date']?><p></td>
                    </tr>
            <?
                endforeach;
            ?>
        </table>
    <?else:?>
        <h1>Авторизация</h1>
        <form method="POST">
            <input type="text" name="login" placeholder="Логин"/>
            <input type="password" name="pass" placeholder="Пароль"/>
            <input type="hidden" name="action" value="auth"/>
            <button>Войти</button>
        </form>
    <?endif;?>
</body>
</html>
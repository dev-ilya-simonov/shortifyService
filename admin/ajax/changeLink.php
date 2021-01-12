<?
require($_SERVER['DOCUMENT_ROOT'].'/Connector.php');
switch($_POST['type']){
    case 'change':
        foreach($_POST as $name => $value):
            if(strpos($name,'FIELD') !== false)
                $fieldName = explode('__',$name)[1];
        endforeach;

        $db = new Database();
        $arParams = [
            "$fieldName" => $_POST['FIELD__'.$fieldName]
        ];
        $arWhere = [
            'id' => $_POST['id'] 
        ];
        $result = $db->updateData('links',$arParams,$arWhere);
        if($result)
            $resp = ['STATUS'=>'OK','MESSAGE'=>'Ссылка успешно изменена'];
        else
            $resp = ['STATUS'=>'ERROR','MESSAGE'=>'Что-то пошло не так'];
        break;
    case 'delete':
        $arWhere = [
            'id' => $_POST['id'] 
        ];
        $result = $db->deleteData('links',$arWhere);
        $result = $db->deleteData('links_visits',$arWhere);
        if($result)
            $resp = ['STATUS'=>'OK','MESSAGE'=>'Ссылка успешно удалена'];
        else
            $resp = ['STATUS'=>'ERROR','MESSAGE'=>'Что-то пошло не так'];
        break;
}
echo json_encode($resp);
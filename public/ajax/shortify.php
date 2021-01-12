<?
require($_SERVER['DOCUMENT_ROOT'].'/Connector.php');

if($_REQUEST['LINK']):
    $shortify = new Shortify($_REQUEST['LINK']);

    $shortify->createShortLink();
    $shortID = $shortify->getID();
    $shortLink = $shortify->renderLink();

    $DB = new Database();
    $arParams = [
        'initial_link' => $_REQUEST['LINK'],
        'short_link' => $shortID,
        'full_short_link' => $shortLink,
        'ip' => $_SERVER['REMOTE_ADDR']
    ];
    if($DB->setData('links',$arParams))
        $resp = ['STATUS'=>'OK','MESSAGE'=>$shortLink];
    else
        $resp = ['STATUS'=>'ERROR','MESSAGE'=>'Произошла ошибка при создании короткой ссылки. Перезагрузите страницу и попробуйте еще раз'];
else:
    $resp = ['STATUS'=>'ERROR','MESSAGE'=>'Не передана ссылка на сокращение'];
endif;

echo json_encode($resp);
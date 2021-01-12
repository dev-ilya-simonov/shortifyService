<?

$db = new Database();

$idUrl = explode('/',$_SERVER['REQUEST_URI'])[2];
$arParams = [
    'WHERE' => [
        'short_link' => $idUrl
    ]
];
$linkArr = $db->getData('links','*',$arParams)[0];
if($linkArr) {
    $arParams = [
        'link_id' => (int) $linkArr['id'],
        'ip' => $_SERVER['REMOTE_ADDR']
    ];
    $db->setData('links_visits',$arParams);
?>
    <script>
        window.location.replace('<?=$linkArr['initial_link']?>');
    </script>
<?
}
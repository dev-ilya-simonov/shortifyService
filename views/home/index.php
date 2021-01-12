<?Template::loadHeader()?>
<h1>Введите адрес, который вы хотите сократить</h1>
<form action="/public/ajax/shortify.php">
    <input type="text" name="LINK" placeolder="Введите адрес ссылки"/>
    <button>Сократить</button>
</form>
<?Template::loadFooter()?>
<?

class Template {
    
    public static function loadHeader() {
        require VIEWS_DIR.'/.default/header.php';
    }

    public static function loadFooter() {
        require VIEWS_DIR.'/.default/footer.php';
    }

}
<?

class Router {
    private $uri,
            $route,
            $params;

    public function __construct() {
        $this->uri = (!empty($_SERVER['REQUEST_URI']) && $_SERVER['REQUEST_URI'] != '/') ? $_SERVER['REQUEST_URI'] : false;
    }

    private function parseUri() {
        $uriArr = explode('?',$this->uri);
        $this->route = $uriArr[0];
        $this->routeArr = explode('/',$this->route);
        //$this->params = $uriArr[1];
    }

    public function load() {
        if($this->uri):
            $this->parseUri();
            switch($this->routeArr[1]){
                case 's':
                    $fn = ROOT . '/shortify/index.php';
                    break;
                case 'admin':
                    $fn = ROOT . '/admin/' . $this->route . '/index.php';
                    break;
                default:
                    $fn = VIEWS_DIR . '/' . $this->route . '/index.php';
                    break;
            }
        else:
            $fn = VIEWS_DIR . '/home/index.php';
        endif;
        
 
        (file_exists($fn)) ? require $fn : require VIEWS_DIR . '/404.php'; 
    }

}
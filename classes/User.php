<?

class User {
    private $session,$user,$db;

    public function __construct() {
        $this->db = new Database();
    }

    public function isAuth() {
        if(!isset($_SESSION['USER']))
            return false;
        else    
            return true;
    }

    public function login($login,$pass) {
        $arParams = [
            'WHERE' => [
                'login' => $login,
                'pass' => $pass
            ]
        ];
        $this->user = $this->db->getData('users','*',$arParams);
        if($this->user)
            $_SESSION['USER'] = md5($this->user[0]['login']);
        else
            return false;
    }

    public function logout() {
        unset($_SESSION['USER']);
    }

    public function httpAuth() {      
       
    }
}
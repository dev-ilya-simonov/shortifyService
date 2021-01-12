<?

class Shortify {
    private $length = 12;
    private $alph = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    private $link,
            $shortLink,
            $shortID;

    public function __construct($link) {
        $this->link = $link;
    }
    
    public function getID() {
        return $this->shortID;
    }

    public function renderLink() {
        $this->shortLink = str_replace('#LINK#',$this->shortID,SHORT_URL_TEMPLATE);
        return $this->shortLink;
    }

    public function createShortLink() {
        $str = '';
        for($i=0; $i < $this->length; $i++):
            $str .= $this->alph[mt_rand(0, strlen($this->alph) - 1)];
        endfor;

        $this->shortID = $str;

        return $this;
    }

}
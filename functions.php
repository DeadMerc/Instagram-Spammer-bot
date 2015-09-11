<?php

/*
 * @autor:Maxim Milchakov
 * @link:vk.com/max7771
 * @date:02 2015 
 */

class InstaBot {

    public $key = '';
    public $cooName = '';
    public $proxy = '';
    public $aNames = '';
    public $Names = '';
    public $proxyAuth = '';
    public $user_id = '';

    //gen cookie file;
    public function __construct($user_id) {
        $this->user_id = $user_id; 
        $name = md5(rand(1000, 9999999999));
        $this->cooName = 'coo/' . $name . '.txt';
        $fp = fopen("coo/$name.txt", "w");
        $this->setProxy();
        $this->getNames();
        
    }

    //get Names for comment
    private function getNames() {

        $db = new SafeMySQL();
        $names = $db->getAll("SELECT text FROM comments WHERE complete='0' AND key_id = ?s",$this->user_id);
        for ($i = 0; $i < 8; $i++) {
            $this->aNames[] = $names[$i][text];
            $this->Names .= $names[$i][text] . ' ';
        }
    }

    // Имена для комментов использованы.
    private function setNamesComplete() {
        $db = new SafeMySQL();
        for ($i = 0; $i < count($this->aNames); $i++) {
            $db->query("UPDATE comments SET complete='1' WHERE text=?s AND key_id = ?s", $this->aNames[$i],$this->user_id);
        }
    }

    private function setProxy() {
        $db = new SafeMySQL();
        $proxys = $db->getAll("SELECT * FROM proxy WHERE remain > 0 AND key_id = ?s",$this->user_id);
        $this->proxy = $proxys[0];
        //$this->proxy = 0;
        //$this->proxyAuth = 'p_deadmerc:DWEc1Doc';
        $proxy = $proxys[0];
        $proxy['remain'] --;
        $db->query("UPDATE proxy SET remain=?i WHERE proxy = ?s AND key_id = ?s", $proxy['remain'], $proxy['proxy'],$this->user_id);
    }

    public function getKey() {
        $url = "https://instagram.com/accounts/login/";
        $page = file_get_contents($url);
        $content = preg_match('/"viewer":null,"csrf_token":"(.*?)"}}/i', $page, $found);
        //print_r($content);die;
        $key = $found[1];
        if (!empty($key)) {
            $this->key = $key;
            //print_r($key);die;
            return 1;
        } else {
            
            return 0;
        }
    }

    public function getStatus() {
        $time = getdate();
        //print_r($time[0]);
        $now = $time[0];
        $urlE = 'https://instagram.com/ajax/bz';
        $ch = curl_init();
        //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        //curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_URL, $urlE);
        //curl_setopt($ch, CURLOPT_REFERER, $urlE);
        //curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, '{"q":[{"page_id":"vbhvhu","posts":[["slipstream:pageview",{"event_name":"pageview","url":"https://instagram.com/accounts/login/ajax/?targetOrigin=https%3A%2F%2Finstagram.com","hostname":"instagram.com","path":"/accounts/login/ajax/","user_time":' . $now . ',"description":"Ajax Login","referer":"https://instagram.com/accounts/login/"},' . $now . ',0]],"trigger":"slipstream:pageview"}],"ts":' . $now . '}');
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (Windows; U; Windows NT 5.0; En; rv:1.8.0.2) Gecko/20070306 Firefox/1.0.0.4");
        //curl_setopt($ch, CURLOPT_HTTPHEADER, array("X-Requested-With: XMLHttpRequest", "Content-Type: application/json; charset=utf-8"));
        $header = array(
            'Accept:*/*',
            'Accept-Encoding:gzip, deflate',
            'Accept-Language:ru-RU,ru;q=0.8,en-US;q=0.5,en;q=0.3',
            'Connection:keep-alive',
            'Content-Type:application/x-www-form-urlencoded; charset=UTF-8',
            'Host:instagram.com',
            'Origin:https://instagram.com',
            'Referer:https://instagram.com/accounts/login/ajax/?targetOrigin=https%3A%2F%2Finstagram.com',
            'Mozilla/4.0 (Windows; U; Windows NT 5.0; En; rv:1.8.0.2) Gecko/20070306 Firefox/1.0.0.4',
            'X-Requested-With:XMLHttpRequest',
            'X-Instagram-AJAX:1',
            'Pragma:no-cache',
            'Cookie:csrftoken=' . $this->key . '; ccode=RU;'
        );
        //curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        //
        if ($this->proxy != '0') {
            //print_r($this->proxy);
            $proxy = explode(':', $this->proxy[proxy]);
            curl_setopt($ch, CURLOPT_PROXYAUTH, CURLAUTH_NTLM);
            curl_setopt($ch, CURLOPT_PROXY, $proxy[0]);
            curl_setopt($ch, CURLOPT_PROXYPORT, $proxy[1]);
            //curl_setopt($ch, CURLOPT_PROXY, $this->proxy);
            if (!empty($this->proxyAuth)) {
                curl_setopt($ch, CURLOPT_PROXYUSERPWD, $this->proxyAuth);
            }
        }


        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cooName);
        curl_setopt($ch, CURLOPT_COOKIEJAR, $this->cooName);
        $result = curl_exec($ch);
        //$cooki = file_get_contents($this->cooName);
        //print_r($cooki);
        //var_dump($result)
        //print_r($result);die;
        if ($result == '{"status":"ok"}') {
            return 1;
        } else {
            echo curl_error($ch);
            return $result . ':ans';
        }
        //echo $result;
        curl_close($ch);
    }

    public function Auth($login, $pass) {
        $urlAuth = 'https://instagram.com/accounts/login/ajax/';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_URL, $urlAuth);
        curl_setopt($ch, CURLOPT_REFERER, 'https://instagram.com');
        //curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_POST, 1);

        if ($this->proxy != '0') {
            $proxy = explode(':', $this->proxy);
            curl_setopt($ch, CURLOPT_PROXY, $proxy[0]);
            curl_setopt($ch, CURLOPT_PROXYPORT, $proxy[1]);
            //curl_setopt($ch, CURLOPT_PROXY, $this->proxy);
            if (!empty($this->proxyAuth)) {
                curl_setopt($ch, CURLOPT_PROXYUSERPWD, $this->proxyAuth);
            }
        }

        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "username=" . $login . "&password=" . $pass . '&intent=');
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (Windows; U; Windows NT 5.0; En; rv:1.8.0.2) Gecko/20070306 Firefox/1.0.0.4");
        //curl_setopt($ch, CURLOPT_HTTPHEADER, array("X-Requested-With: XMLHttpRequest", "Content-Type: application/json; charset=utf-8"));
        $header = array(
            'User-Agent: Mozilla/5.0 (Windows NT 6.2; WOW64; rv:36.0) Gecko/20100101 Firefox/36.0',
            'Accept: */*',
            'Accept-Language: ru-RU,ru;q=0.8,en-US;q=0.5,en;q=0.3',
            'Accept-Encoding: gzip, deflate',
            'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
            'X-Instagram-AJAX: 1',
            'X-CSRFToken: ' . $this->key . '',
            'X-Requested-With: XMLHttpRequest',
            'Referer: https://instagram.com/accounts/login/ajax/?targetOrigin=https%3A%2F%2Finstagram.com',
            'Cookie: csrftoken=' . $this->key . '; ccode=RU;',
            'Connection: keep-alive',
            'Pragma: no-cache',
            'Cache-Control: no-cache',
        );
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);


        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cooName);
        curl_setopt($ch, CURLOPT_COOKIEJAR, $this->cooName);



        $result = curl_exec($ch);
        //print_r($result);die;
        return $result;
        curl_close($ch);
    }

    public function sendMess($messId, $text) {
        //351413639717370901

        $this->setNamesComplete();
        $urlDocoment = 'http://instagram.com/web/comments/' . $messId . '/add/';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_URL, $urlDocoment);
        curl_setopt($ch, CURLOPT_REFERER, 'https://instagram.com');
        //curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_POST, 1);

        if ($this->proxy != '0') {
            $proxy = explode(':', $this->proxy);
            curl_setopt($ch, CURLOPT_PROXY, $proxy[0]);
            curl_setopt($ch, CURLOPT_PROXYPORT, $proxy[1]);
            //curl_setopt($ch, CURLOPT_PROXY, $this->proxy);
            if (!empty($this->proxyAuth)) {
                curl_setopt($ch, CURLOPT_PROXYUSERPWD, $this->proxyAuth);
            }
        }

        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, 'comment_text=' . $this->Names . '');
        //curl_setopt($ch, CURLOPT_POSTFIELDS, 'comment_text=hate https');
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (Windows; U; Windows NT 5.0; En; rv:1.8.0.2) Gecko/20070306 Firefox/1.0.0.4");
        //curl_setopt($ch, CURLOPT_HTTPHEADER, array("X-Requested-With: XMLHttpRequest", "Content-Type: application/json; charset=utf-8"));
        $header = array(
            'Host: instagram.com',
            'User-Agent: Mozilla/5.0 (Windows NT 6.2; WOW64; rv:36.0) Gecko/20100101 Firefox/36.0',
            'Accept: */*',
            'Accept-Language: ru-RU,ru;q=0.8,en-US;q=0.5,en;q=0.3',
            //'Accept-Encoding: gzip, deflate',
            'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
            'X-Instagram-AJAX: 1',
            'X-CSRFToken: ' . $this->key . '',
            'X-Requested-With: XMLHttpRequest',
            'Referer: http://instagram.com/p/TgeNfslLwV/?modal=true',
            //'Content-Length: 21',
            'Cookie: csrftoken=' . $this->key . ';',
            'Connection: keep-alive',
            'Pragma: no-cache',
            'Cache-Control: no-cache'
        );


        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $this->cooName);
        curl_setopt($ch, CURLOPT_COOKIEJAR, $this->cooName);
        $result = curl_exec($ch);
        curl_close($ch);
        $ans = json_decode($result);
        //print_r($ans);die;
        $ans = $ans->status;
        if ($ans == 'ok') {
            return 'ok';
        } else {
            return $ans;
        }
    }

}

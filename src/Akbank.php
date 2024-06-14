<?php

namespace Phpdev;

Class Akbank
{
    
    public $username = "";
    public $pasword = "";
    
    function __construct($username, $password)
    {
        $this->username       = $username;
        $this->password       = $password;
    }
    
    public function hesap_hareketleri()
    {
        
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://firmahizmetleri.akbank.com/Extre_InterfaceService/service.asmx/GetExtre',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/soap+xml;',
            "Authorization: Basic ".base64_encode($this->username.":".$this->password)."",
        ),
        ));
        $result = curl_exec($curl);
        curl_close($curl);
        $xmlobject = @simplexml_load_string($result);
        if(isset($xmlobject->Hesap)){
            return json_encode([
                'statu'=>true,
                'response' =>$xmlobject
            ]);
        } else {
            return json_encode([
                'statu'=>false,
                'response' => (string) $xmlobject->head->title
            ]);
        } 
    }
    
    
}



?>



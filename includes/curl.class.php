<?php
// ------------------------------------------------
// This is a cURL Object
// Created by: Gilberto Cortez
// 
// InteractiveUtopia.com
// Save@InteractiveUtopia.com
// ------------------------------------------------

class CurlServer
{
    private $access_token;

    function __construct($token)
    {
        // Bitly Access Token
        $this->access_token = $token;
    }

    function post_request($url, $json_data)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array( 'Authorization: Bearer ' . $this->access_token , 
                                                    'Content-Type: application/json', 
                                                    'Content-Length: ' . strlen($json_data)
                                                ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        curl_close($ch);
        $serverReponseObject = json_decode($server_output);

        // Debug
        //print_r ( $server_output );
        return $serverReponseObject;
    }

    function patch_request($url, $json_data)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array( 'Authorization: Bearer ' . $this->access_token , 
                                                    'Content-Type: application/json', 
                                                    'Content-Length: ' . strlen($json_data)
                                                ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        curl_close($ch);
        $serverReponseObject = json_decode($server_output);

        // Debug
        //print_r ( $server_output );
        return $serverReponseObject;
    }

    function get_request($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, false);
        $headers = array(
            'Authorization: Bearer ' . $this->access_token
        );
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec($ch);
        curl_close($ch);
        $serverReponseObject = json_decode($server_output);

        // Debug
        print_r ( $server_output );
        return $serverReponseObject;
    }
}
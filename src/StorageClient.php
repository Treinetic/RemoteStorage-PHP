<?php
/**
 * Created by PhpStorm.
 * User: Hasitha Mapalagama (dev.hasitha@gmail.com)
 * Date: 3/19/18
 * Time: 10:15 AM
 */

namespace Treinetic\RStorage;

class StorageClient
{

    private $ACCESS_KEY;
    private $SECRECT_KEY;
    private $URL = "";

    public function __construct($url = null, $aKey = null, $sKey = null)
    {
        $this->ACCESS_KEY = $aKey;
        $this->SECRECT_KEY = $sKey;
        $this->URL = $url;
    }


    public function makeDirectory($path)
    {
        $data = array("path" => $path);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $this->URL . "/api/makeDirectory");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: " . $this->ACCESS_KEY . ":" . $this->SECRECT_KEY));
        $response = curl_exec($ch);
        $json = json_decode($response);
        if ($json->message_id != "SUCCESS") {
            throw new \Exception($json->message);
        }
        return $json->message_id == "SUCCESS";
    }

    public function put($file, $path, $name)
    {
        $data = array(
            "path" => $path,
            "file" => new \CURLFile($file),
            "name" => $name
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $this->URL . "/api/store");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: " . $this->ACCESS_KEY . ":" . $this->SECRECT_KEY));
        $response = curl_exec($ch);
        $json = json_decode($response);
        if ($json->message_id != "SUCCESS") {
            throw new \Exception($json->message);
        }
        return $json->message_id == "SUCCESS";
    }

    public function get($file)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $this->URL . "/api/get?path=" . $file);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: " . $this->ACCESS_KEY . ":" . $this->SECRECT_KEY));
        $response = curl_exec($ch);
        if (empty($response) || curl_getinfo($ch, CURLINFO_HTTP_CODE) != 200) {
            if (!empty($response)) {
                $json = json_decode($response);
                throw new \Exception($json->message);
            }
            throw new \Exception("Unexpected error");
        }
        return $response;
    }

    public function delete($path)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $this->URL . "/api/delete?path=" . $path);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: " . $this->ACCESS_KEY . ":" . $this->SECRECT_KEY));
        $response = curl_exec($ch);
        $json = json_decode($response);
        if ($json->message_id != "SUCCESS") {
            throw new \Exception($json->message);
        }
        return $json->message_id == "SUCCESS";
    }

    public function copy($from, $to)
    {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $this->URL . "/api/copy?src=" . $from . "&dest=" . $to);
        curl_setopt($ch, CURLOPT_PUT, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: " . $this->ACCESS_KEY . ":" . $this->SECRECT_KEY));
        $response = curl_exec($ch);
        $json = json_decode($response);
        if ($json->message_id != "SUCCESS") {
            throw new \Exception($json->message);
        }
        return $json->message_id == "SUCCESS";
    }

    public function move($from, $to)
    {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $this->URL . "/api/move?src=" . $from . "&dest=" . $to);
        curl_setopt($ch, CURLOPT_PUT, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: " . $this->ACCESS_KEY . ":" . $this->SECRECT_KEY));
        $response = curl_exec($ch);
        $json = json_decode($response);
        if ($json->message_id != "SUCCESS") {
            throw new \Exception($json->message);
        }
        return $json->message_id == "SUCCESS";
    }

    public function exists($path)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $this->URL . "/api/exists?path=" . $path);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Authorization: " . $this->ACCESS_KEY . ":" . $this->SECRECT_KEY));
        $response = curl_exec($ch);
        $json = json_decode($response);
        if (!($json->message_id == "EXIST" || $json->message_id == "NOT_FOUND")) {
            throw new \Exception($json->message);
        }
        return $json->message_id == "EXIST";
    }

}
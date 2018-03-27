<?php

error_reporting(E_ALL);
ini_set('display_errors', 'On');


function CallAPI($method, $url, $data)
{
    $curl = curl_init();

    switch ($method)
    {
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);

            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
        case "DELETE":
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
            break;
        default:
            if ($data)
                $url = sprintf("%s?%s", $url, http_build_query($data));
    }


    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HEADER, 1);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec($curl);

    curl_close($curl);

    return $result;
}
header("Content-Type:text/plain");

$data = array('content' => $_POST['content'] ,'methode'=>$_POST['methode'],'langue'=>$_POST['langue'], 'donnee'=> $_POST['donnee']);
if($_POST['methode']=="GET"){
  echo CallAPI($_POST['methode'], $_POST['url'], null);
}else{
  echo CallAPI($_POST['methode'], $_POST['url'], $data);
}
?>

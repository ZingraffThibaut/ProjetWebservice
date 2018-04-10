<?php


include("connexion.php");

$urls = explode("/",$_SERVER['REQUEST_URI']);
$methode = $_SERVER['REQUEST_METHOD'];

//{"id_article":"2","nom":"VTT","prix":"100","id_categ":"1"}

switch ($urls[3]) {
  case 'article':
    if($methode=="GET"){
      if(empty($urls[4])){
        $requete = "SELECT id_article FROM REST_Article ORDER BY id_article";
        $res = $dbh->query($requete);
        $err = $res->errorInfo();
        if(empty($err[2])){
          convertXMLArticles($res);
        }else{
          http_response_code(500);
        }
      }else{
        $requete = "SELECT id_article, nom, prix, id_categ FROM REST_Article WHERE id_article=".$urls[4];
        $res = $dbh->query($requete);
        $err = $res->errorInfo();
        if(empty($err[2])){
          convertXMLArticle($res);
        }else{
          http_response_code(500);
        }
      }
    }else if($methode=="POST"){
      if($_POST["content"]=="application/xml"){
        $dom = new DOMDocument;
        $dom->loadXML($_POST['donnee']);

        $els = $dom->getElementsByTagName('nom');
        foreach ($els as $el) {
            $nom = $el->nodeValue;
        }

        $els = $dom->getElementsByTagName('prix');
        foreach ($els as $el) {
            $prix = $el->nodeValue;
        }

        $els = $dom->getElementsByTagName('categ');
        foreach ($els as $el) {
            $categ = $el->nodeValue;
        }

        if(!empty($nom) && !empty($prix) &&!empty($categ)){
          $requete="INSERT INTO REST_Article VALUES(NULL, '$nom', $prix, $categ)";
          $res = $dbh->query($requete);
          $err = $res->errorInfo();
          if(empty($err[2])){
            echo 'ok';
          }else{
            http_response_code(500);
          }
        }else{
          http_response_code(400);
        }
      }else if($_POST["content"]=="application/json"){
        $data = json_decode($_POST['donnee']);
        if(!empty($data->nom) && !empty($data->prix) &&!empty($data->id_categ)){
          $requete="INSERT INTO REST_Article VALUES(NULL, '$data->nom', $data->prix, $data->id_categ)";
          $res = $dbh->query($requete);
          $err = $res->errorInfo();
          if(empty($err[2])){
            echo 'ok';
          }else{
            http_response_code(500);
          }
        }else{
          http_response_code(400);
        }
      }else{
        http_response_code(500);
      }
    }else if($methode=="DELETE"){
      if(!empty($urls[4])){
        $requete = "DELETE FROM REST_Article WHERE id_article=".$urls[4];
        $res = $dbh->query($requete);
        $err = $res->errorInfo();
        if(empty($err[2])){
          echo 'ok';
        }else{
          http_response_code(500);
        }
      }else{
        http_response_code(400);
      }
    }else{
      http_response_code(404);
    }
  break;
  case 'categorie':
  if($methode=="GET"){
    if(empty($urls[4])){
        $requete = "SELECT id_categ FROM REST_Categ ORDER BY id_categ";
        $res = $dbh->query($requete);
        $err = $res->errorInfo();
        if(empty($err[2])){
          convertXMLCategs($res);
        }else{
          http_response_code(500);
        }
      }else{
        $requete = "SELECT id_categ, nom FROM REST_Categ WHERE id_categ=".$urls[4];
        $res = $dbh->query($requete);
        $err = $res->errorInfo();
        if(empty($err[2])){
          convertXMLCateg($res);
        }else{
          http_response_code(500);
        }
      }
  }else if($methode=="POST"){
    if($_POST["content"]=="application/xml"){
      $dom = new DOMDocument;
      $dom->loadXML($_POST['donnee']);

      $els = $dom->getElementsByTagName('nom');
      foreach ($els as $el) {
          $nom = $el->nodeValue;
      }

      if(!empty($nom)){
        $requete="INSERT INTO REST_Categ VALUES(NULL, '$nom')";
        $res = $dbh->query($requete);
        $err = $res->errorInfo();
        if(empty($err[2])){
          echo 'ok';
        }else{
          http_response_code(500);
        }
      }else{
        http_response_code(400);
      }
    }else if($_POST["content"]=="application/json"){
      $data = json_decode($_POST['donnee']);
      if(!empty($data->nom)){
        $requete="INSERT INTO REST_Categ VALUES(NULL, '$data->nom')";
        $res = $dbh->query($requete);
        $err = $res->errorInfo();
        if(empty($err[2])){
          echo 'ok';
        }else{
          http_response_code(500);
        }
      }else{
        http_response_code(400);
      }
    }else{
      http_response_code(500);
    }
  }else if($methode=="DELETE"){
    if(!empty($urls[4])){
      $requete = "DELETE FROM REST_Categ WHERE id_categ=".$urls[4];
      $res = $dbh->query($requete);
      $err = $res->errorInfo();
      if(empty($err[2])){
        echo 'ok';
      }else{
        http_response_code(500);
      }
    }else{
      http_response_code(400);
    }
  }else{
    http_response_code(404);
  }
    break;

  default:
  http_response_code(404);
  break;
}



function convertXMLArticles($res){

  $xml = new XMLWriter();

      $xml->openURI("php://output");
      $xml->startDocument();
      $xml->setIndent(true);

      $xml->startElement('articles');

      while ($row = $res->fetch()) {

        $xml->startElement("article");

        $xml->writeAttribute('lien', 'http://workspace.simonin-hugo.fr/IUT/REST/HTTPREST/article/'.$row['id_article']);
        $xml->writeRaw($row['id_article']);

        $xml->endElement();
      }

      $xml->endElement();

      header('Content-type: text/xml');
      $xml->flush();

}

function convertXMLArticle($res){

  $row = $res->fetch();

  if($row){

    $xml = new XMLWriter();

    $xml->openURI("php://output");
    $xml->startDocument();
    $xml->setIndent(true);

    $xml->startElement('article');



    $xml->writeAttribute('id',$row['id_article']);

    $xml->startElement("nom");
    $xml->writeRaw($row['nom']);
    $xml->endElement();

    $xml->startElement("prix");
    $xml->writeRaw($row['prix']);
    $xml->endElement();

    $xml->startElement("categ");
    $xml->writeRaw($row['id_categ']);
    $xml->endElement();

    $xml->endElement();

    header('Content-type: text/xml');
    $xml->flush();
  }else{
    http_response_code(404);
  }

}


function convertXMLCategs($res){

  $xml = new XMLWriter();

      $xml->openURI("php://output");
      $xml->startDocument();
      $xml->setIndent(true);

      $xml->startElement('categories');

      while ($row = $res->fetch()) {

        $xml->startElement("categorie");

        $xml->writeAttribute('lien', 'http://workspace.simonin-hugo.fr/IUT/REST/HTTPREST/categorie/'.$row['id_categ']);
        $xml->writeRaw($row['id_categ']);

        $xml->endElement();
      }

      $xml->endElement();

      header('Content-type: text/xml');
      $xml->flush();
}

function convertXMLCateg($res){
  $row = $res->fetch();

  if($row){
    $xml = new XMLWriter();

    $xml->openURI("php://output");
    $xml->startDocument();
    $xml->setIndent(true);

    $xml->startElement('categorie');

    $xml->writeAttribute('id', $row['id_categ']);

    $xml->startElement('nom');
    $xml->writeRaw($row['nom']);
    $xml->endElement();

    $xml->endElement();

    header('Content-type: text/xml');
    $xml->flush();
  }else{
    http_response_code(404);
  }
}

 ?>

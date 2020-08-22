<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_2-4</title>
</head>
<body>
    <form action=""method="post">
    <input type="text"name="str"value="コメント by名前">
    <input type="submit"name="送信">
    </form>
    
    <?php
    if(isset($_POST["str"])&&$_POST["str"]!=""){
    $str=$_POST["str"];
    $filename="02-4.txt";
    
    if(file_exists($filename)){
    $lines = file($filename,FILE_IGNORE_NEW_LINES);
    foreach($lines as $line){
        echo $line . "<br>";
        }
    }
    
    $fp=fopen($filename,"a");
    fwrite($fp,$str."\n");
    fclose($fp);
    
    echo $str."<br>";
    
    if($str=="コメント by名前"){
    echo "完了";
    }
    else{
    echo "書き込んでくれてありがとう！";
      }
}
?>
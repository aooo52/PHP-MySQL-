<?php
         //変数設定
          $filename="005.txt";
          $filenames = "03-05.txt";
          $date=date("Y年m月d日H時i分s秒");
          
        //送信ボタン設定
        if(!empty($_POST["name"]) && !empty($_POST["com"]) 
        && empty($_POST["enum"]) && !empty($_POST["pass"])){
            $pass = $_POST["pass"];
            $name=$_POST["name"]; 
            $com=$_POST["com"];
            if(file_exists($filename)){
                $num=count(file($filename))+1;
            }
            else{
                $num=1;
            }
            $str=$num."<>".$name."<>".$com."<>".$date."<>".$pass."<>"."\n";
            
            $fp=fopen($filename,"a");
            fwrite($fp,$str);
            fclose($fp);
            
            if(file_exists($filenames)){
                $cnt=count(file($filenames))+1;
            }
            else{
                $cnt=1;
            }
            $pstr=$cnt."<>".$pass."<>"."\n";
            
            $pfp=fopen($filenames,"a");
            fwrite($pfp,$pstr);
            fclose($pfp);
            
            
            
        }
                  //削除ボタン設定
        if(isset($_POST["dell"])&&!empty($_POST["pass1"])){
            $del = $_POST["del"];
            $pass2 = $_POST["pass1"];
            $lines = file($filename);
        
            $dfp = fopen("$filename","w");
            foreach($lines as $line){
                $dhoya = explode("<>",$line."\n");
                if(($dhoya[0]!=$del)&&($dhoya[4]!=$pass1)){
                fwrite($dfp,$line);
                }
                elseif($dhoya[4]==$pass1){
                echo "削除しました"."<br>";
                }
            }
            fclose($dfp);
        }
                  //編集ボタン設定
        if(isset($_POST["Esubmit"])&&!empty($_POST["pass2"])){
            $rnum=$_POST["rnum"];
            $pass2=$_POST["pass2"];
            $elines=file($filename,FILE_IGNORE_NEW_LINES);
            foreach($elines as $eline){
                $ehoya=explode("<>",$eline);
                if($ehoya[0]==$rnum && $ehoya[4]==$pass2){
                    $Enumber=$ehoya[0];
                    $Ename=$ehoya[1];
                    $Ecomment=$ehoya[2];
                }
            }
        }
                  //編集実行機能
        if(!empty($_POST["name"]) && !empty($_POST["com"]) 
        && !empty($_POST["enum"]) && !empty($_POST["pass"])){
            $name=$_POST["name"]; 
            $com=$_POST["com"];
            $enum=$_POST["enum"];
            $pass=$_POST["pass"];
            $elines=file($filename,FILE_IGNORE_NEW_LINES);
            $efp=fopen($filename,"w");
            foreach($elines as $eline){
                $ehoya=explode("<>",$eline);
                if($ehoya[0]==$enum){
$estr=$enum."<>".$name."<>".$com."<>".$date."<>".$pass."<>"."\n";
                    fwrite($efp,$estr);
                }
                elseif($ehoya[0]!=$enum){
$estr=$ehoya[0]."<>".$ehoya[1]."<>".$ehoya[2]."<>".$ehoya[3]."<>".$ehoya[4]."\n";
                      fwrite($efp,$estr);
                }
            }
            fclose($efp);
        }
                 //ブザ表示
        if(file_exists($filename)){
            $contents=file($filename,FILE_IGNORE_NEW_LINES);
            foreach($contents as $content){
                $view=explode("<>",$content);
                if($view[0]!=0){
                    echo $view[0]." ".$view[1]." ".$view[2]." ". $view[3]. "<br>";
                }elseif($view[0]==0);
                    echo "";
          }
          }
        ?>
        <!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset=UTF-8>
    <title>mission_3-5</title>
</head>
<body>
    
    
    
        <form action=""method="post">
        <input type="hidden" name="enum" 
        value="<?php if(!empty($_POST["rnum"])){echo $Enumber;}?>">
          
        <input type="text" name="name" placeholder="名前" 
        value="<?php if(!empty($_POST["rnum"])){echo $Ename;} ?>">
          
        <input type="text" name="com" placeholder="コメント" 
        value="<?php if(!empty($_POST["rnum"])){echo $Ecomment;}?>">
          
        <input type="password" name="pass" placeholder="パスワード"
        value="<?php if(!empty($_POST["pass2"])){echo $pass;}?>">
          
        <input type="submit" name="Csubmit"><br>
          
        <input type="text" name="del" placeholder="削除対象番号">
        <input type="password" name="pass1" placeholder="パスワード">
 
        <input type="submit" name="dell" value="削除"><br>
          
        <input type="text" name="rnum" placeholder="編集対象番号">
        <input type="password" name="pass2" placeholder="パスワード">
        
        <input type="submit" name="Esubmit" value="編集">
        </form> 
</body>
</html>
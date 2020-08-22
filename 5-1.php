<?php
    // DB接続設定 

    //4-1(データベースの接続)
    $dsn ='データベース名';
    $user = 'ユーザ名';
    $password = 'パスワード';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    
    //4-2(テーブル作成)
    $sql = "CREATE TABLE IF NOT EXISTS ttttt"
	   ." ("
	   . "id INT AUTO_INCREMENT PRIMARY KEY,"//id int型
	   . "name char(32),"                   //name char型32文字
	   . "comment TEXT,"                    // comment
	   . "date DATETIME,"                  //date
       . "pass varchar(255)"
	   .");";
	 $stmt = $pdo->query($sql);
	 
	//4-3(テーブル一覧表示)
    $sql ='SHOW TABLES';
	    $result = $pdo -> query($sql);
	    foreach ($result as $row){
		    //echo $row[0];
		    //echo '<br>';
		}
		
    //4-4(テーブルの構成詳細)
    $sql ='SHOW TABLES';
	$result = $pdo -> query($sql);
	foreach ($result as $row){
	//	echo $row[0];
		//echo '<br>';
	}
	echo "<hr>";
	
	//4-5(入力)
	if(!empty($_POST["name"]) && !empty($_POST["comment"]) 
	&& !empty($_POST["pass"]) && empty($_POST["str"])){
	$name = $_POST["name"];
	$comment = $_POST["comment"];
	$pass = $_POST["pass"];
	$date=date("Y-m-d H:i:s");
    $sql = $pdo -> prepare("INSERT INTO ttttt (name, comment, date, pass) 
    VALUES (:name, :comment, :date, :pass)");
	$sql -> bindParam(':name', $name, PDO::PARAM_STR);
	$sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
	$sql -> bindParam(':date', $date, PDO::PARAM_STR);
	$sql -> bindParam(':pass', $pass, PDO::PARAM_STR);
	$sql -> execute();
	}
    
    //4-8(削除)
    if(!empty($_POST["dnum"]) && !empty($_POST["dpass"])){
    $dpass = $_POST["dpass"];
    $id = $_POST["dnum"];
    
    $sql = 'SELECT * FROM ttttt';
	$stmt = $pdo->query($sql);
	$results = $stmt->fetchAll();
	    foreach ($results as $row){
            if(($dpass == $row['pass'])&&($id == $row['id'])){
	             $sql = 'delete from ttttt where id=:id';
	             $stmt = $pdo->prepare($sql);
	             $stmt->bindParam(':id', $id, PDO::PARAM_INT);
	             $stmt->execute();
            }
        }
    }
	
		//4-7(編集  フォームに入れる)
    if(!empty($_POST["rnum"]) && !empty($_POST["rpass"])){
	$id = $_POST["rnum"]; //変更する投稿番号
	$rpass = $_POST["rpass"];
	$sql = 'SELECT * FROM ttttt';
	$stmt = $pdo->query($sql);
	$results = $stmt->fetchAll();
	    foreach ($results as $row){
            if(($rpass == $row['pass'])&&($id == $row['id'])){
	             $enum = $row['id'];
		         $ename = $row['name'];
		         $ecom = $row['comment'];
            }
        }
    }
    //編集(フォームに入ってから)
    if(!empty($_POST["str"]) && !empty($_POST["name"]) 
    && !empty($_POST["comment"]) && !empty($_POST["pass"])){
        
	$name = $_POST["name"];
	$comment = $_POST["comment"]; //変更したい名前、変更したいコメントは自分で決めること
	$id = $_POST["str"];
	$pass = $_POST["pass"];
	
	$sql = 'SELECT * FROM ttttt';
	$stmt = $pdo->query($sql);
	$results = $stmt->fetchAll();
	    foreach ($results as $row){
            if(($pass == $row['pass'])&&($id == $row['id'])){
	            $sql = 'UPDATE ttttt SET name=:name,comment=:comment WHERE id=:id';
	            $stmt = $pdo->prepare($sql);
	            $stmt->bindParam(':name', $name, PDO::PARAM_STR);
	            $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
	            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
	            $stmt->execute();
            }
        }
	}
	
		//4-6(出力・表示)
    $sql = 'SELECT * FROM ttttt';
	$stmt = $pdo->query($sql);
	$results = $stmt->fetchAll();
	foreach ($results as $row){
		//$rowの中にはテーブルのカラム名が入る
		echo $row['id'].',';
		echo $row['name'].',';
		echo $row['comment'];
		echo " ".$row['date'].'<br>';
	echo "<hr>";
	}
	
	?>

<!DOCTYPE html>
    <html lang="ja">
    <head>
        <meta charset=UTF-8>
        <title>mission_5-1</title>
    </head>
    <body>

    <form action=""method="post">
        
        <input type="hidden" name="str" placeholder="kakushi" 
        value="<?php if(!empty($_POST["rnum"])){echo $enum;}?>">
        <input type="text" name="name" placeholder="名前" 
        value="<?php if(!empty($_POST["rnum"])){echo $ename;}?>">
        <input type="text" name="comment" placeholder="コメント"
        value="<?php if(!empty($_POST["rnum"])){echo $ecom;}?>">
        <input type="password" name="pass" placeholder="パスワード">
        <input type="submit" name="Csubmit"><br>
        
        <input type="text" name="dnum" placeholder="削除" >
        <input type="password" name="dpass" placeholder="パスワード">
        <input type="submit" name="Csubmit"><br>
        
        <input type="text" name="rnum" placeholder="編集" >
        <input type="password" name="rpass" placeholder="パスワード">
        <input type="submit" name="Csubmit"><br>
        
    </form> 
    </body>
</html>
<?php
//接続
  $dsn = "データベース名";
	$user = 'ユーザー名';
	$password = "パスワード";
  $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

// $sql = 'DROP TABLE tbtest';
//     $stmt = $pdo->query($sql);
//     echo "削除";


//テーブルを作成
	$sql = "CREATE TABLE IF NOT EXISTS tbtest"
	." ("
	. "id INT AUTO_INCREMENT PRIMARY KEY,"
	. "name TEXT,"
	. "comment TEXT"
	.");";
  $stmt = $pdo->query($sql);

 $name = $_POST["name"];
 $text =$_POST["text"];
 $deleteNo=$_POST["deleteNo"];
 $choiceNo=$_POST["choiceNo"];
 $editNo=$_POST["editNo"];
 $pass1=$_POST["pass1"];
 $pass2=$_POST["pass2"];


//  入力
        if(!empty($text)&&!empty($name)&&empty($editNo)&&!empty($pass1)&&$pass1=="pass"){

              $sql = $pdo -> prepare("INSERT INTO tbtest (name, comment) VALUES (:name, :comment)");
              $sql -> bindParam(':name', $name, PDO::PARAM_STR);
              $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
              $name = $_POST["name"];
              $comment =$_POST["text"];//好きな名前、好きな言葉は自分で決めること
              $sql -> execute();
                      echo "書き込み完了";

        }elseif(empty($name)&&empty($text)&&empty($pass1)){
            echo "";
        }elseif(empty($name)){
            echo "no name";
        }elseif(empty($text)){
           echo "no text";

        }elseif(empty($pass1)){
            echo "no pass ";
        }elseif($pass1!="pass1"){
            echo "uncorrect pass";
        }

//削除
        if(!empty($deleteNo)&&!empty($pass2)&&$pass2=="pass"){
            	$id = $deleteNo;
              $sql = 'delete from tbtest where id=:id';
              $stmt = $pdo->prepare($sql);
              $stmt->bindParam(':id', $id, PDO::PARAM_INT);
              $stmt->execute();
       }elseif(empty($deleteNo)&&empty($pass2)){
            echo "";
       }elseif(empty($pass2)||$pass2!="pass2"){
            echo "no pass or uncorrect";
        }

  //編集先の選択
        if(!empty($choiceNo)){
                  $id = $choiceNo;

             $sql = 'SELECT * FROM tbtest WHERE id=:id ';
              $stmt = $pdo->prepare($sql);                  // ←差し替えるパラメータを含めて記述したSQLを準備し、
              $stmt->bindParam(':id', $id, PDO::PARAM_INT); // ←その差し替えるパラメータの値を指定してから、
              $stmt->execute();                             // ←SQLを実行する。
              $results = $stmt->fetchAll();
                foreach ($results as $row){
                  //$rowの中にはテーブルのカラム名が入る

                  $name1=$row['name'];
                  $comment1=$row['comment'];


                echo "<hr>";
                }

        }
  //編集番号を選択後の処理
         if(!empty($text)&&!empty($name)&&!empty($editNo)&&!empty($pass1)&&$pass1=="pass"){
              	$id = $editNo; //変更する投稿番号
                $name = $_POST["name"];
                $comment =$_POST["text"]; //変更したい名前、変更したいコメントは自分で決めること
                $sql = 'UPDATE tbtest SET name=:name,comment=:comment WHERE id=:id';
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':name', $name, PDO::PARAM_STR);
                $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->execute();
                echo "起動";
         }elseif(empty($name)&&empty($text)&&empty($pass1)){
            echo "";
        }elseif(empty($name)){
            echo "no name";
        }elseif(empty($text)){
           echo "no text";

        }elseif(empty($pass1)){
            echo "no pass ";
        }elseif($pass1!="pass1"){
            echo "uncorrect pass";
        }



?>





<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>掲示板</title>
</head>
<body>
 <form action="" method="post" >

        <a>入力フォーム</a><br>
       <input type="text" name="name" value="<?php if (!empty($choiceNo)) {
                                             echo $name1;
                                            } else {
                                             echo "";
                                            } ?>"placeholder="name"><br>
        <input type="text" name="text" value="<?php if (!empty($choiceNo)) {
                                             echo $comment1;
                                            } else {
                                             echo "";
                                            } ?>"placeholder="comment" >
        <input  name="editNo" value="<?php if (!empty($choiceNo)) {
                                             echo $choiceNo;
                                            } else {
                                             echo "";
                                            } ?>"placeholder="変更番号選択" ><br>
        <input  type="text" name="pass1"  placeholder="password"   ><br>
        <input type="submit" name="送信"><br>

       <a>削除フォーム</a><br>
        <input type="text" name="deleteNo" placeholder="削除対象番号"><br>
        <input type="text" name="pass2"  placeholder="password" ><br>
        <input type="submit" name="delete" value="削除"><br>

       <a>編集フォーム</a><br>
        <input type="text" name="choiceNo" placeholder="編集対象番号"><br>

        <input type="submit" name="choice" value="編集"><br>


        <?php




            	$sql = 'SELECT * FROM tbtest';//アスタリスクは全てを
              $stmt = $pdo->query($sql);
              $results = $stmt->fetchAll();
              foreach ($results as $row){
                //$rowの中にはテーブルのカラム名が入る
                echo $row['id'].',';
                echo $row['name'].',';
                echo $row['comment'];
                echo "<br>";


              }

        ?>




</body>


</html>

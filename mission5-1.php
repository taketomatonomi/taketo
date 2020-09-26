<html>
<?php
    if(isset($_POST["name"])){$name=$_POST["name"];}
    if(isset($_POST["com"])){$com=$_POST["com"];}
    if(isset($_POST["num"])){$num=$_POST["num"];}
    if(isset($_POST["edit"])){$edit=$_POST["edit"];}
    if(isset($_POST["flag"])){$q=$_POST["flag"];}

    if(isset($_POST["pass0"])){$pass0=$_POST["pass0"];}
    if(isset($_POST["pass1"])){$pass1=$_POST["pass1"];}
    if(isset($_POST["pass2"])){$pass2=$_POST["pass2"];}



  $dsn = 'データベース名';
  $user = 'ユーザー名';
  $password = 'パスワード';
  $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

  $sql = "CREATE TABLE IF NOT EXISTS tbtest_1"
	." ("
	. "id INT AUTO_INCREMENT PRIMARY KEY,"
	. "name char(32),"
	. "comment TEXT,"
  . "pass TEXT,"
  . "date_1 TEXT"
	.");";
	$stmt = $pdo->query($sql);


  //編集
   if(empty($edit)!=true )
   {
     echo "編集を開始します";
      $sql = 'SELECT * FROM tbtest_1';
      $stmt = $pdo->query($sql);
      $results = $stmt->fetchAll();
       foreach ($results as $row)
       {
        // echo $row['id'];
        // echo $edit."<br>";
         if($edit==$row['id'] && $pass2==$row['pass'])
         {
           $NAME=$row['name'];
           $COME=$row['comment'];
           $PASS=$row['pass'];
           echo "編集します<br>";
         }
       }
   }
?>

<form action="" method="post">
    <input type="text" name="name" value="<?php if(isset($NAME)){echo $NAME;}?>">
    <input type="text" name="com" value="<?php if(isset($COME)){echo $COME;}?>">
    <input type="hidden" name="flag" value="<?php echo $edit;?>">
    <input type="text" name="pass0" value="<?php if(isset($PASS)){echo $PASS;}?>">
    <input type="submit" name="submit">
</form>

<form action="" method="post">
    <input type="number" name="num">
    <input type="text" name="pass1">
    <input type="submit" name="submit1" value="削除">
</form>

<form action="" method="post">
    <input type="number" name="edit">
    <input type="text" name="pass2">
    <input type="submit" name="submit2" value="編集">

</form>


  <?php
  /*追加で書き込み*/
  if(empty($name)!=true&&empty($com)!=true && empty($pass0)!=true && $q==0)
  {
    $date = date("Y年m月d日 H時i分s秒");
    $sql = $pdo -> prepare("INSERT INTO tbtest_1 (name, comment, pass, date_1) VALUES (:name, :comment, :pass, :date_1)");
    $sql -> bindParam(':name', $name, PDO::PARAM_STR);
    $sql -> bindParam(':comment', $com, PDO::PARAM_STR);
    $sql -> bindParam(':pass', $pass0, PDO::PARAM_STR);
    $sql -> bindParam(':date_1', $date, PDO::PARAM_STR);
    $sql -> execute();
    echo "追加で書き込み";
  }else if(empty($name)!=true&&empty($com)!=true&&empty($pass0)!=true&&$q>0)
  {
      $id = $q; //変更する投稿番号
    	$sql = 'UPDATE tbtest_1 SET name=:name,comment=:comment,pass=:pass,date_1=:date_1 WHERE id=:id';
    	$stmt = $pdo->prepare($sql);
    	$stmt->bindParam(':name', $name, PDO::PARAM_STR);
    	$stmt->bindParam(':comment', $com, PDO::PARAM_STR);
      $sql -> bindParam(':pass', $pass0, PDO::PARAM_STR);
      $sql -> bindParam(':date_1', $date, PDO::PARAM_STR);
    	$stmt->bindParam(':id', $id, PDO::PARAM_INT);
    	$stmt->execute();
      echo "編集した";
  }

  /*削除*/
  if(empty($num)!=true && empty($pass1)!=true)
  {
    $id = $num;
    $sql = 'delete from tbtest_1 where id=:id';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
  }

    //おそらく表示なはず
    $sql = 'SELECT * FROM tbtest_1';
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
    foreach ($results as $row)
    {
      //$rowの中にはテーブルのカラム名が入る
      echo $row['id'].',';
      echo $row['name'].',';
      echo $row['comment'].',';
      echo $row['date_1'].',';
      echo "<br>";
    }
    echo "<br>";

  $sql ='SHOW CREATE TABLE tbtest_1';
  $result = $pdo -> query($sql);
  foreach ($result as $row){
    echo $row[1];
  }
  echo "<hr>";
?>
</html>

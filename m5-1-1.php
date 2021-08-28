<!DOCUTYPE>
<html lang="ja">
<head>
    <meta chraset="UTF-8">
    <title>mission_5-1</title>
</head>
<body>
<?php
$dsn="mysql:dbname=:***;host=localhost";
$user="***";
$password="***";
$pdo= new PDO($dsn,$user,$password,array(PDO::ATTR_ERRMODE =>PDO::ERRMODE_WARNING));

$sql="CREATE TABLE IF NOT EXISTS WW"
    ."("
    ."id int AUTO_INCREMENT PRIMARY KEY,"
    ."name CHAR(32),"
    ."comment TEXT,"
    ."date DATETIME,"
    ."password CHAR(32)"
    .");";
    $stmt= $pdo->query($sql);


//編集選択
if(!empty($_POST["edit"])&&!empty($_POST["pass2"])){
    $edit=$_POST["edit"];
    $pass2=$_POST["pass2"];
    $ee=$pdo -> query("SELECT * FROM WW");
    //$ee ->fetch(PDO::FETCH_ASSOC);
    //$ee ->fetchAll();
    $eee= $ee -> fetchAll();
    foreach($eee as $row){
        if($pass2==$row["password"]&&$row["id"]==$edit){
            $ehidden=$row["id"];
            $ename=$row["name"];
            $ecomment=$row["comment"];
        }elseif($row["id"]==$edit&&$row["password"] !==$pass2){
            echo "パスワードが一致しません"."<br>";
            //echo "<input type="text" name="name" placeholder="名前">"."<br>";
           // echo "<input type="text" name="comment" placeholder="コメント">"."<br>";
           // echo "<input type="num" name="hidden">";
            }
    }//var_dump($row);
}
//削除機能
if(!empty($_POST["delete"])&&!empty($_POST["pass1"])){
    //$cc="DELETE FROM WW WHERE id=:id"
    //echo "checkif_in1";
    $delete=$_POST["delete"];//削除番号
    $pass1=$_POST["pass1"];//パスワード
    $cc="SELECT * FROM WW";
    $dd= $pdo -> query($cc);
    //$dd= $pdo -> prepare($cc);
    //$dd -> execute();
    //$dd -> fetch(PDO::FETCH_ASSOC);
    //$dd -> fetchAll();
    $ddd= $dd -> fetchAll();
    //echo "ppp";
   foreach($ddd as $row){
            if($row["password"]==$pass1&&$row["id"]==$delete){
            $ee = $pdo ->prepare("DELETE FROM WW WHERE id=:id");
            $ee -> bindParam(":id",$delete,PDO::PARAM_INT);
            //$ee -> bindParam(":password",$pass1,PDO::PARAM_INT);
            $ee -> execute();
        }elseif($row["id"]==$delete&&$row["password"] !== $pass1){
            echo "パスワードが違います";
        }
    }
}

?>

<form action="" method="POST">
    投稿フォーム<br>
<label>名前<br>
    <input type="txt" name="name" value="<?php if(!empty($ename)){echo $ename;}?>" placeholder="名前"><br>
</label>
<label>コメント<br>
    <input type="txt" name="comment" value="<?php if(!empty($ecomment)){echo $ecomment;}?>" placeholder="コメント"><br>
</label>
<label>パスワード<br>
    <input type="password" name="pass" placeholder="パスワード">
</label>
    <input type="hidden" name="hidden" value="<?php if(!empty($ehidden)){echo $ehidden;}?>">
    <input type="submit" name="submit" value="送信"><br>
    <br>
    削除フォーム<br>
<label>削除番号<br>
    <input type="num" name="delete" placeholder="削除番号"><br>
</label>
<label>パスワード<br>
    <input type="password" name="pass1" placeholder="パスワード">
</label>
    <input type="submit" name="submit"  value="削除"><br>
    <br>
    編集フォーム<br>
<label>編集番号<br>
    <input type="num" name="edit" placeholder="編集番号"><br>
</label>
<label>パスワード<br>
    <input type="password" name="pass2" placeholder="パスワード">
    <input type="submit" name="submit" value="編集">
</label>
</form>

<?php
//新規投稿
$date=date("Y/m/d H:i:s");
if(!empty($_POST["name"])&&!empty($_POST["comment"])&&!empty($_POST["pass"])&&empty($_POST["hidden"])){
     $aa="INSERT INTO WW (id,name,comment,date,password) VALUES(:id,:name,:comment,:date,:password)";
     $bb = $pdo-> prepare($aa);//データベースに結果を入れた塊
     $bb -> bindParam(":id",$NUll);
     $bb -> bindParam(":name",$_POST["name"],PDO::PARAM_STR);
     $bb -> bindParam(":comment",$_POST["comment"],PDO::PARAM_STR);
     $bb -> bindParam(":date",$date,PDO::PARAM_STR);
     $bb -> bindParam(":password",$_POST["pass"],PDO::PARAM_INT);
     $bb ->execute();
     //データベースに投稿内容を書き出すことが出来た
}


//編集機能
//echo "ppp";
if(!empty($_POST["name"])&&!empty($_POST["comment"])&&!empty($_POST["hidden"])){
    $ff=$pdo->prepare("UPDATE WW SET name=:name,comment=:comment WHERE id=:id");
    $ff -> bindParam(":name",$_POST["name"],PDO::PARAM_STR);
    $ff -> bindParam(":comment",$_POST["comment"],PDO::PARAM_STR);
    $ff -> bindParam(":id",$_POST["hidden"],PDO::PARAM_INT);
    $ff -> execute();
    //echo "編集しました";
}
$ee="SELECT * FROM WW";
$gg= $pdo ->query($ee);
//$gg ->fetch(PDO::FETCH_ASSOC);
//$gg -> fetchAll();
$ggg= $gg ->fetchAll();
foreach($ggg as $row){
    echo $row["id"].",";
    echo $row["name"].",";
    echo $row["comment"].",";
    echo $row["date"].",";
    echo "<hr>";
}

?>
</body>
</html>

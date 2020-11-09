<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>mission_5-1</title>
    </head>
    <body>
        <?php
            //入力データを変数に代入
            $str1=$_POST["name"];  $str2=$_POST["comment"];
            $num=$_POST["num1"];   $dstr=$_POST["num2"]; $editnum=$_POST["num3"];
            $pass1=$_POST["pass1"]; $pass2=$_POST["pass2"]; $pass3=$_POST["pass3"];
            $date=date("Y/m/d H:i:s");
            
            //DB接続
            $dsn ='データベース名';
            $user = 'ユーザー名';
            $password = 'パスワード';
            $pdo = new PDO($dsn,$user,$password,array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_WARNING));
            
            //テーブル作成
            $sql="CREATE TABLE IF NOT EXISTS tb_7"
            ."("
            ."id INT AUTO_INCREMENT PRIMARY KEY,"
            ."name char(32),"
            ."comment TEXT,"
            ."date DATETIME"
            .");";
            $stmt=$pdo->query($sql);
            
            /*テーブルを表示
            $sql='SHOW TABLES';
            $result = $pdo -> query($sql);
                foreach($result as $row){
                    echo $row[0];
                    echo '<br>';
                }
            echo "<hr>";
            
	    
    	    //テーブルの内容表示
    	    $sql ='SHOW CREATE TABLE tb_7';
    	    $result = $pdo -> query($sql);
    	    foreach ($result as $row){
    		    echo $row[1];
    	    }
    	    echo "<hr>";*/
    	    
    	//ボタン1が押されたとき   
        if($_POST["submit1"]){
            //編集欄に数字があれば編集
            if(!empty($_POST["num1"])){
                if(!empty($_POST["name"]) && !empty($_POST["comment"])){
                    if(empty($_POST["pass1"])){
    	            $mess1= "ERROR:パスワードを入力してください";
    	            }elseif($pass1 != "nyanta"){
    	                $mess2= "ERROR:パスワードが違います";
    	            }else{
        	             $id = $num; 
                    	 $sql = 'update tb_7 set name=:name,comment=:comment, date=:date where id=:id';
                    	 $stmt = $pdo->prepare($sql);
                    	 $stmt->bindParam(':name', $str1, PDO::PARAM_STR);
                    	 $stmt->bindParam(':comment', $str2, PDO::PARAM_STR);
                    	 $stmt->bindParam(':date', $date, PDO::PARAM_STR);
                    	 $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                    	 $stmt->execute();
    	            } 
                }elseif(!empty($_POST["name"]) && empty($_POST["comment"])){
                    $mess3= "ERROR:コメントを入力してください";
                }elseif(empty($_POST["name"]) && !empty($_POST["comment"])){
                    $mess4= "ERROR:名前を入力してください";
                }else{
                    $mess5= "ERROR:名前とコメントを入力してください";
                }
            }else{
                //編集欄に数字が無ければ新たにデータを書き込み
                if(!empty($_POST["name"]) && !empty($_POST["comment"])){
                    if(empty($_POST["pass1"])){
    	            $mess1= "ERROR:パスワードを入力してください";
    	            }elseif($pass1 != "nyanta"){
    	                $mess2= "ERROR:パスワードが違います";
    	            }else{
    	                $sql = $pdo -> prepare("INSERT INTO tb_7 (name, comment,date) VALUES (:name, :comment, :date)");
                	    $sql -> bindParam(':name', $name, PDO::PARAM_STR);
                	    $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
                	    $sql -> bindParam(':date', $date, PDO::PARAM_STR);
                	    $name = $str1;
                	    $comment = $str2; 
                	    $sql -> execute();
    	            }
                }elseif(!empty($_POST["name"]) && empty($_POST["comment"])){
                    $mess3= "ERROR:コメントを入力してください";
                }elseif(empty($_POST["name"]) && !empty($_POST["comment"])){
                    $mess4= "ERROR:名前を入力してください";
                }else{
                    $mess5= "ERROR:名前とコメントを入力してください";
                }
            }
        }
        //削除ボタンが押されたら
        if($_POST["submit2"]){
    	    
    	    //削除フォームに入力あるとき
    	    if(!empty($_POST["num2"])){
    	        if(empty($_POST["pass2"])){
    	            $mess1= "ERROR:パスワードを入力してください";
    	        }elseif($pass2 != "kiki"){
    	            $mess2= "ERROR:パスワードが違います";
    	        }else{
    	            $id = $dstr;
                	$sql = 'delete from tb_7 where id=:id';
                	$stmt = $pdo->prepare($sql);
                	$stmt->bindParam(':id', $id, PDO::PARAM_INT);
                	$stmt->execute();
            	}
    	    }else{
    	        $mess6= "ERROR:削除したい投稿の番号を指定してください";
    	    }
        }
        
        //ボタン3が押されたら
        if($_POST["submit3"]){
            //編集番号が空でなければ、編集開始
            if(!empty($_POST["num3"])){
                if(empty($_POST["pass3"])){
                    $mess1= "ERROR:パスワードを入力してください";
                }elseif($pass3 != konyanta){
                    $mess2= "ERROR:パスワードが違いますよ";
                }else{
                    $sql = 'SELECT * FROM tb_7';
                	$stmt = $pdo->query($sql);
                	$results = $stmt->fetchAll();
                	foreach ($results as $row){
                	    if($row['id'] == $editnum){
                		    $rename=$row['name'];
                		    $recomment=$row['comment'];
                		    $editnum=$row['id'];
                	    }
                    }
                }
            }else{
                $mess7= "ERROR:編集したい投稿の番号を選択してください";
            }
        }
            
            ?>
            
            <form action="" method="post">
                【 投稿フォーム 】<br>
                お名前　　：<input type="text" name="name" placeholder="お名前" value="<?php echo $rename; ?>"><br>
                コメント　：<input type="text" name="comment" placeholder="コメント" value="<?php echo $recomment; ?>">
                <br>
                <input type="hidden" name="num1" value="<?php echo $editnum; ?>">
                パスワード：<input type="password" name="pass1" placeholder="パスワード"><br>
                <input type="submit" name="submit1" value="送信"><br>
                <p></p>
                【 削除フォーム 】<br>
                削除したい番号：<input type="num" name="num2" placeholder="削除したい番号" ><br>
                パスワード　　：<input type="password" name="pass2" placeholder="パスワード"><br>
                <input type="submit" name="submit2" value="削除"><br>
                <p></p>
                【 編集フォーム 】<br>
                編集したい番号：<input type="num" name="num3" placeholder="編集したい番号" ><br>
                パスワード　　：<input type="password" name="pass3" placeholder="パスワード"><br>
                <input type="submit" name="submit3" value="編集"><br>
                <p></p>
            </form>
            <?php
            //errorを表示
            echo $mess1.$mess2.$mess3.$mess4.$mess5.$mess6.$mess7."<br>";
            //入力したデータを表示
            echo "<hr>";
            echo "【投稿内容】<br>";
            $sql = 'SELECT * FROM tb_7';
        	$stmt = $pdo->query($sql);
        	$results = $stmt->fetchAll();
        	foreach ($results as $row){
        		echo $row['id'].',';
        		echo $row['name'].',';
        		echo $row['comment'].',';
        		echo $row['date'].'<br>';
        	}
        	?>
    </body>
</html>

<?php

$comment_array = array();

//DB接続
try{
  $pdo = new PDO('mysql:host=localhost;dbname=test', 'testuser', 'testpass');
}catch(PDOException $e){
  echo $e->getMessege();
}
  if(!empty($_POST['submitButton'])){
    $postDate = date("Y-m-d H:i:s");
    try{
      $stmt = $pdo->prepare("INSERT INTO `testtable` (`username`, `comment`, `postDate`) VALUES (:username, :comment, :postDate);");
      $stmt->bindParam(':username', $_POST['username'], PDO::PARAM_STR);
      $stmt->bindParam(':comment', $_POST['comment'], PDO::PARAM_STR);
      $stmt->bindParam(':postDate', $postDate, PDO::PARAM_STR);

      $stmt->execute();
    }catch(PDOException $e){
      echo $e->getMessege();
    }
  }

  //DBからコメントデータを取得する
  $sql = "SELECT * FROM `testtable`;";
  $comment_array = $pdo->query($sql);

  //DBの接続を閉じる
  $pdo = null;
?>

<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>PHP-DB-Practice</title>
    <link rel="stylesheet" href="./style.css">
  </head>
  <body>
    <h1 class="title">PHPで掲示板アプリ</h1>
    <hr>
    <div class="boardWrapper">
      <section>
        <?php foreach($comment_array as $comment) :?>
        <article>
          <div class="wrapper">
            <div class="nameArea">
              <span>名前：</span>
              <p class="username"><?php echo $comment['username']; ?></p>
              <time>:<?php echo $comment['postDate']; ?></time>
            </div>
            <p class="comment"><?php echo $comment['comment']; ?></p>
          </div>
        </article>
          <?php endforeach ?>
      </section>
      <form method="POST" class="formWrapper">
        <div>
          <input type="submit" value="書き込む" name="submitButton">
          <label for="">名前：</label>
          <input type="text" name="username">
        </div>
        <div>
          <textarea name="comment" class="commentTextArea"></textarea>
        </div>
      </form>
    </div>
  </body>
</html>

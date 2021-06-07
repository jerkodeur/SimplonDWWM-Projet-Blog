<?php

$page = isset($_GET['page']) ? $_GET['page'] : 'post.home';
$path = dirname(__DIR__);

ob_start();
try {
    if ($page === 'post.home') {

        try {
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
            ];
            $db = new PDO('mysql:host=localhost;dbname=simplon_blog', 'root', '', $options);
        } catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage() . "<br/>";
            die();
        }

        $request = $db->query('SELECT id, title, LEFT(content, 100) as content, user, date FROM post');
        $request->setFetchMode(PDO::FETCH_ASSOC);
        $posts = $request->fetchAll();
        $request->closeCursor();

        require $path . '/view/post/home.php';
    } elseif ($page === 'post.show') {

        try {
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
            ];
            $db = new PDO('mysql:host=localhost;dbname=simplon_blog', 'root', '', $options);
        } catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage() . "<br/>";
            die();
        }

        $request = $db->prepare('SELECT * FROM post WHERE id=?');
        $request->execute([$_GET['id']]);
        $request->setFetchMode(PDO::FETCH_ASSOC);
        $post = $request->fetch();
        $request->closeCursor();

        require $path . '/view/post/show.php';
    } elseif ($page === 'user.connect') {
        require $path . '/view/user/connectionForm.php';
    } else {
        throw new Exception('404');
    }
} catch (Exception $e) {
    require $path . '/view/error/' . $e->getMessage() . '.php';
}
$content = ob_get_clean();

require $path . '/view/base.php';

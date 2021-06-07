<?php

$page = isset($_GET['page']) ? $_GET['page'] : 'post.home';

ob_start();
try {
    if ($page === 'post.home') {

        try {
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
            ];
            $db = new PDO('mysql:host=localhost;dbname=blog', 'root', '', $options);
        } catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage() . "<br/>";
            die();
        }

        $request = $db->query('SELECT id, title, LEFT(content, 100) as content, user, date FROM post');
        $request->setFetchMode(PDO::FETCH_ASSOC);
        $posts = $request->fetchAll();
        $request->closeCursor();

        require 'home.php';
    } elseif ($page === 'post.show') {

        try {
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
            ];
            $db = new PDO('mysql:host=localhost;dbname=blog', 'root', '', $options);
        } catch (PDOException $e) {
            print "Erreur !: " . $e->getMessage() . "<br/>";
            die();
        }

        $request = $db->prepare('SELECT * FROM post WHERE id=?');
        $request->execute([$_GET['id']]);
        $request->setFetchMode(PDO::FETCH_ASSOC);
        $post = $request->fetch();
        $request->closeCursor();

        require 'show.php';
    } elseif ($page === 'user.connect') {
        require 'connectionForm.php';
    } else {
        throw new Exception('404');
    }
} catch (Exception $e) {
    require 'error404.php';
}
$content = ob_get_clean();

require 'base.php';

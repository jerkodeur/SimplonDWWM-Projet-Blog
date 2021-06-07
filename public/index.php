<?php

$page = isset($_GET['page']) ? $_GET['page'] : 'post.home';
$path = dirname(__DIR__);

try {
    if ($page === 'post.home') {
        require $path . '/controller/postController.php';
        home();
    } elseif ($page === 'post.show') {
        require $path . '/controller/postController.php';
        show();
    } elseif ($page === 'user.connect') {
        require $path . '/controller/userController.php';
        home();
    } else {
        throw new Exception('404');
    }
} catch (Exception $e) {
    require $path . '/controller/errorController.php';
    throwError($e);
}

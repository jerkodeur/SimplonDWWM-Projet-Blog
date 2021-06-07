<?php

$page = isset($_GET['page']) ? $_GET['page'] : 'post.home';
$path = dirname(__DIR__);

ob_start();
try {
    if ($page === 'post.home') {
        require $path . '/model/postRepository.php';
        $posts = findAll();

        require $path . '/view/post/home.php';
    } elseif ($page === 'post.show') {
        require $path . '/model/postRepository.php';
        $post = findOneById($_GET['id']);

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

<!DOCTYPE html>
<html>
<?php include __DIR__ . '/../partial/head.php' ?>
<body>
    <?php include __DIR__ . '/../partial/menu.php' ?>

    <div class="wrapper" style="max-width: 600px;">
        <div class="posts">
            <?php $likes = explode(';', $_SESSION['user']['likes']); ?>

            <div class="box text-center no-padding" data-post-id="<?=$post['id']?>">
                <?php if ($_SESSION['user']['id'] == $post['user_id']) : ?>
                    <span class="close" style="position:absolute;right:15px;top:18px;" title="Excluir post" onclick="if (confirm('Tem certeza que deseja excluir este post?')) excluirPost(<?=$post['id']?>);">&times;</span>
                <?php endif; ?>
                <div class="big-heart"></div>
                <header>
                    <a href="/<?=$post['login']?>">
                        <div class="avatar" style="background-image: url(<?=!empty($post['avatar']) ? $post['avatar'] : '/public/img/avatar.jpg' ?>)" title="<?=$post['name']?>"></div>
                        <p class="username"><?=$post['login']?></p>
                    </a>
                </header>
                <div class="post" style="background-image: url(<?= $post['img_path'] ?>)"></div>
                <footer>
                    <a href="#" class="like<?= in_array($post['id'], $likes) ? ' liked' : ''; ?>" title="Curtir">Curtir</a>
                    <p class="likes"><span><?=$post['likes']?></span>&nbsp;curtidas</p>
                    <?php $livestamp = str_replace(' ', 'T', $post['created_at']) ?>
                    <p class="created_at" data-livestamp="<?=$livestamp?>" title="<?= 'Postado em ' . date('d/m/y \à\s H\hi', strtotime($livestamp)) ?>"></p>
                </footer>
            </div>
        </div>
        
    </div>

    <?php include __DIR__ . '/../partial/footer.php' ?>
    <?php include __DIR__ . '/../partial/scripts.php' ?>
</body>
</html>
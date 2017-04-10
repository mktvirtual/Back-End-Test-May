<!DOCTYPE html>
<html>
<?php include __DIR__ . '/../partial/head.php' ?>
<body>
    <?php include __DIR__ . '/../partial/menu.php' ?>

    <?php if ($user['id'] == $_SESSION['user']['id']) : ?>
    <form id="upload-avatar" method="post" action="/upload/avatar" enctype="multipart/form-data">
        <input type="file" id="avatar" name="avatar" class="invisible" onchange="readURL(this, 'avatar');" />
    </form>
    <?php endif; ?>

    <div class="wrapper">
        <div class="col-md-12 profile">
            <div class="info">
                <div class="row">
                    <div class="col-xs-4 text-center">
                        <?php if ($user['id'] == $_SESSION['user']['id']) : ?>
                        <div class="avatar" title="Alterar imagem do perfil" style="background-image: url(<?=!empty($user['avatar']) ? $user['avatar'] : '/public/img/avatar.jpg' ?>);" onclick="$('input#avatar').trigger('click');">
                            <div></div>
                        </div>
                        <span class="close remove-avatar" title="Remover imagem do perfil" style="position: relative; left: -5%">&times;</span>
                        <?php else : ?>
                        <div class="avatar" title="<?=$user['name']?>" style="cursor:default; background-image: url(<?=!empty($user['avatar']) ? $user['avatar'] : '/public/img/avatar.jpg' ?>);"">
                            <div></div>
                        </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-xs-8">
                        <?php if ($user['id'] == $_SESSION['user']['id']) : ?>
                        <p class="text-right" style="float:right"><a href="#editar-perfil" onclick="$('.info').hide(); $('.edit').show();">Editar perfil</a></p>
                        <?php endif; ?>
                        <h2 style="font-weight: 300;"><?= $user['login'] ?></h2>
                        <h4><strong><?= count($posts) ?></strong> <?= count($posts) == 1 ? 'post' : 'posts' ?></h4>
                        <h4><strong><?= $user['name'] ?></strong>&nbsp;<?= $user['biografy'] ?></h4>
                    </div>
                </div>
                <div class="row">
                    <div class="profile-posts">
                        <?php foreach ($posts as $post) : ?>
                            <div class="col-xs-4">
                                <div class="img-post" style="background-image: url(<?= $post['img_path'] ?>">
                                    <a href="/<?= $user['login'] ?>/post/<?= $post['id'] ?>" class="img-likes"><p><i></i><?= number_format($post['likes'], 0, ',', '.') ?></p></a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <?php if ($user['id'] == $_SESSION['user']['id']) : ?>
                <?php include __DIR__ . '/../partial/edit-profile.php' ?>
            <?php endif; ?>
        </div>
    </div>

    <?php include __DIR__ . '/../partial/footer.php' ?>
    <?php include __DIR__ . '/../partial/scripts.php' ?>

    <script>
        $(window).on('load', function() {
            if (window.location.href.split('#editar-perfil').length == 2) {
                $('.info').hide();
                $('.edit').show();
            }
        });
    </script>
</body>
</html>
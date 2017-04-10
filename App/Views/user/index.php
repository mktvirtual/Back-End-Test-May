<!DOCTYPE html>
<html>
<?php include __DIR__ . '/../partial/head.php' ?>
<body>
    <?php include __DIR__ . '/../partial/menu.php' ?>

    <div class="wrapper" style="max-width: 600px;">
        <?php if (isset($_SESSION['welcome'])) : ?>
            <div class="box text-center">
                <span class="close close-box">&times;</span>
                <h4><strong>Bem-vindo ao InstaMkt!</strong></h4>
                <p>Siga contas para ver fotos e vídeos no seu feed.</p>
            </div>
        <?php endif; ?>

        <?php if (empty($user['avatar'])) : ?>
            <div class="box text-center">
                <span class="close close-box">&times;</span>
                <a href="#" id="edit-avatar" onclick="$('input#avatar').trigger('click');">
                    <div class="add-avatar">
                        <i class="icon-plus">+</i>
                        <p>Adicionar uma foto do perfil</p>
                    </div>

                    <img src="" alt="" class="avatar-img" style="display:none; border-radius:50%;" width="125" height="125" />
                </a>
                <form id="upload-avatar" method="post" action="/upload/avatar" enctype="multipart/form-data">
                    <input type="file" id="avatar" name="avatar" class="invisible" onchange="readURL(this, 'avatar');" />
                </form>
            </div>
        <?php endif; ?>

        <div class="box text-center click-to-post">
            <a href="#" id="edit-post" onclick="$('input#post').trigger('click');">
                <div class="add-post">
                    <i class="icon-plus">+</i>
                    <p>Publicar uma foto</p>
                </div>

                <!-- <img src="" alt="" class="post-img" style=" border-radius:0; border: 1px solid #999" width="600" height="600" /> -->
                <div class="pre-post post-img" style="display:none;"></div>
            </a>
            <form id="upload-post" method="post" action="/upload/post" enctype="multipart/form-data">
                <input type="file" id="post" name="post" class="invisible" onchange="readURL(this, 'post');" />
            </form>
        </div>
        <div class="text-center">
            <div class="row">
                <a href="#" class="btn btn-primary btn-post" style="display:none;" onclick="$('#upload-post').submit();">Publicar</a>
                <a href="/" class="btn-post" style="display:none;margin-left:10px;">Cancelar</a>
                <hr class="btn-post" style="display: none">
                <div class="btn-post" style="margin-bottom:60px;display:none"></div>
            </div>
        </div>

        <div class="posts">
            <?php $likes = explode(';', $_SESSION['user']['likes']); ?>
            <?php foreach ($posts as $post) : ?>
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
            <?php endforeach; ?>
        </div>
        
    </div>

    <?php include __DIR__ . '/../partial/footer.php' ?>
    <?php include __DIR__ . '/../partial/scripts.php' ?>
</body>
</html>
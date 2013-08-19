<!-- Perfil-->
<div class="container_12 post">
    <div class="grid_12">
        <h2>Página do Usuário <?php echo $user[0]["nome"] . "(@{$user[0]["username"]})"; ?></h2>
    </div>
    <div class="grid_12">
        <img src="https://graph.facebook.com/<?php echo $user[0]['username'] ?>/picture?type=large" />
    </div>
    <br clear="all" />
</div>
<center><h2>Últimas Postagens</h2></center>
<?php
echo $postsHelper->toHtml($lastPosts);    
?>

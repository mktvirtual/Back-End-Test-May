<script>
    
    $(function(){
        $('#toCrop').Jcrop({
            onChange: preview,
            onSelect: preview,
            minSize		: [ 350, 350 ],
            maxSize		: [ 350, 350 ]
        });
        
        $('#submit').click(function(){
            $.post( '/user/photo_edit/<?php echo $idPhoto; ?>', {
                x: $('#x').val(), 
                y: $('#y').val(), 
                w: $('#w').val(), 
                h: $('#h').val()
            }, function(){
                alert("FOI");
            });
            return false;
        });
    });
</script>

<div class="post container_12">
    <div class="grid_12">
        <p>
            <a href="/user/profile/<?php echo $post[0]["users_id"] ?>"><img class="fotoPost" src="https://graph.facebook.com/<?php echo $post[0]["username"] ?>/picture" align="left"/></a>
        <p>
            <b><?php echo $post[0]["nome"] . " em " . date("d/m/Y - H:i:s", strtotime($post[0]["created"])); ?></b>
            <b><?php echo $post[0]["comentario"] ?></b>
        </p>
        </p>
    </div>
    <div class="foto grid_12">
        <img class="fotoPost" id="toCrop" src="/usersFiles/<?php echo $post[0]["endereco"] ?>" />
        <a href="javascript:void(0);" class="formee-button" id="submit">TERMINADO!</a>
    </div>
    <br clear="all"/>
</div>
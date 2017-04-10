<div class="edit" style="display: none">
    <h4><small>EDITAR PERFIL</small></h4>
    <div class="box" style="margin-top: 10px;">
        <form action="" method="post" class="form-horizontal">
            <input type="hidden" name="id" id="id" value="<?=$_SESSION['user']['id']?>" />
            <div class="form-group">
                <div class="col-sm-4 text-right">
                    <div class="avatar" title="Alterar imagem do perfil" style="width:44px; height:44px;background-image:url(<?=!empty($user['avatar']) ? $user['avatar'] : '/public/img/avatar.jpg' ?>);" onclick="$('input#avatar').trigger('click');"></div>
                    <span class="close remove-avatar" title="Remover imagem do perfil">&times;</span>
                </div>
                <div class="col-sm-8">
                    <h4 class="user-login"><?= $user['login'] ?></h4>
                </div>
            </div>
            <br/>
            <div class="form-group">
                <label for="name" class="control-label col-sm-4">Nome</label>
                <div class="col-sm-8">
                    <input class="form-control" type="text" id="name" name="name" value="<?= $user['name'] ?>" required="required" />
                </div>
            </div>
            <div class="form-group">
                <label for="login" class="control-label col-sm-4">Nome de usuário</label>
                <div class="col-sm-8">
                    <input class="form-control" type="text" id="login" name="login" value="<?= $user['login'] ?>" required="required" />
                </div>
            </div>
            <div class="form-group">
                <label for="site" class="control-label col-sm-4">Site</label>
                <div class="col-sm-8">
                    <input class="form-control" type="text" id="site" name="site" value="<?= $user['site'] ?>" />
                </div>
            </div>
            <div class="form-group">
                <label for="site" class="control-label col-sm-4">Biografia</label>
                <div class="col-sm-8">
                    <textarea name="biografy" id="biografy" rows="3" class="form-control"><?= $user['biografy'] ?></textarea>
                </div>
            </div>
            <br/>
            <div class="col-sm-8 col-sm-offset-4">
                <h4><small>INFORMAÇÕES PRIVADAS</small></h4>
            </div>
            <div class="form-group">
                <label for="email" class="control-label col-sm-4">Email</label>
                <div class="col-sm-8">
                    <input class="form-control" type="email" id="email" name="email" value="<?= $user['email'] ?>" disabled="disabled" />
                </div>
            </div>
            <div class="form-group">
                <label for="gender" class="control-label col-sm-4">Sexo</label>
                <div class="col-sm-8">
                    <?php $gender = ['F'=>'Feminino', 'M'=>'Masculino', 'O'=>'Outro']; ?>
                    <select name="gender" id="gender" class="form-control">
                        <option value="">Não especificado</option>
                        <?php foreach ($gender as $id => $name) : ?>
                            <?php $selected = $user['gender'] == $id ? 'selected="selected"' : ''; ?>
                            <option value="<?=$id?>" <?=$selected?>><?=$name?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            
            <div class="form-group" style="margin-top: 40px;">
                <div class="col-sm-8 col-sm-offset-4">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                    <a href="#" style="margin-left: 20px;" onclick="$('.info').show(); $('.edit').hide();">Cancelar</a>
                </div>
            </div>
        </form>
    </div>
</div>
<!DOCTYPE html>
<html>

    <?php include __DIR__ . '/../partial/head.php' ?>

    <body>

        <?php include __DIR__ . '/../partial/menu.php' ?>
        
        <video class="hidden-sm hidden-xs" style="position: fixed; top: 0; left: 0; z-index: -1;" poster="https://www.mktvirtual.com.br/wp-content/themes/mkt-virtual-2015/assets/video/carreira2017.jpg" preload="auto" muted="" width="100%" height="auto" id="aboutvideo" loop="" autoplay=""> <source src="https://www.mktvirtual.com.br/wp-content/themes/mkt-virtual-2015/assets/video/carreira2017.mp4" type="video/mp4"> <source src="https://www.mktvirtual.com.br/wp-content/themes/mkt-virtual-2015/assets/video/carreira2017.webm" type="video/webm"> <source src="https://www.mktvirtual.com.br/wp-content/themes/mkt-virtual-2015/assets/video/carreira2017.ogg" type="video/ogg"> </video>
        
        <div class="wrapper" style="opacity: 0.9">
            <div class="col-md-4 col-md-offset-8 box">
                <form method="post" action="/">
                    <div class="logo"></div>
                    <div class="form-group">
                        <input class="form-control" type="email" name="email" id="email" placeholder="Email" required="required"  value="<?php echo @$_POST['email'] ?>" autofocus />
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="text" name="name" id="name" placeholder="Nome completo" required="required" value="<?php echo @$_POST['name'] ?>" />
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="text" name="login" id="login" placeholder="Nome de usuário" required="required"  value="<?php echo @$_POST['login'] ?>" />
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="password" name="password" id="password" placeholder="Senha" required="required"  value="" />
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary btn-block" type="submit">Cadastre-se</button>
                    </div>

                    <p class="text-center" style="padding: 15px 20px; color: #999">Ao cadastrar-se, você concorda com nossos Termos e Política de Privacidade.</p>
                </form>
            </div>

            <div class="col-md-4 col-md-offset-8 box text-center">
                <span>Já é cadastrado? <a href="/login" class="forgot">Faça login</a></span>
            </div>
        </div>

        <?php include __DIR__ . '/../partial/scripts.php' ?>

    </body>
</html>
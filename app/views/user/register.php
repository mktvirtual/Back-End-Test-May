

<div class="ui two column grid">
    <div class="column">
        <form action="/logar" method="post" id="login-form">
            <div class="ui fluid form segment">
                <h3 class="ui header">Logar</h3>
                <div class="field">
                    <label>Usuário</label>
                    <input id="login-username" placeholder="Usuário" type="text" name="login[username]" value="<?php echo (isset($login['username'])) ? $login['username'] : null; ?>">
                </div>
                <div class="field">
                    <label>Senha</label>
                    <input type="password" name="login[password]" id="login-password">
                </div>
                <div class="ui blue submit button">Logar</div>
            </div>
        </form>
    </div>
    <div class="column">
        <form action="/enviar-cadastro" method="post" id="register-form">
            <div class="ui fluid form segment">
                <h3 class="ui header">Registrar</h3>
                <div class="field">
                    <label>E-mail</label>
                    <input placeholder="E-mail" type="text" name="form[email]" id="form-email" value="<?php echo (isset($form['email'])) ? $form['email'] : null; ?>">
                    <?php if (isset($errors) && $errors->has('email')): ?>
                        <div class="ui red message"><?php echo $errors->first('email'); ?></div>
                    <?php endif; ?>
                </div>
                <div class="field">
                    <label>Usuário</label>
                    <input placeholder="Usuário" type="text" name="form[username]" id="form-username" value="<?php echo (isset($form['username'])) ? $form['username'] : null; ?>">
                    <?php if (isset($errors) && $errors->has('username')): ?>
                        <div class="ui red message"><?php echo $errors->first('username'); ?></div>
                    <?php endif; ?>
                </div>
                <div class="field">
                    <label>Senha</label>
                    <input type="password" name="form[password]" id="form-password">
                    <?php if (isset($errors) && $errors->has('password')): ?>
                        <div class="ui red message"><?php echo $errors->first('password'); ?></div>
                    <?php endif; ?>
                </div>
                <div class="ui blue submit button">Registrar</div>
            </div>
        </form>
    </div>
</div>
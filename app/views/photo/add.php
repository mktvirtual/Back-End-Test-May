<div class="ui one column grid">
    <div class="column">
        <form action="/enviar-foto" method="post" id="send-photo-form" enctype="multipart/form-data">
            <div class="ui fluid form segment">
                <h3 class="ui header">Adicionar foto</h3>
                <div class="field">
                    <label>Imagem</label>
                    <input type="file" name="photo" id="form-photo" accept="image/x-png, image/gif, image/jpeg">
                    <?php if (isset($errors) && $errors->has('photo')): ?>
                        <div class="ui red message"><?php echo $errors->first('photo'); ?></div>
                    <?php endif; ?>
                </div>
                <div class="field">
                    <label>Descrição</label>
                    <textarea name="form[description]" maxlength="140" id="form-description"><?php echo (isset($form['description'])) ? $form['description'] : null; ?></textarea>
                    <?php if (isset($errors) && $errors->has('description')): ?>
                        <div class="ui red message"><?php echo $errors->first('description'); ?></div>
                    <?php endif; ?>
                </div>
                <div class="ui blue submit button">Cadastrar</div>
            </div>
        </form>
    </div>
</div>
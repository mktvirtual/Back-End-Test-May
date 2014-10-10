<?php $loggedUser = \Skp\Registry::get('loggedUser'); ?>

<div class="ui grid segment" style="margin-top: 30px;">
    <div class="two wide column">
        <img class="rounded ui image" src="<?php echo \forxer\Gravatar\Gravatar::image($user->email, 120, 'mm'); ?>">
    </div>
    <div class="fourteen wide column grid">
        <h2 class="ui header"><?php echo $user->username; ?></h2>
        <p class="ui">
            <?php echo $user->about; ?>

            <?php if ($loggedUser): ?>

                <?php if ($loggedUser->id != $user->id): ?>
                    <?php $followed = $loggedUser->followed($user); ?>
                    <div class="ui blue button small follow<?php echo ($followed) ? ' followed' : null; ?>" data-username="<?php echo $user->username; ?>">
                        <?php echo ($followed) ? 'Deixar de seguir' : 'Seguir'; ?>
                    </div>

                 <?php else: ?>

                     <div class="ui green button small" onclick="window.location='/adicionar-foto';">
                         Adicionar foto
                     </div>

                 <?php endif; ?>

            <?php endif; ?>

        </p>
        <div class="ui column">

            <div class="ui compact menu fright">
                <a class="item">
                    <i class="icon photo"></i> Posts
                    <div class="floating ui teal label"><?php echo $user->posts->count(); ?></div>
                </a>
                <a class="item">
                    <i class="icon users"></i> Seguidores
                    <div class="floating ui teal label"><?php echo $user->followers->count(); ?></div>
                </a>
                <a class="item">
                    <i class="icon users"></i> Seguindo
                    <div class="floating ui teal label"><?php echo $user->following->count(); ?></div>
                </a>
            </div>

        </div>
    </div>
</div>

<div class="ui column grid">
    <div class="column">
        <div class="ui fluid form segment">

            <?php if ($user->posts->count()): ?>

                <div class="ui items" id="list-photos" data-username="<?php echo $user->username; ?>">

                </div>

                <div style="text-align: center">
                    <div class="ui active inline loader" id="photo-loader" style="display: none;"></div>
                </div>

            <?php else: ?>

                <div class="ui message">
                    <div class="header">
                        Oppss...
                    </div>
                    <p>
                        Nenhuma foto para exibição
                    </p>
                </div>

            <?php endif; ?>

        </div>
    </div>
</div>
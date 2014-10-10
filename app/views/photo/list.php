<?php foreach ($photos as $photo): ?>
    <div class="item photo-<?php echo $photo->id; ?> photo-item">
        <div class="image">
            <img src="/pool/photos/<?php echo $photo->id, '/thumb_', $photo->name; ?>" width="159" class="open-photo">
            <a class="<?php if ($loggedUser && $photo->liked($loggedUser)) echo 'active '; ?>like ui corner label like-photo" data-photo="<?php echo $photo->id; ?>">
                <i class="like icon"></i>
            </a>
        </div>
        <div class="content">
            <p class="description"><?php echo $photo->description; ?></p>
            <div class="extra like-count">
                <?php echo $photo->likes->count(); ?> like's
            </div>
        </div>

        <div class="list-photo ui modal">
            <i class="close icon"></i>
            <div class="header">
                Foto
            </div>
            <div class="content">
                <div class="left">
                    <img src="/pool/photos/<?php echo $photo->id, '/', $photo->name; ?>" height="460">
                </div>
                <div class="right">
                    <?php echo $photo->description; ?>
                </div>
            </div>
            <div class="actions">

            </div>
        </div>

    </div>
<?php endforeach; ?>
<?php if ($last): ?>
    <div class="pagination-end" style="display: none;"></div>
<?php endif; ?>
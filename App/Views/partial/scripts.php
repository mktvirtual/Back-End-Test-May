<!-- <?php var_dump(@$_SESSION['flashMsg']); ?> -->
<?php if (!empty(@$_SESSION['flashMsg']['message'])) : ?>
    <?php $flash = $_SESSION['flashMsg']; ?>
    <div id="flash-msg" class="<?= $flash['type'] ?>"><p><strong><?= $flash['title'] ?></strong> <?= $flash['message'] ?><span>&times;</span></p></div>
<?php endif; ?>

<div id="loading" style="display:none">
    <p>Carregando...</p>
</div>

<script>
    // Globals 
    var UID = '<?= @$user['id'] ?>';
    var sUID = '<?=@$_SESSION['user']['id']?>';
</script>
<script src="https://code.jquery.com/jquery-3.2.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="/public/js/moment.js"></script>
<script src="/public/js/moment-with-locales.js"></script>
<script src="/public/js/livestamp.js"></script>
<script src="/public/js/index.js"></script>
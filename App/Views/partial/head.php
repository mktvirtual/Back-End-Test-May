<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
    <link rel="stylesheet" href="/public/fonts/ionicons.min.css" />
    <link rel="stylesheet" href="/public/css/style.css" />
    <?php if (!empty($user['login']) && strlen($_SERVER['REQUEST_URI']) > 1) : ?>
        <title><?= $user['name'] ?> (@<?= $user['login'] ?>) • InstaMkt</title>
    <?php else : ?>
        <title><?=@$title?> InstaMkt</title>
    <?php endif; ?>
</head>
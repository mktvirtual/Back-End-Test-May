<!DOCTYPE html>
<html>
<head>
    <!-- Standard Meta -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

    <!-- Site Properities -->
    <title>InstaMkt</title>

    <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700|Open+Sans:300italic,400,300,700' rel='stylesheet' type='text/css'>

    <link rel="stylesheet" type="text/css" href="/css/semantic.min.css">
    <link rel="stylesheet" type="text/css" href="/css/styles.css">

    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.js"></script>
    <script src="/javascript/semantic.min.js"></script>
    <script src="/javascript/scripts.js"></script>

</head>
<body>
<div class="ui two grid masthead segment" id="top-header">
    <div class="column">
        <div class="inverted secondary pointing ui">
            <div class="header item">

                <div class="fleft" id="instamkt">
                    <a href="/">InstaMkt</a>
                </div>

                <?php if (isLogged()): ?>

                    <div class="fright" id="login-btn">
                        <div class="ui icon button small red" onclick="window.location='/sair';">
                            <i class="close icon"></i>
                            Sair
                        </div>
                    </div>

                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php if (isset($error)): ?>
    <div class="ui column grid">
        <div class="ui column visible message red">
            <p><?php echo $error; ?></p>
        </div>
    </div>
<?php elseif (isset($success)): ?>
    <div class="ui column grid">
        <div class="ui column visible message green">
            <p><?php echo $success; ?></p>
        </div>
    </div>
<?php endif; ?>

<?php echo $content; ?>

</body>

</html>

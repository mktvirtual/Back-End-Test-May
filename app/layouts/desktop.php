<html>
    <head>
        <title>ShareUP! Fotos</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <script type="text/javascript" src="/script/jquery.min.js"></script>
        <script type="text/javascript" src="/script/jquery.Jcrop.js"></script>
        <link rel="stylesheet" href="/css/jquery.Jcrop.css" type="text/css" />
        <link href="/css/960.css" rel="stylesheet" type="text/css" />
        <link href="/css/style.css" rel="stylesheet" type="text/css" />
        <link href="/css/formee/formee-style.css" rel="stylesheet" type="text/css" />
        <link href="/css/formee/formee-structure.css" rel="stylesheet" type="text/css" />
        <script>
            function confirma(questao, url){
                if(confirm(questao)){
                    location.href = url;
                }
            }
        </script>
    </head>
    <body>
        <div id="header">
            <div id="logo">
                <a href="/" style="text-decoration: none;"><h1>ShareUP!</h1></a>
                <h5>Fotos</h5>
            </div>
            <div class="login">
                <?php
                if (empty($userData)) {
                    echo "<a href='{$loginUrl}'><img width='40px' src='/images/login_facebook.png'/></a></div>";
                } else {
                    echo "<div><a href='/user/profile/{$userData["id"]}'><img src='https://graph.facebook.com/{$userData["username"]}/picture' style='vertical-align:middle;'/></a> <a href='{$logoutUrl}' style='color:#FFFFFF; font-weight:bold;'>Sair</a></div>";
                }
                ?>

            </div>
        </div>


        <div id="content">
            <?php
            if(!empty($userData["id"])){
                echo $postsHelper->formPost();
            }
            echo $this->conteudo;
            ?>
        </div>
    </body>
</html>

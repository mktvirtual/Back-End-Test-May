<?php if (@$_SESSION['user']) : ?>
<div>
    <nav class="navbar navbar-default navigation-clean">
        <div class="container">
            <div class="navbar-header"><a class="navbar-brand navbar-link" href="/">InstaMkt</a>
                <button class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
            </div>
            <div class="collapse navbar-collapse" id="navcol-1">
                <ul class="nav navbar-nav navbar-right">
                    <li role="presentation"><a href="/<?=$_SESSION['user']['login']?>">Meu Perfil</a></li>
                    <li role="presentation"><a href="#" onclick="if (confirm('Tem certeza que deseja sair?')) window.location.href='/logout';">Sair</a></li>
                </ul>
            </div>
        </div>
    </nav>
</div>
<?php endif; ?>
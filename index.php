<?php

define('ROOT', __DIR__);
define('DS', DIRECTORY_SEPARATOR);

require ROOT.DS.'vendor'.DS.'autoload.php';
$mkt = new Mkt\Face();
$banco = new Mkt\db();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Inicio - Teste MKT</title>
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/font-awesome.min.css" rel="stylesheet">
    <link href="assets/css/prettyPhoto.css" rel="stylesheet">
    <link href="assets/css/animate.css" rel="stylesheet">
    <link href="assets/css/main.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->       
    <link rel="shortcut icon" href="assets/images/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="assets/images/ico/apple-touch-icon-57-precomposed.png">
</head><!--/head-->
<body>
    <header class="navbar navbar-inverse navbar-fixed-top wet-asphalt" style="background-color:#fff" role="banner">
        <div class="container">
            <div class="navbar-header" >
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php"><img src="assets/images/mkt-virtual.gif" alt="logo"></a>
            </div>
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <!--<li class="active"><a href="index.html">Inicio</a></li>
                    <li><a href="blog.html">Blog</a></li> 
                    <li><a href="contact-us.html">Contact</a></li>-->
                </ul>
            </div>
        </div>
    </header><!--/header-->
    <section id="main-slider" class="no-margin">
        <div class="carousel slide wet-asphalt">
          
            <div class="carousel-inner">
                <div class="item active" style="background-image: url(assets/images/slider/bg2.jpg)">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="carousel-content  centered">
                                	<?php 
                                	if($mkt->islogado()){
                                	?>
                                    <h2 class="boxed animation animated-item-1">Bem Vindo, <?php echo $mkt->infoUser()["name"];?>.</h2><br>   
                                    <p class="boxed animation animated-item-2">Obrigado por estar utilizando o sistema.</p><br>
                                    <a class="btn btn-md animation animated-item-3" href="<?php echo $mkt->url();?>">Sair</a>
                                    <?php }else{?>
                                    <h2 class="boxed animation animated-item-1">Bem Vindo.</h2><br>   
                                    <p class="boxed animation animated-item-2">Utilize seu facebook para acessar nosso sistema.</p><br>
                                    <a class="btn btn-md animation animated-item-3" href="<?php echo $mkt->url();?>">Login Facebook</a>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!--/.item-->
                
            </div><!--/.carousel-inner-->
        </div><!--/.carousel-->
        
    </section><!--/#main-slider-->

    <section id="services" class="emerald">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-sm-6">
                    <div class="media">
                        <div class="pull-left">
                            <i class="icon-facebook icon-md"></i>
                        </div>
                        <div class="media-body">
                            <h3 class="media-heading">Facebook</h3>
                            <p>Nosso sistema funciona com integração completa ao facebook.</p>
                        </div>
                    </div>
                </div><!--/.col-md-4-->
                <div class="col-md-4 col-sm-6">
                    <div class="media">
                        <div class="pull-left">
                            <i class="icon-twitter icon-md"></i>
                        </div>
                        <div class="media-body">
                            <h3 class="media-heading">Twitter</h3>
                            <p>Em breve.</p>
                        </div>
                    </div>
                </div><!--/.col-md-4-->
                <div class="col-md-4 col-sm-6">
                    <div class="media">
                        <div class="pull-left">
                            <i class="icon-google-plus icon-md"></i>
                        </div>
                        <div class="media-body">
                            <h3 class="media-heading">Google Plus</h3>
                            <p>Em Breve</p>
                        </div>
                    </div>
                </div><!--/.col-md-4-->
            </div>
        </div>
    </section><!--/#services-->
    <!-- Estou Logado-->
    <section id="portfolio" class="container">
        
        <ul class="portfolio-items col-3">
		<?php

			$fotos = $banco->getLinhas("SELECT * FROM fotos WHERE cd_uid = ? order by dt_postada", array($mkt->infoUser()["id"]));
			foreach ($fotos as $f){
				echo '<li class="portfolio-item">
                <div class="item-inner">
                    <img src="uploads/t/'.$f["nm_foto"].'" alt="" height="250px" 	>
                    <h5>'.$f["nm_legenda"].'</h5>
                    <div class="overlay">
                        <a class="preview btn btn-danger" href="uploads/p/'.$f["nm_foto"].'" rel="prettyPhoto"><i class="icon-eye-open"></i></a>             
                    </div>           
                </div>           
            </li><!--/.portfolio-item-->';
			}

		?>          
        	
            
        </ul>
    </section><!--/#portfolio-->


<?php
if(!$mkt->islogado()){
echo'    <section id="recent-works">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <h3>Ultimas Fotos</h3>
                    <p>Ultimas fotos postadas pelos nossos usuários.</p>
                  
                </div>
                <div class="col-md-9">
                    <div id="scroller" class="carousel slide">
                        <div class="carousel-inner">
                            <div class="item active">
                                <div class="row">';
                                   
                                	
$ultpost = $banco->getLinhas("SELECT * FROM fotos order by dt_postada limit 3");
foreach ($ultpost as $thumb){
echo ' <div class="col-xs-4">
                                        <div class="portfolio-item">
                                            <div class="item-inner">
                                                <img class="img-responsive" src="uploads/t/'.$thumb["nm_foto"].'" alt="">
                                                <h5>
                                                    '.$thumb["nm_legenda"].'
                                                </h5>
                                                <div class="overlay">
                                                    <a class="preview btn btn-danger" title="'.$thumb["nm_legenda"].'" href="upload/p/'.$thumb["nm_foto"].'" rel="prettyPhoto"><i class="icon-eye-open"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>';

}
                                 
		echo ' </div></section><!--/#recent-works-->';
    
}
?>

<?php
if($mkt->islogado()){
?>
 <section id="testimonial" class="alizarin">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="center">
                        <h2>Envio de imagens </h2>
                    </div>
                    <div class="gap"></div>
                    <div class="row">
                        	<div class="col-sm-6">
                
                <div class="status alert alert-success" style="display: none"></div>
                	<form id="form1" name="form1" enctype="multipart/form-data" method="post" action="envio.php">
                    <div class="row">
                        <div class="col-sm-5">
                           <h4>Escolha a foto:</h4>
                        	 <div class="form-group">
                                <input type="file" name="file" class="form-control" required="required" >
                            </div>
                            <div class="form-group">
                                <input type="text" name="legen" class="form-control" required="required" placeholder="Legenda">
                            </div>
                           
                            <div class="form-group">
                                  <input type="submit" name="Submit" class="btn btn-primary btn-lg" value="Enviar" />

                            </div>
                        </div>
                       
                    </div>
                </form>
            </div><!--/.col-sm-8-->
                    </div>
                </div>
            </div>
        </div>
    </section><!--/#testimonial-->
<?php
}
?>




    <section id="bottom" class="wet-asphalt">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <h4>Sobre</h4>
                    <p>Teste da MKT Virtual para Programador PHP, estou utilizando um tema FREE para uma melhor apresentação do projeto.</p>
                    <p>Obrigado pela oportunidade.</p>
                </div><!--/.col-md-3-->

              
                <div class="col-md-3 col-sm-6">
                    <h4>Rodolfo Conde</h4>
                    <address>
                        <strong><a href="http://br.linkedin.com/pub/rodolfo-conde/5b/260/336/">Linkedin</a></strong><br>
                        <abbr title="email">Email:</abbr> rodolfoconde@live.com<br> 
                        <abbr title="Phone">Cel:</abbr> +55 13 98117-3674 
                    </address>
                   
                   
                </div> <!--/.col-md-3-->
            </div>
        </div>
    </section><!--/#bottom-->

    <footer id="footer" class="midnight-blue">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    &copy; 2013 <a target="_blank" href="http://shapebootstrap.net/" title="Free Twitter Bootstrap WordPress Themes and HTML templates">ShapeBootstrap</a>. All Rights Reserved.
                </div>
                
            </div>
        </div>
    </footer><!--/#footer-->

    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery.prettyPhoto.js"></script>
    <script src="assets/js/main.js"></script>
</body>
</html>
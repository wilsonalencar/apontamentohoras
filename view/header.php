<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Gestão</title> 
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" href="<?php echo app::dominio; ?>/view/assets/materialize/css/materialize.min.css" media="screen,projection" />
    <link href="<?php echo app::dominio; ?>view/assets/css/bootstrap.css" rel="stylesheet" />
    <link href="<?php echo app::dominio; ?>view/assets/css/font-awesome.css" rel="stylesheet" />
    <link href="<?php echo app::dominio; ?>view/assets/js/morris/morris-0.4.3.min.css" rel="stylesheet" />
    <link href="<?php echo app::dominio; ?>view/assets/css/custom-styles.css" rel="stylesheet" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <link rel="stylesheet" href="<?php echo app::dominio; ?>view/assets/js/Lightweight-Chart/cssCharts.css"> 
</head>

<?php if (!empty($_SESSION['logado']) && $_SERVER['SCRIPT_NAME'] != '/login.php') { ?>
    <body>
        <div id="wrapper">
            <nav class="navbar navbar-default top-navbar" role="navigation">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle waves-effect waves-dark" data-toggle="collapse" data-target=".sidebar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand waves-effect waves-dark" href="index.php">
                        <img src="<?php echo app::dominio; ?>view/assets/img/bravo-icon.png">
                    </a>

    				
    		<div id="sideNav" href=""><i class="material-icons dp48">toc</i></div>
                </div>

                <ul class="nav navbar-top-links navbar-right"> 
    				<li><a class="dropdown-button waves-effect waves-dark" href="#!" data-activates="dropdown4"><i class="fa fa-envelope fa-fw"></i> <i class="material-icons right">arrow_drop_down</i></a></li>				
    				<li><a class="dropdown-button waves-effect waves-dark" href="#!" data-activates="dropdown3"><i class="fa fa-tasks fa-fw"></i> <i class="material-icons right">arrow_drop_down</i></a></li>
    				<li><a class="dropdown-button waves-effect waves-dark" href="#!" data-activates="dropdown2"><i class="fa fa-bell fa-fw"></i> <i class="material-icons right">arrow_drop_down</i></a></li>
    				  <li><a class="dropdown-button waves-effect waves-dark" href="#!" data-activates="dropdown1"><i class="fa fa-user fa-fw"></i> <b><?php echo $_SESSION['nome']; ?></b> <i class="material-icons right">arrow_drop_down</i></a></li>
                </ul>
            </nav>
    		<!-- Dropdown Structure -->
    <ul id="dropdown1" class="dropdown-content">
        <li><a href="#"><i class="fa fa-user fa-fw"></i> My Profile</a>
        </li>
        <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
        </li> 
        <li><a href="<?php echo app::dominio; ?>login.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
        </li>
    </ul>
    <ul id="dropdown2" class="dropdown-content w250">
      <li>
                                    <div>
                                        <i class="fa fa-comment fa-fw"></i> New Comment
                                        <span class="pull-right text-muted small">4 min</span>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                    <div>
                                        <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                                        <span class="pull-right text-muted small">12 min</span>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                    <div>
                                        <i class="fa fa-envelope fa-fw"></i> Message Sent
                                        <span class="pull-right text-muted small">4 min</span>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                    <div>
                                        <i class="fa fa-tasks fa-fw"></i> New Task
                                        <span class="pull-right text-muted small">4 min</span>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                    <div>
                                        <i class="fa fa-upload fa-fw"></i> Server Rebooted
                                        <span class="pull-right text-muted small">4 min</span>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a class="text-center" href="#">
                                    <strong>See All Alerts</strong>
                                    <i class="fa fa-angle-right"></i>
                                </a>
                            </li>
    </ul>
    <ul id="dropdown3" class="dropdown-content dropdown-tasks w250">
    <li>
    		<a href="#">
    			<div>
    				<p>
    					<strong>Task 1</strong>
    					<span class="pull-right text-muted">60% Complete</span>
    				</p>
    				<div class="progress progress-striped active">
    					<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
    						<span class="sr-only">60% Complete (success)</span>
    					</div>
    				</div>
    			</div>
    		</a>
    	</li>
    	<li class="divider"></li>
    	<li>
    		<a href="#">
    			<div>
    				<p>
    					<strong>Task 2</strong>
    					<span class="pull-right text-muted">28% Complete</span>
    				</p>
    				<div class="progress progress-striped active">
    					<div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="28" aria-valuemin="0" aria-valuemax="100" style="width: 28%">
    						<span class="sr-only">28% Complete</span>
    					</div>
    				</div>
    			</div>
    		</a>
    	</li>
    	<li class="divider"></li>
    	<li>
    		<a href="#">
    			<div>
    				<p>
    					<strong>Task 3</strong>
    					<span class="pull-right text-muted">60% Complete</span>
    				</p>
    				<div class="progress progress-striped active">
    					<div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%">
    						<span class="sr-only">60% Complete (warning)</span>
    					</div>
    				</div>
    			</div>
    		</a>
    	</li>
    	<li class="divider"></li>
    	<li>
    		<a href="#">
    			<div>
    				<p>
    					<strong>Task 4</strong>
    					<span class="pull-right text-muted">85% Complete</span>
    				</p>
    				<div class="progress progress-striped active">
    					<div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width: 85%">
    						<span class="sr-only">85% Complete (danger)</span>
    					</div>
    				</div>
    			</div>
    		</a>
    	</li>
    	<li class="divider"></li>
    	<li>
    </ul>   
    <ul id="dropdown4" class="dropdown-content dropdown-tasks w250 taskList">
      <li>
                                    <div>
                                        <strong>John Doe</strong>
                                        <span class="pull-right text-muted">
                                            <em>Today</em>
                                        </span>
                                    </div>
                                    <p>Lorem Ipsum has been the industry's standard dummy text ever since the 1500s...</p>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                    <div>
                                        <strong>John Smith</strong>
                                        <span class="pull-right text-muted">
                                            <em>Yesterday</em>
                                        </span>
                                    </div>
                                    <p>Lorem Ipsum has been the industry's standard dummy text ever since an kwilnw...</p>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="#">
                                    <div>
                                        <strong>John Smith</strong>
                                        <span class="pull-right text-muted">
                                            <em>Yesterday</em>
                                        </span>
                                    </div>
                                    <p>Lorem Ipsum has been the industry's standard dummy text ever since the...</p>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a class="text-center" href="#">
                                    <strong>Read All Messages</strong>
                                    <i class="fa fa-angle-right"></i>
                                </a>
                            </li>
    </ul>  
            <nav class="navbar-default navbar-side" role="navigation">
                <div class="sidebar-collapse">
                    <ul class="nav" id="main-menu">
                        <li>
                            <a class="active-menu waves-effect waves-dark" href="index.php"><i class="fa fa-dashboard"></i> Index</a>
                        </li>
                        
                        <li>
                            <?php if ($app->checkAccess($_SESSION['id_perfilusuario'], $funcConst::perfil_cadastrobasico)){ ?>
                                <a href="#" class="waves-effect waves-dark"><i class="fa fa-sitemap"></i> Cadastros básicos<span class="fa arrow"></span></a>
                            <?php } ?>
                            <ul class="nav nav-second-level">
                                <?php if ($app->checkAccess($_SESSION['id_perfilusuario'], $funcConst::perfil_cliente)){ ?>
                                    <li>
                                        <a href="#">Clientes<span class="fa arrow"></span></a>
                                        <ul class="nav nav-third-level">
                                            <li>
                                                <a href="<?php echo app::dominio; ?>clientes.php" >Cadastro de Clientes</a>
                                            </li>
                                            <li>
                                                <a href="<?php echo app::dominio; ?>consulta_clientes.php" >Buscar Cliente</a>
                                            </li>
                                        </ul>
                                    </li>
                                <?php } ?>
                                <?php if ($app->checkAccess($_SESSION['id_perfilusuario'], $funcConst::perfil_projetos)){ ?>
                                <li>
                                    <a href="#">Projetos<span class="fa arrow"></span></a>
                                    <ul class="nav nav-third-level">
                                        <li>
                                            <a href="<?php echo app::dominio; ?>projetos.php" >Cadastro de Projetos</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo app::dominio; ?>consulta_projetos.php" >Buscar Projetos</a>
                                        </li>

                                    </ul>
                                </li>
                                <?php } ?>
                                <?php if ($app->checkAccess($_SESSION['id_perfilusuario'], $funcConst::perfil_pilares)){ ?>
                                <li>
                                    <a href="#">Pilares<span class="fa arrow"></span></a>
                                    <ul class="nav nav-third-level">
                                        <li>
                                            <a href="<?php echo app::dominio; ?>pilares.php" >Cadastro de Pilares</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo app::dominio; ?>consulta_pilares.php" >Buscar Pilares</a>
                                        </li>

                                    </ul>
                                </li>
                                <?php } ?>
                                <?php if ($app->checkAccess($_SESSION['id_perfilusuario'], $funcConst::perfil_contratacoes)){ ?>
                                <li>
                                    <a href="#">Contratações<span class="fa arrow"></span></a>
                                    <ul class="nav nav-third-level">
                                        <li>
                                           <a href="<?php echo app::dominio; ?>contratacoes.php" >Tipo de Contratação</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo app::dominio; ?>consulta_contratacoes.php" >Buscar Contratações</a>
                                        </li>

                                    </ul>
                                </li>
                                 <?php } ?>
                                <?php if ($app->checkAccess($_SESSION['id_perfilusuario'], $funcConst::perfil_perfilprofissional)){ ?>
                                <li>
                                    <a href="#">Perfil Profissional<span class="fa arrow"></span></a>
                                    <ul class="nav nav-third-level">
                                        <li>
                                             <a href="<?php echo app::dominio; ?>perfil_prof.php" >Cadastro de perfil profissional</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo app::dominio; ?>consulta_perfil_prof.php" >Buscar Perfis Profissionais</a>
                                        </li>

                                    </ul>
                                </li>
                                 <?php } ?>
                                <?php if ($app->checkAccess($_SESSION['id_perfilusuario'], $funcConst::perfil_responsabilidade)){ ?>
                                <li>
                                    <a href="#">Responsabilidades<span class="fa arrow"></span></a>
                                    <ul class="nav nav-third-level">
                                        <li>
                                            <a href="<?php echo app::dominio; ?>responsabilidades.php" >Cadastro de responsabilidade</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo app::dominio; ?>consulta_responsabilidades.php" >Busca de Responsabilidades</a>
                                        </li>

                                    </ul>
                                </li>
                                 <?php } ?>
                                <?php if ($app->checkAccess($_SESSION['id_perfilusuario'], $funcConst::perfil_usuario)){ ?>
                                <li>
                                    <a href="#" class="waves-effect waves-dark"> Usuários<span class="fa arrow"></span></a>
                                    <ul class="nav nav-third-level">
                                         <li>
                                            <a href="<?php echo app::dominio; ?>usuarios.php" >Cadastro de Usuários</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo app::dominio; ?>consulta_usuarios.php" >Consulta de Usuários</a>
                                        </li>
                                    </ul>
                                </li>
                                 <?php } ?>

                                 <?php if ($app->checkAccess($_SESSION['id_perfilusuario'], $funcConst::perfil_funcionario)){ ?>
                                <li>
                                    <a href="#" class="waves-effect waves-dark"> Funcionários<span class="fa arrow"></span></a>
                                    <ul class="nav nav-third-level">
                                         <li>
                                            <a href="<?php echo app::dominio; ?>funcionarios.php" >Cadastro de Funcionários</a>
                                        </li>
                                        <li>
                                            <a href="<?php echo app::dominio; ?>consulta_funcionarios.php" >Consulta de Funcionários</a>
                                        </li>
                                    </ul>
                                </li>
                                 <?php } ?>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
<?php   } ?>
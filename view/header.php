<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Bravo - Gestão de Projetos</title> 
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<link rel="stylesheet" href="<?php echo app::dominio; ?>/view/assets/materialize/css/materialize.min.css" media="screen,projection" />
    <link href="<?php echo app::dominio; ?>view/assets/css/bootstrap.css" rel="stylesheet" />
    <link href="<?php echo app::dominio; ?>view/assets/css/font-awesome.css" rel="stylesheet" />
    <link href="<?php echo app::dominio; ?>view/assets/js/morris/morris-0.4.3.min.css" rel="stylesheet" />
    <link href="<?php echo app::dominio; ?>view/assets/css/custom-styles.css" rel="stylesheet" />
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

    

    <link rel="stylesheet" href="<?php echo app::dominio; ?>view/assets/js/Lightweight-Chart/cssCharts.css"> 

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/datatables/1.10.12/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/datatables-tabletools/2.1.5/css/TableTools.min.css">
    <link rel="stylesheet" href="//cdn.datatables.net/buttons/1.1.2/css/buttons.dataTables.min.css">
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
    				  <li><a class="dropdown-button waves-effect waves-dark active-menu" href="#!" data-activates="dropdown1"><i class="fa fa-user fa-fw"></i> <b><?php echo $_SESSION['nome']; ?></b> <i class="material-icons right">arrow_drop_down</i></a></li>
                </ul>
            </nav>
    		<!-- Dropdown Structure -->
    <ul id="dropdown1" class="dropdown-content">
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
                            <a class="active-menu waves-effect waves-dark" href="index.php"><i class="fa fa-home"></i> Home</a>
                        </li>
                        
                        <li>
                            <?php if ($app->checkAccess($_SESSION['id_perfilusuario'], $funcConst::perfil_cadastrobasico)){ ?>
                                <a href="#" class="waves-effect waves-dark active-menu"><i class="fa fa-sitemap"></i> Cadastros<span class="fa arrow"></span></a>
                            <?php } ?>
                            <ul class="nav nav-second-level">
                                <?php if ($app->checkAccess($_SESSION['id_perfilusuario'], $funcConst::perfil_cliente)){ ?>
                                    <li>
                                        <a href="#" class="active-menu">Clientes<span class="fa arrow"></span></a>
                                        <ul class="nav nav-third-level">
                                            <li>
                                                <a class="active-menu" href="<?php echo app::dominio; ?>clientes.php" >Adicionar</a>
                                            </li>
                                            <li>
                                                <a class="active-menu" href="<?php echo app::dominio; ?>consulta_clientes.php" >Consultar</a>
                                            </li>
                                        </ul>
                                    </li>
                                <?php } ?>
                                <?php if ($app->checkAccess($_SESSION['id_perfilusuario'], $funcConst::perfil_propostas)){ ?>
                                <li>
                                    <a href="#" class="active-menu">Propostas<span class="fa arrow"></span></a>
                                    <ul class="nav nav-third-level">
                                        <li>
                                            <a class="active-menu" href="<?php echo app::dominio; ?>propostas.php" >Adicionar</a>
                                        </li>
                                        <li>
                                            <a class="active-menu" href="<?php echo app::dominio; ?>consulta_propostas.php" >Consultar</a>
                                        </li>

                                    </ul>
                                </li>
                                <?php } ?>

                                <?php if ($app->checkAccess($_SESSION['id_perfilusuario'], $funcConst::perfil_pilares)){ ?>
                                <li>
                                    <a href="#" class="active-menu">Pilares<span class="fa arrow"></span></a>
                                    <ul class="nav nav-third-level">
                                        <li>
                                            <a class="active-menu" href="<?php echo app::dominio; ?>pilares.php" >Adicionar</a>
                                        </li>
                                        <li>
                                            <a class="active-menu" href="<?php echo app::dominio; ?>consulta_pilares.php" >Consultar</a>
                                        </li>

                                    </ul>
                                </li>
                                <?php } ?>
                                <?php if ($app->checkAccess($_SESSION['id_perfilusuario'], $funcConst::perfil_contratacoes)){ ?>
                                <li>
                                    <a href="#" class="active-menu">Contratações<span class="fa arrow"></span></a>
                                    <ul class="nav nav-third-level">
                                        <li>
                                           <a class="active-menu" href="<?php echo app::dominio; ?>contratacoes.php" >Adicionar</a>
                                        </li>
                                        <li>
                                            <a class="active-menu" href="<?php echo app::dominio; ?>consulta_contratacoes.php" >Consultar</a>
                                        </li>

                                    </ul>
                                </li>
                                 <?php } ?>
                                <?php if ($app->checkAccess($_SESSION['id_perfilusuario'], $funcConst::perfil_perfilprofissional)){ ?>
                                <li>
                                    <a href="#" class="active-menu">Perfil Profissional<span class="fa arrow"></span></a>
                                    <ul class="nav nav-third-level">
                                        <li>
                                             <a class="active-menu" href="<?php echo app::dominio; ?>perfil_prof.php" >Adicionar</a>
                                        </li>
                                        <li>
                                            <a class="active-menu" href="<?php echo app::dominio; ?>consulta_perfil_prof.php" >Consultar</a>
                                        </li>

                                    </ul>
                                </li>
                                 <?php } ?>
                                <?php if ($app->checkAccess($_SESSION['id_perfilusuario'], $funcConst::perfil_responsabilidade)){ ?>
                                <li>
                                    <a href="#" class="active-menu">Responsabilidades<span class="fa arrow"></span></a>
                                    <ul class="nav nav-third-level">
                                        <li>
                                            <a class="active-menu" href="<?php echo app::dominio; ?>responsabilidades.php" >Adicionar</a>
                                        </li>
                                        <li>
                                            <a class="active-menu" href="<?php echo app::dominio; ?>consulta_responsabilidades.php" >Consultar</a>
                                        </li>

                                    </ul>
                                </li>
                                 <?php } ?>
                                <?php if ($app->checkAccess($_SESSION['id_perfilusuario'], $funcConst::perfil_usuario)){ ?>
                                <li>
                                    <a href="#" class="waves-effect waves-dark active-menu"> Usuários<span class="fa arrow"></span></a>
                                    <ul class="nav nav-third-level">
                                         <li>
                                            <a class="active-menu" href="<?php echo app::dominio; ?>usuarios.php" >Adicionar</a>
                                        </li>
                                        <li>
                                            <a class="active-menu" href="<?php echo app::dominio; ?>consulta_usuarios.php" >Consultar</a>
                                        </li>
                                    </ul>
                                </li>
                                 <?php } ?>

                                 <?php if ($app->checkAccess($_SESSION['id_perfilusuario'], $funcConst::perfil_funcionario)){ ?>
                                <li>
                                    <a href="#" class="waves-effect waves-dark active-menu"> Funcionários<span class="fa arrow"></span></a>
                                    <ul class="nav nav-third-level">
                                         <li>
                                            <a class="active-menu" href="<?php echo app::dominio; ?>funcionarios.php" >Adicionar</a>
                                        </li>
                                        <li>
                                            <a class="active-menu" href="<?php echo app::dominio; ?>consulta_funcionarios.php" >Consultar</a>
                                        </li>
                                    </ul>
                                </li>
                                 <?php } ?>
                            </ul>
                        </li>

                        
                        <?php if ($app->checkAccess($_SESSION['id_perfilusuario'], $funcConst::perfil_projetos)){ ?>
                        <li>
                            <a href="#" class="active-menu"><i class="fa fa-file-text"></i> Projetos<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a class="active-menu" href="<?php echo app::dominio; ?>projetos.php" >Adicionar</a>
                                </li>
                                <li>
                                    <a class="active-menu" href="<?php echo app::dominio; ?>consulta_projetos.php" >Consulta</a>
                                </li>
                                <li>
                                    <a class="active-menu" href="<?php echo app::dominio; ?>liberar_projetos.php" >Liberar Projeto</a>
                                </li>
                                <?php if ($app->checkAccess($_SESSION['id_perfilusuario'], $funcConst::perfil_cria_apontamentos)){ ?> 
                                    <li>
                                        <a class="active-menu" href="<?php echo app::dominio; ?>projetoapontamentos.php" >Liberar Apontamento</a>
                                    </li>
                                <?php } ?>        
                            </ul>
                        </li>
                        <?php } ?>
                        
                        <?php if ($app->checkAccess($_SESSION['id_perfilusuario'], $funcConst::perfil_apontamento)){ ?>
                        <li>
                            <a class="active-menu" href="<?php echo app::dominio; ?>apontamentos.php"><i class="fa fa-calendar"></i> Apontamento</a><!-- query_builder -->
                        </li>
                        <?php } ?>

                        <?php if ($app->checkAccess($_SESSION['id_perfilusuario'], $funcConst::perfil_aprovacao)){ ?>
                        <li>
                            <a class="active-menu" href="<?php echo app::dominio; ?>libera_apontamento.php"><i class="fa fa-thumbs-up"></i> Aprovação</a><!-- thumb_up -->
                        </li>
                        <?php } ?>

                        <?php if ($app->checkAccess($_SESSION['id_perfilusuario'], $funcConst::perfil_relatorios)){ ?>
                        <li>
                            <a href="#" class="active-menu"><i class="fa fa-list"></i> Relatórios<span class="fa arrow"></span></a><!-- reorder -->
                            <ul class="nav nav-second-level">
                                <li>
                                    <a class="active-menu" href="<?php echo app::dominio; ?>rlt_hrecurso.php" >Horas por recursos</a>
                                </li>
                                <li>
                                    <a class="active-menu" href="<?php echo app::dominio; ?>rlt_hprojeto.php" >Horas por projetos</a>
                                </li>
                                <li>
                                    <a class="active-menu" href="<?php echo app::dominio; ?>rlt_hpilar.php" >Horas por pilares</a>
                                </li>
                                <li>
                                    <a class="active-menu" href="<?php echo app::dominio; ?>rlt_despProjRec.php" >Despesas</a>
                                </li>
                            </ul>
                        </li>
                        <?php } ?>
                    </ul>
                </div>
            </nav>
<?php   } ?>
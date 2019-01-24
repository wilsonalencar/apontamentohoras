<?php require_once(app::path.'view/header.php'); ?>

<div id="page-wrapper">

	<div class="header"> 
		<h1 class="page-header">
		     Banco de Horas
		</h1>
		<ol class="breadcrumb">
			<li><a href="#">Projetos</a></li>
			<li class="active">Liberar Banco de Horas</li>
		</ol>
	</div>

	<div id="page-inner">
		<div class="row">
			<div class="col-lg-12">

				<div class="card">

					<div class="card-action">
						Liberação de Banco de Horas
					</div>

					<div class="card-content">
						<div class="row">

							<form method="post" action="projetobancodehoras.php" enctype="multipart/form-data">

									<div class="col-md-12">
										<?php
					                      if (!empty($msg)) { 
					                        if ($success) {
					                            echo "<div class='alert alert-success'>
					                                    <strong>Sucesso !</strong> $msg
					                                  </div>";
					                          }
					                          if (!$success) {
					                            echo "<div class='alert alert-danger'>
					                                    <strong>ERRO !</strong> $msg
					                                  </div>";
					                          }                           
					                        }
					                     ?>
				                 	</div>

									<div class="col-md-4">
										<div class="form-group">
											<label>Funcionario:</label>
											<select name="funcionario_id" class="form-control" required>

												<option style="display: none;" value>- Selecione -</option>

												<?php foreach($funcionarios as $funcionario){ ?>

													<option value="<?=$funcionario['id']?>">
														<?=$funcionario['nome']?>
													</option>

												<?php } ?>

											</select>
										</div>
									</div>

									<div class="col-md-4">
										<div class="form-group">
											<br>
											<button type="submit" name="action" value="1" class="btn btn-info">
												Adicionar
											</button>
										</div>
									</div>

							</form>

							<div class="col-lg-12">

								<table class="table table-bordered table-hover">

									<thead>
										<tr>
											<th>Funcionario</th>
											<th>Excluir</th>
										</tr>
									</thead>

									<tbody>

										<?php foreach($acessos as $acesso){ ?>

											<tr>
												<td><?=$acesso['nome']?></td>
												<td width="1">
													<form method="post" action="projetobancodehoras.php">
														<input type="hidden" name="funcionario_id" value="<?=$acesso['funcionario_id']?>">
														<button class="btn btn-danger" type="submit" name="action" value="2">
															Excluir
														</button>
													</form>
												</td>
											</tr>

										<?php } ?>

									</tbody>

								</table>

							</div>

						</div>
					</div>

				</div>

			</div>
		</div>
	</div>

</div>

<?php require_once(app::path.'/view/footer.php'); ?>
<?php
	error_reporting(0);

	if (!empty($_FILES)) {

		if (substr($_FILES['xml']['name'], 0, 6) == 'S-2200') {
			converteTxtLayout2200($_FILES['xml']);
		}
	}

	function converteTxtLayout2200($file)
	{
		$xml = simplexml_load_file($file['tmp_name']);
		
		$txt = '';
		foreach($xml->evtAdmissao->attributes() as $a => $b) {
		   $ID = $b;
		}

		$quebraLinha = PHP_EOL;
		//$quebraLinha = '<br>';

		//indice>
		$txt .= 'CAD2200_01|';
		$txt .= $ID.'|';
		$txt .= $xml->evtAdmissao->ideEmpregador->nrInsc.'|'; //cnpj empregador

		$indicadorExclusao = '|';
		$identificadorRetificacao = 'N|';


		if ((int)$xml->evtAdmissao->ideEvento->indRetif === 2) {
			$identificadorRetificacao = 'S|';
		}

		/* TRABALHADOR */
		$txt .= $indicadorExclusao;
		$txt .= $identificadorRetificacao;
		$txt .= $xml->evtAdmissao->trabalhador->cpfTrab.'|'; //cpf trabalhador
		$txt .= $xml->evtAdmissao->trabalhador->nisTrab.'|'; //nis trabalhador
		$txt .= $xml->evtAdmissao->trabalhador->nmTrab.'|'; //nome trabalhador
		$txt .= $xml->evtAdmissao->trabalhador->sexo.'|'; //sexo trabalhador
		$txt .= $xml->evtAdmissao->trabalhador->racaCor.'|'; //raca / cor trabalhador
		$txt .= $xml->evtAdmissao->trabalhador->estCiv.'|'; //estado civil trabalhador
		$txt .= $xml->evtAdmissao->trabalhador->grauInstr.'|'; //grau instrucao abalhador
		$txt .= $xml->evtAdmissao->trabalhador->nmSoc.'|'; //nome social para travesti
		$txt .= $xml->evtAdmissao->trabalhador->indPriEmpr.'|'; //primeiro empregoor trabalhad

		/* TRABALHADOR / NASCIMENTO */
		$txt .= $xml->evtAdmissao->trabalhador->nascimento->dtNascto.'|';//data nascimento trabalhador
		$txt .= $xml->evtAdmissao->trabalhador->nascimento->codMunic.'|';//municipio trabalhador
		$txt .= $xml->evtAdmissao->trabalhador->nascimento->uf.'|';//uf trabalhador
		$txt .= $xml->evtAdmissao->trabalhador->nascimento->paisNascto.'|';//pais nacto trabalhador 
		$txt .= $xml->evtAdmissao->trabalhador->nascimento->paisNac.'|';//pais nacto trabalhador 
		$txt .= $xml->evtAdmissao->trabalhador->nascimento->nmMae.'|';//mae trabalhador 
		$txt .= $xml->evtAdmissao->trabalhador->nascimento->nmPai.'|';//pai trabalhador 


		/* TRABALHADOR / ENDERECO */
		$resideExterior = '|';
		$txt .= $resideExterior;
		$txt .= $xml->evtAdmissao->trabalhador->endereco->brasil->tpLograd.'|';//tp lograd
		$txt .= $xml->evtAdmissao->trabalhador->endereco->brasil->dscLograd.'|';
		$txt .= $xml->evtAdmissao->trabalhador->endereco->brasil->nrLograd.'|';
		$txt .= $xml->evtAdmissao->trabalhador->endereco->brasil->complemento.'|'; //complemento
		$txt .= $xml->evtAdmissao->trabalhador->endereco->brasil->bairro.'|'; //bairro
		$txt .= $xml->evtAdmissao->trabalhador->endereco->brasil->cep.'|'; //cep
		$txt .= $xml->evtAdmissao->trabalhador->endereco->brasil->uf.'|'; //uf
		$txt .= $xml->evtAdmissao->trabalhador->endereco->brasil->codMunic.'|'; //codMunc
		$txt .= $xml->evtAdmissao->trabalhador->endereco->exterior->paisResid.'|'; //codMunc
		$txt .= $xml->evtAdmissao->trabalhador->endereco->exterior->nmCid.'|'; //cidade no exterio

		/* TRABALHADOR / DOCUMENTOS */
		$txt .= $xml->evtAdmissao->trabalhador->documentos->CTPS->nrCtps.'|'; //numero da carteira do trabalhador
		$txt .= $xml->evtAdmissao->trabalhador->documentos->CTPS->serieCtps.'|'; //numero da carteira do trabalhador
		$txt .= $xml->evtAdmissao->trabalhador->documentos->CTPS->ufCtps.'|'; //numero da carteira do trabalhador
		$txt .= $xml->evtAdmissao->trabalhador->aposentadoria->trabAposent.'|'; //verificar
		$txt .= $xml->evtAdmissao->trabalhador->trabEstrangeiro->dtChegada.'|'; //verificar
		$txt .= $xml->evtAdmissao->trabalhador->trabEstrangeiro->classTrabEstrang.'|'; //verificar
		$txt .= $xml->evtAdmissao->trabalhador->trabEstrangeiro->casadoBr.'|'; //verificar
		$txt .= $xml->evtAdmissao->trabalhador->trabEstrangeiro->filhosBr.'|'; //verificar


		$txt .= substr($xml->evtAdmissao->trabalhador->contato->fonePrinc, 0, 2).'|'; //verificar
		$txt .= substr($xml->evtAdmissao->trabalhador->contato->fonePrinc, 2).'|';
		$txt .= $xml->evtAdmissao->trabalhador->contato->emailPrinc.'|';//email principal

		$txt .= substr($xml->evtAdmissao->trabalhador->contato->foneAlternat, 0, 2).'|'; //fone alternativo
		$txt .= substr($xml->evtAdmissao->trabalhador->contato->foneAlternat, 2).'|'; 
		$txt .= $xml->evtAdmissao->trabalhador->contato->emailAlternat.'|';//email alternativo

		/* TRABALHADOR / infoDeficiencia */ 
		$txt .= $xml->evtAdmissao->trabalhador->infoDeficiencia->defFisica.'|';//deficiencia fisica
		$txt .= $xml->evtAdmissao->trabalhador->infoDeficiencia->defVisual.'|';//deficiencia fisica
		$txt .= $xml->evtAdmissao->trabalhador->infoDeficiencia->defAuditiva.'|';//deficiencia fisica
		$txt .= $xml->evtAdmissao->trabalhador->infoDeficiencia->defMental.'|';//deficiencia fisica
		$txt .= $xml->evtAdmissao->trabalhador->infoDeficiencia->defIntelectual.'|';//deficiencia fisica
		$txt .= $xml->evtAdmissao->trabalhador->infoDeficiencia->reabReadap.'|';//deficiencia fisica
		$txt .= $xml->evtAdmissao->trabalhador->infoDeficiencia->infoCota.'|';//deficiencia fisica
		$txt .= $xml->evtAdmissao->trabalhador->infoDeficiencia->observacao.'|';//verificar
		

		if (!empty($xml->evtAdmissao->trabalhador->dependente)) {
			
			foreach($xml->evtAdmissao->trabalhador->dependente as $dependente) {
				$txt .= $quebraLinha;
				$txt .= 'CAD2200_02|';
				$txt .= $dependente->tpDep.'|';
				$txt .= $dependente->nmDep.'|'; 
				$txt .= $dependente->dtNascto.'|';
				$txt .= $dependente->cpfDep.'|';  
				$txt .= $dependente->depIRRF.'|';
				$txt .= $dependente->depSF.'|';  
				$txt .= $dependente->incTrab.'|'; 
			}
 
		}

		if (!empty($xml->evtAdmissao->trabalhador->documentos)) {
			$txt .= $quebraLinha;
			$txt .= 'CAD2200_03|';		

			foreach($xml->evtAdmissao->trabalhador->documentos as $key => $documentos) {
				foreach($documentos as $keyValue => $documento) {
					
					if ($keyValue != 'CTPS') {

						

						$txt .= $keyValue.'|';
						if ($keyValue == 'RIC') {
							$txt .= $documento->nrRic.'|';
						}

						if ($keyValue == 'RG') {
							$txt .= $documento->nrRg.'|';
						}

						if ($keyValue == 'RNE') {
							$txt .= $documento->nrRne.'|';
						}

						if ($keyValue == 'OC') {
							$txt .= $documento->nrOc.'|';
						}  
						$txt .= $documento->orgaoEmissor.'|';
						$txt .= $documento->dtExped.'|';
						$txt .= $documento->dtValid.'|';
						$txt .= $documento->ufCnh.'|';  
						$txt .= $documento->dtPriHab.'|';
						$txt .= $documento->categoriCnh.'|'; 
					}
				}
			}
		}

		
		if (!empty($xml->evtAdmissao->vinculo)) {
			$txt .= $quebraLinha;
			$txt .= 'CAD2200_04|';
			$txt .= $xml->evtAdmissao->vinculo->matricula.'|';
			$txt .= $xml->evtAdmissao->vinculo->tpRegTrab.'|';
			$txt .= $xml->evtAdmissao->vinculo->tpRegPrev.'|';
			$txt .= $xml->evtAdmissao->vinculo->cadIni.'|';
			$txt .= $xml->evtAdmissao->vinculo->infoRegimeTrab->infoCeletista->dtAdm.'|';
			$txt .= $xml->evtAdmissao->vinculo->infoRegimeTrab->infoCeletista->tpAdmissao.'|';
			$txt .= $xml->evtAdmissao->vinculo->infoRegimeTrab->infoCeletista->indAdmissao.'|';
			$txt .= $xml->evtAdmissao->vinculo->infoRegimeTrab->infoCeletista->tpRegJor.'|';
			$txt .= $xml->evtAdmissao->vinculo->infoRegimeTrab->infoCeletista->natAtividade.'|';
			$txt .= $xml->evtAdmissao->vinculo->infoRegimeTrab->infoCeletista->dtBase.'|';
			$txt .= $xml->evtAdmissao->vinculo->infoRegimeTrab->infoCeletista->cnpjSindCategProf.'|';
			$txt .= $xml->evtAdmissao->vinculo->infoRegimeTrab->infoCeletista->FGTS->opcFGTS.'|';
			$txt .= $xml->evtAdmissao->vinculo->infoRegimeTrab->infoCeletista->FGTS->dtOpcFGTS.'|';
			$txt .= $xml->evtAdmissao->vinculo->infoRegimeTrab->infoCeletista->aprend->nrInsc.'|';
			$txt .= $xml->evtAdmissao->vinculo->infoRegimeTrab->infoCeletista->trabTemporario->hipLeg.'|';
			$txt .= $xml->evtAdmissao->vinculo->infoRegimeTrab->infoCeletista->trabTemporario->justContr.'|';
			$txt .= $xml->evtAdmissao->vinculo->infoRegimeTrab->infoCeletista->trabTemporario->tpInclContr.'|';

			$txt .= $xml->evtAdmissao->vinculo->infoRegimeTrab->infoCeletista->trabTemporario->ideTomadorServ->nrInsc.'|';
			$txt .= $xml->evtAdmissao->vinculo->infoRegimeTrab->infoCeletista->trabTemporario->ideTomadorServ->ideEstabVinc->nrInsc.'|';

			$txt .= $xml->evtAdmissao->vinculo->infoContrato->codCateg.'|';
			$txt .= $xml->evtAdmissao->vinculo->infoContrato->codCargo.'|';
			$txt .= $xml->evtAdmissao->vinculo->infoContrato->codFuncao.'|';
			$txt .= $xml->evtAdmissao->vinculo->infoContrato->codCarreira.'|';
			$txt .= $xml->evtAdmissao->vinculo->infoContrato->dtIngrCarr.'|';
			$txt .= $xml->evtAdmissao->vinculo->infoContrato->remuneracao->vrSalFx.'|';
			$txt .= $xml->evtAdmissao->vinculo->infoContrato->remuneracao->undSalFixo.'|';
			$txt .= $xml->evtAdmissao->vinculo->infoContrato->remuneracao->descSalVar.'|'; //verificar

			$txt .= $xml->evtAdmissao->vinculo->infoContrato->duracao->tpContr.'|';
			$txt .= $xml->evtAdmissao->vinculo->infoContrato->duracao->dtTerm.'|';
			$txt .= $xml->evtAdmissao->vinculo->infoContrato->duracao->clauAssec.'|'; //verificar
			$txt .= $xml->evtAdmissao->vinculo->desligamento->dtDeslig.'|'; //verificar

			$txt .= $xml->evtAdmissao->vinculo->infoContrato->horContratual->qtdHrsSem.'|';
			$txt .= $xml->evtAdmissao->vinculo->infoContrato->horContratual->tpJornada.'|';
			$txt .= $xml->evtAdmissao->vinculo->infoContrato->horContratual->descTpJorn.'|'; // ????? 
			$txt .= $xml->evtAdmissao->vinculo->infoContrato->horContratual->tmpParc.'|';

			$txt .= $xml->evtAdmissao->vinculo->infoContrato->localTrabalho->localTrabGeral->tpInsc.'|';
			$txt .= $xml->evtAdmissao->vinculo->infoContrato->localTrabalho->localTrabGeral->nrInsc.'|';
			$txt .= $xml->evtAdmissao->vinculo->infoContrato->localTrabalho->localTrabGeral->descComp.'|';


			$txt .= $xml->evtAdmissao->vinculo->infoContrato->localTrabalho->localTrabDom->tpLograd.'|'; //verificar
			$txt .= $xml->evtAdmissao->vinculo->infoContrato->localTrabalho->localTrabDom->descLograd.'|'; //verificar
			$txt .= $xml->evtAdmissao->vinculo->infoContrato->localTrabalho->localTrabDom->nrLograd.'|'; //verificar
			$txt .= $xml->evtAdmissao->vinculo->infoContrato->localTrabalho->localTrabDom->complemento.'|'; //verificar
			$txt .= $xml->evtAdmissao->vinculo->infoContrato->localTrabalho->localTrabDom->bairro.'|'; //verificar
			$txt .= $xml->evtAdmissao->vinculo->infoContrato->localTrabalho->localTrabDom->cep.'|'; //verificar
			$txt .= $xml->evtAdmissao->vinculo->infoContrato->localTrabalho->localTrabDom->codMunic.'|'; //verificar
			$txt .= $xml->evtAdmissao->vinculo->infoContrato->localTrabalho->localTrabDom->uf.'|'; //verificar

			$txt .= $xml->evtAdmissao->vinculo->sucessaoVinc->cnpjEmpregAnt.'|'; //verificar
			$txt .= $xml->evtAdmissao->vinculo->sucessaoVinc->matricAnt.'|'; //verificar
			$txt .= $xml->evtAdmissao->vinculo->sucessaoVinc->dtTransf.'|'; //verificar
			$txt .= $xml->evtAdmissao->vinculo->sucessaoVinc->observacao.'|'; //verificar
			

			$txt .= $xml->evtAdmissao->vinculo->infoRegimeTrab->infoEstatutario->infoDecJud->nrProcJud.'|';
			$txt .= $xml->evtAdmissao->vinculo->infoRegimeTrab->infoEstatutario->indProvim.'|';
			$txt .= $xml->evtAdmissao->vinculo->infoRegimeTrab->infoEstatutario->tpProv.'|';
			$txt .= $xml->evtAdmissao->vinculo->infoRegimeTrab->infoEstatutario->dtNomeacao.'|';
			$txt .= $xml->evtAdmissao->vinculo->infoRegimeTrab->infoEstatutario->dtPosse.'|';
			$txt .= $xml->evtAdmissao->vinculo->infoRegimeTrab->infoEstatutario->dtExercicio.'|';
			$txt .= $xml->evtAdmissao->vinculo->infoRegimeTrab->infoEstatutario->tpPlanRP.'|';

			$txt .= $xml->evtAdmissao->vinculo->infoContrato->alvaraJudicial->nrProcJud.'|';

			$txt .= $xml->evtAdmissao->vinculo->afastamento->dtIniAfast.'|'; //verificar
			$txt .= $xml->evtAdmissao->vinculo->afastamento->codMotAfast.'|'; //verificar
		}

		
		if (!empty($xml->evtAdmissao->vinculo->infoRegimeTrab->infoCeletista->trabTemporario->ideTrabSubstituido)) {
			$txt .= $quebraLinha;
			$txt .= 'CAD2200_05|';
			$txt .= $xml->evtAdmissao->vinculo->infoRegimeTrab->infoCeletista->trabTemporario->ideTrabSubstituido->cpfTrabSubst.'|';
		}

		if (!empty($xml->evtAdmissao->vinculo->infoContrato->horContratual->horario)) {

			foreach($xml->evtAdmissao->vinculo->infoContrato->horContratual->horario as $horario) {
				$txt .= $quebraLinha;
				$txt .= 'CAD2200_06|';
				$txt .= $horario->dia.'|';
				$txt .= $horario->codHorContrat.'|';
			}
		}

		if (!empty($xml->evtAdmissao->infoContrato->filiacaoSindical)) {
			$txt .= $quebraLinha;
			$txt .= 'CAD2200_07|';

			$txt .= $xml->evtAdmissao->infoContrato->filiacaoSindical->cnpjSindTrab.'|'; //verificar
		}

		if (!empty($xml->evtAdmissao->infoContrato->observacoes)) {
			$txt .= $quebraLinha;
			$txt .= 'CAD2200_08|';

			$txt .= $xml->evtAdmissao->infoContrato->observacoes->observacao.'|'; //verificar
		}


		$name = str_replace('xml', 'txt', $file['name']);
		$file = fopen($name, 'a');
		fwrite($file, $txt);
		fclose($file);
	}
?>

<html>
	<head>
		<title>Seja bem vindo ao Import de XML para TXT</title>
	</head>

	<body>
		<form method="POST" action="import.php" enctype="multipart/form-data">
			<label>Informar XML</label><br><br>
			<input type="file" name="xml" id="xml">
			<input type="submit" value="Gerar TXT">
		</form>		
	</body>
</html>
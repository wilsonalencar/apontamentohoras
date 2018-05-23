<?php
	error_reporting(0);
	$quebraLinha = PHP_EOL;
	//$quebraLinha = '<br>';

	if (!empty($_FILES)) {
		$files = array();
		
		foreach ($_FILES['xml']['name'] as $a => $b) {
			$files[$a]['name'] = $b;
		}

		foreach ($_FILES['xml']['type'] as $c => $d) {
			$files[$c]['type'] = $d;
		}
		
		foreach ($_FILES['xml']['tmp_name'] as $e => $f) {
			$files[$e]['tmp_name'] = $f;
		}
		
		foreach ($_FILES['xml']['error'] as $g => $h) {
			$files[$g]['error'] = $h;
		}

		foreach ($_FILES['xml']['size'] as $g => $h) {
			$files[$g]['size'] = $h;
		}

		foreach ($files as $id => $file) {
			if (substr($file['name'], 0, 6) == 'S-2200') {
				$arr[] = converteTxtLayout2200($file, $quebraLinha);
			}

			if (substr($file['name'], 0, 6) == 'S-2299') {
				$arr[] = converteTxtLayout2299($file, $quebraLinha);
			}

			if (substr($file['name'], 0, 6) == 'S-2399') {
				$arr[] = converteTxtLayout2399($file, $quebraLinha);
			}

			if (substr($file['name'], 0, 6) == 'S-2206') {
				$arr[] = converteTxtLayout2206($file, $quebraLinha);
			}

			if (substr($file['name'], 0, 6) == 'S-2300') {
				$arr[] = converteTxtLayout2300($file, $quebraLinha);
			}

			if (substr($file['name'], 0, 6) == 'S-2205') {
				$arr[] = converteTxtLayout2205($file, $quebraLinha);
			}

			if (substr($file['name'], 0, 6) == 'S-2306') {
				$arr[] = converteTxtLayout2306($file, $quebraLinha);
			}

			if (substr($file['name'], 0, 6) == 'S-2230') {
				$arr[] = converteTxtLayout2230($file, $quebraLinha);
			}

			if (substr($file['name'], 0, 6) == 'S-2250') {
				$arr[] = converteTxtLayout2250($file, $quebraLinha);
			}

			if (substr($file['name'], 0, 6) == 'S-2190') {
				$arr[] = converteTxtLayout2190($file, $quebraLinha);
			}

			if (substr($file['name'], 0, 6) == 'S-2298') {
				$arr[] = converteTxtLayout2298($file, $quebraLinha);
			}

			if (substr($file['name'], 0, 6) == 'S-1295') {
				$arr[] = converteTxtLayout1295($file, $quebraLinha);
			}

			if (substr($file['name'], 0, 6) == 'S-1299') {
				$arr[] = converteTxtLayout1299($file, $quebraLinha);
			}

			if (substr($file['name'], 0, 6) == 'S-1298') {
				$arr[] = converteTxtLayout1298($file, $quebraLinha);
			}

			if (substr($file['name'], 0, 6) == 'S-1300') {
				$arr[] = converteTxtLayout1300($file, $quebraLinha);
			}

			if (substr($file['name'], 0, 6) == 'S-1200') {
				$arr[] = converteTxtLayout1200($file, $quebraLinha);
			}

			if (substr($file['name'], 0, 6) == 'S-1210') {
				$arr[] = converteTxtLayout1210($file, $quebraLinha);
			}	

		}
		$date = date('dmYHi');
		$zip = new ZipArchive();
		$path = 'convert_'.$date.'.zip';

		touch($path);
		
		$res = $zip->open($path , ZipArchive::CREATE);
		if($res === true){
			foreach ($arr as $in => $name) {
		    	$zip->addFile(  $name , $name );
			}
		
		$zip->close();

		foreach ($arr as $inn => $namee) {
		    unlink($namee);
		}

		donwloadArquivo($path);			     
		}

		exit;
	}

	function converteTxtLayout1210($file, $quebraLinha)
	{
		$xml = simplexml_load_file($file['tmp_name']);
		$txt = '';
		$txt .= 'MOV3024_01|';  

		foreach($xml->evtPgtos->attributes() as $a => $b) {
		   $ID = $b;
		}

		$txt .= $ID.'|';
		$txt .= $xml->evtPgtos->ideEmpregador->nrInsc.'|';

		$indicadorExclusao = '|';
		$txt .= $indicadorExclusao;	

		$txt .= $xml->evtPgtos->ideEvento->indApuracao.'|';
		$txt .= $xml->evtPgtos->ideEvento->perApur.'|';
		
		$txt .= $xml->evtPgtos->ideBenef->cpfBenef.'|';

		$txt .= $xml->evtPgtos->ideBenef->deps->vrDedDep.'|';

		if (!empty($xml->evtPgtos->ideBenef->infoPgto)) {
			foreach($xml->evtPgtos->ideBenef->infoPgto as $infoPgto) {
				$txt .= $quebraLinha;
				$txt .= 'MOV3024_02|';
				$txt .= $infoPgto->dtPgto.'|';
				$txt .= $infoPgto->tpPgto.'|'; 
				$txt .= $infoPgto->indResBr.'|'; 
			}
		}

		if (!empty($xml->evtPgtos->ideBenef->infoPgto)) {
			foreach($xml->evtPgtos->ideBenef->infoPgto as $infoPgto) {
				$txt .= $infoPgto->detPgtoBenPr->perRef.'|'; 
				$txt .= $infoPgto->detPgtoBenPr->ideDmDev.'|'; 
				$txt .= $infoPgto->detPgtoBenPr->indPgtoTt.'|'; 
				$txt .= $infoPgto->detPgtoBenPr->vrLiq.'|'; 
			}
		}

		if (!empty($xml->evtPgtos->ideBenef->infoPgto)) {
			foreach($xml->evtPgtos->ideBenef->infoPgto as $infoPgto) {
				$txt .= $infoPgto->idePgtoExt->idePais->codPais.'|'; 
				$txt .= $infoPgto->idePgtoExt->idePais->indNIF.'|'; 
				$txt .= $infoPgto->idePgtoExt->idePais->nifBenef.'|'; 	
				$txt .= $infoPgto->idePgtoExt->endExt->dscLograd.'|'; 	
				$txt .= $infoPgto->idePgtoExt->endExt->nrLograd.'|'; 	
				$txt .= $infoPgto->idePgtoExt->endExt->complem.'|'; 	
				$txt .= $infoPgto->idePgtoExt->endExt->bairro.'|'; 	
				$txt .= $infoPgto->idePgtoExt->endExt->nmCid.'|'; 	
				$txt .= $infoPgto->idePgtoExt->endExt->codPostal.'|'; 	
			}
		}
		
		if (!empty($xml->evtPgtos->ideBenef->infoPgto)) {
			foreach($xml->evtPgtos->ideBenef->infoPgto as $infoPgto) {
				if (!empty($infoPgto->detPgtoFl)) {
					foreach ($infoPgto->detPgtoFl as $detPgtoFl) {
						$txt .= $quebraLinha;
						$txt .= 'MOV3024_03|';
						$txt .= $detPgtoFl->perRef.'|'; 
						$txt .= $detPgtoFl->ideDmDev.'|'; 
						$txt .= $detPgtoFl->indPgtoTt.'|'; 
						$txt .= $detPgtoFl->vrLiq.'|'; 
						$txt .= $detPgtoFl->nrRecArq.'|'; 
					}
				}
			}
		}

		if (!empty($xml->evtPgtos->ideBenef->infoPgto)) {
			foreach($xml->evtPgtos->ideBenef->infoPgto as $infoPgto) {
				if (!empty($infoPgto->detPgtoFl)) {
					foreach ($infoPgto->detPgtoFl as $detPgtoFl) {
						if (!empty($detPgtoFl->retPgtoTot)) {
							foreach ($detPgtoFl->retPgtoTot as $retPgtoTot) {
								$txt .= $quebraLinha;
								$txt .= 'MOV3024_04|';
								$txt .= $retPgtoTot->codRubr.'|'; 
								$txt .= $retPgtoTot->ideTabRubr.'|'; 
								$txt .= $retPgtoTot->qtdRubr.'|'; 
								$txt .= $retPgtoTot->fatorRubr.'|'; 
								$txt .= $retPgtoTot->vrUnit.'|'; 
								$txt .= $retPgtoTot->vrRubr.'|';		
							}
						} 
					}
				}
			}
		}

		if (!empty($xml->evtPgtos->ideBenef->infoPgto)) {
			foreach($xml->evtPgtos->ideBenef->infoPgto as $infoPgto) {
				if (!empty($infoPgto->detPgtoFl)) {
					foreach ($infoPgto->detPgtoFl as $detPgtoFl) {
						if (!empty($detPgtoFl->retPgtoTot)) {
							foreach ($detPgtoFl->retPgtoTot as $retPgtoTot) {
								if (!empty($retPgtoTot->penAlim)) {
									foreach ($retPgtoTot->penAlim as $penAlim) {
										$txt .= $quebraLinha;
										$txt .= 'MOV3024_05|';
										$txt .= $retPgtoTot->cpfBenef.'|'; 
										$txt .= $retPgtoTot->dtNasctoBenef.'|'; 
										$txt .= $retPgtoTot->nmBenefic.'|'; 
										$txt .= $retPgtoTot->vlrPensao.'|'; 
									}
								}
							}
						}
					}
				}
			}
		}

		if (!empty($xml->evtPgtos->ideBenef->infoPgto)) {
			foreach($xml->evtPgtos->ideBenef->infoPgto as $infoPgto) {
				if (!empty($infoPgto->detPgtoFl)) {
					foreach ($infoPgto->detPgtoFl as $detPgtoFl) {
						if (!empty($detPgtoFl->infoPgtoParc)) {
							foreach ($detPgtoFl->infoPgtoParc as $infoPgtoParc) {
								$txt .= $quebraLinha;
								$txt .= 'MOV3024_06|';
								$txt .= $infoPgtoParc->codRubr.'|'; 
								$txt .= $infoPgtoParc->ideTabRubr.'|'; 
								$txt .= $infoPgtoParc->qtdRubr.'|'; 
								$txt .= $infoPgtoParc->fatorRubr.'|'; 
								$txt .= $infoPgtoParc->vrUnit.'|'; 
								$txt .= $infoPgtoParc->vrRubr.'|';		
							}
						} 
					}
				}
			}
		}

		if (!empty($xml->evtPgtos->ideBenef->infoPgto)) {
			foreach($xml->evtPgtos->ideBenef->infoPgto as $infoPgto) {
				if (!empty($infoPgto->detPgtoBenPr)) {
					foreach ($infoPgto->detPgtoBenPr as $detPgtoBenPr) {
						if (!empty($detPgtoBenPr->retPgtoTot)) {
							foreach ($detPgtoBenPr->retPgtoTot as $retPgtoTot) {
								$txt .= $quebraLinha;
								$txt .= 'MOV3024_07|';
								$txt .= $retPgtoTot->codRubr.'|'; 
								$txt .= $retPgtoTot->ideTabRubr.'|'; 
								$txt .= $retPgtoTot->qtdRubr.'|'; 
								$txt .= $retPgtoTot->fatorRubr.'|'; 
								$txt .= $retPgtoTot->vrUnit.'|'; 
								$txt .= $retPgtoTot->vrRubr.'|';		
							}
						} 

						if (!empty($detPgtoBenPr->infoPgtoParc)) {
							foreach ($detPgtoBenPr->infoPgtoParc as $infoPgtoParc) {
								$txt .= $quebraLinha;
								$txt .= 'MOV3024_08|';
								$txt .= $infoPgtoParc->codRubr.'|'; 
								$txt .= $infoPgtoParc->ideTabRubr.'|'; 
								$txt .= $infoPgtoParc->qtdRubr.'|'; 
								$txt .= $infoPgtoParc->fatorRubr.'|'; 
								$txt .= $infoPgtoParc->vrUnit.'|'; 
								$txt .= $infoPgtoParc->vrRubr.'|';		
							}
						} 
					}
				}
			}
		}


		if (!empty($xml->evtPgtos->ideBenef->infoPgto)) {
			foreach($xml->evtPgtos->ideBenef->infoPgto as $infoPgto) {
				if (!empty($infoPgto->detPgtoFer)) {
					foreach ($infoPgto->detPgtoFer as $detPgtoFer) {
						$txt .= $quebraLinha;
						$txt .= 'MOV3024_09|';
						$txt .= $detPgtoFer->codCateg.'|'; 
						$txt .= $detPgtoFer->dtIniGoz.'|'; 
						$txt .= $detPgtoFer->qtDias.'|'; 
						$txt .= $detPgtoFer->vrLiq.'|'; 
					}
				}
			}
		}

		if (!empty($xml->evtPgtos->ideBenef->infoPgto)) {
			foreach($xml->evtPgtos->ideBenef->infoPgto as $infoPgto) {
				if (!empty($infoPgto->detPgtoFer)) {
					foreach ($infoPgto->detPgtoFer as $detPgtoFer) {
						if (!empty($detPgtoFer->detRubrFer)) {
							foreach ($detPgtoFer->detRubrFer as $detRubrFer) {
								$txt .= $quebraLinha;
								$txt .= 'MOV3024_10|';
								$txt .= $detRubrFer->codRubr.'|'; 
								$txt .= $detRubrFer->ideTabRubr.'|'; 
								$txt .= $detRubrFer->qtdRubr.'|'; 
								$txt .= $detRubrFer->fatorRubr.'|'; 
								$txt .= $detRubrFer->vrUnit.'|'; 
								$txt .= $detRubrFer->vrRubr.'|';	
							}
						}
					}
				}
			}
		}

		if (!empty($xml->evtPgtos->ideBenef->infoPgto)) {
			foreach($xml->evtPgtos->ideBenef->infoPgto as $infoPgto) {
				if (!empty($infoPgto->detPgtoFer)) {
					foreach ($infoPgto->detPgtoFer as $detPgtoFer) {
						if (!empty($detPgtoFer->detRubrFer)) {
							foreach ($detPgtoFer->detRubrFer as $detRubrFer) {
								if (!empty($detRubrFer->penAlim)) {
									foreach ($detRubrFer->penAlim as $penAlim) {
										$txt .= $quebraLinha;
										$txt .= 'MOV3024_11|';
										$txt .= $penAlim->cpfBenef.'|'; 
										$txt .= $penAlim->dtNasctoBenef.'|'; 
										$txt .= $penAlim->nmBenefic.'|'; 
										$txt .= $penAlim->vlrPensao.'|'; 
									}
								}
							}
						}
					}
				}
			}
		}

		if (!empty($xml->evtPgtos->ideBenef->infoPgto)) {
			foreach($xml->evtPgtos->ideBenef->infoPgto as $infoPgto) {
				if (!empty($infoPgto->detPgtoAnt)) {
					foreach ($infoPgto->detPgtoAnt as $detPgtoAnt) {
						$txt .= $quebraLinha;
						$txt .= 'MOV3024_12|';
						$txt .= $detPgtoAnt->codCateg.'|'; 
					}
				}
			}
		}

		if (!empty($xml->evtPgtos->ideBenef->infoPgto)) {
			foreach($xml->evtPgtos->ideBenef->infoPgto as $infoPgto) {
				if (!empty($infoPgto->detPgtoAnt)) {
					foreach ($infoPgto->detPgtoAnt as $detPgtoAnt) {
						if (!empty($detPgtoAnt->infoPgtoAnt)) {
							foreach ($detPgtoAnt->infoPgtoAnt as $infoPgtoAnt) {
								$txt .= $quebraLinha;
								$txt .= 'MOV3024_13|';
								$txt .= $infoPgtoAnt->tpBcIRRF.'|'; 
								$txt .= $infoPgtoAnt->vrBcIRRF.'|'; 
							}
						}
					}
				}
			}
		}

		$txt .= $quebraLinha;
		$name = str_replace('xml', 'txt', $file['name']);
		if (file_exists($name)) {
			unlink($name);
		}

		$file = fopen($name, 'a');
		fwrite($file, $txt);
		fclose($file);
		if (file_exists($name)) {
			return $name;
		}
	}


	function converteTxtLayout1200($file, $quebraLinha)
	{
		$xml = simplexml_load_file($file['tmp_name']);
		$txt = '';
		$txt .= 'MOV0021_01|';  

		foreach($xml->evtRemun->attributes() as $a => $b) {
		   $ID = $b;
		}

		$txt .= $ID.'|';
		$txt .= $xml->evtRemun->ideEmpregador->nrInsc.'|';

		$indicadorExclusao = '|';
		$txt .= $indicadorExclusao;	

		$txt .= $xml->evtRemun->ideEvento->indApuracao.'|';
		$txt .= $xml->evtRemun->ideEvento->perApur.'|';

		$txt .= $xml->evtRemun->ideTrabalhador->cpfTrab.'|';
		$txt .= $xml->evtRemun->ideTrabalhador->nisTrab.'|';
		$txt .= $xml->evtRemun->ideTrabalhador->infoComplem->nmTrab.'|';
		$txt .= $xml->evtRemun->ideTrabalhador->infoComplem->dtNascto.'|';
		$txt .= $xml->evtRemun->ideTrabalhador->infoComplem->codCBO.'|';
		$txt .= $xml->evtRemun->ideTrabalhador->infoComplem->natAtividade.'|';
		$txt .= $xml->evtRemun->ideTrabalhador->infoComplem->qtdDiasTrab.'|';

		$txt .= $xml->evtRemun->ideTrabalhador->infoComplem->sucessaoVinc->cnpjEmpregAnt.'|';
		$txt .= $xml->evtRemun->ideTrabalhador->infoComplem->sucessaoVinc->matricAnt.'|';
		$txt .= $xml->evtRemun->ideTrabalhador->infoComplem->sucessaoVinc->dtAdm.'|';
		$txt .= $xml->evtRemun->ideTrabalhador->infoComplem->sucessaoVinc->observacao.'|';

		$txt .= $xml->evtRemun->ideTrabalhador->infoMV->indMV.'|';

		if (!empty($xml->evtRemun->ideTrabalhador->infoMV->remunOutrEmpr)) {
			foreach($xml->evtRemun->ideTrabalhador->infoMV->remunOutrEmpr as $remunOutrEmpr) {
				$txt .= $quebraLinha;
				$txt .= 'MOV0021_02|';
				$txt .= $remunOutrEmpr->nrInsc.'|';
				$txt .= $remunOutrEmpr->codCateg.'|'; 
				$txt .= $remunOutrEmpr->vlrRemunOE.'|'; 
			}
		}

		if (!empty($xml->evtRemun->ideTrabalhador->procJudTrab)) {
			foreach($xml->evtRemun->ideTrabalhador->procJudTrab as $procJudTrab) {
				$txt .= $quebraLinha;
				$txt .= 'MOV0021_03|';
				$txt .= $procJudTrab->tpTrib.'|';
				$txt .= $procJudTrab->nrProcJud.'|'; 
				$txt .= $procJudTrab->codSusp.'|'; 
			}
		}

		if (!empty($xml->evtRemun->dmDev)) {
			foreach($xml->evtRemun->dmDev as $dmDev) {
				$txt .= $quebraLinha;
				$txt .= 'MOV0021_04|';
				$txt .= $dmDev->ideDmDev.'|';
				$txt .= $dmDev->codCateg.'|'; 
			}
		}

		if (!empty($xml->evtRemun->dmDev)) {
			foreach($xml->evtRemun->dmDev as $dmDev) {
				if (!empty($dmDev->infoPerApur->ideEstabLot)) {
					foreach($dmDev->infoPerApur->ideEstabLot as $lote) {
						$txt .= $quebraLinha;
						$txt .= 'MOV0021_05|';
						$txt .= $lote->tpInsc.'|';
						$txt .= $lote->nrInsc.'|';
						$txt .= $lote->codLotacao.'|';
						$txt .= $lote->qtdDiasAv.'|';				
					}
				}
			}
		}
		if (!empty($xml->evtRemun->dmDev)) {
			foreach($xml->evtRemun->dmDev as $dmDev) {
				if (!empty($dmDev->infoPerApur->ideEstabLot)) {
					foreach($dmDev->infoPerApur->ideEstabLot as $lote) {
						if (!empty($lote->remunPerApur)) {
							foreach ($lote->remunPerApur as $remunPerApur) {
								$txt .= $quebraLinha;
								$txt .= 'MOV0021_06|';
								$txt .= $remunPerApur->matricula.'|';
								$txt .= $remunPerApur->indSimples.'|';
								$txt .= $remunPerApur->infoAgNocivo->grauExp.'|';
							}
						}
					}
				}
			}
		}

		if (!empty($xml->evtRemun->dmDev)) {
			foreach($xml->evtRemun->dmDev as $dmDev) {
				if (!empty($dmDev->infoPerApur->ideEstabLot)) {
					foreach($dmDev->infoPerApur->ideEstabLot as $lote) {
						if (!empty($lote->remunPerApur)) {
							foreach ($lote->remunPerApur as $remunPerApur) {
								if (!empty($remunPerApur->itensRemun)) {
									foreach ($remunPerApur->itensRemun as $itensRemun) {
										$txt .= $quebraLinha;
										$txt .= 'MOV0021_07|';
										$txt .= $itensRemun->codRubr.'|';
										$txt .= $itensRemun->ideTabRubr.'|';
										$txt .= $itensRemun->qtdRubr.'|';
										$txt .= $itensRemun->fatorRubr.'|';
										$txt .= $itensRemun->vrUnit.'|';
										$txt .= $itensRemun->vrRubr.'|';
									}
								}
							}
						}
					}
				}
			}
		}

		if (!empty($xml->evtRemun->dmDev)) {
			foreach($xml->evtRemun->dmDev as $dmDev) {
				if (!empty($dmDev->infoPerApur->ideEstabLot)) {
					foreach($dmDev->infoPerApur->ideEstabLot as $lote) {
						if (!empty($lote->remunPerApur)) {
							foreach ($lote->remunPerApur as $remunPerApur) {
								if (!empty($remunPerApur->infoSaudeColet->detOper)) {
									foreach ($remunPerApur->infoSaudeColet->detOper as $detOper) {
										$txt .= $quebraLinha;
										$txt .= 'MOV0021_08|';
										$txt .= $detOper->cnpjOper.'|';
										$txt .= $detOper->regANS.'|';
										$txt .= $detOper->vrPgTit.'|';
									}
								}
							}
						}
					}
				}
			}
		}

		if (!empty($xml->evtRemun->dmDev)) {
			foreach($xml->evtRemun->dmDev as $dmDev) {
				if (!empty($dmDev->infoPerApur->ideEstabLot)) {
					foreach($dmDev->infoPerApur->ideEstabLot as $lote) {
						if (!empty($lote->remunPerApur)) {
							foreach ($lote->remunPerApur as $remunPerApur) {
								if (!empty($remunPerApur->infoSaudeColet->detOper)) {
									foreach ($remunPerApur->infoSaudeColet->detOper as $detOper) {
										if (!empty($detOper->detPlano)) {
											foreach ($detOper->detPlano as $detPlano) {
												$txt .= $quebraLinha;
												$txt .= 'MOV0021_09|';
												$txt .= $detPlano->tpDep.'|';
												$txt .= $detPlano->cpfDep.'|';
												$txt .= $detPlano->nmDep.'|';
												$txt .= $detPlano->dtNascto.'|';
												$txt .= $detPlano->vlrPgDep.'|';
											}
										}
									}
								}
							}
						}
					}
				}
			}
		}

		if (!empty($xml->evtRemun->dmDev)) {
			foreach($xml->evtRemun->dmDev as $dmDev) {
				if (!empty($dmDev->infoPerAnt->ideADC)) {
					foreach($dmDev->infoPerAnt->ideADC as $ideADC) {
						$txt .= $quebraLinha;
						$txt .= 'MOV0021_10|';
						$txt .= $ideADC->dtAcConv.'|';
						$txt .= $ideADC->tpAcConv.'|';
						$txt .= $ideADC->compAcConv.'|';
						$txt .= $ideADC->dtEfAcConv.'|';
						$txt .= $ideADC->dsc.'|';
						$txt .= $ideADC->remunSuc.'|';
					}
				}
			}
		}

		if (!empty($xml->evtRemun->dmDev)) {
			foreach($xml->evtRemun->dmDev as $dmDev) {
				if (!empty($dmDev->infoPerAnt->ideADC)) {
					foreach($dmDev->infoPerAnt->ideADC as $ideADC) {
						if (!empty($ideADC->idePeriodo)) {
							foreach ($ideADC->idePeriodo as $idePeriodo) {
								$txt .= $quebraLinha;
								$txt .= 'MOV0021_11|';
								$txt .= $idePeriodo->perRef.'|';
							}
						}
					}
				}
			}
		}

		if (!empty($xml->evtRemun->dmDev)) {
			foreach($xml->evtRemun->dmDev as $dmDev) {
				if (!empty($dmDev->infoPerAnt->ideADC)) {
					foreach($dmDev->infoPerAnt->ideADC as $ideADC) {
						if (!empty($ideADC->idePeriodo)) {
							foreach ($ideADC->idePeriodo as $idePeriodo) {
								if (!empty($idePeriodo->ideEstabLot)) {
									foreach ($idePeriodo->ideEstabLot as $ideEstabLot) {
										$txt .= $quebraLinha;
										$txt .= 'MOV0021_12|';
										$txt .= $ideEstabLot->tpInsc.'|';
										$txt .= $ideEstabLot->nrInsc.'|';
										$txt .= $ideEstabLot->codLotacao.'|';
									}
								}
							}
						}
					}
				}
			}
		}

		if (!empty($xml->evtRemun->dmDev)) {
			foreach($xml->evtRemun->dmDev as $dmDev) {
				if (!empty($dmDev->infoPerAnt->ideADC)) {
					foreach($dmDev->infoPerAnt->ideADC as $ideADC) {
						if (!empty($ideADC->idePeriodo)) {
							foreach ($ideADC->idePeriodo as $idePeriodo) {
								if (!empty($idePeriodo->ideEstabLot)) {
									foreach ($idePeriodo->ideEstabLot as $ideEstabLot) {
										if (!empty($ideEstabLot->remunPerAnt)) {
											foreach ($ideEstabLot->remunPerAnt as $remunPerAnt) {
												$txt .= $quebraLinha;
												$txt .= 'MOV0021_13|';
												$txt .= $remunPerAnt->matricula.'|';
												$txt .= $remunPerAnt->matricula.'|';
												$txt .= $remunPerAnt->infoAgNocivo->grauExp.'|';
											}
										}
									}
								}
							}
						}
					}
				}
			}
		}

		if (!empty($xml->evtRemun->dmDev)) {
			foreach($xml->evtRemun->dmDev as $dmDev) {
				if (!empty($dmDev->infoPerApur->ideEstabLot)) {
					foreach($dmDev->infoPerApur->ideEstabLot as $lote) {
						if (!empty($lote->remunPerAnt)) {
							foreach ($lote->remunPerAnt as $remunPerAnt) {
								if (!empty($remunPerAnt->itensRemun)) {
									foreach ($remunPerAnt->itensRemun as $itensRemun) {
										$txt .= $quebraLinha;
										$txt .= 'MOV0021_14|';
										$txt .= $itensRemun->codRubr.'|';
										$txt .= $itensRemun->ideTabRubr.'|';
										$txt .= $itensRemun->qtdRubr.'|';
										$txt .= $itensRemun->fatorRubr.'|';
										$txt .= $itensRemun->vrUnit.'|';
										$txt .= $itensRemun->vrRubr.'|';
									}
								}
							}
						}
					}
				}
			}
		}

		if (!empty($xml->evtRemun->dmDev)) {
			foreach($xml->evtRemun->dmDev as $dmDev) {
				if (!empty($dmDev->infoTrabInterm)) {
					foreach($dmDev->infoTrabInterm as $infoTrabInterm) {
						$txt .= $quebraLinha;
						$txt .= 'MOV0021_15|';
						$txt .= $infoTrabInterm->codConv.'|';
					}
				}
			}
		}

		$txt .= $quebraLinha;
		$name = str_replace('xml', 'txt', $file['name']);
		if (file_exists($name)) {
			unlink($name);
		}
		$file = fopen($name, 'a');
		fwrite($file, $txt);
		fclose($file);
		if (file_exists($name)) {
			return $name;
		}
	}

	function converteTxtLayout1300($file, $quebraLinha)
	{
		$xml = simplexml_load_file($file['tmp_name']);
		$txt = '';
		$txt .= 'MOV1300_01|';  

		foreach($xml->evtContrSindPatr->attributes() as $a => $b) {
		   $ID = $b;
		}

		$txt .= $ID.'|';
		$txt .= $xml->evtContrSindPatr->ideEmpregador->nrInsc.'|';

		$indicadorExclusao = '|';
		$txt .= $indicadorExclusao;
		
		$txt .= $xml->evtContrSindPatr->ideEvento->indApuracao.'|';
		$txt .= $xml->evtContrSindPatr->ideEvento->perApur.'|';

		if (!empty($xml->evtContrSindPatr->contribSind)) {	
			foreach($xml->evtContrSindPatr->contribSind as $contribSind) {
				$txt .= $quebraLinha;
				$txt .= 'MOV1300_02|';
				$txt .= $contribSind->cnpjSindic.'|';
				$txt .= $contribSind->tpContribSind.'|'; 
				$txt .= $contribSind->vlrContribSind.'|'; 
			}
		}
		
		$txt .= $quebraLinha;
		$name = str_replace('xml', 'txt', $file['name']);
		if (file_exists($name)) {
			unlink($name);
		}
		$file = fopen($name, 'a');
		fwrite($file, $txt);
		fclose($file);
		if (file_exists($name)) {
			return $name;
		}
	}

	function converteTxtLayout1299($file, $quebraLinha)
	{
		$xml = simplexml_load_file($file['tmp_name']);
		$txt = '';
		$txt .= 'MOV3028|';  

		foreach($xml->evtFechaEvPer->attributes() as $a => $b) {
		   $ID = $b;
		}

		$txt .= $ID.'|';
		$txt .= $xml->evtFechaEvPer->ideEmpregador->nrInsc.'|';

		$indicadorExclusao = '|';
		$txt .= $indicadorExclusao;
		
		$txt .= $xml->evtFechaEvPer->ideEvento->indApuracao.'|';
		$txt .= $xml->evtFechaEvPer->ideEvento->perApur.'|';
		$txt .= $xml->evtFechaEvPer->ideRespInf->nmResp.'|';
		$txt .= $xml->evtFechaEvPer->ideRespInf->cpfResp.'|';
		$txt .= substr($xml->evtFechaEvPer->ideRespInf->telefone, 0, 2).'|';
		$txt .= substr($xml->evtFechaEvPer->ideRespInf->telefone, 2).'|';
		$txt .= $xml->evtFechaEvPer->ideRespInf->email.'|';
	
		$txt .= $quebraLinha;
		$name = str_replace('xml', 'txt', $file['name']);
		if (file_exists($name)) {
			unlink($name);
		}
		$file = fopen($name, 'a');
		fwrite($file, $txt);
		fclose($file);
		if (file_exists($name)) {
			return $name;
		}
	}

	function converteTxtLayout1298($file, $quebraLinha)
	{
		$xml = simplexml_load_file($file['tmp_name']);
		$txt = '';
		$txt .= 'MOV3027|';  

		foreach($xml->evtReabreEvPer->attributes() as $a => $b) {
		   $ID = $b;
		}

		$txt .= $ID.'|';
		$txt .= $xml->evtReabreEvPer->ideEmpregador->nrInsc.'|';

		$indicadorExclusao = '|';
		$txt .= $indicadorExclusao;
		
		$txt .= $xml->evtReabreEvPer->ideEvento->indApuracao.'|';
		$txt .= $xml->evtReabreEvPer->ideEvento->perApur.'|';
	
		$txt .= $quebraLinha;
		$name = str_replace('xml', 'txt', $file['name']);
		if (file_exists($name)) {
			unlink($name);
		}
		$file = fopen($name, 'a');
		fwrite($file, $txt);
		fclose($file);
		if (file_exists($name)) {
			return $name;
		}
	}

	function converteTxtLayout1295($file, $quebraLinha)
	{
		$xml = simplexml_load_file($file['tmp_name']);
		$txt = '';
		$txt .= 'MOV1295|';  

		foreach($xml->evtTotConting->attributes() as $a => $b) {
		   $ID = $b;
		}

		$txt .= $ID.'|';
		$txt .= $xml->evtTotConting->ideEmpregador->nrInsc.'|';

		$indicadorExclusao = '|';
		$txt .= $indicadorExclusao;
		
		$txt .= $xml->evtTotConting->ideEvento->indApuracao.'|';
		$txt .= $xml->evtTotConting->ideEvento->perApur.'|';
		$txt .= $xml->evtTotConting->ideRespInf->nmResp.'|';
		$txt .= $xml->evtTotConting->ideRespInf->cpfResp.'|';
		$txt .= substr($xml->evtTotConting->ideRespInf->telefone, 0, 2).'|';
		$txt .= substr($xml->evtTotConting->ideRespInf->telefone, 2).'|';
		$txt .= $xml->evtTotConting->ideRespInf->email.'|';
		$txt .= $quebraLinha;
		$name = str_replace('xml', 'txt', $file['name']);
		if (file_exists($name)) {
			unlink($name);
		}
		$file = fopen($name, 'a');
		fwrite($file, $txt);
		fclose($file);
		if (file_exists($name)) {
			return $name;
		}
	}

	function converteTxtLayout2298($file, $quebraLinha)
	{
		$xml = simplexml_load_file($file['tmp_name']);
		$txt = '';
		$txt .= 'MOV1017|';  

		foreach($xml->evtReintegr->attributes() as $a => $b) {
		   $ID = $b;
		}

		$txt .= $ID.'|';
		$txt .= $xml->evtReintegr->ideEmpregador->nrInsc.'|';

		$indicadorExclusao = '|';
		$txt .= $indicadorExclusao;

		$txt .= $xml->evtReintegr->ideVinculo->cpfTrab.'|';
		$txt .= $xml->evtReintegr->ideVinculo->nisTrab.'|';
		$txt .= $xml->evtReintegr->ideVinculo->matricula.'|';

		$txt .= $xml->evtReintegr->infoReintegr->tpReint.'|';
		$txt .= $xml->evtReintegr->infoReintegr->nrProcJud.'|';
		$txt .= $xml->evtReintegr->infoReintegr->nrLeiAnistia.'|';
		$txt .= $xml->evtReintegr->infoReintegr->dtEfetRetorno.'|';
		$txt .= $xml->evtReintegr->infoReintegr->dtEfeito.'|';
		$txt .= $xml->evtReintegr->infoReintegr->indPagtoJuizo.'|';
		$txt .= $quebraLinha;
		$name = str_replace('xml', 'txt', $file['name']);
		if (file_exists($name)) {
			unlink($name);
		}
		$file = fopen($name, 'a');
		fwrite($file, $txt);
		fclose($file);
		if (file_exists($name)) {
			return $name;
		}
	}

	function converteTxtLayout2190($file, $quebraLinha)
	{
		$xml = simplexml_load_file($file['tmp_name']);
		$txt = '';
		$txt .= 'CAD3030|';  

		foreach($xml->evtAdmPrelim->attributes() as $a => $b) {
		   $ID = $b;
		}

		$txt .= $ID.'|';
		$txt .= $xml->evtAdmPrelim->ideEmpregador->nrInsc.'|';

		$indicadorExclusao = '|';
		$txt .= $indicadorExclusao;

		$txt .= $xml->evtAdmPrelim->infoRegPrelim->cpfTrab.'|';
		$txt .= $xml->evtAdmPrelim->infoRegPrelim->dtNascto.'|';
		$txt .= $xml->evtAdmPrelim->infoRegPrelim->dtAdm.'|';
		$txt .= $quebraLinha;
		$name = str_replace('xml', 'txt', $file['name']);
		if (file_exists($name)) {
			unlink($name);
		}
		$file = fopen($name, 'a');
		fwrite($file, $txt);
		fclose($file);
		if (file_exists($name)) {
			return $name;
		}
	}
	function converteTxtLayout2250($file, $quebraLinha)
	{
		$xml = simplexml_load_file($file['tmp_name']);
		$txt = '';
		$txt .= 'MOV1003|';  

		foreach($xml->evtAvPrevio->attributes() as $a => $b) {
		   $ID = $b;
		}

		$txt .= $ID.'|';
		$txt .= $xml->evtAvPrevio->ideEmpregador->nrInsc.'|';

		$indicadorExclusao = '|';
		$txt .= $indicadorExclusao;

		$txt .= $xml->evtAvPrevio->ideVinculo->cpfTrab.'|';
		$txt .= $xml->evtAvPrevio->ideVinculo->nisTrab.'|';
		$txt .= $xml->evtAvPrevio->ideVinculo->matricula.'|';

		$txt .= $xml->evtAvPrevio->infoAvPrevio->detAvPrevio->dtAvPrv.'|';
		$txt .= $xml->evtAvPrevio->infoAvPrevio->detAvPrevio->dtPrevDeslig.'|';
		$txt .= $xml->evtAvPrevio->infoAvPrevio->detAvPrevio->tpAvPrevio.'|';
		$txt .= $xml->evtAvPrevio->infoAvPrevio->detAvPrevio->observacao.'|';

		$txt .= $xml->evtAvPrevio->infoAvPrevio->cancAvPrevio->dtCancAvPrv.'|';
		$txt .= $xml->evtAvPrevio->infoAvPrevio->cancAvPrevio->observacao.'|';
		$txt .= $xml->evtAvPrevio->infoAvPrevio->cancAvPrevio->mtvCancAvPrevio.'|';
		$txt .= $quebraLinha;

		$name = str_replace('xml', 'txt', $file['name']);
		if (file_exists($name)) {
			unlink($name);
		}
		$file = fopen($name, 'a');
		fwrite($file, $txt);
		fclose($file);
		if (file_exists($name)) {
			return $name;
		}
	}

	function converteTxtLayout2230($file, $quebraLinha)
	{
		$xml = simplexml_load_file($file['tmp_name']);
		$txt = '';
		$txt .= 'MOV2230_01|';  

		foreach($xml->evtAfastTemp->attributes() as $a => $b) {
		   $ID = $b;
		}

		$txt .= $ID.'|';
		$txt .= $xml->evtAfastTemp->ideEmpregador->nrInsc.'|';

		$indicadorExclusao = '|';
		$txt .= $indicadorExclusao;		

		$txt .= $xml->evtAfastTemp->ideVinculo->cpfTrab.'|';
		$txt .= $xml->evtAfastTemp->ideVinculo->nisTrab.'|';
		$txt .= $xml->evtAfastTemp->ideVinculo->matricula.'|';
		$txt .= $xml->evtAfastTemp->ideVinculo->codCateg.'|';

		$txt .= $xml->evtAfastTemp->infoAfastamento->iniAfastamento->dtIniAfast.'|';
		$txt .= $xml->evtAfastTemp->infoAfastamento->iniAfastamento->codMotAfast.'|';
		$txt .= $xml->evtAfastTemp->infoAfastamento->iniAfastamento->infoMesmoMtv.'|';
		$txt .= $xml->evtAfastTemp->infoAfastamento->iniAfastamento->tpAcidTransito.'|';
		$txt .= $xml->evtAfastTemp->infoAfastamento->iniAfastamento->observacao.'|';

		$txt .= $xml->evtAfastTemp->infoAfastamento->iniAfastamento->infoCessao->cnpjCess.'|';
		$txt .= $xml->evtAfastTemp->infoAfastamento->iniAfastamento->infoCessao->infOnus.'|';

		$txt .= $xml->evtAfastTemp->infoAfastamento->iniAfastamento->infoMandSind->cnpjSind.'|';
		$txt .= $xml->evtAfastTemp->infoAfastamento->iniAfastamento->infoMandSind->infOnusRemun.'|';
		
		$txt .= $xml->evtAfastTemp->infoAfastamento->infoRetif->origRetif.'|';
		$txt .= $xml->evtAfastTemp->infoAfastamento->infoRetif->tpProc.'|';
		$txt .= $xml->evtAfastTemp->infoAfastamento->infoRetif->nrProc.'|';

		$txt .= $xml->evtAfastTemp->infoAfastamento->fimAfastamento->dtTermAfast.'|';


		if (!empty($xml->evtAfastTemp->infoAfastamento->iniAfastamento->infoAtestado)) {	
			foreach($xml->evtAfastTemp->infoAfastamento->iniAfastamento->infoAtestado as $infoAtestado) {
				$txt .= $quebraLinha;
				$txt .= 'MOV2230_02|';
				$txt .= $infoAtestado->codCID.'|';
				$txt .= $infoAtestado->qtdDiasAfast.'|'; 
				$txt .= $infoAtestado->emitente->nmEmit.'|'; 
				$txt .= $infoAtestado->emitente->ideOC.'|'; 
				$txt .= $infoAtestado->emitente->nrOc.'|'; 
				$txt .= $infoAtestado->emitente->ufOC.'|'; 
			}
		}
		$txt .= $quebraLinha;

		$name = str_replace('xml', 'txt', $file['name']);
		if (file_exists($name)) {
			unlink($name);
		}

		$file = fopen($name, 'a');
		fwrite($file, $txt);
		fclose($file);

		if (file_exists($name)) {
			return $name;
		}
	}

	function converteTxtLayout2306($file, $quebraLinha)
	{
		$xml = simplexml_load_file($file['tmp_name']);
		$txt = '';
		$txt .= 'CAD2306_01|';  

		foreach($xml->evtTSVAltContr->attributes() as $a => $b) {
		   $ID = $b;
		}

		$txt .= $ID.'|';
		$txt .= $xml->evtTSVAltContr->ideEmpregador->nrInsc.'|';

		$indicadorExclusao = '|';
		$txt .= $indicadorExclusao;
		$txt .= $xml->evtTSVAltContr->ideEvento->indRetif.'|';
		$txt .= $xml->evtTSVAltContr->ideTrabSemVinculo->cpfTrab.'|';
		$txt .= $xml->evtTSVAltContr->ideTrabSemVinculo->nisTrab.'|';
		$txt .= $xml->evtTSVAltContr->ideTrabSemVinculo->codCateg.'|';

		$txt .= $xml->evtTSVAltContr->infoTSVAlteracao->dtAlteracao.'|';
		$txt .= $xml->evtTSVAltContr->infoTSVAlteracao->natAtividade.'|';

		$txt .= $xml->evtTSVAltContr->infoTSVAlteracao->dtAlteracao.'|';
		$txt .= $xml->evtTSVAltContr->infoTSVAlteracao->infoComplementares->cargoFuncao->codCargo.'|';
		$txt .= $xml->evtTSVAltContr->infoTSVAlteracao->infoComplementares->cargoFuncao->codFuncao.'|';

		$txt .= $xml->evtTSVAltContr->infoTSVAlteracao->infoComplementares->remuneracao->vrSalFx.'|';
		$txt .= $xml->evtTSVAltContr->infoTSVAlteracao->infoComplementares->remuneracao->undSalFixo.'|';
		$txt .= $xml->evtTSVAltContr->infoTSVAlteracao->infoComplementares->remuneracao->dscSalVar.'|';

		$txt .= $xml->evtTSVAltContr->infoTSVAlteracao->infoComplementares->infoEstagiario->natEstagio.'|';
		$txt .= $xml->evtTSVAltContr->infoTSVAlteracao->infoComplementares->infoEstagiario->nivEstagio.'|';
		$txt .= $xml->evtTSVAltContr->infoTSVAlteracao->infoComplementares->infoEstagiario->areaAtuacao.'|';
		$txt .= $xml->evtTSVAltContr->infoTSVAlteracao->infoComplementares->infoEstagiario->nrApol.'|';
		$txt .= $xml->evtTSVAltContr->infoTSVAlteracao->infoComplementares->infoEstagiario->vlrBolsa.'|';
		$txt .= $xml->evtTSVAltContr->infoTSVAlteracao->infoComplementares->infoEstagiario->dtPrevTerm.'|';

		$txt .= $xml->evtTSVAltContr->infoTSVAlteracao->infoComplementares->infoEstagiario->instEnsino->cnpjInstEnsino.'|';
		$txt .= $xml->evtTSVAltContr->infoTSVAlteracao->infoComplementares->infoEstagiario->instEnsino->nmRazao.'|';
		$txt .= $xml->evtTSVAltContr->infoTSVAlteracao->infoComplementares->infoEstagiario->instEnsino->dscLograd.'|';
		$txt .= $xml->evtTSVAltContr->infoTSVAlteracao->infoComplementares->infoEstagiario->instEnsino->nrLograd.'|';
		$txt .= $xml->evtTSVAltContr->infoTSVAlteracao->infoComplementares->infoEstagiario->instEnsino->bairro.'|';
		$txt .= $xml->evtTSVAltContr->infoTSVAlteracao->infoComplementares->infoEstagiario->instEnsino->cep.'|';
		$txt .= $xml->evtTSVAltContr->infoTSVAlteracao->infoComplementares->infoEstagiario->instEnsino->codMunic.'|';
		$txt .= $xml->evtTSVAltContr->infoTSVAlteracao->infoComplementares->infoEstagiario->instEnsino->uf.'|';
		
		$txt .= $xml->evtTSVAltContr->infoTSVAlteracao->infoComplementares->infoEstagiario->ageIntegracao->cnpjAgntInteg.'|';
		$txt .= $xml->evtTSVAltContr->infoTSVAlteracao->infoComplementares->infoEstagiario->ageIntegracao->nmRazao.'|';
		$txt .= $xml->evtTSVAltContr->infoTSVAlteracao->infoComplementares->infoEstagiario->ageIntegracao->dscLograd.'|';
		$txt .= $xml->evtTSVAltContr->infoTSVAlteracao->infoComplementares->infoEstagiario->ageIntegracao->nrLograd.'|';
		$txt .= $xml->evtTSVAltContr->infoTSVAlteracao->infoComplementares->infoEstagiario->ageIntegracao->bairro.'|';
		$txt .= $xml->evtTSVAltContr->infoTSVAlteracao->infoComplementares->infoEstagiario->ageIntegracao->cep.'|';
		$txt .= $xml->evtTSVAltContr->infoTSVAlteracao->infoComplementares->infoEstagiario->ageIntegracao->codMunic.'|';
		$txt .= $xml->evtTSVAltContr->infoTSVAlteracao->infoComplementares->infoEstagiario->ageIntegracao->uf.'|';

		$txt .= $xml->evtTSVAltContr->infoTSVAlteracao->infoComplementares->infoEstagiario->supervisorEstagio->cpfSupervisor.'|';
		$txt .= $xml->evtTSVAltContr->infoTSVAlteracao->infoComplementares->infoEstagiario->supervisorEstagio->nmSuperv.'|';
		$txt .= $quebraLinha;

		$name = str_replace('xml', 'txt', $file['name']);
		if (file_exists($name)) {
			unlink($name);
		}
		$file = fopen($name, 'a');
		fwrite($file, $txt);
		fclose($file);
		if (file_exists($name)) {
			return $name;
		}
	}

	function converteTxtLayout2300($file, $quebraLinha)
	{
		$xml = simplexml_load_file($file['tmp_name']);
		$txt = '';
		$txt .= 'CAD2300_01|';  

		foreach($xml->evtTSVInicio->attributes() as $a => $b) {
		   $ID = $b;
		}

		$txt .= $ID.'|';
		$txt .= $xml->evtTSVInicio->ideEmpregador->nrInsc.'|';

		$indicadorExclusao = '|';
		$txt .= $indicadorExclusao;

		$indRetif = '|';
		if ((int)$xml->evtTSVInicio->ideEvento->indRetif == 2) {
			$indRetif = 'S|';
		}

		if ((int)$xml->evtTSVInicio->ideEvento->indRetif == 1) {
			$indRetif = 'N|';
		}

		$txt .= $indRetif;
		$txt .= $xml->evtTSVInicio->trabalhador->cpfTrab.'|';
		$txt .= $xml->evtTSVInicio->trabalhador->nisTrab.'|';
		$txt .= $xml->evtTSVInicio->trabalhador->nmTrab.'|';
		$txt .= $xml->evtTSVInicio->trabalhador->sexo.'|';
		$txt .= $xml->evtTSVInicio->trabalhador->racaCor.'|';
		$txt .= $xml->evtTSVInicio->trabalhador->estCiv.'|';
		$txt .= $xml->evtTSVInicio->trabalhador->grauInstr.'|';
		$txt .= $xml->evtTSVInicio->trabalhador->nmSoc.'|';

		$txt .= $xml->evtTSVInicio->trabalhador->nascimento->dtNascto.'|';
		$txt .= $xml->evtTSVInicio->trabalhador->nascimento->codMunic.'|';
		$txt .= $xml->evtTSVInicio->trabalhador->nascimento->uf.'|';
		$txt .= $xml->evtTSVInicio->trabalhador->nascimento->paisNascto.'|';
		$txt .= $xml->evtTSVInicio->trabalhador->nascimento->paisNac.'|';
		$txt .= $xml->evtTSVInicio->trabalhador->nascimento->nmMae.'|';
		$txt .= $xml->evtTSVInicio->trabalhador->nascimento->nmPai.'|';

		$resideExterior = '|';
		$txt .= $resideExterior;

		$txt .= $xml->evtTSVInicio->trabalhador->endereco->brasil->tpLograd.'|';
		$txt .= $xml->evtTSVInicio->trabalhador->endereco->brasil->dscLograd.'|';
		$txt .= $xml->evtTSVInicio->trabalhador->endereco->brasil->nrLograd.'|';
		$txt .= $xml->evtTSVInicio->trabalhador->endereco->brasil->complemento.'|';
		$txt .= $xml->evtTSVInicio->trabalhador->endereco->brasil->bairro.'|';
		$txt .= $xml->evtTSVInicio->trabalhador->endereco->brasil->cep.'|';
		$txt .= $xml->evtTSVInicio->trabalhador->endereco->brasil->uf.'|';
		$txt .= $xml->evtTSVInicio->trabalhador->endereco->brasil->codMunic.'|';

		$txt .= $xml->evtTSVInicio->trabalhador->endereco->exterior->paisResid.'|';
		$txt .= $xml->evtTSVInicio->trabalhador->endereco->exterior->nmCid.'|';

		$txt .= $xml->evtTSVInicio->trabalhador->documentos->CTPS->nrCtps.'|'; 
		$txt .= $xml->evtTSVInicio->trabalhador->documentos->CTPS->serieCtps.'|';
		$txt .= $xml->evtTSVInicio->trabalhador->documentos->CTPS->ufCtps.'|'; 

		$txt .= $xml->evtTSVInicio->trabalhador->trabEstrangeiro->dtChegada.'|'; 
		$txt .= $xml->evtTSVInicio->trabalhador->trabEstrangeiro->classTrabEstrang.'|';
		$txt .= $xml->evtTSVInicio->trabalhador->trabEstrangeiro->casadoBr.'|'; 
		$txt .= $xml->evtTSVInicio->trabalhador->trabEstrangeiro->filhosBr.'|'; 

		$txt .= substr($xml->evtTSVInicio->trabalhador->contato->fonePrinc, 0, 2).'|';
		$txt .= substr($xml->evtTSVInicio->trabalhador->contato->fonePrinc, 2).'|';
		$txt .= $xml->evtTSVInicio->trabalhador->contato->emailPrinc.'|';
		$txt .= substr($xml->evtTSVInicio->trabalhador->contato->foneAlternat, 0, 2).'|'; 
		$txt .= substr($xml->evtTSVInicio->trabalhador->contato->foneAlternat, 2).'|'; 
		$txt .= $xml->evtTSVInicio->trabalhador->contato->emailAlternat.'|';

		$txt .= $xml->evtTSVInicio->trabalhador->infoDeficiencia->defFisica.'|';
		$txt .= $xml->evtTSVInicio->trabalhador->infoDeficiencia->defVisual.'|';
		$txt .= $xml->evtTSVInicio->trabalhador->infoDeficiencia->defAuditiva.'|';
		$txt .= $xml->evtTSVInicio->trabalhador->infoDeficiencia->defMental.'|';
		$txt .= $xml->evtTSVInicio->trabalhador->infoDeficiencia->defIntelectual.'|';
		$txt .= $xml->evtTSVInicio->trabalhador->infoDeficiencia->reabReadap.'|';
		$txt .= $xml->evtTSVInicio->trabalhador->infoDeficiencia->observacao.'|';

		
		if (!empty($xml->evtTSVInicio->trabalhador->dependente)) {
			
			foreach($xml->evtTSVInicio->trabalhador->dependente as $dependente) {
				$txt .= $quebraLinha;
				$txt .= 'CAD2300_02|';
				$txt .= $dependente->tpDep.'|';
				$txt .= $dependente->nmDep.'|'; 
				$txt .= $dependente->dtNascto.'|';
				$txt .= $dependente->cpfDep.'|';  
				$txt .= $dependente->depIRRF.'|';
				$txt .= $dependente->depSF.'|';  
				$txt .= $dependente->incTrab.'|'; 
			}
 
		}

		if (!empty($xml->evtTSVInicio->trabalhador->documentos)) {

			foreach($xml->evtTSVInicio->trabalhador->documentos as $key => $documentos) {
				foreach($documentos as $keyValue => $documento) {
					
					if ($keyValue != 'CTPS') {
						$txt .= $quebraLinha;
						$txt .= 'CAD2300_03|';		
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

		$txt .= $quebraLinha;
		$txt .= 'CAD2300_04|';
		$txt .= $xml->evtTSVInicio->infoTSVInicio->dtInicio.'|';
		$txt .= $xml->evtTSVInicio->infoTSVInicio->codCateg.'|';
		$txt .= $xml->evtTSVInicio->infoTSVInicio->natAtividade.'|';
		$txt .= $xml->evtTSVInicio->infoTSVInicio->cadIni.'|';

		$txt .= $xml->evtTSVInicio->infoTSVInicio->termino->dtTerm.'|';

		$txt .= $xml->evtTSVInicio->infoTSVInicio->infoComplementares->cargoFuncao->codCargo.'|';
		$txt .= $xml->evtTSVInicio->infoTSVInicio->infoComplementares->cargoFuncao->codFuncao.'|';

		$txt .= $xml->evtTSVInicio->infoTSVInicio->infoComplementares->remuneracao->vrSalFx.'|';
		$txt .= $xml->evtTSVInicio->infoTSVInicio->infoComplementares->remuneracao->undSalFixo.'|';
		$txt .= $xml->evtTSVInicio->infoTSVInicio->infoComplementares->remuneracao->descSalVar.'|';

		$txt .= $xml->evtTSVInicio->infoTSVInicio->infoComplementares->fgts->opcFGTS.'|';
		$txt .= $xml->evtTSVInicio->infoTSVInicio->infoComplementares->fgts->dtOpcFGTS.'|';

		$txt .= $xml->evtTSVInicio->infoTSVInicio->infoComplementares->infoDirigenteSindical->categOrig.'|';
		$txt .= $xml->evtTSVInicio->infoTSVInicio->infoComplementares->infoDirigenteSindical->cnpjOrigem.'|';
		$txt .= $xml->evtTSVInicio->infoTSVInicio->infoComplementares->infoDirigenteSindical->dtAdmOrig.'|';
		$txt .= $xml->evtTSVInicio->infoTSVInicio->infoComplementares->infoDirigenteSindical->matricOrig.'|';
		
		$txt .= $xml->evtTSVInicio->infoTSVInicio->infoComplementares->infoTrabCedido->categOrig.'|';
		$txt .= $xml->evtTSVInicio->infoTSVInicio->infoComplementares->infoTrabCedido->cnpjCednt.'|';
		$txt .= $xml->evtTSVInicio->infoTSVInicio->infoComplementares->infoTrabCedido->matricCed.'|';
		$txt .= $xml->evtTSVInicio->infoTSVInicio->infoComplementares->infoTrabCedido->dtAdmCed.'|';
		$txt .= $xml->evtTSVInicio->infoTSVInicio->infoComplementares->infoTrabCedido->tpRegTrab.'|';
		$txt .= $xml->evtTSVInicio->infoTSVInicio->infoComplementares->infoTrabCedido->tpRegPrev.'|';
		$txt .= $xml->evtTSVInicio->infoTSVInicio->infoComplementares->infoTrabCedido->infOnus.'|';

		$txt .= $xml->evtTSVInicio->infoTSVInicio->infoComplementares->infoEstagiario->natEstagio.'|';
		$txt .= $xml->evtTSVInicio->infoTSVInicio->infoComplementares->infoEstagiario->nivEstagio.'|';
		$txt .= $xml->evtTSVInicio->infoTSVInicio->infoComplementares->infoEstagiario->areaAtuacao.'|';
		$txt .= $xml->evtTSVInicio->infoTSVInicio->infoComplementares->infoEstagiario->nrApol.'|';
		$txt .= $xml->evtTSVInicio->infoTSVInicio->infoComplementares->infoEstagiario->vlrBolsa.'|';
		$txt .= $xml->evtTSVInicio->infoTSVInicio->infoComplementares->infoEstagiario->dtPrevTerm.'|';

		$txt .= $xml->evtTSVInicio->infoTSVInicio->infoComplementares->infoEstagiario->instEnsino->cnpjInstEnsino.'|';
		$txt .= $xml->evtTSVInicio->infoTSVInicio->infoComplementares->infoEstagiario->instEnsino->nmRazao.'|';
		$txt .= $xml->evtTSVInicio->infoTSVInicio->infoComplementares->infoEstagiario->instEnsino->dscLograd.'|';
		$txt .= $xml->evtTSVInicio->infoTSVInicio->infoComplementares->infoEstagiario->instEnsino->nrLograd.'|';
		$txt .= $xml->evtTSVInicio->infoTSVInicio->infoComplementares->infoEstagiario->instEnsino->bairro.'|';
		$txt .= $xml->evtTSVInicio->infoTSVInicio->infoComplementares->infoEstagiario->instEnsino->cep.'|';
		$txt .= $xml->evtTSVInicio->infoTSVInicio->infoComplementares->infoEstagiario->instEnsino->codMunic.'|';
		$txt .= $xml->evtTSVInicio->infoTSVInicio->infoComplementares->infoEstagiario->instEnsino->uf.'|';

		$txt .= $xml->evtTSVInicio->infoTSVInicio->infoComplementares->infoEstagiario->ageIntegracao->cnpjAgntInteg.'|';
		$txt .= $xml->evtTSVInicio->infoTSVInicio->infoComplementares->infoEstagiario->ageIntegracao->nmRazao.'|';
		$txt .= $xml->evtTSVInicio->infoTSVInicio->infoComplementares->infoEstagiario->ageIntegracao->dscLograd.'|';
		$txt .= $xml->evtTSVInicio->infoTSVInicio->infoComplementares->infoEstagiario->ageIntegracao->nrLograd.'|';
		$txt .= $xml->evtTSVInicio->infoTSVInicio->infoComplementares->infoEstagiario->ageIntegracao->bairro.'|';
		$txt .= $xml->evtTSVInicio->infoTSVInicio->infoComplementares->infoEstagiario->ageIntegracao->cep.'|';
		$txt .= $xml->evtTSVInicio->infoTSVInicio->infoComplementares->infoEstagiario->ageIntegracao->codMunic.'|';
		$txt .= $xml->evtTSVInicio->infoTSVInicio->infoComplementares->infoEstagiario->ageIntegracao->uf.'|';

		$txt .= $xml->evtTSVInicio->infoTSVInicio->infoComplementares->infoEstagiario->supervisorEstagio->cpfSupervisor.'|';
		$txt .= $xml->evtTSVInicio->infoTSVInicio->infoComplementares->infoEstagiario->supervisorEstagio->nmSuperv.'|';

		$txt .= $xml->evtTSVInicio->infoTSVInicio->afastamento->dtIniAfast.'|';
		$txt .= $xml->evtTSVInicio->infoTSVInicio->afastamento->codMotAfast.'|';
		$txt .= $quebraLinha;

		$name = str_replace('xml', 'txt', $file['name']);
		if (file_exists($name)) {
			unlink($name);
		}
		$file = fopen($name, 'a');
		fwrite($file, $txt);
		fclose($file);
		if (file_exists($name)) {
			return $name;
		}
	}

	function converteTxtLayout2205($file, $quebraLinha)
	{
		$xml = simplexml_load_file($file['tmp_name']);
		$txt = '';
		$txt .= 'CAD2205_01|';  

		foreach($xml->evtAltContratual->attributes() as $a => $b) {
		   $ID = $b;
		}

		$txt .= $ID.'|';
		$txt .= $xml->evtAltCadastral->ideEmpregador->nrInsc.'|';

		$indicadorExclusao = '|';
		$txt .= $indicadorExclusao;

		$txt .= $xml->evtAltCadastral->ideEvento->indRetif.'|';
		$txt .= $xml->evtAltCadastral->alteracao->dtAlteracao.'|';

		$txt .= $xml->evtAltCadastral->ideTrabalhador->cpfTrab.'|';

		$txt .= $xml->evtAltCadastral->alteracao->dadosTrabalhador->nisTrab.'|';
		$txt .= $xml->evtAltCadastral->alteracao->dadosTrabalhador->nmTrab.'|';
		$txt .= $xml->evtAltCadastral->alteracao->dadosTrabalhador->sexo.'|';
		$txt .= $xml->evtAltCadastral->alteracao->dadosTrabalhador->racaCor.'|';
		$txt .= $xml->evtAltCadastral->alteracao->dadosTrabalhador->estCiv.'|';
		$txt .= $xml->evtAltCadastral->alteracao->dadosTrabalhador->grauInstr.'|';
		$txt .= $xml->evtAltCadastral->alteracao->dadosTrabalhador->nmSoc.'|';

		$resideExterior = '|';
		$txt .= $resideExterior;

		$txt .= $xml->evtAltCadastral->alteracao->dadosTrabalhador->endereco->brasil->tpLograd.'|';
		$txt .= $xml->evtAltCadastral->alteracao->dadosTrabalhador->endereco->brasil->dscLograd.'|';
		$txt .= $xml->evtAltCadastral->alteracao->dadosTrabalhador->endereco->brasil->nrLograd.'|';
		$txt .= $xml->evtAltCadastral->alteracao->dadosTrabalhador->endereco->brasil->complemento.'|';
		$txt .= $xml->evtAltCadastral->alteracao->dadosTrabalhador->endereco->brasil->bairro.'|';
		$txt .= $xml->evtAltCadastral->alteracao->dadosTrabalhador->endereco->brasil->cep.'|';
		$txt .= $xml->evtAltCadastral->alteracao->dadosTrabalhador->endereco->brasil->uf.'|';
		$txt .= $xml->evtAltCadastral->alteracao->dadosTrabalhador->endereco->brasil->codMunic.'|';

		$txt .= $xml->evtAltCadastral->alteracao->dadosTrabalhador->endereco->exterior->paisResid.'|';
		$txt .= $xml->evtAltCadastral->alteracao->dadosTrabalhador->endereco->exterior->nmCid.'|';

		$txt .= $xml->evtAltCadastral->alteracao->dadosTrabalhador->documentos->CTPS->nrCtps.'|'; 
		$txt .= $xml->evtAltCadastral->alteracao->dadosTrabalhador->documentos->CTPS->serieCtps.'|';
		$txt .= $xml->evtAltCadastral->alteracao->dadosTrabalhador->documentos->CTPS->ufCtps.'|';

		$txt .= $xml->evtAltCadastral->alteracao->dadosTrabalhador->aposentadoria->trabAposent.'|';
		$txt .= $xml->evtAltCadastral->alteracao->dadosTrabalhador->trabEstrangeiro->dtChegada.'|';
		$txt .= $xml->evtAltCadastral->alteracao->dadosTrabalhador->trabEstrangeiro->classTrabEstrang.'|';
		$txt .= $xml->evtAltCadastral->alteracao->dadosTrabalhador->trabEstrangeiro->casadoBr.'|';
		$txt .= $xml->evtAltCadastral->alteracao->dadosTrabalhador->trabEstrangeiro->filhosBr.'|'; 

		$txt .= substr($xml->evtAltCadastral->alteracao->dadosTrabalhador->contato->fonePrinc, 0, 2).'|';
		$txt .= substr($xml->evtAltCadastral->alteracao->dadosTrabalhador->contato->fonePrinc, 2).'|';
		$txt .= $xml->evtAltCadastral->alteracao->dadosTrabalhador->contato->emailPrinc.'|';
		$txt .= substr($xml->evtAltCadastral->alteracao->dadosTrabalhador->contato->foneAlternat, 0, 2).'|'; 
		$txt .= substr($xml->evtAltCadastral->alteracao->dadosTrabalhador->contato->foneAlternat, 2).'|'; 
		$txt .= $xml->evtAltCadastral->alteracao->dadosTrabalhador->contato->emailAlternat.'|';

		$txt .= $xml->evtAltCadastral->alteracao->dadosTrabalhador->infoDeficiencia->defFisica.'|';
		$txt .= $xml->evtAltCadastral->alteracao->dadosTrabalhador->infoDeficiencia->defVisual.'|';
		$txt .= $xml->evtAltCadastral->alteracao->dadosTrabalhador->infoDeficiencia->defAuditiva.'|';
		$txt .= $xml->evtAltCadastral->alteracao->dadosTrabalhador->infoDeficiencia->defMental.'|';
		$txt .= $xml->evtAltCadastral->alteracao->dadosTrabalhador->infoDeficiencia->defIntelectual.'|';
		$txt .= $xml->evtAltCadastral->alteracao->dadosTrabalhador->infoDeficiencia->reabReadap.'|';
		$txt .= $xml->evtAltCadastral->alteracao->dadosTrabalhador->infoDeficiencia->infoCota.'|';
		$txt .= $xml->evtAltCadastral->alteracao->dadosTrabalhador->infoDeficiencia->observacao.'|';

		if (!empty($xml->evtAltCadastral->alteracao->dadosTrabalhador->dependente)) {
			foreach($xml->evtAltCadastral->alteracao->dadosTrabalhador->dependente as $dependente) {
				$txt .= $quebraLinha;
				$txt .= 'CAD2205_02|';
				$txt .= $dependente->tpDep.'|';
				$txt .= $dependente->nmDep.'|'; 
				$txt .= $dependente->dtNascto.'|';
				$txt .= $dependente->cpfDep.'|';  
				$txt .= $dependente->depIRRF.'|';
				$txt .= $dependente->depSF.'|';  
				$txt .= $dependente->incTrab.'|'; 
			}
		}

		if (!empty($xml->evtAltCadastral->alteracao->dadosTrabalhador->documentos)) {

			foreach($xml->evtAltCadastral->alteracao->dadosTrabalhador->documentos as $key => $documentos) {
				foreach($documentos as $keyValue => $documento) {
					if ($keyValue != 'CTPS') {
						$txt .= $quebraLinha;
						$txt .= 'CAD2205_03|';		

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
		$txt .= $quebraLinha;

		$name = str_replace('xml', 'txt', $file['name']);
		if (file_exists($name)) {
			unlink($name);
		}
		$file = fopen($name, 'a');
		fwrite($file, $txt);
		fclose($file);
		if (file_exists($name)) {
			return $name;
		}
	}

	function converteTxtLayout2206($file, $quebraLinha)
	{
		$xml = simplexml_load_file($file['tmp_name']);
		$txt = '';
	
		foreach($xml->evtAltContratual->attributes() as $a => $b) {
		   $ID = $b;
		}
		
		$txt .= 'CAD2206_01|';
		$txt .= $ID.'|'; 

		$txt .= $xml->evtAltContratual->ideEmpregador->nrInsc.'|';

		$indicadorExclusao = '|';
		$txt .= $indicadorExclusao;
		$txt .= $xml->evtAltContratual->ideEvento->indRetif.'|';

		$txt .= $xml->evtAltContratual->altContratual->dtAlteracao.'|';
		$txt .= $xml->evtAltContratual->altContratual->dtEf.'|';
		$txt .= $xml->evtAltContratual->altContratual->dscAlt.'|';

		$txt .= $xml->evtAltContratual->ideVinculo->cpfTrab.'|';
		$txt .= $xml->evtAltContratual->ideVinculo->nisTrab.'|';

		$txt .= $quebraLinha;
		$txt .= 'CAD2206_02|';
		$txt .= $xml->evtAltContratual->ideVinculo->matricula.'|';
		$txt .= $xml->evtAltContratual->altContratual->vinculo->tpRegPrev.'|';

		$txt .= $xml->evtAltContratual->altContratual->infoRegimeTrab->infoCeletista->tpRegJor.'|';
		$txt .= $xml->evtAltContratual->altContratual->infoRegimeTrab->infoCeletista->natAtividade.'|';
		$txt .= $xml->evtAltContratual->altContratual->infoRegimeTrab->infoCeletista->dtBase.'|';
		$txt .= $xml->evtAltContratual->altContratual->infoRegimeTrab->infoCeletista->cnpjSindCategProf.'|';
		$txt .= $xml->evtAltContratual->altContratual->infoRegimeTrab->infoCeletista->trabTemp->justProrr.'|';
		$txt .= $xml->evtAltContratual->altContratual->infoRegimeTrab->infoCeletista->aprend->nrInsc.'|';

		$txt .= $xml->evtAltContratual->altContratual->infoContrato->codCateg.'|';
		$txt .= $xml->evtAltContratual->altContratual->infoContrato->codCargo.'|';
		$txt .= $xml->evtAltContratual->altContratual->infoContrato->codFuncao.'|';
		$txt .= $xml->evtAltContratual->altContratual->infoContrato->codCarreira.'|';
		$txt .= $xml->evtAltContratual->altContratual->infoContrato->dtIngrCarr.'|';

		$txt .= $xml->evtAltContratual->altContratual->infoContrato->remuneracao->vrSalFx.'|';
		$txt .= $xml->evtAltContratual->altContratual->infoContrato->remuneracao->undSalFixo.'|';
		$txt .= $xml->evtAltContratual->altContratual->infoContrato->remuneracao->dscSalVar.'|';

		$txt .= $xml->evtAltContratual->altContratual->infoContrato->duracao->tpContr.'|';
		$txt .= $xml->evtAltContratual->altContratual->infoContrato->duracao->dtTerm.'|';

		$txt .= $xml->evtAltContratual->altContratual->infoContrato->horContratual->qtdHrsSem.'|';
		$txt .= $xml->evtAltContratual->altContratual->infoContrato->horContratual->tpJornada.'|';
		$txt .= $xml->evtAltContratual->altContratual->infoContrato->horContratual->dscTpJorn.'|';
		$txt .= $xml->evtAltContratual->altContratual->infoContrato->horContratual->tmpParc.'|';

		$txt .= $xml->evtAltContratual->altContratual->infoContrato->localTrabalho->localTrabGeral->tpInsc.'|';	
		$txt .= $xml->evtAltContratual->altContratual->infoContrato->localTrabalho->localTrabGeral->nrInsc.'|';	
		$txt .= $xml->evtAltContratual->altContratual->infoContrato->localTrabalho->localTrabGeral->descComp.'|';		
		
		$txt .= $xml->evtAltContratual->altContratual->infoContrato->localTrabalho->localTrabDom->tpLograd.'|';
		$txt .= $xml->evtAltContratual->altContratual->infoContrato->localTrabalho->localTrabDom->dscLograd.'|';
		$txt .= $xml->evtAltContratual->altContratual->infoContrato->localTrabalho->localTrabDom->nrLograd.'|';
		$txt .= $xml->evtAltContratual->altContratual->infoContrato->localTrabalho->localTrabDom->complemento.'|';
		$txt .= $xml->evtAltContratual->altContratual->infoContrato->localTrabalho->localTrabDom->bairro.'|';
		$txt .= $xml->evtAltContratual->altContratual->infoContrato->localTrabalho->localTrabDom->cep.'|';
		$txt .= $xml->evtAltContratual->altContratual->infoContrato->localTrabalho->localTrabDom->codMunic.'|';
		$txt .= $xml->evtAltContratual->altContratual->infoContrato->localTrabalho->localTrabDom->uf.'|';

		$txt .= $xml->evtAltContratual->altContratual->infoContrato->alvaraJudicial->nrProcJud.'|';
		$txt .= $xml->evtAltContratual->altContratual->infoContrato->servPubl->mtvAlter.'|';

		$txt .= $quebraLinha;
		$txt .= 'CAD2206_03|';
		$txt .= $xml->evtAltContratual->altContratual->infoRegimeTrab->infoEstatutario->tpPlanRP.'|';

		if (!empty($xml->evtAltContratual->altContratual->infoContrato->horContratual->horario)) {

			foreach($xml->evtAltContratual->altContratual->infoContrato->horContratual->horario as $horario) {
				$txt .= $quebraLinha;
				$txt .= 'CAD2206_04|';
				$txt .= $horario->dia.'|';
				$txt .= $horario->codHorContrat.'|';
			}
		}
		
		$txt .= $quebraLinha;
		$txt .= 'CAD2206_05|';
		$txt .= $xml->evtAltContratual->altContratual->infoContrato->filiacaoSindical->cnpjSindTrab.'|';


		if (!empty($xml->evtAltContratual->altContratual->infoContrato->observacoes)) {

			foreach($xml->evtAltContratual->altContratual->infoContrato->observacoes as $observacoes) {
				$txt .= $quebraLinha;
				$txt .= 'CAD2206_06|';
				$txt .= $observacoes->observacao.'|';
			}
		}
		$txt .= $quebraLinha;
		$name = str_replace('xml', 'txt', $file['name']);
		if (file_exists($name)) {
			unlink($name);
		}
		$file = fopen($name, 'a');
		fwrite($file, $txt);
		fclose($file);
		if (file_exists($name)) {
			return $name;
		}
	}

	function converteTxtLayout2399($file, $quebraLinha)
	{
		$xml = simplexml_load_file($file['tmp_name']);
		$txt = '';
	
		foreach($xml->evtTSVTermino->attributes() as $a => $b) {
		   $ID = $b;
		}
		
		$txt .= 'MOV1018_01|';
		$txt .= $ID.'|'; 
		$txt .= $xml->evtTSVTermino->ideEmpregador->nrInsc.'|';

		$indicadorExclusao = '|';
		$txt .= $indicadorExclusao;

		$txt .= $xml->evtTSVTermino->ideTrabSemVinculo->cpfTrab.'|';
		$txt .= $xml->evtTSVTermino->ideTrabSemVinculo->nisTrab.'|';
		$txt .= $xml->evtTSVTermino->ideTrabSemVinculo->codCateg.'|';

		$txt .= $xml->evtTSVTermino->infoTSVTermino->dtTerm.'|';
		$txt .= $xml->evtTSVTermino->infoTSVTermino->mtvDesligTSV.'|';
		$txt .= $xml->evtTSVTermino->infoTSVTermino->quarentena->dtFimQuar.'|';
		$txt .= $xml->evtTSVTermino->infoTSVTermino->verbasResc->infoMV->indMV.'|';

		if (!empty($xml->evtTSVTermino->infoTSVTermino->verbasResc->dmDev)) {
			
			foreach($xml->evtTSVTermino->infoTSVTermino->verbasResc->dmDev as $dmDev) {
				$txt .= $quebraLinha;
				$txt .= 'MOV1018_02|';
				$txt .= $dmDev->ideDmDev.'|'; 
			}
		}
		
		if (!empty($xml->evtTSVTermino->infoTSVTermino->verbasResc->dmDev)) {

			foreach($xml->evtTSVTermino->infoTSVTermino->verbasResc->dmDev as $dmDev) {

				if (!empty($dmDev->ideEstabLot)) {

					foreach($dmDev->ideEstabLot as $lote) {
						$txt .= $quebraLinha;
						$txt .= 'MOV1018_03|';
						$txt .= $lote->tpInsc.'|';
						$txt .= $lote->nrInsc.'|';
						$txt .= $lote->codLotacao.'|';
						$txt .= $lote->infoAgNocivo->grauExp.'|';
						$txt .= $lote->infoSimples->indSimples.'|';
					}
				}
			}
		}


		if (!empty($xml->evtTSVTermino->infoTSVTermino->verbasResc->dmDev)) {

			foreach($xml->evtTSVTermino->infoTSVTermino->verbasResc->dmDev as $dmDev) {

				if (!empty($dmDev->ideEstabLot)) {

					foreach($dmDev->ideEstabLot as $lote) {
						
						if (!empty($lote->detVerbas)) {

							foreach($lote->detVerbas as $verbas) {

								$txt .= $quebraLinha;
								$txt .= 'MOV1018_04|';
								$txt .= $verbas->codRubr.'|';
								$txt .= $verbas->ideTabRubr.'|';
								$txt .= $verbas->qtdRubr.'|';
								$txt .= $verbas->fatorRubr.'|';
								$txt .= $verbas->vrUnit.'|';
								$txt .= $verbas->vrRubr.'|';
							}
						}
					}
				}
			}
		}


		if (!empty($xml->evtTSVTermino->infoTSVTermino->verbasResc->dmDev)) {

			foreach($xml->evtTSVTermino->infoTSVTermino->verbasResc->dmDev as $dmDev) {

				if (!empty($dmDev->ideEstabLot)) {

					foreach($dmDev->ideEstabLot as $lote) {
						
						if (!empty($lote->infoSaudeColet->detOper)) {

							foreach($lote->infoSaudeColet->detOper as $detOper) {

								$txt .= $quebraLinha;
								$txt .= 'MOV1018_05|';
								$txt .= $detOper->cnpjOper.'|';
								$txt .= $detOper->regANS.'|';
								$txt .= $detOper->vrPgTit.'|';
							}
						}
					}
				}
			}
		}


		if (!empty($xml->evtTSVTermino->infoTSVTermino->verbasResc->dmDev)) {

			foreach($xml->evtTSVTermino->infoTSVTermino->verbasResc->dmDev as $dmDev) {

				if (!empty($dmDev->ideEstabLot)) {

					foreach($dmDev->ideEstabLot as $lote) {
						
						if (!empty($lote->infoSaudeColet->detOper)) {

							foreach($lote->infoSaudeColet->detOper as $detOper) {

								if (!empty($detOper->detPlano)) {
									
									foreach($detOper->detPlano as $detPlano) {

										$txt .= $quebraLinha;
										$txt .= 'MOV1018_06|';

										$txt .= $detPlano->tpDep.'|';
										$txt .= $detPlano->cpfDep.'|';
										$txt .= $detPlano->nmDep.'|';
										$txt .= $detPlano->dtNascto.'|';
										$txt .= $detPlano->vlrPgDep.'|';

									}									
								}
							}
						}
					}
				}
			}
		}

		if (!empty($xml->evtTSVTermino->infoTSVTermino->verbasResc->procJudTrab)) {

			foreach($xml->evtTSVTermino->infoTSVTermino->verbasResc->procJudTrab as $procJudTrab) {

				$txt .= $quebraLinha;
				$txt .= 'MOV1018_07|';

				$txt .= $procJudTrab->tpTrib.'|';
				$txt .= $procJudTrab->nrProcJud.'|';
				$txt .= $procJudTrab->codSusp.'|';
			}
		}

		if (!empty($xml->evtTSVTermino->infoTSVTermino->verbasResc->infoMV->remunOutrEmpr)) {

			foreach($xml->evtTSVTermino->infoTSVTermino->verbasResc->infoMV->remunOutrEmpr as $remunOutrEmpr) {

				$txt .= $quebraLinha;
				$txt .= 'MOV1018_08|';

				$txt .= $remunOutrEmpr->tpInsc.'|';
				$txt .= $remunOutrEmpr->nrInsc.'|';
				$txt .= $remunOutrEmpr->codCateg.'|';
			}
		}
		$txt .= $quebraLinha;
		$name = str_replace('xml', 'txt', $file['name']);
		if (file_exists($name)) {
			unlink($name);
		}
		$file = fopen($name, 'a');
		fwrite($file, $txt);
		fclose($file);
		if (file_exists($name)) {
			return $name;
		}
	}

	function converteTxtLayout2299($file, $quebraLinha)
	{
		$xml = simplexml_load_file($file['tmp_name']);

		$txt = '';
		foreach($xml->evtDeslig->attributes() as $a => $b) {
		   $ID = $b;
		}

		$txt .= 'MOV1007_01|';
		$txt .= $ID.'|';

		$txt .= $xml->evtDeslig->ideEmpregador->nrInsc.'|'; //cnpj empregador

		$indicadorExclusao = '|';
		$txt .= $indicadorExclusao;

		$txt .= $xml->evtDeslig->ideVinculo->cpfTrab.'|'; //cpf trab
		$txt .= $xml->evtDeslig->ideVinculo->nisTrab.'|'; //nis trab
		$txt .= $xml->evtDeslig->ideVinculo->matricula.'|'; //matricula

		$txt .= $xml->evtDeslig->infoDeslig->mtvDeslig.'|'; //motivo desligamento codigo
		$txt .= $xml->evtDeslig->infoDeslig->dtDeslig.'|';
		$txt .= $xml->evtDeslig->infoDeslig->indPagtoAPI.'|';
		$txt .= $xml->evtDeslig->infoDeslig->dtProjFimAPI.'|';
		$txt .= $xml->evtDeslig->infoDeslig->pensAlim.'|';
		$txt .= $xml->evtDeslig->infoDeslig->percAliment.'|';
		$txt .= $xml->evtDeslig->infoDeslig->vrAlim.'|';
		$txt .= $xml->evtDeslig->infoDeslig->nrCertObito.'|';
		$txt .= $xml->evtDeslig->infoDeslig->nrProcTrab.'|';
		$txt .= $xml->evtDeslig->infoDeslig->indCumprParc.'|';

		if (!empty($xml->evtDeslig->infoDeslig->observacoes)) {
			foreach($xml->evtDeslig->infoDeslig->observacoes as $observacoes) {
				$txt .= $observacoes->observacao.'|'; 
			}
		}

		$txt .= $xml->evtDeslig->infoDeslig->sucessaoVinc->cnpjSucessora.'|';

		$txt .= $xml->evtDeslig->infoDeslig->quarentena->dtFimQuar.'|';

		$txt .= $xml->evtDeslig->infoDeslig->verbasResc->infoMV->indMV.'|';

		$txt .= $xml->evtDeslig->infoDeslig->transfTit->cpfSubstituto.'|';
		$txt .= $xml->evtDeslig->infoDeslig->transfTit->dtNascto.'|';

		$idConsig = '|';
		if (!empty($xml->evtDeslig->infoDeslig->consigFGTS)) {	
			foreach($xml->evtDeslig->infoDeslig->consigFGTS as $FGTS) {
				$txt .= $idConsig;
				$txt .= $FGTS->insConsig.'|';
				$txt .= $FGTS->nrContr.'|';
			}
		}		
		

		if (!empty($xml->evtDeslig->infoDeslig->verbasResc->dmDev)) {
			
			foreach($xml->evtDeslig->infoDeslig->verbasResc->dmDev as $dmDev) {
				$txt .= $quebraLinha;
				$txt .= 'MOV1007_02|';
				$txt .= $dmDev->ideDmDev.'|'; 

				if (!empty($dmDev->infoPerApur->ideEstabLot)) {

					foreach($dmDev->infoPerApur->ideEstabLot as $lote) {
						$txt .= $quebraLinha;
						$txt .= 'MOV1007_03|';
						$txt .= $lote->tpInsc.'|';
						$txt .= $lote->nrInsc.'|';
						$txt .= $lote->codLotacao.'|';
						$txt .= $lote->infoAgNocivo->grauExp.'|';
						$txt .= $lote->infoSimples->indSimples.'|';
						
						if (!empty($lote->detVerbas)) {

							foreach($lote->detVerbas as $verbas) {

								$txt .= $quebraLinha;
								$txt .= 'MOV1007_04|';
								$txt .= $verbas->codRubr.'|';
								$txt .= $verbas->ideTabRubr.'|';
								$txt .= $verbas->qtdRubr.'|';
								$txt .= $verbas->fatorRubr.'|';
								$txt .= $verbas->vrUnit.'|';
								$txt .= $verbas->vrRubr.'|';
							}
						}
						
						if (!empty($lote->infoSaudeColet->detOper)) {

							foreach($lote->infoSaudeColet->detOper as $detOper) {

								$txt .= $quebraLinha;
								$txt .= 'MOV1007_05|';
								$txt .= $detOper->cnpjOper.'|';
								$txt .= $detOper->regANS.'|';
								$txt .= $detOper->vrPgTit.'|';

								if (!empty($detOper->detPlano)) {

									foreach($detOper->detPlano as $detPlano) {
										$txt .= $quebraLinha;
										$txt .= 'MOV1007_06|';
										$txt .= $detPlano->tpDep.'|';
										$txt .= $detPlano->cpfDep.'|';
										$txt .= $detPlano->nmDep.'|';
										$txt .= $detPlano->dtNascto.'|';
										$txt .= $detPlano->vlrPgDep.'|';
									}
								}
							}
						}
					}
				}

				if (!empty($dmDev->infoPerAnt->ideADC)) {

					foreach($dmDev->infoPerAnt->ideADC as $ideADC) {

						$txt .= $quebraLinha;
						$txt .= 'MOV1007_07|';
						$txt .= $ideADC->dtAcConv.'|';
						$txt .= $ideADC->tpAcConv.'|';
						$txt .= $ideADC->compAcConv.'|';
						$txt .= $ideADC->dtEfAcConv.'|';
						$txt .= $ideADC->dsc.'|';
						
						if (!empty($ideADC->idePeriodo)) {

							foreach($ideADC->idePeriodo as $idePeriodo) {

								$txt .= $quebraLinha;
								$txt .= 'MOV1007_08|';
								$txt .= $idePeriodo->perRef.'|';

								if (!empty($idePeriodo->ideEstabLot)) {
									
									foreach ($idePeriodo->ideEstabLot as $ideEstabLot) {
										$txt .= $quebraLinha;
										$txt .= 'MOV1007_09|';
										$txt .= $ideEstabLot->tpInsc.'|';
										$txt .= $ideEstabLot->nrInsc.'|';
										$txt .= $ideEstabLot->codLotacao.'|';
										$txt .= $ideEstabLot->infoAgNocivo->grauExp.'|';
										$txt .= $ideEstabLot->infoSimples->indSimples.'|';
										
										if (!empty($ideEstabLot->detVerbas)) {
										
											foreach ($ideEstabLot->detVerbas as $detVerbas) {
												$txt .= $quebraLinha;
												$txt .= 'MOV1007_10|';
												$txt .= $detVerbas->codRubr.'|';
												$txt .= $detVerbas->ideTabRubr.'|';
												$txt .= $detVerbas->qtdRubr.'|';
												$txt .= $detVerbas->fatorRubr.'|';
												$txt .= $detVerbas->vrUnit.'|';
												$txt .= $detVerbas->vrRubr.'|';
											}
										}
									}
								}
							}
						}
					}
				}

				if (!empty($dmDev->infoTrabInterm)) {

					foreach($dmDev->infoTrabInterm as $infoTrabInterm) {				
						$txt .= $quebraLinha;
						$txt .= 'MOV1007_11|';
						$txt .= $infoTrabInterm->codConv.'|';

					}
				}
			}
		}

		if (!empty($xml->evtDeslig->infoDeslig->verbasResc->procJudTrab)) {

			foreach($xml->evtDeslig->infoDeslig->verbasResc->procJudTrab as $procJudTrab) {
				$txt .= $quebraLinha;
				$txt .= 'MOV1007_12|';
				$txt .= $procJudTrab->tpTrib.'|';
				$txt .= $procJudTrab->nrProcJud.'|';
				$txt .= $procJudTrab->codSusp.'|';
			}
		}

		if (!empty($xml->evtDeslig->infoDeslig->verbasResc->infoMV->remunOutrEmpr)) {

			foreach($xml->evtDeslig->infoDeslig->verbasResc->infoMV->remunOutrEmpr as $remunOutrEmpr) {
				$txt .= $quebraLinha;
				$txt .= 'MOV1007_13|';
				$txt .= $remunOutrEmpr->tpInsc.'|';
				$txt .= $remunOutrEmpr->nrInsc.'|';
				$txt .= $remunOutrEmpr->vlrRemunOE.'|';
			}
		}

		$txt .= $quebraLinha;
		$name = str_replace('xml', 'txt', $file['name']);
		if (file_exists($name)) {
			unlink($name);
		}
		$file = fopen($name, 'a');
		fwrite($file, $txt);
		fclose($file);
		if (file_exists($name)) {
			return $name;
		}
	}

	function converteTxtLayout2200($file, $quebraLinha)
	{
		$xml = simplexml_load_file($file['tmp_name']);
		
		$txt = '';
		foreach($xml->evtAdmissao->attributes() as $a => $b) {
		   $ID = $b;
		}

		$txt .= 'CAD2200_01|';
		$txt .= $ID.'|';
		$txt .= $xml->evtAdmissao->ideEmpregador->nrInsc.'|'; //cnpj empregador

		$indicadorExclusao = '|';
		$identificadorRetificacao = 'N';


		if ((int)$xml->evtAdmissao->ideEvento->indRetif === 2) {
			$identificadorRetificacao = 'S';
		}

		/* TRABALHADOR */
		$txt .= $indicadorExclusao;
		$txt .= $identificadorRetificacao.'|';
		
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

			foreach($xml->evtAdmissao->trabalhador->documentos as $key => $documentos) {
				foreach($documentos as $keyValue => $documento) {
					
					
					if ($keyValue != 'CTPS') {
						$txt .= $quebraLinha;
						$txt .= 'CAD2200_03|';		

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
		$txt .= $quebraLinha;
		$name = str_replace('xml', 'txt', $file['name']);
		if (file_exists($name)) {
			unlink($name);
		}

		$file = fopen($name, 'a');
		fwrite($file, $txt);
		fclose($file);
		if (file_exists($name)) {
			return $name;
		}
	}

	function donwloadArquivo($file)
	{
	  if(isset($file) && file_exists($file)){ // faz o teste se a variavel não esta vazia e se o arquivo realmente existe
      	switch(strtolower(substr(strrchr(basename($file),"."),1))){ // verifica a extensão do arquivo para pegar o tipo
		     case "pdf": $tipo="application/pdf"; break;
		     case "exe": $tipo="application/octet-stream"; break;
		     case "zip": $tipo="application/zip"; break;
		     case "doc": $tipo="application/msword"; break;
		     case "xls": $tipo="application/vnd.ms-excel"; break;
		     case "ppt": $tipo="application/vnd.ms-powerpoint"; break;
		     case "gif": $tipo="image/gif"; break;
		     case "png": $tipo="image/png"; break;
		     case "jpg": $tipo="image/jpg"; break;
		     case "mp3": $tipo="audio/mpeg"; break;
		     case "php": // deixar vazio por seurança
		     case "htm": // deixar vazio por seurança
		     case "html": // deixar vazio por seurança
	  		}
      header("Content-Type: ".$tipo); // informa o tipo do arquivo ao navegador
      header("Content-Length: ".filesize($file)); // informa o tamanho do arquivo ao navegador
      header("Content-Disposition: attachment; filename=".basename($file)); // informa ao navegador que é tipo anexo e faz abrir a janela de download, tambem informa o nome do arquivo
      readfile($file); // lê o arquivo
	  }
	}
?>

<html>
	<head>
		<title>Seja bem vindo ao Import de XML para TXT</title>
	</head>

	<body>
		<form method="POST" action="import.php" enctype="multipart/form-data">
			<label>Informar XML</label><br><br>
			<input type="file" name="xml[]" id="xml" multiple>
			<input type="submit" value="Gerar TXT">
		</form>		
	</body>
</html>
<!DOCTYPE html>
<html>
	<head>
		<title>Produit</title>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="css/style.css">

		<script type="text/javascript" src="js/jquery.min.js"></script>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>
		<script type="text/javascript" src="js/sweetalert2.all.min.js"></script>
		<script type="text/javascript" src="js/script.js"></script>
	</head>
	<body>
		<div class="container">
			<div>
				<form method="post" id="formule" action="">
					<table id="form">
						<tr>
							<td>Multiplicande</td><td>Multiplicateur</td>
						</tr>
						<tr>
							<td><input type="text" value="<?= (isset($_POST['multiplicande']))?$_POST['multiplicande']:''; ?>" name="multiplicande"  id="multiplicande" pattern="[0-9]*" title="Entrer un nombre"></td>
							<td><input type="text" value="<?php echo (isset($_POST['multiplicateur']))?$_POST['multiplicateur']:''; ?>" name="multiplicateur" id="multiplicateur" pattern="[0-9]*" title="Entrer un nombre"></td>
						</tr>
						<tr><td colspan="2"><button name="calcul" id="calcul" class="w-100">Calculer</button></td></tr>
					</table>
				</form>
				<hr>
			<?php
				if (isset($_POST['calcul'])) {
					$n1 = $_POST['multiplicande'];
					$n2 = $_POST['multiplicateur'];
					if (!empty($n1) && !empty($n2)) {
						echo produit($n1, $n2);
					}
				}
				
				function produit($multiplicande, $multiplicateur) {
					$on = false;
					$x = 1;
					$produit = $multiplicande * $multiplicateur;
					$n1 = array_map('intval', str_split($multiplicande));
					$n2 = array_map('intval', str_split($multiplicateur));
					$p  = array_map('intval', str_split($produit));
					$t  = '<table id="operation">';
					/* ===================== TR 1 ===================== */
						$t .= '<tr>';
						$t .= '<td rowspan="2" class="symbol">X</td>';
						for ($i = 0; $i < count($p)-count($n1); $i++) {
							$t .= '<td></td>';
						}
						for ($i = 0; $i < count($n1); $i++) {
							$t .= '<td><input type="text" value="'.$n1[$i].'" readonly></td>';
						}
						$t .= '</tr>';
					/* ===================== TR 2 ===================== */
						$t .= '<tr>';
						for ($i = 0; $i < count($p)-count($n2); $i++) {
							$t .= '<td></td>';
						}
						for ($i = 0; $i < count($n2); $i++) {
							$t .= '<td><input type="text" value="'.$n2[$i].'" readonly></td>';
						}
						$t .= '</tr>';
					/* ===================== TR 3 ===================== */
						$t .= '<tr><td colspan="'.(count($p)+1).'" class="ligne"></td></tr>';
					/* ===================== TR X ===================== */
					if (count($n2) == 1) {
						$t .= '<tr>';
						$t .= '<td class="symbol">=</td>';
						for ($i = 0; $i < count($p); $i++) {
							$t .= '<td>';
							$t .= '<input type="text" class="val" id="input'.(count($p)-$i).'">';
							// $t .= '<input type="text" class="val" id="input'.(count($p)-$i).'" value="'.(($on==true)?$p[$i]:'').'" onkeyup="jump('.(count($p)-$i).')">';
							$t .= '</td>';
						}
						$t .= '</tr>';
					}
					else {
						$x = 0;
						for ($i = 0; $i < count($n2); $i++) {
							$t .= '<tr>';
							if ($i == 0) {
								$t .= '<td class="symbol" rowspan="'.count($n2).'">+</td>';
							}
							$p1 = $n2[count($n2)-$i-1]*$multiplicande;
							$p11  = array_map('intval', str_split($p1));
							if ($p1 == 0) {
								for ($j = 0; $j < (count($p)-count($n1)-$i); $j++) {
									$t .= '<td></td>';
								}
								for ($j = 0; $j < count($n1); $j++) {
									$t .= '<td>';
									$t .= '<input type="text" class="val" id="input'.(count($n1)+$x-$j).'">';
									// $t .= '<input type="text" class="val" value="0">';
									$t .= '</td>';
								}
								$x += count($n1);
								for ($j = 0; $j < $i; $j++) {
									$t .= '<td><input type="text" value="." disabled></td>';
								}
							}
							else {
								for ($j = 0; $j < (count($p)-count($p11)-$i); $j++) {
									$t .= '<td></td>';
								}
								for ($j = 0; $j < count($p11); $j++) {
									$t .= '<td>';
									$t .= '<input type="text" class="val" id="input'.(count($p11)+$x-$j).'"">';
									// $t .= '<input type="text" class="val" id="input'.(count($p11)+$x-$j).'" value="'.(($on==true)?$p11[$j]:'').'" onkeyup="jump('.(count($p11)+$x-$j).')">';
									$t .= '</td>';
								}
								$x += count($p11);
								for ($j = 0; $j < $i; $j++) {
									$t .= '<td><input type="text" value="." disabled></td>';
								}
							}
							$t .= '</tr>';
						}
						/* ===================== TR X ===================== */
						$t .= '<tr><td colspan="'.(count($p)+1).'" class="ligne"></td></tr>';
						/* ===================== TR PRODUIT ===================== */
						$t .= '<tr>';
						$t .= '<td class="symbol">=</td>';
						for ($i = 0; $i < count($p); $i++) {
							$t .= '<td>';
							$t .= '<input type="text" class="val" id="input'.(count($p)+$x-$i).'">';
							// $t .= '<input type="text" class="val" id="input'.(count($p)+$x-$i).'" value="'.(($on==true)?$p[$i]:'').'" onkeyup="jump('.(count($p)+$x-$i).')">';
							$t .= '</td>';
						}
						$t .= '</tr>';
					}
					$t .= '</table>';
					return $t;
				}
			?>
			<?php
				// $num_quetion = 10;
				// for ($i = 0; $i < $num_quetion; $i++) {
				// 	$x  = '<div class="question'.$i.' operation">';
				// 	$t .= '<h1><button class="btn btn-info w-100">Question '.$i.'</button></h1>';
				// 	$t .= '<input type="hidden" class="q" value="'.$i.'">';
				// 	$t .= '<input type="hidden" class="n1" value="'.random_int(100, 999).'">';
				// 	$t .= '<input type="hidden" class="n2" value="'.rand(10,99).'">';
				// 	$t .= '</div>';
				// 	// echo $x;
				// }
			?>
		</div>
		<script type="text/javascript" src="script.js"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				var multiplicande  = $('#multiplicande').val();
				var multiplicateur = $('#multiplicateur').val();
				var produit = multiplicande * multiplicateur;

				var length_input = $('input:visible[class=val]').length;
				$('input:visible[class=val]').attr('maxlength','1');
				$('#input1').focus();
				$(".val").keyup(function(e){
					var i = parseInt($(this).attr("id").replace("input", ""));
					if ($('#input'+i).val() >= 0 && $('#input'+i).val() <= 9 && $('#input'+i).val() != '' && e.which != 32 && e.which != 9) {
						if (i == length_input) {
							$('input:visible[class=val]').blur(); 
						}
						else { $('#input'+(i+1)).focus(); }
					}

				});
			});
		</script>
	</body>
</html>
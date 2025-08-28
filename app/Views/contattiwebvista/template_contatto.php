<?php 
	if(sizeof($contatti) > 0)
	{
		?>
		<table class="col-lg-6" id="table_contatti">
			<thead>
				<th style="border: 1px solid;">Ragione sociale</th>
				<th style="border: 1px solid;border-right:0;">Azioni</th>
				<th style="border: 1px solid;border-left:0;">&nbsp;</th>
			</thead>
			<tbody>
		<?php
		foreach ($contatti as $contatto): 
		?>
				<tr>
					<td style="border: 1px solid;"><?=$contatto['ragione_sociale'];?></td>
					<td style="border: 1px solid;border-right:0;">
						<!-- MODIFICA -->
						<a href="<?=base_url()?>index.php/UpdateContattoWebVista/<?=$contatto['contId']?>" class='btn btn-warning'><i class="material-icons">edit</i></a>
					</td>
					<td style="border: 1px solid;border-left:0;">
						<!-- ELIMINA -->
						<a href="<?=base_url()?>index.php/delAttivita/<?=$contatto['contId']?>" class='btn btn-danger'><i class="material-icons">clear</i></a>
					</td>
				</tr>
		<?php endforeach; ?>
			</tbody>
		</table>
	<?php
	}
	else
	{
		?>
		<h3>Nessun utente trovato nel DB</h3>
		<?php
	}	

	
	?>
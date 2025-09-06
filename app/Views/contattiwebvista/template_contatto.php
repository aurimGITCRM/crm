<?php 
	if(sizeof($contatti) > 0)
	{
		?>
		<table class="table col-lg-6" id="table_contatti">
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
						<a href="UpdateContattoWebVista/<?=$contatto['contId']?>" class='btn btn-warning'><i class="material-icons">edit</i></a>
					</td>
					<td style="border: 1px solid;border-left:0;">
						<!-- ELIMINA -->
						<a href="javascript:void(0)" onclick="if(confirm('Sei sicuro di cancellare il contatto selezionato?')){location.href='delContattoWebVista/<?=$contatto['contId']?>';}" class='btn btn-danger'><i class="material-icons">clear</i></a>
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
<?php 
	if(sizeof($attivita) > 0)
	{
		?>
		<table class="col-lg-12" id="table_attivita">
			<thead>
				<th style="border: 1px solid;">Nome</th>
				<th style="border: 1px solid;border-right:0;">Azioni</th>
				<th style="border: 1px solid;border-left:0;">&nbsp;</th>
			</thead>
			<tbody>
		<?php
		foreach ($attivita as $att): 
		?>
				<tr>
					<td style="border: 1px solid;"><?=$att['nome'];?></td>
					<td style="border: 1px solid;border-right:0;">
						<!-- MODIFICA -->
						<a href="UpdateAttivita/<?=$att['id']?>" class='btn btn-warning'><i class="material-icons">edit</i></a>
					</td>
					<td style="border: 1px solid;border-left:0;">
						<!-- ELIMINA -->
						<a href="delAttivita/<?=$att['id']?>" class='btn btn-danger'><i class="material-icons">clear</i></a>
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
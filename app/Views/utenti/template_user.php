<?php 
	if(sizeof($users) > 0)
	{
		?>
		<table class="col-lg-6" id="table_users">
			<thead>
				<!-- se presente rn partition -->
				<?php if(isset($users[0]['rn'])): ?><th style="border: 1px solid;">Riga</th><?php endif;?>
				<th style="border: 1px solid;">Nome</th>
				<th style="border: 1px solid;">Cognome</th>
				<th style="border: 1px solid;">Sesso</th>
				<th style="border: 1px solid;">Email</th>
				<th style="border: 1px solid;border-right:0;">Azioni</th>
				<th style="border: 1px solid;border-left:0;">&nbsp;</th>
			</thead>
			<tbody>
		<?php
		foreach ($users as $users_item): 
		?>
				<tr>
					<!-- se presente rn partition -->
					<?php if(isset($users[0]['rn'])): ?><td style="border: 1px solid;"><?=$users_item['rn'];?></td><?php endif;?>
					<td style="border: 1px solid;"><?=$users_item['nome'];?></td>
					<td style="border: 1px solid;"><?=$users_item['cognome'];?></td>
					<td style="border: 1px solid;"><?=$users_item['sesso'] == 'M' ? "Maschio" : "Femmina" ?></td>
					<td style="border: 1px solid;"><?=$users_item['email'];?></td>
					<td style="border: 1px solid;border-right:0;">
						<!-- MODIFICA -->
						<a href="<?=base_url()?>index.php/UpdateUser/<?=$users_item['id']?>" class='btn btn-warning'><i class="material-icons">edit</i></a>
					</td>
					<td style="border: 1px solid;border-left:0;">
						<!-- ELIMINA -->
						<a href="<?=base_url()?>index.php/delUser/<?=$users_item['id']?>" class='btn btn-danger'><i class="material-icons">clear</i></a>
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
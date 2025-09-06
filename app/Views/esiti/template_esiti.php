<?php 
	if(sizeof($esiti) > 0)
	{
		?>
		<table class="col-lg-6" id="table_esiti">
			<thead>
				<th style="border: 1px solid;">Nome</th>
				<th style="border: 1px solid;">Utente modifica</th>
				<th style="border: 1px solid;">Data</th>
				<th style="border: 1px solid;border-right:0;">Azioni</th>
				<th style="border: 1px solid;border-left:0;">&nbsp;</th>
			</thead>
			<tbody>
                <?php foreach ($esiti as $esito): ?>
                        <tr>
                            <td style="border: 1px solid;"><?=$esito['nomeEsito'];?></td>
                            <td style="border: 1px solid;"><?=$esito['utente']?></td>
                            <td style="border: 1px solid;"><?=$esito['data'];?></td>
                            <td style="border: 1px solid;border-right:0;">
                                <!-- MODIFICA -->
                                <a href="/index.php/UpdateEsito/<?=$esito['idEsito']?>" class='btn btn-warning'><i class="material-icons">edit</i></a>
                            </td>
                            <td style="border: 1px solid;border-left:0;">
                                <!-- ELIMINA -->
                                <a href="javascript:void(0)" onclick="if(confirm('Sei sicuro di cancellare esito e esito in tutte le campagne associate?')){location.href='delEsito/<?=$esito['idEsito']?>';}" class='btn btn-danger'><i class="material-icons">clear</i></a>
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
		<h3>Nessun esito trovato nel DB</h3>
		<?php
	}	

	
	?>
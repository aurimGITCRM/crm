<?php 
	if(sizeof($campagne) > 0)
	{
		?>
		<table class="col-lg-6" id="table_campagne">
			<thead>
				<th style="border: 1px solid;">Nome</th>
				<th style="border: 1px solid;">Tipo</th>
				<th style="border: 1px solid;">Utente modifica</th>
				<th style="border: 1px solid;">Data</th>
				<th style="border: 1px solid;border-right:0;">Azioni</th>
				<th style="border: 1px solid;border-left:0;">&nbsp;</th>
			</thead>
			<tbody>
                <?php foreach ($campagne as $campagna): ?>
                        <tr>
                            <td style="border: 1px solid;"><?=$campagna['campNome'];?></td>
                            <td style="border: 1px solid;"><?=$campagna['campTipo'];?></td>
                            <td style="border: 1px solid;"><?=$campagna['utente']?></td>
                            <td style="border: 1px solid;"><?=$campagna['data'];?></td>
                            <td style="border: 1px solid;border-right:0;">
                                <!-- MODIFICA -->
                                <a href="<?=base_url()?>UpdateCampagna/<?=$campagna['campId']?>" class='btn btn-warning'><i class="material-icons">edit</i></a>
                            </td>
                            <td style="border: 1px solid;border-left:0;">
                                <!-- ELIMINA -->
                                <a href="javascript:void(0)" onclick="if(confirm('Sei sicuro di cancellare la campagna selezionata?')){location.href='<?=base_url()?>delCampaign/<?=$campagna['campId']?>';}" class='btn btn-danger'><i class="material-icons">clear</i></a>
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
		<h3>Nessuna campagna trovata nel DB</h3>
		<?php
	}	
	?>
<script>
	$(function() 
	{
		$('#table_campagne_esiti').DataTable({
			language: {
				url: "https://cdn.datatables.net/plug-ins/2.1.8/i18n/it-IT.json"
			},
			columnDefs: [{
				targets: -1, 
				orderable: false
			}],
			"searching": true,
			"paging": true,
			"info": false
			});
	});

	//Cancellazione campagne esiti
	function deleteCE(campId,idEsito)
	{
		$.ajax({
            url: '/DeleteCampagneEsiti/' + campId + '/' + idEsito,
            method: "GET",
            data: {
            },
            success: function(res) {
				if(res !== undefined)
				{
					$('#campagne_esiti').empty();
					$('#campagne_esiti').html(res);
				}
            },
            error: function(err) {
                console.log(err);
            },
        });
	}

    function insertCE(campId)
    {
        $('#lblerror').hide();
        if($('#esito_insert').val() == '')
            $('#lblerroresiti').show();
        else
        {
            $.ajax({
            url: '/InsertCampagneEsiti/' + campId + '/' + $('#esito_insert').val(),
            method: "GET",
            data: {
            },
            success: function(res) {
				if(res !== undefined)
				{
					$('#campagne_esiti').empty();
					$('#campagne_esiti').html(res);
				}
            },
            error: function(err) {
                console.log(err);
            },
            });
        }
    }
</script>

<div style="width:90%" id="campagne_esiti">
    <br><br>
            <table class="col-lg-6" id="table_campagne_esiti">
                <thead>
                    <th style="border: 1px solid;">Campagna</th>
                    <th style="border: 1px solid;">Esito</th>
                    <th style="border: 1px solid;border-right:0;">Azioni</th>
                </thead>
                <tbody>
                    <?php if(sizeof($esiti_campagne) > 0):
                        foreach ($esiti_campagne as $es): ?>
                            <tr>
                                <td style="border: 1px solid;"><?=$es['campNome'];?></td>
                                <td style="border: 1px solid;"><?=$es['nomeEsito']?></td>
                                <td style="border: 1px solid;border-left:0;">
                                    <a href="/CampagneEsitiDestinazioni/<?=$es['campid_Fk']?>/<?=$es['idEsito_Fk']?>" class="btn btn-primary">Gestisci destinazioni</a>
                                    <!-- ELIMINA -->
                                    <a href="javascript:void(0)" onclick="deleteCE(<?=$es['campid_Fk']?>,<?=$es['idEsito_Fk']?>)" class='btn btn-danger'><i class="material-icons">clear</i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <?php if(!empty($esitinonassociati)): ?>
                        <?php if(sizeof($esitinonassociati['dati']) > 0): ?>
                            <tr>
                                <td style="border: 1px solid;"><?=$esitinonassociati['campNome'] ?? "";?></td>
                                <td style="border: 1px solid;">
                                    <select id="esito_insert" class="form-control">
                                        <option value="">Seleziona...</option>
                                        <?php foreach($esitinonassociati['dati'] as $esitononassociato): ?>
                                                <?php if(is_array($esitononassociato)): ?>
                                                    <option value="<?=$esitononassociato['idEsito']?>"><?=$esitononassociato['nomeEsito']?></option>
                                                <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <td style="border: 1px solid;border-left:0;">
                                    <!-- INSERISCI -->
                                    <a href="javascript:void(0)" onclick="insertCE(<?=$esitinonassociati['campId'] ?>)" class='btn btn-success'><i class="material-icons">save</i></a>
                                </td>
                            </tr>
                        <?php endif; ?>
                    <?php endif; ?>
                </tbody>
            </table>
            <label class="alert alert-danger" id="lblerroresiti" style="display:none;">Selezionare un esito</label>
        <?php	
    ?>
</div>



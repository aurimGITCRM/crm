<script>
	$(function() 
	{
		$('#table_campagne_utenti').DataTable({
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

	//Cancellazione campagne utenti
	function deleteCU(campId,idUtente)
	{
		$.ajax({
            url: '/DeleteCampagneUtenti/' + campId + '/' + idUtente,
            method: "GET",
            data: {
            },
            success: function(res) {
				if(res !== undefined)
				{
					$('#campagne_utenti').empty();
					$('#campagne_utenti').html(res);
				}
            },
            error: function(err) {
                console.log(err);
            },
        });
	}

    function insertCU(campId)
    {
        $('#lblerror').hide();
        if($('#utente_insert').val() == '')
            $('#lblerror').show();
        else
        {
            $.ajax({
            url: '/InsertCampagneUtenti/' + campId + '/' + $('#utente_insert').val(),
            method: "GET",
            data: {
            },
            success: function(res) {
				if(res !== undefined)
				{
					$('#campagne_utenti').empty();
					$('#campagne_utenti').html(res);
				}
            },
            error: function(err) {
                console.log(err);
            },
            });
        }
    }
</script>

<div style="width:90%" id="campagne_utenti">
    <br><br>
            <table class="col-lg-6" id="table_campagne_utenti">
                <thead>
                    <th style="border: 1px solid;">Campagna</th>
                    <th style="border: 1px solid;">Utente</th>
                    <th style="border: 1px solid;border-right:0;">Azioni</th>
                </thead>
                <tbody>
                    <?php if(sizeof($campagne_utenti) > 0):
                        foreach ($campagne_utenti as $cu): ?>
                            <tr>
                                <td style="border: 1px solid;"><?=$cu['campNome'];?></td>
                                <td style="border: 1px solid;"><?=$cu['utente']?></td>
                                <td style="border: 1px solid;border-left:0;">
                                    <!-- ELIMINA -->
                                    <a href="javascript:void(0)" onclick="deleteCU(<?=$cu['campId']?>,<?=$cu['idUtente_Fk']?>)" class='btn btn-danger'><i class="material-icons">clear</i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <?php if(!empty($utentinonassociati)): ?>
                        <?php if(sizeof($utentinonassociati['dati']) > 0): ?>
                            <tr>
                                <td style="border: 1px solid;"><?=$utentinonassociati['campNome'] ?? "";?></td>
                                <td style="border: 1px solid;">
                                    <select id="utente_insert" class="form-control">
                                        <option value="">Seleziona...</option>
                                        <?php foreach($utentinonassociati['dati'] as $utentenonassociato): ?>
                                                <option value="<?=$utentenonassociato['id']?>"><?=$utentenonassociato['utente']?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <td style="border: 1px solid;border-left:0;">
                                    <!-- INSERISCI -->
                                    <a href="javascript:void(0)" onclick="insertCU(<?=$utentinonassociati['campId']?>)" class='btn btn-success'><i class="material-icons">save</i></a>
                                </td>
                            </tr>
                        <?php endif; ?>
                    <?php endif; ?>
                </tbody>
            </table>
            <label class="alert alert-danger" id="lblerror" style="display:none;">Selezionare un utente</label>
        <?php	
    ?>
</div>



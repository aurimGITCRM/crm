<script>
	$(function() 
	{
		$('#table_campagne_attivita').DataTable({
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
	function deleteATT(campId,attId)
	{
		$.ajax({
            url: '/DeleteCampagneAttivita/' + campId + '/' + attId,
            method: "GET",
            data: {
            },
            success: function(res) {
				if(res !== undefined)
				{
					$('#campagne_attivita').empty();
					$('#campagne_attivita').html(res);
				}
            },
            error: function(err) {
                console.log(err);
            },
        });
	}

    function insertATT(campId)
    {
        $('#lblerrorattivita').hide();
        if($('#att_insert').val() == '')
            $('#lblerrorattivita').show();
        else
        {
            $.ajax({
            url: '/InsertCampagneAttivita/' + campId + '/' + $('#att_insert').val(),
            method: "GET",
            data: {
            },
            success: function(res) {
				if(res !== undefined)
				{
					$('#campagne_attivita').empty();
					$('#campagne_attivita').html(res);
				}
            },
            error: function(err) {
                console.log(err);
            },
            });
        }
    }
</script>

<div style="width:90%" id="campagne_attivita">
    <br><br>
            <table class="col-lg-6" id="table_campagne_attivita">
                <thead>
                    <th style="border: 1px solid;">Attività</th>
                    <th style="border: 1px solid;border-right:0;">Azioni</th>
                </thead>
                <tbody>
                    <?php if(sizeof($campagne_attivita) > 0 && sizeof($campagne_attivita['attivita_campagne']) > 0):
                        foreach ($campagne_attivita['attivita_campagne'] as $att): ?>
                            <tr>
                                <td style="border: 1px solid;"><?=$att['nome'];?></td>
                                <td style="border: 1px solid;border-left:0;">
                                    <!-- ELIMINA -->
                                    <a href="javascript:void(0)" onclick="deleteATT(<?=$att['campid_Fk']?>,<?=$att['attId_Fk']?>)" class='btn btn-danger'><i class="material-icons">clear</i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <?php if(sizeof($campagne_attivita['attivitanonassociate']) > 0): ?>
                        <tr>
                            <td style="border: 1px solid;">
                                <select id="att_insert" class="form-control">
                                    <option value="">Seleziona...</option>
                                    <?php foreach($campagne_attivita['attivitanonassociate'] as $attivitanonassociata): ?>
                                            <option value="<?=$attivitanonassociata['id']?>"><?=$attivitanonassociata['nome']?></option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                            <td style="border: 1px solid;border-left:0;">
                                <!-- INSERISCI -->
                                <a href="javascript:void(0)" onclick="insertATT(<?=$campagne_attivita['campId'] ?>)" class='btn btn-success'><i class="material-icons">save</i></a>
                            </td>
                        </tr>
                    <?php endif; ?>       
                </tbody>
            </table>
            <label class="alert alert-danger" id="lblerrorattivita" style="display:none;">Selezionare un attività</label>
        <?php	
    ?>
</div>



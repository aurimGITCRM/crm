<script>
	//Cancellazione campagne esiti
	function deleteMAC(campId,macroId)
	{
		$.ajax({
            url: '/DeleteCampagneMacro/' + campId + '/' + macroId,
            method: "GET",
            data: {
            },
            success: function(res) {
				if(res !== undefined)
				{
					$('#campagne_macro').empty();
					$('#campagne_macro').html(res);
				}
            },
            error: function(err) {
                console.log(err);
            },
        });
	}

    function insertMAC(campId)
    {
        $('#lblerrormacro').hide();
        if($('#mac_insert').val() == '')
            $('#lblerrormacro').show();
        else
        {
            $.ajax({
            url: '/InsertCampagneMacro/' + campId + '/' + $('#mac_insert').val(),
            method: "GET",
            data: {
            },
            success: function(res) {
				if(res !== undefined)
				{
					$('#campagne_macro').empty();
					$('#campagne_macro').html(res);
				}
            },
            error: function(err) {
                console.log(err);
            },
            });
        }
    }
</script>

<div style="width:90%" id="campagne_macro">
    <br><br>
            <table class="col-lg-6" id="table_campagne_macro">
                <thead>
                    <th style="border: 1px solid;">Macro prodotti</th>
                    <th style="border: 1px solid;border-right:0;">Azioni</th>
                </thead>
                <tbody>
                    <?php if(sizeof($macro_attivita) > 0 && sizeof($macro_attivita) > 0):
                        foreach ($macro_attivita as $macro): ?>
                            <tr>
                                <td style="border: 1px solid;"><?=$macro['nome'];?></td>
                                <td style="border: 1px solid;border-left:0;">
                                    <!-- ELIMINA -->
                                    <a href="javascript:void(0)" onclick="deleteMAC(<?=$macro['campid_Fk']?>,<?=$macro['macroId_Fk']?>)" class='btn btn-danger'><i class="material-icons">clear</i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <?php if(sizeof($macro_attivita) == 0): ?>
                        <tr>
                            <td style="border: 1px solid;">
                                <select id="mac_insert" class="form-control">
                                    <option value="">Seleziona...</option>
                                    <?php foreach($macroproducts as $macro): ?>
                                            <option value="<?=$macro['macroId']?>"><?=$macro['nome']?></option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                            <td style="border: 1px solid;border-left:0;">
                                <!-- INSERISCI -->
                                <a href="javascript:void(0)" onclick="insertMAC(<?=$campId ?>)" class='btn btn-success'><i class="material-icons">save</i></a>
                            </td>
                        </tr>
                    <?php endif; ?>       
                </tbody>
            </table>
            <label class="alert alert-danger" id="lblerrormacro" style="display:none;">Selezionare un macro prodotto</label>
        <?php	
    ?>
</div>



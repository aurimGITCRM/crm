
<style>
    .material-icons 
	{
        vertical-align: middle !important;
        font-size:30px !important;
    }
</style>
<div align="center"><h1><?=strtoupper($title)?></h1></div>

<div style="width:90%" align="center">
    <br><br>
            <?php if(sizeof($campagne) > 0): ?>
                <table class="col-lg-6" id="table_campagne_utenti">
                    <thead>
                        <th style="border: 1px solid;text-align:center;">Campagna</th>
                        <th style="border: 1px solid;border-right:0;text-align:center;">Azioni</th>
                    </thead>
                    <tbody>
                        <?php if(sizeof($campagne['campagne_utenti']) > 0):
                            foreach ($campagne['campagne_utenti'] as $cu): ?>
                                <tr>
                                    <td style="border: 1px solid;text-align:center;">
                                        <?=$cu['campNome'];?>
                                    </td>
                                    <td style="border: 1px solid;border-left:0;text-align:center;">
                                        <a href="/index.php/CampagneContattiLiberoWebVista/<?=$cu['campId'];?>"  class='btn btn-success icon-link'>Gestisci contatto <i class="material-icons">edit</i></a>
                                        &nbsp;<a href="/index.php/CampagneContattiUtenteWebVista/<?=$cu['campId'];?>"  class='btn btn-success icon-link'>Visualizza i contatti<i class="material-icons">search</i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            <?php else: ?> 
                <label class="alert alert-danger" id="lblerror">Nessuna campagna associata</label>    
            <?php endif; ?>
            
        <?php	
    ?>
</div>
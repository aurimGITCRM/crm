<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Import Contatti</title>
</head>
<body>
    <h1>Seleziona il file dei contatti da importare</h1>
    <form action="/upload_contacts" method="post" enctype="multipart/form-data">
         <?= csrf_field() ?> 
        <label for="file">Scegli il file CSV</label>
        <input type="file" id="file" name="file" accept=".csv">
        <button type="submit" class="btn btn-primary btn-orange">Carica</button>
    </form>
    
    <?php if(!empty($esito)):?>
        <div class="alert alert-success"><?=$esito?></div>
    <?php endif; ?>
</body>
</html>
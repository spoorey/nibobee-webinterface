<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title>Nibobee Webinterface</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
          integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <div class="page-header">
        <h1>Nibobee Webinterface</h1>
    </div>
    <form class="form-horizontal" method="post">
        <div class="form-group">
            <label for="speed" class="col-sm-2 control-label">Geschwindigkeit</label>

            <div class="col-sm-10">
                <select name="speed" id="speed">
                    <?php for ($i = 0; $i <= 15; $i++): ?>
                        <option value="<?php echo $i*100; ?>"><?php echo $i*100; ?></option>
                    <?php endfor; ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="direction" class="col-sm-2 control-label">Richtungsänderung</label>

            <div class="col-sm-10">
                <select name="direction" id="direction">
                    <option value="none">Keine</option>
                    <option value="left">Links</option>
                    <option value="right">Rechts</option>
                    <option value="h_right">Hart Rechts</option>
                    <option value="h_left">Hart Links</option>
                    <option value="r_right">Rechts rotieren</option>
                    <option value="r_left">Links rotieren</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary">Ausführen</button>
            </div>
        </div>
        <hr>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button name="back" type="submit" class="btn btn-primary">Zurück zum Ausgangspunkt</button>
            </div>
        </div>
    </form>
</div>
</body>
</html>

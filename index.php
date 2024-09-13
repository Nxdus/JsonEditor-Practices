<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" type="text/css" href="./bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <script type="text/javascript" src="./bootstrap-5.3.3-dist/js/bootstrap.min.js"></script>

    <link rel="stylesheet" type="text/css" href="./style.css">

    <script type="text/javascript" src="./JQuery.js"></script>

    <title>Practice Site</title>
</head>

    <body class="container d-flex justify-content-center align-items-center" style="min-height: 100dvh;">

        <?php include_once('./components/fileUpload.php') ?>

        <?php if (isset($_SESSION['jsonData'])): $jsonData = $_SESSION['jsonData']; ?>
            <?php if (empty($jsonData)) return; ?>
                <table class="table text-center table-bordered">
                    <form action="./action/edit.php" method="post">
                        <thead>
                            <tr>
                                <th>DELETE</th>
                                <th>#</th>
                                <?php $colum_index = array_keys($jsonData[0]);?>
                                <?php foreach ($colum_index as $key): ?>
                                    <th><?php print_r(strtoupper($key)) ?>
                                    <input type="hidden" name="delcol-key" value="<?php echo $key?>">
                                    <button type="submit" name="delcol-submit" class="btn btn-danger btn-sm">Delete</button>
                                <?php endforeach; ?>
                            </tr>
                        </thead>
                        <tbody>
                                <?php $row_index = 0;?>
                                <?php foreach ($jsonData as $row): ?>
                                    <tr id="row-<?php echo $row_index; ?>">
                                        <td>
                                            <input type="checkbox" class="form-check-input border-dark" name="checkbox-<?php echo $row_index; ?>">
                                        </td>
                                        <td><?php echo $row_index + 1; ?></td>
                                        <?php $cell_index = 0; ?>
                                        <?php foreach($row as $cell): ?>
                                            <td>
                                                <?php $colum_key = $colum_index[$cell_index]; ?>
                                                <input type="text" class="border-0 text-center form-control" name="<?php echo $row_index."_".$colum_key ?>" value="<?php echo $cell;?>">
                                            </td>
                                        <?php $cell_index++; endforeach; ?>
                                    </tr>
                                    <?php $row_index++; ?>
                                <?php endforeach; ?>
                                
                                <input type="text" class="border-0 text-center form-control" name="addcol-key" placeholder="Key value">
                                <button type="submit" name="addcol-submit" class="btn btn-primary">+</button>

                                <div class="position-absolute bottom-0 end-0 m-5">
                                    <button type="submit" name="add-submit" class="btn btn-success">Add</button>
                                    <button type="submit" name="save-submit" class="btn btn-primary">Save</button>
                                    <button type="submit" name="download-submit" class="btn btn-warning">Download</button>
                                    <button type="submit" name="clear-submit" class="btn btn-danger">Clear</button>
                                </div>
                        </tbody>
                    </form>
                </table>
        <?php endif; ?>
    </body>

    <script>
        $('#download').click(function() {
            $('#save').click();
            var downloadLink = document.createElement('a');
       
            downloadLink.href = './action/download.php';
            
            downloadLink.download = 'data.json';
            document.body.appendChild(downloadLink);
                downloadLink.click();
                document.body.removeChild(downloadLink);
        });
    </script>
</html>
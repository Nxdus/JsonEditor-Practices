<?php
    if (isset($_POST['upload-submit']) && $_FILES['jsonFile']['error'] == 0) {
        $uploadFile = $_FILES['jsonFile']['tmp_name'];

        $fileType = mime_content_type($uploadFile);

        if ($fileType == 'application/json') {
            $jsonData = file_get_contents($uploadFile);
            $jsonData = json_decode($jsonData, true);

            if (json_last_error() === JSON_ERROR_NONE) {
                
                if (!isset($jsonData[0])) {
                    $jsonDataArray = array();
                    array_push($jsonDataArray, $jsonData);
                    $jsonData = $jsonDataArray;
                }

                $keys = array();

                foreach ($jsonData as $data) {
                    $side_keys = array_keys($data);
                    foreach ($side_keys as $key) {
                        if (!in_array($key, $keys)) {
                            array_push($keys, $key);
                        }
                    }
                }

                foreach ($jsonData as $k => $data) {
                    $side_keys = array_keys($data);
                    foreach ($keys as $key) {
                        if (!isset($data[$key])) {
                            $data[$key] = "";
                            $jsonData[$k] = $data;
                        }
                    }
                }

                $_SESSION['jsonData'] = $jsonData;
            }
        }
    }
?>


<?php if (!empty($_SESSION['jsonData'])) return; ?>
<form id="upload-form" method="post" enctype="multipart/form-data" action="<?php echo $_SERVER["PHP_SELF"] ?>" class="w-25 p-3 justify-content-center align-item-center text-center border rounded-2">
    <div>
        <label for="jsonFile" class="form-label"><h3>Upload</h3></label>
        <div>
            <input type="file" name="jsonFile" accept=".json" class="form-control">
            <input type="submit" name="upload-submit" value="Upload" class="btn btn-primary mt-3">
        </div>
    </div>
</form>
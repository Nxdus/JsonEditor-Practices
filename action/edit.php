<?php

    session_start();

    if (isset($_POST['clear-submit'])) {
        unset($_SESSION['jsonData']);
        header("Location: ../");
        return;
    }

    if (isset($_POST['save-submit']) || isset($_POST['add-submit']) || isset($_POST["download-submit"]) || isset($_POST['delcol-submit']) || isset($_POST['addcol-submit'])) {

        $jsonData = $_SESSION['jsonData'];
        $colum_index = array_keys($jsonData[0]);

        if (isset($_POST['add-submit'])) {
            $dummy = array();

            foreach ($colum_index as $key) {
                $dummy[$key] = "";
            }

            array_push($jsonData, $dummy);
        } elseif (isset($_POST['delcol-submit'])) {
            $key = $_POST['delcol-key'];
            foreach ($jsonData as $k => $data) {
                unset($data[$key]);
                $jsonData[$k] = $data;
            }
        } elseif (isset($_POST['addcol-submit'])) {
            $key = $_POST['addcol-key'];
            foreach ($jsonData as $k => $data) {
                $data[$key] = "";
                $jsonData[$k] = $data;
            }
        } 

        $row_index = 0;

        foreach ($jsonData as $row) {
            $cell_index = 0;

            if (isset($_POST['checkbox-'.$row_index])) {
                unset($jsonData[$row_index]);
            } else {
                foreach($row as $cell) {
                    $colum_key = $colum_index[$cell_index];
    
                    if (isset($_POST[$row_index."_".$colum_key])) {
                        $data = $_POST[$row_index."_".$colum_key];
                        $jsonData[$row_index][$colum_key] = $data;
                    }
    
                    $cell_index++;
                }
            }

            $row_index++;
        }

        if (empty($jsonData)) {
            unset($_SESSION['jsonData']);
        } else {
            $_SESSION['jsonData'] = array_values($jsonData);
        }

        if (isset($_POST['download-submit']) && isset($_SESSION['jsonData'])) {
            $jsonData = json_encode($_SESSION['jsonData'], JSON_UNESCAPED_UNICODE);

            $filename = 'data.json';
        
            header('Content-Type: application/json; charset=utf-8');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            header('Content-Length: ' . strlen($jsonData));

            echo $jsonData;
            exit;
        }
    }

    header("Location: ../")

?>
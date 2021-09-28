<?php

// Baca content file plaintext
function readFileExternal(string $filename): string
{
    $file = fopen($filename, "r") or die("Unable to open the file");
    $filecontent = fread($file, filesize($filename));
    fclose($file);
    return $filecontent;
}

// Cek inputan key user apakah terdiri kurang dari 6 huruf
function checkIfUserInputHasMoreThan6Characters(string $input): bool
{
    if (strlen($input) >= 6) {
        return true;
    }

    return false;
}

// Eliminasi huruf yang sama pada inputan user
function eliminateSimilarLetterInUserInput(string $input): string
{
    $tempResult = str_split($input);
    $tempInput = $input;

    for ($i = 0; $i < strlen($input); $i++) {
        for ($j = $i + 1; $j < strlen($input); $j++) {
            if ($tempInput[$i] == $input[$j]) {
                unset($tempResult[$j]);
            }
        }
    }

    $result = implode("", $tempResult);
    return $result;
}

// Eliminasi huruf x di hasil dekripsi
function eliminateXinBetweenSameLetter(string $message): string
{
    $result = '';

    for ($i = 0; $i < strlen($message); $i++) {
        if ($i + 1 == strlen($message) - 1 && $message[strlen($message) - 1] != "X") {
            $result .= strtoupper($message[$i]) . strtoupper($message[($i + 1)]);
            break;
        }

        if ($message[($i + 1)] != "X") {
            $result .= strtoupper($message[$i]);
        } else {
            $result .= strtoupper($message[$i]);
            $i++;
        }
    }

    return $result;
}

// Bandingin key sama seluruh alphabet, kalo ada yang sama hapus alphabetnya
function eliminateSimilarLetterBetweenUserInputAndAlphabet(string $input): string
{
    $alphabet = "ABCDEFGHIKLMNOPQRSTUVWXYZ";
    $tempResult = str_split($alphabet);

    for ($i = 0; $i < strlen($input); $i++) {
        for ($j = 0; $j < strlen($alphabet); $j++) {
            if (strtoupper($input[$i]) == $alphabet[$j]) {
                unset($tempResult[$j]);
                break;
            }
        }
    }

    $result = implode("", $tempResult);
    return $result;
}

// Sisipkan huruf x di pasangan huruf yang sama (untuk enkripsi)
function insertXinBetweenSameLetter(string $message): array
{
    $tempInput = array();

    for ($i = 0; $i < strlen($message); $i++) {
        if ($i + 1 == strlen($message)) {
            array_push($tempInput, strtoupper($message[$i]), "X");
            break;
        }

        if ($message[$i] != $message[($i + 1)]) {
            array_push($tempInput, strtoupper($message[$i]), strtoupper($message[($i + 1)]));
            $i++;
        } else {
            array_push($tempInput, strtoupper($message[$i]), "X");
        }
    }

    $result = implode("", $tempInput);
    $splitedResult = str_split($result, 2);
    return $splitedResult;
}

function encrypt(array $matrix, array $message): string
{
    $columnIndexListener = 0;
    $rowIndexListener = 0;
    $tempResult = array();

    for ($i = 0; $i < count($message); $i++) {
        // echo "Iterasi $i" . PHP_EOL;
        for ($j = 0; $j < 2; $j++) {
            for ($k = 0; $k < 5; $k++) {
                for ($m = 0; $m < 5; $m++) {
                    if ($message[$i][$j] == $matrix[$k][$m]) {
                        // echo "In " . $k . $m . PHP_EOL;
                        if ($j == 1) {
                            // echo "In 1" . PHP_EOL;
                            if ($columnIndexListener < $k && $rowIndexListener > $m || $columnIndexListener < $k && $rowIndexListener < $m || $columnIndexListener > $k && $rowIndexListener < $m || $columnIndexListener > $k && $rowIndexListener > $m) {
                                // echo "In 2" . PHP_EOL;
                                array_push($tempResult, $matrix[$columnIndexListener][$m], $matrix[$k][$rowIndexListener]);
                                break;
                            } else if ($columnIndexListener == $k) {
                                // echo "In 3" . PHP_EOL;
                                if (!isset($matrix[$columnIndexListener][$rowIndexListener + 1])) {
                                    array_push($tempResult, $matrix[$columnIndexListener][0], $matrix[$columnIndexListener][$m + 1]);
                                    break;
                                } else if (!isset($matrix[$columnIndexListener][$m + 1])) {
                                    array_push($tempResult, $matrix[$columnIndexListener][$rowIndexListener + 1], $matrix[$columnIndexListener][0]);
                                    break;
                                } else {
                                    array_push($tempResult, $matrix[$columnIndexListener][$rowIndexListener + 1], $matrix[$columnIndexListener][$m + 1]);
                                    break;
                                }
                            } else if ($rowIndexListener == $m) {
                                // echo "In 4" . PHP_EOL;
                                if (!isset($matrix[$columnIndexListener + 1][$rowIndexListener])) {
                                    array_push($tempResult, $matrix[0][$rowIndexListener], $matrix[$k + 1][$rowIndexListener]);
                                    break;
                                } else if (!isset($matrix[$k + 1][$rowIndexListener])) {
                                    array_push($tempResult, $matrix[$columnIndexListener + 1][$rowIndexListener], $matrix[0][$rowIndexListener]);
                                    break;
                                } else {
                                    array_push($tempResult, $matrix[$columnIndexListener + 1][$rowIndexListener], $matrix[$k + 1][$rowIndexListener]);
                                    break;
                                }
                            }
                        } else {
                            $columnIndexListener = $k;
                            $rowIndexListener = $m;
                        }
                    }
                }
            }
        }
        $columnIndexListener = 0;
        $rowIndexListener = 0;
    }

    $result = implode("", $tempResult);
    return $result;
}

function decrypt(array $matrix, array $message): string
{
    $columnIndexListener = 0;
    $rowIndexListener = 0;
    $tempResult = array();

    for ($i = 0; $i < count($message); $i++) {
        // echo "Iterasi $i" . PHP_EOL;
        for ($j = 0; $j < 2; $j++) {
            for ($k = 0; $k < 5; $k++) {
                for ($m = 0; $m < 5; $m++) {
                    if ($message[$i][$j] == $matrix[$k][$m]) {
                        // echo "In " . $k . $m . PHP_EOL;
                        if ($j == 1) {
                            // echo "In 1" . PHP_EOL;
                            if ($columnIndexListener < $k && $rowIndexListener > $m || $columnIndexListener < $k && $rowIndexListener < $m || $columnIndexListener > $k && $rowIndexListener < $m || $columnIndexListener > $k && $rowIndexListener > $m) {
                                // echo "In 2" . PHP_EOL;
                                array_push($tempResult, $matrix[$columnIndexListener][$m], $matrix[$k][$rowIndexListener]);
                                break;
                            } else if ($columnIndexListener == $k) {
                                // echo "In 3" . PHP_EOL;
                                if ($rowIndexListener == 0) {
                                    array_push($tempResult, $matrix[$columnIndexListener][4], $matrix[$columnIndexListener][$m - 1]);
                                    break;
                                } else if ($m == 0) {
                                    array_push($tempResult, $matrix[$columnIndexListener][$rowIndexListener - 1], $matrix[$columnIndexListener][4]);
                                    break;
                                } else {
                                    array_push($tempResult, $matrix[$columnIndexListener][$rowIndexListener - 1], $matrix[$columnIndexListener][$m - 1]);
                                    break;
                                }
                            } else if ($rowIndexListener == $m) {
                                // echo "In 4" . PHP_EOL;
                                if ($columnIndexListener == 0) {
                                    array_push($tempResult, $matrix[4][$rowIndexListener], $matrix[$k - 1][$rowIndexListener]);
                                    break;
                                } else if ($k == 0) {
                                    array_push($tempResult, $matrix[$columnIndexListener - 1][$rowIndexListener], $matrix[4][$rowIndexListener]);
                                    break;
                                } else {
                                    array_push($tempResult, $matrix[$columnIndexListener - 1][$rowIndexListener], $matrix[$k - 1][$rowIndexListener]);
                                    break;
                                }
                            }
                        } else {
                            $columnIndexListener = $k;
                            $rowIndexListener = $m;
                        }
                    }
                }
            }
        }
        $columnIndexListener = 0;
        $rowIndexListener = 0;
    }

    $result = implode("", $tempResult);
    return $result;
}

// Buat table matrix
function createAndAssignMatrix(string $preparedMessage): array
{
    // Playfair cipher matrix table
    $matrix = [[], [], [], [], []];

    // Assign matrix
    $counter = 0;
    for ($i = 0; $i < 5; $i++) {
        for ($j = 0; $j < 5; $j++) {
            $matrix[$i][$j] = $preparedMessage[$counter];
            $counter++;
        }
    }

    return $matrix;
}

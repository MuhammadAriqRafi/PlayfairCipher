<?php

require_once "./PlayfairCipherController.php";

// User Interface
while (true) {
    $keyInput = strtoupper((string)readline('Masukkan kunci : '));
    if (checkIfUserInputHasMoreThan6Characters($keyInput)) break;
}

echo PHP_EOL . "Enkripsi tekan 1" . PHP_EOL;
echo "Dekripsi tekan 2" . PHP_EOL;
$decryptOrEncrypt = (int)readline("Pilih : ");
echo PHP_EOL;

$messageFile = (string)readline('Masukkan nama file pesan : ') . ".txt";
$messageFileContent = readFileExternal($messageFile);
$preparedMessage = eliminateSimilarLetterInUserInput(str_replace("J", "I", $keyInput)) . eliminateSimilarLetterBetweenUserInputAndAlphabet($keyInput);
$preparedMatrix = createAndAssignMatrix($preparedMessage);
$formatedMessage = insertXinBetweenSameLetter(str_replace(' ', '', $messageFileContent));

switch ($decryptOrEncrypt) {
    case 1:
        echo "Encrypted Message : " . encrypt($preparedMatrix, $formatedMessage);
        break;
    case 2:
        echo "Decrypted Message : " . eliminateXinBetweenSameLetter(decrypt($preparedMatrix, $formatedMessage));
        break;
    default:
        echo "Pilihan tidak tersedia";
        break;
}

// Encrypt message

// Iterate Matrix
// echo PHP_EOL;

// echo PHP_EOL;

// for ($i = 0; $i < 5; $i++) {
//     for ($j = 0; $j < 5; $j++) {
//         echo $matrix[$i][$j];
//     }
//     echo PHP_EOL;
// }

// echo PHP_EOL;

// $index11 = 0;
// $index12 = 0;
// $index21 = 0;
// $index22 = 0;

// for ($x = 0; $x < count($message); $x++) {
//     for ($i = 0; $i < 5; $i++) {
//         for ($j = 0; $j < 5; $j++) {
//             if ($message[$x][0] == $matrix[$i][$j]) {
//                 $index11 = $i;
//                 $index12 = $j;
//                 break;
//             }
//         }
//         for ($j = 0; $j < 5; $j++) {
//             if ($message[$x][1] == $matrix[$i][$j]) {
//                 $index21 = $i;
//                 $index22 = $j;
//                 break;
//             }
//         }
//     }

//     if ($index11 == $index21) {
//         if ($index11 == 4) {
//             array_push($tempResult, $matrix[$index11][0], $matrix[$index21 + 1][$index22]);
//         } else if ($index21 == 4) {
//             array_push($tempResult, $matrix[$index11][$index12 + 1], $matrix[$index21][0]);
//         } else {
//             array_push($tempResult, $matrix[$index11][$index12 + 1], $matrix[$index21][$index22 + 1]);
//         }
//     } else if ($index12 == $index22) {
//         if ($index11 == 4) {
//             array_push($tempResult, $matrix[0][$index12], $matrix[$index21 + 1][$index22]);
//         } else if ($index21 == 4) {
//             array_push($tempResult, $matrix[$index11 + 1][$index12], $matrix[0][$index22]);
//         } else {
//             array_push($tempResult, $matrix[$index11 + 1][$index12], $matrix[$index21 + 1][$index22]);
//         }
//     } else if ($index11 < $index21) {
//         array_push($tempResult, $matrix[$index11][$index22], $matrix[$index21][$index12]);
//     } else {
//         array_push($tempResult, $matrix[$index11][$index22], $matrix[$index21][$index12]);
//     }
// }

// $result = implode("", $tempResult);
// echo "Encrypted Message: " . $result;

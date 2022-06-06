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

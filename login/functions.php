<?php
// Function to generate a random 4-letter code excluding 'I' and 'O'
function generateVerificationCode() {
    $letters = 'ABCDEFGHJKLMNPQRSTUVWXYZ'; // Exclude 'I' and 'O'
    return substr(str_shuffle($letters), 0, 4);
}
?>

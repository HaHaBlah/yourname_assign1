<?php
$plain = "wgwgsfbeeh";
$new_hash = password_hash($plain, PASSWORD_DEFAULT);
echo "New hash: " . $new_hash . "\n";
if (password_verify($plain, $new_hash)) {
    echo "Match";
} else {
    echo "No match";
}
?>
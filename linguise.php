<?php
$linguise_options = array(
  "api_key" => "Vza1wDgcaYul8HYu59OdQV1MB6OpgTWv",
  "original_language" => "es",
);
if (isset($_SERVER["HTTP_X_LINGUISE_KEY"])) {
  include_once __DIR__ . "/linguise/script-php/index.php";
}

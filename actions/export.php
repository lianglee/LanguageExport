<?php
set_time_limit(0);
$code = input('code');

$LanguageExport = new LanguageExport($code);
$LanguageExport->genArchive();

$LanguageExport->download();

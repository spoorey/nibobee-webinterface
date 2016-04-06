<?php
$cmd = file_get_contents(__DIR__ . '/command.bat');
echo exec($cmd);

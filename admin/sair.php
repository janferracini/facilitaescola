<?php

session_start();

unset($_SESSION["facilita_escola"]);

header("Location: ../index.php");

<?php


function getPeriodo($periodo_id)
{
    $periodo_id = explode("-", $periodo_id);
    return $periodo_id[1];
}
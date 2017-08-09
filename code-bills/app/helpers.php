<?php

function isRouteActive($name)
{
    return Route::currentRouteNamed($name);
}

function dateBrToEn($date)
{
    if ($date == null) {
        return $date;
    }

    $date = \DateTime::createFromFormat('d/m/Y', trim($date));

    return $date->format('Y-m-d');
}

function dateEnToBr($date)
{
    if ($date == null) {
        return $date;
    }

    $date = \DateTime::createFromFormat('Y-m-d', trim($date));

    return $date->format('d/m/Y');
}

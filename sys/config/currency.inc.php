<?php

    if (!defined("APP_SIGNATURE")) {

        header("Location: /");
        exit;
    }

    $CURRENCY_ARRAY = array();

    array_push($CURRENCY_ARRAY, array(
        "code" => "USD",
        "name" => "US dollar",
        "symbol" => "$"
    ));

    array_push($CURRENCY_ARRAY, array(
        "code" => "EUR",
        "name" => "Euro, EU countries",
        "symbol" => "€"
    ));

    array_push($CURRENCY_ARRAY, array(
        "code" => "MXN",
        "name" => "Peso, Mexico",
        "symbol" => "$"
    ));

    array_push($CURRENCY_ARRAY, array(
        "code" => "BRL",
        "name" => "Real, Brazil",
        "symbol" => "$"
    ));

    array_push($CURRENCY_ARRAY, array(
        "code" => "INR",
        "name" => "Rupee, India",
        "symbol" => "₹"
    ));

    array_push($CURRENCY_ARRAY, array(
        "code" => "GBP",
        "name" => "Great Britain",
        "symbol" => "£"
    ));

    array_push($CURRENCY_ARRAY, array(
        "code" => "TRY",
        "name" => "Lira, Turkey",
        "symbol" => "₺"
    ));

    array_push($CURRENCY_ARRAY, array(
        "code" => "IDR",
        "name" => "Rupee, Indonesia",
        "symbol" => "Rp"
    ));

    array_push($CURRENCY_ARRAY, array(
        "code" => "PEN",
        "name" => "Sol, Peru",
        "symbol" => "Sol"
    ));

    array_push($CURRENCY_ARRAY, array(
        "code" => "DOP",
        "name" => "Peso, Dominican Republic",
        "symbol" => "$"
    ));

    array_push($CURRENCY_ARRAY, array(
        "code" => "RUR",
        "name" => "Ruble, Russia",
        "symbol" => "руб."
    ));
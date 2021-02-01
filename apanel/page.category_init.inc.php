<?php

    /*!
     * ifsoft.co.uk
     *
     * http://ifsoft.com.ua, https://ifsoft.co.uk, https://raccoonsquare.com
     * raccoonsquare@gmail.com
     *
     * Copyright 2012-2020 Demyanchuk Dmitry (raccoonsquare@gmail.com)
     */

    if (!defined("APP_SIGNATURE")) {

        header("Location: /");
        exit;
    }

    if (!admin::isSession()) {

        header("Location: /".APP_ADMIN_PANEL."/login");
        exit;
    }

    $main_categories = array(
        "Phones, tablets and accessories",
        "Cars, motorcycles and other vehicles",
        "Real estate",
        "Clothing, Fashion and Style",
        "Pets",
        "Computers, game consoles and accessories",
        "Cosmetics, perfumes and other health and beauty products",
        "Furniture",
        "Shoes",
        "Tools and other household goods",
        "Wristwatches",
        "Business and services");

    $phone_subcategories = array(
        "Mobile phones and tablets",
        "Accessories for phones and tablets",
        "Other");

    $auto_subcategories = array(
        "Cars",
        "Trucks",
        "Buses",
        "Moto",
        "Special machinery",
        "Agricultural machinery",
        "Water transport",
        "Air Transport",
        "Tires and wheels",
        "Auto parts",
        "Accessories for cars",
        "Moto parts",
        "Moto accessories",
        "Other parts",
        "Other");

    $realty_subcategories = array(
        "Sale of apartments, rooms",
        "Long-term rental apartments, rooms",
        "Sale of houses",
        "Long term rental homes",
        "Sale of land",
        "Land lease",
        "Sale of commercial real estate",
        "Rental of commercial real estate",
        "Sale of garages, parking",
        "Rent garages, parking",
        "Daily Rental",
        "Other");

    $fashion_subcategories = array(
        "Women\'s clothing",
        "Lingerie, swimwear",
        "Men\'s clothing",
        "Men\'s underwear",
        "Hats",
        "Bags",
        "Jewelry",
        "Bijouterie",
        "Gifts",
        "Other");

    $pets_subcategories = array(
        "Dogs",
        "Cats",
        "Birds",
        "Reptiles",
        "Rodents",
        "Aquarium",
        "Pet supplies",
        "Other");

    $computers_subcategories = array(
        "Desktop computers",
        "Laptops",
        "Servers",
        "Gaming consoles",
        "Games for PC and Consoles",
        "Peripherals",
        "Monitors",
        "External drives",
        "Components and accessories",
        "Expendable materials",
        "Software",
        "Other");

    $cosmetics_subcategories = array(
        "Cosmetics",
        "Perfumery",
        "Care products",
        "Other health and beauty products");

    $furniture_subcategories = array(
        "Living room furniture",
        "Bedroom furniture",
        "Hallway furniture",
        "Kitchen furniture",
        "Bathroom furniture",
        "Office furniture",
        "Other");

    $shoes_subcategories = array(
        "Women\'s shoes",
        "Men\'s shoes",
        "Other");

    $tools_subcategories = array(
        "Power tool",
        "Hand tool",
        "Gas powered tools",
        "Other tools",
        "Garden tools",
        "Household equipment",
        "Other");

    $watches_subcategories = array(
        "Women\'s watches",
        "Men\'s wrist watch",
        "Other");

    $services_subcategories = array(
        "Construction services",
        "Design and architecture",
        "Selling a business",
        "Financial services",
        "Babysitters",
        "Entertainment",
        "Auto and Moto Services",
        "Animal Services",
        "Tourism",
        "Education and Sport",
        "Equipment",
        "Advertising / Printing / Marketing / Internet",
        "Other");

    $category = new category($dbo);

    if ($category->getCategoriesCount() == 0) {

        // Create main categories

        for ($i = 0; $i < count($main_categories); $i++) {

            $category->add(0, $main_categories[$i]);
        }

        //echo "Added main categories - ".count($main_categories)."</br>";

        // Add phones subcategories

        for ($i = 0; $i < count($phone_subcategories); $i++) {

            $category->add(1, $phone_subcategories[$i]);
        }

        //echo "Added phones subcategories - ".count($phone_subcategories)."</br>";

        // Add auto subcategories

        for ($i = 0; $i < count($auto_subcategories); $i++) {

            $category->add(2, $auto_subcategories[$i]);
        }

        //echo "Added auto subcategories - ".count($auto_subcategories)."</br>";

        // Add realty subcategories

        for ($i = 0; $i < count($realty_subcategories); $i++) {

            $category->add(3, $realty_subcategories[$i]);
        }

        //echo "Added realty subcategories - ".count($realty_subcategories)."</br>";

        // Add fashion subcategories

        for ($i = 0; $i < count($fashion_subcategories); $i++) {

            $category->add(4, $fashion_subcategories[$i]);
        }

        //echo "Added fashion subcategories - ".count($fashion_subcategories)."</br>";

        // Add pets subcategories

        for ($i = 0; $i < count($pets_subcategories); $i++) {

            $category->add(5, $pets_subcategories[$i]);
        }

        //echo "Added pets subcategories - ".count($pets_subcategories)."</br>";

        // Add computers subcategories

        for ($i = 0; $i < count($computers_subcategories); $i++) {

            $category->add(6, $computers_subcategories[$i]);
        }

        //echo "Added computers subcategories - ".count($computers_subcategories)."</br>";

        // Add cosmetics subcategories

        for ($i = 0; $i < count($cosmetics_subcategories); $i++) {

            $category->add(7, $cosmetics_subcategories[$i]);
        }

        //echo "Added cosmetics subcategories - ".count($cosmetics_subcategories)."</br>";

        // Add furniture subcategories

        for ($i = 0; $i < count($furniture_subcategories); $i++) {

            $category->add(8, $furniture_subcategories[$i]);
        }

        //echo "Added furniture subcategories - ".count($furniture_subcategories)."</br>";

        // Add shoes subcategories

        for ($i = 0; $i < count($shoes_subcategories); $i++) {

            $category->add(9, $shoes_subcategories[$i]);
        }

        //echo "Added shoes subcategories - ".count($shoes_subcategories)."</br>";

        // Add tools subcategories

        for ($i = 0; $i < count($tools_subcategories); $i++) {

            $category->add(10, $tools_subcategories[$i]);
        }

        //echo "Added tools subcategories - ".count($tools_subcategories)."</br>";

        // Add watches subcategories

        for ($i = 0; $i < count($watches_subcategories); $i++) {

            $category->add(11, $watches_subcategories[$i]);
        }

        //echo "Added watches subcategories - ".count($watches_subcategories)."</br>";

        // Add services subcategories

        for ($i = 0; $i < count($services_subcategories); $i++) {

            $category->add(12, $services_subcategories[$i]);
        }

        //echo "Added services subcategories - ".count($services_subcategories)."</br>";
    }

    header("Location: /".APP_ADMIN_PANEL."/category");
    exit;
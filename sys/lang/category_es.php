<?php

    if (!defined("APP_SIGNATURE")) {

        header("Location: /");
        exit;
    }

	$TEXT = array();

    // For standard categories

    $TEXT['category-1'] = "Teléfonos, tabletas y accesorios.";
    $TEXT['category-2'] = "Automóviles, motocicletas y otros vehículos";
    $TEXT['category-3'] = "Bienes raíces";
    $TEXT['category-4'] = "Ropa, moda y estilo";
    $TEXT['category-5'] = "Animales domésticos";
    $TEXT['category-6'] = "Ordenadores, consolas de videojuegos y accesorios";
    $TEXT['category-7'] = "Cosméticos, perfumes y otros productos de salud y belleza";
    $TEXT['category-8'] = "Mueble";
    $TEXT['category-9'] = "Los zapatos";
    $TEXT['category-10'] = "Herramientas y otros artículos del hogar";
    $TEXT['category-11'] = "Relojes de pulsera";
    $TEXT['category-12'] = "Negocios y servicios";

    $TEXT['category-13'] = "Teléfonos móviles y tabletas";
    $TEXT['category-14'] = "Accesorios para teléfonos y tabletas";
    $TEXT['category-15'] = "Otro";

    $TEXT['category-16'] = "Carros";
    $TEXT['category-17'] = "Camiones";
    $TEXT['category-18'] = "Autobuses";
    $TEXT['category-19'] = "Motos";
    $TEXT['category-20'] = "Maquinaria especial";
    $TEXT['category-21'] = "Maquinaria de agricultura";
    $TEXT['category-22'] = "Transporte de agua";
    $TEXT['category-23'] = "Transporte aereo";
    $TEXT['category-24'] = "Neumáticos y ruedas";
    $TEXT['category-25'] = "Autopartes";
    $TEXT['category-26'] = "Accesorios para coches";
    $TEXT['category-27'] = "Partes de moto";
    $TEXT['category-28'] = "Accesorios de moto";
    $TEXT['category-29'] = "Otras partes";
    $TEXT['category-30'] = "Otro";

    $TEXT['category-31'] = "Venta de pisos, habitaciones";
    $TEXT['category-32'] = "Apartamentos de alquiler a largo plazo, habitaciones";
    $TEXT['category-33'] = "Venta de casas";
    $TEXT['category-34'] = "Casas de alquiler a largo plazo";
    $TEXT['category-35'] = "Venta de terrenos";
    $TEXT['category-36'] = "Arrendamiento de tierras";
    $TEXT['category-37'] = "Venta de inmuebles comerciales";
    $TEXT['category-38'] = "Alquiler de inmuebles comerciales";
    $TEXT['category-39'] = "Venta de garajes, aparcamientos";
    $TEXT['category-40'] = "Alquiler garajes, parking";
    $TEXT['category-41'] = "Alquiler diario";
    $TEXT['category-42'] = "Otro";

    $TEXT['category-43'] = "Ropa de mujer";
    $TEXT['category-44'] = "Lenceria, bañadores";
    $TEXT['category-45'] = "Ropa de Hombre";
    $TEXT['category-46'] = "Ropa interior masculina";
    $TEXT['category-47'] = "Sombreros";
    $TEXT['category-48'] = "Bolsos de mano";
    $TEXT['category-49'] = "Joyería";
    $TEXT['category-50'] = "Bisutería";
    $TEXT['category-51'] = "Regalos";
    $TEXT['category-52'] = "Otro";

    $TEXT['category-53'] = "Los perros";
    $TEXT['category-54'] = "Los gatos";
    $TEXT['category-55'] = "Las aves";
    $TEXT['category-56'] = "Reptiles";
    $TEXT['category-57'] = "Los roedores";
    $TEXT['category-58'] = "Acuario";
    $TEXT['category-59'] = "Suministros para mascotas";
    $TEXT['category-60'] = "Otro";

    $TEXT['category-61'] = "Computadores de escritorio";
    $TEXT['category-62'] = "Computadoras portatiles";
    $TEXT['category-63'] = "Servidores";
    $TEXT['category-64'] = "Consolas de juego";
    $TEXT['category-65'] = "Juegos para PC y consolas";
    $TEXT['category-66'] = "Periféricos";
    $TEXT['category-67'] = "Monitores";
    $TEXT['category-68'] = "Unidades externas";
    $TEXT['category-69'] = "Componentes y accesorios";
    $TEXT['category-70'] = "Materiales fungibles";
    $TEXT['category-71'] = "Software";
    $TEXT['category-72'] = "Otro";

    $TEXT['category-73'] = "Productos cosméticos";
    $TEXT['category-74'] = "Perfumería";
    $TEXT['category-75'] = "Productos para el cuidado";
    $TEXT['category-76'] = "Otros productos de salud y belleza";

    $TEXT['category-77'] = "Mueble del salón";
    $TEXT['category-78'] = "Muebles de dormitorio";
    $TEXT['category-79'] = "Muebles de pasillo";
    $TEXT['category-80'] = "Muebles de cocina";
    $TEXT['category-81'] = "Muebles de baño";
    $TEXT['category-82'] = "Muebles de oficina";
    $TEXT['category-83'] = "Otro";

    $TEXT['category-84'] = "Zapatos de mujer";
    $TEXT['category-85'] = "Zapatos de hombre";
    $TEXT['category-86'] = "Otro";

    $TEXT['category-87'] = "Herramienta eléctrica";
    $TEXT['category-88'] = "Herramienta de mano";
    $TEXT['category-89'] = "Instrumento a gasolina";
    $TEXT['category-90'] = "Otras herramientas";
    $TEXT['category-91'] = "Herramientas de jardín";
    $TEXT['category-92'] = "Equipos para el hogar";
    $TEXT['category-93'] = "Otro";

    $TEXT['category-94'] = "Relojes de mujer";
    $TEXT['category-95'] = "Reloj de los hombres";
    $TEXT['category-96'] = "Otro";

    $TEXT['category-97'] = "Servicios de construcción";
    $TEXT['category-98'] = "Diseño y arquitectura";
    $TEXT['category-99'] = "Vendiendo un negocio";
    $TEXT['category-100'] = "Servicios financieros";
    $TEXT['category-101'] = "Niñeras";
    $TEXT['category-102'] = "Entretenimiento";
    $TEXT['category-103'] = "Servicios de Auto y Moto";
    $TEXT['category-104'] = "Servicios para animales";
    $TEXT['category-105'] = "Turismo";
    $TEXT['category-106'] = "Educación y deporte";
    $TEXT['category-107'] = "Equipo";
    $TEXT['category-108'] = "Publicidad / Impresión / Marketing / Internet";
    $TEXT['category-109'] = "Otro";
<?php

    if (!defined("APP_SIGNATURE")) {

        header("Location: /");
        exit;
    }

	$TEXT = array();

    // For standard categories

    $TEXT['category-1'] = "Telefones, tablets e acessórios";
    $TEXT['category-2'] = "Carros, motocicletas e outros veículos";
    $TEXT['category-3'] = "Imobiliária";
    $TEXT['category-4'] = "Roupas, Moda e Estilo";
    $TEXT['category-5'] = "Animais";
    $TEXT['category-6'] = "Computadores, consolas de jogos e acessórios";
    $TEXT['category-7'] = "Cosméticos, perfumes e outros produtos de saúde e beleza";
    $TEXT['category-8'] = "Mobília";
    $TEXT['category-9'] = "Sapatos";
    $TEXT['category-10'] = "Ferramentas e outros bens de uso doméstico";
    $TEXT['category-11'] = "Relógios de pulso";
    $TEXT['category-12'] = "Negócios e serviços";

    $TEXT['category-13'] = "Telefones e tablets";
    $TEXT['category-14'] = "Acessórios para telefones e tablets";
    $TEXT['category-15'] = "Outros";

    $TEXT['category-16'] = "Carros";
    $TEXT['category-17'] = "Caminhões";
    $TEXT['category-18'] = "Autocarros";
    $TEXT['category-19'] = "Motorcycles";
    $TEXT['category-20'] = "Maquinaria especial";
    $TEXT['category-21'] = "Maquinaria agrícola";
    $TEXT['category-22'] = "Transporte de água";
    $TEXT['category-23'] = "Transporte aéreo";
    $TEXT['category-24'] = "Pneus e Rodas";
    $TEXT['category-25'] = "Autopeças";
    $TEXT['category-26'] = "Acessórios para carros";
    $TEXT['category-27'] = "Peças de motocicleta";
    $TEXT['category-28'] = "Acessórios de motocicleta";
    $TEXT['category-29'] = "Partes diferentes";
    $TEXT['category-30'] = "Outros";

    $TEXT['category-31'] = "Venda de apartamentos, quartos";
    $TEXT['category-32'] = "Aluguer apartamentos de longo prazo, quartos";
    $TEXT['category-33'] = "Venda de casas";
    $TEXT['category-34'] = "Casas de aluguel de longo prazo";
    $TEXT['category-35'] = "Venda de terrenos";
    $TEXT['category-36'] = "Arrendamento de terras";
    $TEXT['category-37'] = "Venda de imóveis comerciais";
    $TEXT['category-38'] = "Aluguer de imóveis comerciais";
    $TEXT['category-39'] = "Venda de garagens, estacionamento";
    $TEXT['category-40'] = "Aluguel de garagens, estacionamento";
    $TEXT['category-41'] = "Aluguer diário";
    $TEXT['category-42'] = "Outros";

    $TEXT['category-43'] = "Roupas Femininas";
    $TEXT['category-44'] = "Lingerie, roupa de banho";
    $TEXT['category-45'] = "Roupa para Homem";
    $TEXT['category-46'] = "Roupa íntima masculina";
    $TEXT['category-47'] = "Chapéus";
    $TEXT['category-48'] = "Bolsas";
    $TEXT['category-49'] = "Joalheria";
    $TEXT['category-50'] = "Bijouterie";
    $TEXT['category-51'] = "Presentes";
    $TEXT['category-52'] = "Outros";

    $TEXT['category-53'] = "Cão";
    $TEXT['category-54'] = "Cat";
    $TEXT['category-55'] = "Aves";
    $TEXT['category-56'] = "Répteis";
    $TEXT['category-57'] = "Roedores";
    $TEXT['category-58'] = "Aquário";
    $TEXT['category-59'] = "Suprimentos para animais de estimação";
    $TEXT['category-60'] = "Outros";

    $TEXT['category-61'] = "Computadores desktop";
    $TEXT['category-62'] = "Portáteis";
    $TEXT['category-63'] = "Servidores";
    $TEXT['category-64'] = "Consolas de jogos";
    $TEXT['category-65'] = "Jogos para PC e Consoles";
    $TEXT['category-66'] = "Periféricos";
    $TEXT['category-67'] = "Monitores";
    $TEXT['category-68'] = "Drives externos";
    $TEXT['category-69'] = "Componentes e acessórios";
    $TEXT['category-70'] = "Expendables";
    $TEXT['category-71'] = "Software";
    $TEXT['category-72'] = "Outros";

    $TEXT['category-73'] = "Cosméticas";
    $TEXT['category-74'] = "Perfumaria";
    $TEXT['category-75'] = "Produtos para cuidados";
    $TEXT['category-76'] = "Outros produtos de saúde e beleza";

    $TEXT['category-77'] = "Mobília da sala de estar";
    $TEXT['category-78'] = "Mobília de quarto";
    $TEXT['category-79'] = "Mobília do corredor";
    $TEXT['category-80'] = "Móveis de cozinha";
    $TEXT['category-81'] = "Mobília do banheiro";
    $TEXT['category-82'] = "Móveis de escritório";
    $TEXT['category-83'] = "Outros";

    $TEXT['category-84'] = "Sapatos femininos";
    $TEXT['category-85'] = "Sapatos masculinos";
    $TEXT['category-86'] = "Outros";

    $TEXT['category-87'] = "Ferramenta de poder";
    $TEXT['category-88'] = "Ferramenta de mão";
    $TEXT['category-89'] = "Ferramentas movidas a gás";
    $TEXT['category-90'] = "Outras ferramentas";
    $TEXT['category-91'] = "Ferramentas de jardim";
    $TEXT['category-92'] = "Equipamento doméstico";
    $TEXT['category-93'] = "Outros";

    $TEXT['category-94'] = "Relógios das mulheres";
    $TEXT['category-95'] = "Relógio de pulso dos homens";
    $TEXT['category-96'] = "Outros";

    $TEXT['category-97'] = "Serviços de construção";
    $TEXT['category-98'] = "Design e arquitetura";
    $TEXT['category-99'] = "Vendendo um negócio";
    $TEXT['category-100'] = "Serviços financeiros";
    $TEXT['category-101'] = "Babás";
    $TEXT['category-102'] = "Entretenimento";
    $TEXT['category-103'] = "Auto e Moto serviços";
    $TEXT['category-104'] = "Serviços para Animais";
    $TEXT['category-105'] = "Turismo";
    $TEXT['category-106'] = "Educação e Esporte";
    $TEXT['category-107'] = "Equipamentos";
    $TEXT['category-108'] = "Publicidade / Impressão / Marketing / Internet";
    $TEXT['category-109'] = "Outros";
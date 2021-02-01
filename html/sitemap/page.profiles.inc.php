<?php

    /*!
     * ifsoft.co.uk
     *
     * http://ifsoft.com.ua, https://ifsoft.co.uk, https://raccoonsquare.com
     * raccoonsquare@gmail.com
     *
     * Copyright 2012-2020 Demyanchuk Dmitry (raccoonsquare@gmail.com)
     */

    header('Content-type: text/xml');
    echo '<?xml version="1.0" encoding="UTF-8" ?>';
?>

<urlset xmlns="http://www.google.com/schemas/sitemap/0.84" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.google.com/schemas/sitemap/0.84 http://www.google.com/schemas/sitemap/0.84/sitemap.xsd">

    <url>
        <loc><?php echo APP_URL; ?>/</loc>
        <priority>1.00</priority>
    </url>

<?php

    $sitemap = new sitemap($dbo);
    $sitemap->setItemsInRequest(2000);
    $result = $sitemap->getProfiles();
    unset($sitemap);

    foreach ($result['items'] as $key => $item) {

        ?>
            <url>
                <loc><?php echo APP_URL; ?>/<?php echo $item['username']; ?></loc>
                <changefreq>monthly</changefreq>
                <priority>0.5</priority>
            </url>
        <?php
    }
?>

</urlset>
<?php

function getProductImage($category, $index, $productName = '') {

    $category = strtolower($category);
    $productName = strtolower($productName);

    // Vivo ki original local image
    if (
        strpos($category, 'mobile') !== false &&
        strpos($productName, 'vivo') !== false &&
        file_exists(__DIR__ . '/images/mobiles/mobile1.jpg')
    ) {
        return 'images/mobiles/mobile1.jpg';
    }

    // Category-wise images
    $images = [

        'mobile' => [
            '1511709268805-2c1e5e7e8b8c',
            '1592899677977-9c10ca588bbd',
            '1512499617640-c74ae3a79d37',
            '1598327105666-5b89351aff97'
        ],

        'laptop' => [
            '1496181133206-80ce9b88a853',
            '1498050108023-c5249f4df085',
            '1517336714731-489689fd1ca8',
            '1588872657578-7efd1f1555ed'
        ],

        'audio' => [
            '1505740420928-5e560c06d30e',
            '1484704849700-f032a568e944',
            '1546435770-a3e426bf472b',
            '1590658268037-6bf12165a8df'
        ],

        'watch' => [
            '1523275335684-37898b6baf30',
            '1524805444758-089113d48a6d',
            '1508685096489-7aacd43bd3b1',
            '1434493789847-2f02dc6ca35d'
        ],

        'fashion' => [
            '1521572163474-6864f9cf17ab',
            '1523381210434-271e8be1f52b',
            '1515886657613-9f3515b0c78f',
            '1483985988355-763728e1935b'
        ],

        'shoe' => [
            '1542291026-7eec264c27ff',
            '1460353581641-37baddab0fa2',
            '1495555961986-6d4c1ecb7be3'
        ],

        'bag' => [
            '1584917865442-de89df76afd3',
            '1553062407-98eeb64c6a62',
            '1548036328-c9fa89d128fa',
            '1590874103328-eac38a683ce7'
        ],

        'beauty' => [
            '1596462502278-27bfdc403348',
            '1608248543803-ba4f8c70ae0b',
            '1522335789203-aabd1fc54bc9',
            '1571781926291-c477ebfd024b'
        ],

        'home' => [
            '1556911220-bff31c812dba',
            '1555041469-a586c61ea9bc',
            '1600210492486-724fe5c67fb0',
            '1600585154340-be6161a56a0c'
        ],

        'toy' => [
            '1599623560574-39d485900c95',
            '1566576912321-d58ddd7a6088',
            '1596461404969-9ae70f2830c1'
        ],

        'book' => [
            '1544947950-fa07a98d237f',
            '1512820790803-83ca734da794',
            '1519682337058-a94d519337bc'
        ],

        'sport' => [
            '1461896836934-ffe607ba8211',
            '1517836357463-d25dfeac3438',
            '1534438327276-14e5300c3a48'
        ],

        'gaming' => [
            '1593305841991-05c297ba4575',
            '1606144042614-b2417e99c4e3',
            '1593113598332-cd288d649433'
        ],

        'automotive' => [
            '1503376780353-7e6692767b70',
            '1492144534655-ae79c964c9d7',
            '1504215680853-026ed2a45def'
        ],

        'accessories' => [
            '1523275335684-37898b6baf30',
            '1526170375885-4d8ecf77b99f',
            '1525547719571-a2d4ac8945e2'
        ]
    ];

    foreach ($images as $keyword => $photoList) {

        if (strpos($category, $keyword) !== false) {

            $photo = $photoList[$index % count($photoList)];

            return "https://images.unsplash.com/photo-" .
                $photo . "?auto=format&fit=crop&w=800&q=80";
        }
    }

    return '';
}
?>
<?php
require_once("helpers.php");
require_once("functions.php");

$sql_cat = "SELECT * FROM categories";
$result_cat = mysqli_query($con, $sql_cat);
$categories = mysqli_fetch_all($result_cat, MYSQLI_ASSOC);

$search = mysqli_real_escape_string($con, $_GET['search']) ?? '';

if (isset($search)) {

    $cur_page = $_GET['page'] ?? 1;
    $page_items = 9;

    $res_pages = mysqli_query($con, "SELECT COUNT(*) as cnt FROM lots
     WHERE MATCH(name, description) AGAINST('$search') AND winner_id IS NULL");
    $res = mysqli_fetch_row($res_pages);
    $items_count = $res[0];

    $pages_count = ceil($items_count / $page_items);
    $offset = ($cur_page - 1) * $page_items;

    $pages = range(1, $pages_count);

    $sql = "SELECT l.id AS id_lot, l.name AS name_lot, price, img, c.name AS name_cat, time_exit
     FROM lots l 
    JOIN categories c ON c.id = l.category_id
    WHERE MATCH(l.name, description) AGAINST('$search') AND winner_id IS NULL
    ORDER BY dt_add DESC LIMIT $page_items OFFSET $offset";
    
    $result = mysqli_query($con, $sql);
    $lots = mysqli_fetch_all($result, MYSQLI_ASSOC);  

    foreach ($lots as $key => $lot) {
        $item_id = $lot['id_lot'];
    
        $sql_new_price = "SELECT price FROM bets WHERE lot_id = $item_id ORDER BY id DESC LIMIT 1";            
        $res_new = mysqli_query($con, $sql_new_price);        
        $new_price = mysqli_fetch_assoc($res_new);
        
        $lots[$key]['bet_step'] = (int)$new_price['price'];
    }   
    

    if (mysqli_num_rows($result) == 0) { 
        $search_page = include_template("error.php", [
            'error_message' => "Ничего не найдено по вашему запросу...",
            'categories' => $categories,
        ]);   
    } else {
        $search_page = include_template("search.php", [
            'lots' => $lots,
            'categories' => $categories,
            'search' => $search,
            'pages_count' => $pages_count,
            'cur_page' => $cur_page,
            'page_items' => $page_items,     
        ]);    
    }
}  elseif(!$search) {
    $search_page = include_template("error.php", [
        'error_message' => "Ничего не найдено по вашему запросу...",
        'categories' => $categories,
    ]); 
}

$layout_page = include_template("layout.php", [
    'content' => $search_page,
     'categories' => $categories,
     'title' => 'Поиск',
    ]);

print($layout_page);
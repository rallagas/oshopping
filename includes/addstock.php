<?php

if(isset($_GET['f_stock_qty'])){
    
include_once "db_conn.inc.php";
include_once "func.inc.php";
extract($_GET);
    $stockqty = htmlentities($f_stock_qty);
    $item_id = htmlentities($f_item_id);
    $searchK = htmlentities($f_search_key);
    $headloc = "";
    if($searchK !== ""){
        $headloc="location:../index.php?searchKey={$searchK}&success";
    }
    else{
        $headloc="location:../index.php?success={$item_id}";
    }

    if(addStock($mysqli,$item_id,$stockqty) !== false){
        header($headloc);
        exit();
    }else{
        header("location:../index.php?error=failedtoAddStock");
        exit();
    }
}
<?php
include_once "db_conn.inc.php";

function fetchCategories($mysqli){
    $arr=array();
    $sql = "SELECT * FROM category;";
    $result = $mysqli->query($sql);
    if($result->num_rows > 0){
       while($row = $result->fetch_assoc()){
         array_push($arr,$row);  
       }
    }
    return $arr;
}


function fetchItems($mysqli,$searchkey="",$orderby="",$sort=""){
    $arr= array() ;
    if($searchkey == ""){
        $sql = "
               SELECT i.item_id item_id
                    , i.item_name item_name
                    , i.item_short_code item_short_code
                    , i.item_price item_price
                    , c.cat_desc cat_desc
                    , CASE WHEN i.item_status = 'A'
                           THEN 'Active'
                           WHEN i.item_status = 'D'
                           THEN 'Discontinued'
                           ELSE 'Invalid'
                       END item_status
                    , sum(order_qty) tot_order_qty
                    , sum(item_qty) tot_item_qty
                    , sum(item_qty) - sum(order_qty) available
               from (
                   SELECT o.item_id item_id, o.order_qty as order_qty, '' as item_qty
             FROM orders o
           UNION ALL
           SELECT item_id, '' as order_qty, s.item_qty
             FROM stock  s 
             JOIN lu_day d 
               ON s.date_added = d.day_id
            WHERE d.date between CURRENT_DATE -30 and CURRENT_DATE
                      
                    ) fct
               join items i 
                 on fct.item_id = i.item_id
               join category c
                 on c.cat_id = i.cat_id
            
           ";
        $o_sort="ORDER BY i.item_name";
        switch($orderby){
              case "code": $o_sort = "ORDER BY item_short_code";
                break;
            case "name": $o_sort = "ORDER BY item_name";
                break;
            case "price": $o_sort = "ORDER BY item_price";
                break;
            case "category": $o_sort = "ORDER BY cat_desc";
                break;
            case "status": $o_sort = " ORDER BY item_status ";
                break;
            case "stockCount": $o_sort = " ORDER BY available ";
                break;
            default:  $o_sort="ORDER BY item_name";
        }
        switch($sort){
            case "ASC": $arrow = " ASC;"; break;
            case "DESC": $arrow = " DESC;"; break;
            default: $arrow = " ASC;";
        }
          $groupby = " GROUP BY item_id
                        , item_name
                        , item_short_code
                        , item_price
                        , cat_desc
                        , CASE WHEN i.item_status = 'A'
                           THEN 'Active'
                           WHEN i.item_status = 'D'
                           THEN 'Discontinued'
                           ELSE 'Invalid'
                       END  ";
        
        $sql = $sql." ".$groupby." ".$o_sort." ".$arrow;
        $result = $mysqli -> query($sql);
      if(!empty($result)){
        $arr = array();
        while($row = $result -> fetch_assoc()){
                array_push($arr,$row);
        }
      }
    }
    else{
       $sql = "SELECT i.item_id item_id
                    , i.item_name item_name
                    , i.item_short_code item_short_code
                    , i.item_price item_price
                    , c.cat_desc cat_desc
                    , CASE WHEN i.item_status = 'A'
                           THEN 'Active'
                           WHEN i.item_status = 'D'
                           THEN 'Discontinued'
                           ELSE 'Invalid'
                       END item_status
                    , sum(order_qty) tot_order_qty
                    , sum(item_qty) tot_item_qty
                    , sum(item_qty) - sum(order_qty) available
               from (
                    SELECT o.item_id item_id, o.order_qty as order_qty, '' as item_qty
             FROM orders o
           UNION ALL
           SELECT item_id, '' as order_qty, s.item_qty
             FROM stock  s 
             JOIN lu_day d 
               ON s.date_added = d.day_id
            WHERE d.date between CURRENT_DATE -30 and CURRENT_DATE
                    ) fct
               join items i 
                 on fct.item_id = i.item_id
               join category c
                 on i.cat_id = c.cat_id
              WHERE item_name LIKE ?
                 OR item_short_code = ?
                 OR item_price = ?
                 OR cat_desc LIKE ?
             ";
        
        $o_sort=" ORDER BY i.item_name";
        switch($orderby){
             case "code": $o_sort = "ORDER BY item_short_code";
                break;
            case "name": $o_sort = "ORDER BY item_name";
                break;
            case "price": $o_sort = "ORDER BY item_price";
                break;
            case "category": $o_sort = "ORDER BY cat_desc";
                break;
            case "status": $o_sort = "ORDER BY item_status";
                break;
            case "stockCount": $o_sort = " ORDER BY available ";
                break;
            default:  $o_sort="ORDER BY item_name";
        }
           switch($sort){
            case "ASC": $arrow = " ASC;"; break;
            case "DESC": $arrow = " DESC"; break;
            default: $arrow = " ASC;";
        }
        $groupby = " GROUP BY item_id
                        , item_name
                        , item_short_code
                        , item_price
                        , cat_desc
                        , item_status ";
        $sql = $sql." ".$groupby." ".$o_sort. " ".$arrow. "";
        $stmt = $mysqli -> stmt_init();
        
        if ($stmt = $mysqli -> prepare($sql)){
            $v_item = "%{$searchkey}%";
            $v_cat = "%{$searchkey}%";
            
            $stmt -> bind_param("ssss", $v_item,$searchkey,$searchkey,$v_cat);
            $stmt -> execute();
            $result = $stmt -> get_result();
            $arr = array();
        
            while($row = $result -> fetch_assoc()){
                    array_push($arr,$row);
            }
            
        }
        
    }
    
    
    return $arr;
    $mysqli -> close();
}

function showItemTable($item_list,$sk="",$access=""){
    if(!empty($item_list)){
    echo "<table class='table text-center'>"; ?>
        <thead>
          <th>
              <a href="?searchKey=<?php echo $sk;?>&orderby=code&sort=ASC" class="btn"><i class="bi bi-caret-up"></i></a>
                 Code
              <a href="?searchKey=<?php echo $sk;?>&orderby=code&sort=DESC" class="btn"><i class="bi bi-caret-down"></i></a>
          </th>
          <th>
              <a href="?searchKey=<?php echo $sk;?>&orderby=name&sort=ASC" class="btn"><i class="bi bi-caret-up"></i></a>
                 Name
              <a href="?searchKey=<?php echo $sk;?>&orderby=name&sort=DESC" class="btn"><i class="bi bi-caret-down"></i></a>
          </th>
          <th>
              <a href="?searchKey=<?php echo $sk;?>&orderby=price&sort=ASC" class="btn"> <i class="bi bi-caret-up"></i> </a>
                  Price
              <a href="?searchKey=<?php echo $sk;?>&orderby=price&sort=DESC" class="btn"> <i class="bi bi-caret-down"></i> </a>
          </th>
          <th>
              <a href="?searchKey=<?php echo $sk;?>&orderby=category&sort=ASC" class="btn"><i class="bi bi-caret-up"></i></a>
                  Category
              <a href="?searchKey=<?php echo $sk;?>&orderby=category&sort=DESC" class="btn"><i class="bi bi-caret-down"></i></a>
          </th>
           <th>
              <a href="?searchKey=<?php echo $sk;?>&orderby=status&sort=ASC" class="btn"><i class="bi bi-caret-up"></i></a>
                 Status
              <a href="?searchKey=<?php echo $sk;?>&orderby=status&sort=DESC" class="btn"><i class="bi bi-caret-down"></i></a>
          </th>
           <th>
              <a href="?searchKey=<?php echo $sk;?>&orderby=stockCount&sort=ASC" class="btn"><i class="bi bi-caret-up"></i></a>
                 Stock Count
              <a href="?searchKey=<?php echo $sk;?>&orderby=stockCount&sort=DESC" class="btn"><i class="bi bi-caret-down"></i></a>
          </th>
           <?php if($access == "ADMIN"){ ?>
                          <th></th>
            <?php } ?>
        </thead>
        <?php    foreach($item_list as $key => $item){ 
                extract($item);
                    echo "<tr>";
                        echo "<td>".$item_short_code. "</td>";
                        echo "<td>".$item_name      . "</td>";
                        echo "<td> Php ".number_format($item_price,2,".",","). "</td>";
                        echo "<td>".$cat_desc       . "</td>";
                        echo "<td>".$item_status    . "</td>";
                      
                       if($access == "ADMIN"){ ?>
                           <td>
                                <div class="container-fluid" id="addStock_<?php echo $item_id; ?>">
                                    <form action="includes/addstock.php" method="GET">
                                        <div class="input-group">
                                            <span class="input-group-text" title="Current Stock Count"><?php echo "OQ: " . $tot_order_qty . " TS: ". $tot_item_qty ." AS: ". $available ;  ?></span>
                                            <input name="f_stock_qty" type="number" class="form-control" placeholder="Add Stock Qty">
                                            <input hidden name="f_item_id" type="text" value="<?php echo $item_id; ?>">
                                            <input hidden name="f_search_key" type="text" value="<?php if(isset($_GET['searchKey'])){ echo $_GET['searchKey']; }else { echo ""; } ?>">
                                            <button type="submit" class="btn btn-outline-orange"> <i class="bi bi-plus"></i> </button>
                                        </div>
                                    </form>
                                   
                                </div>
                           </td>
                       <?php }
                    echo "</tr>"; ?>
            <?php }
            echo "<tr><td colspan='5' class='text-center'><em>End of Result</em></td></tr>";
            echo "</table>";
    }else{
        echo "<em>No Result found.</em>";
    }
        
}
function addStock($mysqli,$item_id,$stockqty){
    $sql = "INSERT INTO `stock` 
             (`item_id`,`item_short_code`,`item_qty`,`date_added`)
            SELECT i.item_id
                 , i.item_short_code
                 , ?
                 , d.day_id
              FROM items i
                 , lu_day d
            WHERE  i.item_id = ?
              AND  d.date = CURRENT_DATE();
    ";
    if($stmt =$mysqli->prepare($sql)){
        $stmt->bind_param("ss",$stockqty,$item_id);
        $stmt->execute();
        return true;
        $stmt->close();
        
    }
    else{
        return false;
    }
}
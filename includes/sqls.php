<?php 
$sql1="select item_short_code
    
      , (case when tot_item_qty is NULL then 0 else tot_item_qty end)
       - (case when tot_order_qty is NULL then 0 else tot_order_qty end)
       as available
from (
SELECT i.item_short_code, sum(COALESCE(s.item_qty,0)) tot_item_qty , sum(COALESCE(o.order_qty,0)) tot_order_qty
  FROM items i
  left outer join stock s
    on (i.item_id = s.stock_id)
  left outer join orders o
    on (i.item_id = o.item_id)
group by i.item_short_code
    ) main";




select item_short_code
 , (case when tot_item_qty is NULL then 0 else tot_item_qty end)
 - (case when tot_order_qty is NULL then 0 else tot_order_qty end)
   as available
from (
SELECT i.item_short_code, sum(COALESCE(s.item_qty,0)) tot_item_qty , sum(COALESCE(o.order_qty,0)) tot_order_qty
 FROM items i
 left outer join stock s
 on (i.item_id = s.stock_id)
 left outer join orders o
 on (i.item_id = o.item_id)
    group by i.item_short_code
    ) main
    
    
    
    
select item_short_code
 , case when tot_item_qty is NULL then 0 else tot_item_qty end tot_item_qty
 , case when tot_order_qty is NULL then 0 else tot_order_qty end tot_order_qty
 , (case when tot_item_qty is NULL then 0 else tot_item_qty end)
 - (case when tot_order_qty is NULL then 0 else tot_order_qty end)
   as available
from (
SELECT i.item_short_code
    , sum(s.item_qty) tot_item_qty 
    , sum(o.order_qty) tot_order_qty
 FROM items i
 left outer join stock s
 on (s.item_id = i.item_id)
 left outer join orders o
 on (o.item_id = i.item_id)
Where s.item_qty is not null and o.order_qty is not null
group by i.item_short_code
    ) main  
ORDER BY `tot_item_qty`  DESC
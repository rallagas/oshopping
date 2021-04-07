<!DOCTYPE html>
<?php
include_once "includes/db_conn.inc.php"; 
include_once "includes/func.inc.php"; 

?>
<html lang="en" dir="ltr">
	<head>     
		<meta charset="UTF-8"/>
		<title>OShopping</title>
	<link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/custom.css">
    <style>
        
     
    </style>
	</head>
<body>
<div class="container" id="headings">
    <div class="row">
        <div class="col-12 shadow py-3 bg-orange rounded text-light">
            <h1 class="display-1 text-light ms-4">OOPee</h1>
            
        </div>
    </div>
    
</div>
<div class="container shadow-sm">
    <div class="row bg-orange-shadow">
        <div class="col-12">
          <?php include_once "includes/nav.inc.php";?>  
        </div>
    </div>
    <div class="row">
        <div class="col-2"></div>
        <div class="col-8">
            <div class="container-fluid">
                <div class="collapse" id="addItemForm">
                    <form action="newitem.inc.php" method="POST">
                       <div class="card shadow">
                          <div class="card-header bg-orange text-white">
                              Add New Item
                          </div>
                          <div class="card-body">
                              <input name="f_itemname" type="text" class="form-control mb-2" placeholder="Item Name">   
                              <input name="f_price" type="number" class="form-control mb-2" placeholder="Price">   
                              <select name="f_category" id="" class="form-select mb-2">
                                  
                                  <?php 
                                     $catlist = fetchCategories($mysqli);
                                     if(!empty($catlist)){
                                         echo "<option>Categories</option>";
                                         foreach($catlist as $key => $cat){
                                             echo "<option value='".$cat['cat_id']."'>".$cat['cat_desc']."</option>";
                                         }
                                     }
                                     else{
                                         echo "<option>Empty</option>";
                                     }
                                  ?>
                              </select>
                              <div class="form-check">
                                 <input type="radio" class="form-check-input mb-2" name="f_status" id="active" value="A"> <label for="active" class="form-check-label">Active</label>
                              </div>
                              <div class="form-check">
                                 <input type="radio" class="form-check-input mb-3" name="f_status" id="discon" value="D"> <label for="discon" class="form-check-label">Discontinue/Non-Active</label>    
                              </div>
                              
                          </div>
                          <div class="card-footer bg-orange-shadow">
                              <button class="btn bg-orange">Save <i class="bi bi-save"></i> </button>
                          </div>
                       </div>
                        
                        
                    </form>
                </div>
            </div>
        </div>
        <div class="col-2"></div>
    </div>
    <div class="row">
        <div class="col-12">
            <?php
            $sk = "";
            $ob = "";
            $di = "";
            if(isset($_GET['searchKey']) ){
               $sk = htmlentities($_GET['searchKey']);
            }
            if(isset($_GET['orderby'])){
              $ob = htmlentities($_GET['orderby']);     
            }
            if(isset($_GET['sort'])){
               $di = htmlentities($_GET['sort']);
            }
            
               $item_list = fetchItems($mysqli,$sk,$ob,$di);
               showItemTable($item_list,$sk,"ADMIN");
             ?>
            
        </div>
    </div>
</div>




</body>
<footer>
    

<script src="js/bootstrap.min.js"></script>
</footer>
</html>
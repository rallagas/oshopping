      <nav class="navbar navbar-expand-lg text-white shadow-sm">
            <div class="container-fluid">
             <a href="index.php" class="navbar-brand btn btn-no-border-orange pb-3"> 
                <i class="bi bi-house"></i> 
                </a>
            <button class="navbar-toggler btn btn-outline-orange" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="bi bi-list"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                   <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                       <li class="nav-item"> 
                          <a   class="nav-link btn btn-no-border-orange" 
                          data-bs-toggle="collapse" 
                                    href="#addItemForm" 
                                    role="button" 
                           aria-expanded="false"
                           aria-controls="addItemForm">
                           Add Item  <i class="bi bi-plus-circle"></i></a> 
                       </li>
                      </ul>
                   
                <form action="index.php" method="GET" class="d-flex">
                    <div class="input-group">
                       <input type="text" name="searchKey" class="form-control" placeholder="Search">
                       <button class="btn bg-orange"><i class="bi bi-search"></i></button>
                    </div>
                </form>
                   
               </div>
                 
             </div>
         </nav>
               
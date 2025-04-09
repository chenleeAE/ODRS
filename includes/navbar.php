
<style>
    .logout-btn {
    background-color: #ffffff !important; /* Set to white or any color you want */

}
.navbar-container {
        display: flex;
        align-items: center;
        width: 100%;
        justify-content: space-between;
        background-color: rgb(68, 4, 4);
}
</style>

<div class="row border-bottom" style="background-color: rgb(68, 4, 4);">
    <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
      

        <div class="navbar-container">
        <div style="display: flex; align-items: center;">
            <img src="../public/img/logo.png" width="100"/>
            <img src="../public/img/lcro.png" width="100" />
            
          
            
            <h3 style="margin-left: 10px; color: white; ">LOCAL CIVIL REGISTRY</h3>
           
        </div>
     
      
        <ul class="nav navbar-top-links navbar-right" >
            <li class="logout-btn">
               
                <a href="#" data-toggle="modal" data-target="#logoutModal"  ><i class="fa fa-sign-out"  ></i> Log out</a>
            </li>
        </ul>
        </div>

        <div class="navbar-header" >
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#" style="background-color: rgb(68, 4, 4);"><i class="fa fa-bars"></i> </a>
        </div>
    </nav>
  
  

</div>


<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" data-keyboard="false" aria-labelledby="myModalLabel" data-backdrop="static">
    <div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
                <h4 class="modal-title">Ready to Leave?</h4>
			</div>
			<div class="modal-body">
                <div class="panel">
                    <h3>Select "Logout" below if you are ready to end your current session.</h3>
                </div>
            </div>
			<div class="modal-footer">
				<button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
				<a class="btn btn-primary" href="../modules/logout.php">Logout</a>
			</div>
		</div>
	</div>
</div>
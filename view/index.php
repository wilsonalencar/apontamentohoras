<?php
  require_once(app::path.'view/header.php');
?>
<div id="page-wrapper">
	<div class="header"> 
	            <h1 class="page-header">
	                Dashboard
	            </h1>
				<ol class="breadcrumb">
				  <li><a href="#">Home</a></li>
				  <li><a href="#">Dashboard</a></li>
				  <li class="active">Data</li>
				</ol> 
								
	</div>
	<div id="page-inner"> 
		<div class="row">
		    <div class="col-md-12">
		    <div class="card">
		        <div class="card-action">
		         Empty Page
		        </div>        
		         <div class="card-content"> 
				     <p>Consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
		            <div class="clearBoth"><br/></div>
				 </div>
			</div>
		    <div class="fixed-action-btn horizontal click-to-toggle">
			    <a class="btn-floating btn-large red">
			      <i class="material-icons">menu</i>
			    </a>
			    <ul>
			      <li><a class="btn-floating red"><i class="material-icons">track_changes</i></a></li>
			      <li><a class="btn-floating yellow darken-1"><i class="material-icons">format_quote</i></a></li>
			      <li><a class="btn-floating green"><i class="material-icons">publish</i></a></li>
			      <li><a class="btn-floating blue"><i class="material-icons">attach_file</i></a></li>
			    </ul>
			</div>
<?php
  require_once(app::path.'view/footer.php');
?>
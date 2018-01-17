<?php
  require_once(app::path.'view/header.php');
?>
<div id="page-wrapper">
	<div class="header"> 
	            <h1 class="page-header">
	                Dashboard
	            </h1>
				<ol class="breadcrumb">
				  <li  class="active"><a href="#">Home</a></li>
				  
				</ol> 
								
	</div>
	<div id="page-inner"> 
		<div class="row">
		    <div class="col-md-12">
		    <div class="card">
		        
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
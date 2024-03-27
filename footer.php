<!-- Customer Login Modal Starts here -->
<div id="CustomerLoginModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
<form method="post" action="" enctype="multipart/form-data" onsubmit="return validateform1()" >
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Customer Login Panel</h4>
      </div>
      <div class="modal-body">
        <p>
			<div class="row">
				<div class="col-md-3"> 
				Login ID
				</div>
				<div class="col-md-9"> 
				<input type="text" name="customerloginid" id="customerloginid" class="form-control" >
				<span id="errcustomerloginid" class="errorclass" ></span>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-md-3"> 
				Password
				</div>
				<div class="col-md-9"> 
				<input type="password" name="customerpassword" id="customerpassword" class="form-control" >
				<span id="errcustomerpassword" class="errorclass" ></span>
				</div>
			</div>
		</p>
      </div>
      <div class="modal-footer">
        <button type="submit" name="btncustomerlogin" id="btncustomerlogin" class="btn btn-default" >Click to Login</button>
      </div>
    </div>
</form>
  </div>
</div>
<!-- Customer Login Modal Ends here -->


<!-- Employee Login Modal Starts here -->
<div id="EmployeeLoginModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

<form method="post" action="" enctype="multipart/form-data"  onsubmit="return validateform2()">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Employee Login Panel</h4>
      </div>
      <div class="modal-body">
        <p>
		<div class="row">
				<div class="col-md-3"> 
				Login ID
				</div>
				<div class="col-md-9"> 
				<input type="text" name="employeeloginid" id="employeeloginid" class="form-control" >
				<span id="erremployeeloginid" class="errorclass" ></span>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-md-3"> 
				Password
				</div>
				<div class="col-md-9"> 
				<input type="password" name="employeepassword" id="employeepassword" class="form-control" >
				<span id="erremployeepassword" class="errorclass" ></span>
				</div>
			</div>
		</p>
		
      </div>
      <div class="modal-footer">
        <button type="submit" name="btnemployeelogin" id="btnemployeelogin" class="btn btn-default" >Click to Login</button>
      </div>
    </div>
</form>
  </div>
</div>
<!-- Employee Login Modal Ends here -->


<!-- Customer register Modal Starts here -->
<div id="CustomerRegisterModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Customer Registration Panel</h4>
      </div>
      <div class="modal-body">
        <p>Some text in the modal.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<!-- Customer Register  Modal Ends here -->

	<!-- Start Footer -->
	<footer class="footer-box">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<p class="footer-company-name"><?php echo $footertext; ?>
<?php
if(!isset($_SESSION['customer_id']))
{
	if(!isset($_SESSION['employee_id']))
	{
	?>
	 | <a href="#"  data-toggle="modal" data-target="#EmployeeLoginModal">Employee Login</a></p>
	<?php
	}
}
?>
				</div>
			</div>
		</div>
	</footer>
	<!-- End Footer -->
	
	<a href="#" id="scroll-to-top" class="new-btn-d br-2"><i class="fa fa-angle-up"></i></a>

	<!-- ALL JS FILES -->
	<script src="js/jquery.min.js"></script>
	<script src="js/popper.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
    <!-- ALL PLUGINS -->
	<script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/jquery.pogo-slider.min.js"></script> 
	<script src="js/slider-index.js"></script>
	<script src="js/smoothscroll.js"></script>
	<script src="js/TweenMax.min.js"></script>
	<script src="js/main.js"></script>
	<script src="js/owl.carousel.min.js"></script>
	<script src="js/form-validator.min.js"></script>
    <script src="js/contact-form-script.js"></script>
	<script src="js/isotope.min.js"></script>	
	<script src="js/images-loded.min.js"></script>	
    <script src="js/custom.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>
<script>
$(document).ready( function () {
$('#datatable').DataTable();
} );
</script>
<script>
function validateform1()
{	
	var alphaExp = /^[a-zA-Z]+$/;	//Variable to validate only alphabets
	var alphaspaceExp = /^[a-zA-Z\s]+$/;//Variable to validate only alphabets with space
	var alphanumericExp = /^[a-zA-Z0-9]+$/;//Variable to validate only alphanumerics
	var numericExpression = /^[0-9]+$/;	//Variable to validate only numbers
	var emailpattern = /^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/; //For email id
	
	$('.errorclass').html('');
	var i = 0;
	if(document.getElementById("customerloginid").value=="")
	{
		document.getElementById("errcustomerloginid").innerHTML="Login ID should not be empty..";
		i=1;
	}
	if(document.getElementById("customerpassword").value=="")
	{
		document.getElementById("errcustomerpassword").innerHTML="Password should not be empty..";
		i=1;
	}	
	if(i==0)
	{
		return true;
	}
	else
	{
		return false;
	}
}
</script>
<script>
function validateform2()
{	
	var alphaExp = /^[a-zA-Z]+$/;	//Variable to validate only alphabets
	var alphaspaceExp = /^[a-zA-Z\s]+$/;//Variable to validate only alphabets with space
	var alphanumericExp = /^[a-zA-Z0-9]+$/;//Variable to validate only alphanumerics
	var numericExpression = /^[0-9]+$/;	//Variable to validate only numbers
	var emailpattern = /^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/; //For email id
	
	$('.errorclass').html('');
	var i = 0;
	//   
	if(document.getElementById("employeeloginid").value=="")
	{
		document.getElementById("erremployeeloginid").innerHTML="Login ID should not be empty..";
		i=1;
	}
	if(document.getElementById("employeepassword").value=="")
	{
		document.getElementById("erremployeepassword").innerHTML="Password should not be empty..";
		i=1;
	}
	if(i==0)
	{
		return true;
	}
	else
	{
		return false;
	}
}
</script>
</body>
</html>
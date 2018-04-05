<?php include_once __DIR__.'/layouts/header.php'; ?>


<div class="container">
  <div class="row">
  <div class="col-sm-4 col-sm-offset-4">
    <h2 class="text-center">Register</h2>
  <form name="register" method="post" id="registerUser">
    <div class="form-group">
      <label for="firstName">First Name</label>
      <input class="form-control" type="text" name="firstName" id="firstName" placeholder="enter your first name here" required="" />
    </div>
    <div class="form-group">
      <label for="lastName">Last Name</label>
      <input class="form-control" type="lastName" id="lastName" name="lastName" placeholder="enter your last name here" required=""/>
    </div>
    <div class="form-group">
      <label for="emailID">Email-ID</label>
      <input class="form-control" type="email" id="emailID" name="emailID" placeholder="enter your emailID here" required=""/>
    </div>
    <div class="form-group">
      <label for="password">Password</label>
      <input class="form-control" type="password" id="password" name="password" placeholder="enter your password here" required=""/>
    </div>
    <div class="form-group">
      <input type="submit" name="submit" class="btn btn-success btn-sm" value="Register"/>
      <small><span>Already have an account? Click <a href="/">here</a> to login.</span></small>
    </div>
  </form>
</div>
</div>
</div>

<script type="text/javascript">

 $(document).ready(function () {


  $(document.body).on('submit','#registerUser',function(e){
    e.preventDefault();
          var APIBaseUrl='http://localhost.searchLocation.com/API/index.php';

         $.ajax({
            type : 'POST',
            url : APIBaseUrl+'?apiName=register',
            type : 'POST',
            data: $(this).serializeArray(),
            dataType : 'JSON',
            encode : true,
            success: function (response, status, xhr) {
              if (response.status) {
                  setCookie('jwt',xhr.getResponseHeader('jwt'),1);
                  window.location.href = '/dashboard.php';
              }else{
                alert("Something went wrong, please try again...");
              }
            },
            error: function (error) {
              console.log(error);
            }
          });
        });

  });



</script>


<?php include_once __DIR__.'/layouts/footer.php'; ?>


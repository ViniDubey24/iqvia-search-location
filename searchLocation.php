<?php include_once __DIR__.'/layouts/user-header.php'; ?>
              
<div class="container">
  <div class="row">
  <div class="col-sm-4 col-sm-offset-4">

    <form name="register" method="post" id="registerUser">

                           <div class="form-group">
      <label for="password">Location</label>
      <input class="form-control" type="text" id="searchTextField" name="password" size="50"  placeholder="Enter a location" autocomplete="on"/>
    </div>
  </form>

               </div>
               </div>
               </div>
           
<script type="text/javascript">

var autocomplete;
  function initAutocomplete() {
        autocomplete = new google.maps.places.Autocomplete((document.getElementById('searchTextField')));
        autocomplete.addListener('place_changed', saveThisLocation);
      }

      function saveThisLocation() {
        var place = autocomplete.getPlace();

        if (confirm("Do you want to save this location?")) {

          var locationData={
            'latitude':place.geometry.location.lat(),
            "longitude":place.geometry.location.lng(),
            "name":place.name,
            "description":place.formatted_address
          };
         $.ajax({
            type : 'POST',
            url : API_BASE_URL+'?apiName=saveLocation',
            type : 'POST',
            data: locationData,
            dataType : 'JSON',
            beforeSend: function(request) {
                request.setRequestHeader('jwt', getCookie('jwt'));
            },
            success: function (response, status, xhr) {
              if (response.status) {
                alert("Successfully saved your location.");
              }else{
                alert("Something went wrong, while saving your location.");
              }
            },
            error: function (error) {
              console.log(error);
              // firstname.html("Something went wrong!");
            }
          });
        }

          
      }

</script>
<script src="http://maps.googleapis.com/maps/api/js?key=<?php echo GOOGLE_KEY; ?>&libraries=places&callback=initAutocomplete" type="text/javascript"></script>

<?php include_once __DIR__.'/layouts/footer.php'; ?>

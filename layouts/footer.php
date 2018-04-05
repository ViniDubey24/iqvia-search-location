		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        
        <script type="text/javascript">
        	

        	 $(document).ready(function () {
  

  $(document.body).on('click','#logout',function(e){

  	setCookie('jwt','',-1);
  	window.location.href = '/';
        });  

  });

        </script>
</body>
</html>
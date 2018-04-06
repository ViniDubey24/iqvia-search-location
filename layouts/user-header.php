<?php include_once __DIR__.'/../config.php'; ?>
<?php include_once __DIR__.'/../checkJWT.php'; ?>

<!DOCTYPE html>
<html>
<head>
	<title>Search Location</title>
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
		<script src="/assets/app.js"> </script>
    <script type="text/javascript">
      var API_BASE_URL='<?php echo API_BASE_URL;?>';
    </script>
</head>
<body>
  <nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="/dashboard.php">iqVia - locations</a>
    </div>
    <ul class="nav navbar-nav">
      <li class=""><a href="/searchLocation.php">Search Location</a></li>
      <li><a href="/savedLocations.php">Saved locations</a></li>
      <li><a href="javascript:;" id="logout">Logout</a></li>
    </ul>
  </div>
</nav>
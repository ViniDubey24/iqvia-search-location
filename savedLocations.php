<?php include_once __DIR__ . '/layouts/user-header.php'; ?>
<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
<div class="container">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <table class="display" id="user-location-table" style="width:100%">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Latitude</th>
                    <th>Longitude</th>
                    <th>CreatedAt</th>
                    <!-- <th>Action</th> -->
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Latitude</th>
                    <th>Longitude</th>
                    <th>CreatedAt</th>
                    <!-- <th>Action</th> -->
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {

        var jwt = getCookie('jwt');


        var userLocation = $('#user-location-table').DataTable({
            "processing": true,
            "serverSide": true,
            "searching": false,
            "ordering": false,
            "ajax": {
                "url": API_BASE_URL + "?apiName=getAllSavedLocation",
                "type": "POST",
                beforeSend: function (request) {
                    request.setRequestHeader('jwt', jwt);
                },
                "data": function (d) {
                    d.method = 'getAllSavedLocation';
                }
            },
            "columns": [
                {"data": "name"},
                {"data": "description"},
                {"data": "latitude"},
                {"data": "longitude"},
                {"data": "createdAt"},
                // {"data": "action"}
            ]
        });

    });
</script>


<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<?php include_once __DIR__ . '/layouts/footer.php'; ?>

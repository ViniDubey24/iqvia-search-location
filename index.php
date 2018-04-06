<?php include_once __DIR__ . '/layouts/header.php'; ?>


<div class="container">
    <div class="row">
        <div class="col-sm-4 col-sm-offset-4">
            <h2 class="text-center">Login</h2>
            <form name="login" method="post" id="loginUser">
                <div class="form-group">
                    <label for="emailID">Email</label>
                    <input class="form-control" type="email" name="emailID" id="emailID" placeholder="emailID"/>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input class="form-control" type="password" id="password" name="password" placeholder="password"/>
                </div>
                <div class="form-group">
                    <input type="submit" name="submit" class="btn btn-success" value="Login"/>
                    <a href="/register.php"><span class="btn btn-default">Register</span></a>
                </div>
            </form>
        </div>
    </div>
</div>


<script type="text/javascript">

    $(document).ready(function () {


        $(document.body).on('submit', '#loginUser', function (e) {
            e.preventDefault();

            $.ajax({
                type: 'POST',
                url: API_BASE_URL + '?apiName=login',
                type: 'POST',
                data: $(this).serializeArray(),
                dataType: 'JSON',
                encode: true,
                success: function (response, status, xhr) {
                    if (response.status) {
                        setCookie('jwt', xhr.getResponseHeader('jwt'), 1);
                        window.location.href = '/dashboard.php';
                    } else {
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

<?php include_once __DIR__ . '/layouts/footer.php'; ?>






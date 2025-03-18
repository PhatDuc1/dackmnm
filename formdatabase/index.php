<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NHẬP THÔNG TIN SINH VIÊN</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>NHẬP THÔNG TIN SINH VIÊN!</h1>
    <div class="container">
        <form action="connect.php" method="post">
            <div>
                <lable>Name</lable>
                <input type="text" name="name" placeholder="Enter your name" autocomplete="off">
            </div>
            <div>
                <lable>Email</lable>
                <input type="text" name="email" placeholder="Enter your email" autocomplete="off">
            </div>
            <div class="genderContainer">
                <lable>Gender</lable>
                <input class="gender1" type="radio" name="gender" value="m">Male
                <input class="gender1" type="radio" name="gender" value="f">Female
                <input class="gender1" type="radio" name="gender" value="o">Others
            </div>
            <div>
                <lable>Mobile</lable>
                <input type="text" name="mobile" placeholder="Enter your mobile" autocomplete="off">
            </div>
            <div>
                <lable>Password</lable>
                <input type="text" name="password" placeholder="Enter your password" autocomplete="off">
            </div>
            <div class="btn">
                <button type="submit">Submit data</button>
            </div>
        </form>
    </div>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form action="/material/doup" method="post" enctype="multipart/form-data">
    @csrf
        <input type="file" name="material" id="">
        <input type="submit" value="提交">
    </form>
</body>
</html>
<!DOCTYPE html>
<html>
<head>
    <title>EvenTinz Success Mail</title>
</head>
<body>
    <p>
        Dear 
        <strong>
            {{ Auth::user()->name }}
        </strong>,
    </p>
    <p>
        {{ $successMsg }}
    </p>
</body>
</html>

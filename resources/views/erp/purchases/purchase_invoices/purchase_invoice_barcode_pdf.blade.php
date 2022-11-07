<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        * {
            box-sizing: border-box;
        }

        .img-container {
            float: left;
            width: 25%;
            padding: 20px;
        }

        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }
    </style>
</head>
<body style="text-align: center; margin: auto">
<div class="clearfix">
@for($i=0, $iMax = $print_qty; $i < $iMax; $i++)
    <div class="img-container">
        <div style="font-size: 12px">{{$product_name}}</div>
        <img src="{{$barcodePath}}" alt="{{$product_sku}}" style="width: 100%; height: 50px">
        <div style="font-size: 12px">{{$product_sku}}</div>
    </div>
@endfor
</div>

</body>
</html>

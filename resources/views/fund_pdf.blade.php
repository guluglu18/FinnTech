<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1 class="mb-3">Fund pdf</h1>
    <div class="row">
        <div class="col-12">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Fund Name</th>
                        <th>Fund Cat Name</th>
                        <th>Fund SubCatName</th>
                        <th>ISIN</th>
                        <th>WKN</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{$fund->id}}</td>
                        <td>{{$fund->name}}</td>
                        <td>{{$fund->fundCategory->name}}</td>
                        <td>{{$fund->fundSubCategory->name}}</td>
                        <td>{{$fund->ISIN}}</td>
                        <td>{{$fund->WKN}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>


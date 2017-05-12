<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style>
        .date {
            white-space: nowrap;
        }
        img{
            max-width: 400px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row">
        <h2>{:name:}</h2>
        <div class="col-md-8">
            <p><a href="{:link:}">{:site:}</a></p>
            <p>{:desc:}</p>
        </div>
        <div class="col-md-4">
            <form method="post">
                <input type="text" name="rss" placeholder="Ваш rss">
                <button>Загрузить</button>
            </form>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th>Название и дата</th>
                <th>Описание</th>
                <th>Теги</th>
            </tr>
            </thead>
            <tbody>
            {:body_table:}
            </tbody>
        </table>
    </div>
</div>
</body>
</html>

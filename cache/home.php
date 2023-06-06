<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo htmlentities(config('name')) ?></title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
        <link rel="stylesheet" href="<?php echo htmlentities(url('/css/app.css')) ?>">
    </head>
    <body>
        <div class="container">
            <h1><a href="./"><?php echo htmlentities(config('name')) ?></a></h1>
            <div class="panel">
                <a class="btn" href="<?php echo htmlentities(route('todo.create')) ?>">Добавить задачу</a>
                <?php if (isAdmin() == true): ?>
                <a class="btn text-right" href="<?php echo htmlentities(route('user.logoff')) ?>">Выход</a>
                <?php else: ?>
                <a class="btn text-right" href="<?php echo htmlentities(route('user.auth')) ?>">Авторизация</a>
                <?php endif; ?>
            </div>
            <div id="data">

<div class="table-responsive">
<table class="table">
  <thead class="table-light">
    <tr>
      <th scope="col">ID <a data-bs-toggle="tooltip" data-bs-title="Сортировка по id по возрастанию" href="/sort/id/order/asc"><i class="fas fa-chevron-up"></i></a> <a data-bs-toggle="tooltip" data-bs-title="Сортировка по id по убыванию" href="/sort/id/order/desc"><i class="fas fa-chevron-down"></i></a></th>
      <th scope="col">Имя <a data-bs-toggle="tooltip" data-bs-title="Сортировка по имени по возрастанию" href="/sort/name/order/asc"><i class="fas fa-chevron-up"></i></a> <a data-bs-toggle="tooltip" data-bs-title="Сортировка по имени по убыванию" href="/sort/name/order/desc"><i class="fas fa-chevron-down"></i></a></th>
      <th scope="col">Email <a data-bs-toggle="tooltip" data-bs-title="Сортировка по email по возрастанию" href="/sort/email/order/asc"><i class="fas fa-chevron-up"></i></a> <a data-bs-toggle="tooltip" data-bs-title="Сортировка по email по убыванию" href="/sort/email/order/desc"><i class="fas fa-chevron-down"></i></a></th>
      <th scope="col">Описание <a data-bs-toggle="tooltip" data-bs-title="Сортировка по описанию по возрастанию" href="/sort/description/order/asc"><i class="fas fa-chevron-up"></i></a> <a data-bs-toggle="tooltip" data-bs-title="Сортировка по описанию по убыванию" href="/sort/description/order/desc"><i class="fas fa-chevron-down"></i></a></th>
      <th scope="col">Статус <a data-bs-toggle="tooltip" data-bs-title="Сортировка по статусу по возрастанию" href="/sort/status/order/asc"><i class="fas fa-chevron-up"></i></a> <a data-bs-toggle="tooltip" data-bs-title="Сортировка по статусу по убыванию" href="/sort/status/order/desc"><i class="fas fa-chevron-down"></i></a></th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
<?php foreach ($todos as $todo_list): ?>    
    <tr>
      <th scope="row"><?php echo htmlentities($todo_list['id']) ?></th>
      <td><?php echo htmlentities($todo_list['name']) ?></td>
      <td><?php echo htmlentities($todo_list['email']) ?></td>
      <td><?php echo htmlentities($todo_list['description']) ?></td>
      <td><?php echo htmlentities($todo_list['status']) ?></td>
      <td><?php if ($todo_list['edited'] == 1): ?>
      <div class="text-success">Отредактировано администратором</div>
      <?php endif; ?>
      <?php if (isAdmin() == true): ?>
      <a href="<?php echo htmlentities(route('todo.edit', ['id' => $todo_list['id']])) ?>">Редактировать</a>
      <?php endif; ?></td>
    </tr>
<?php endforeach; ?>
  </tbody>
  <tfoot>
    <tr>
      <td colspan="6"><?php echo $pagination ?></td>
    </tr>
  </tfoot>
</table>
</div>

                 
            </div>
        </div>
        
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
        <script src="<?php echo htmlentities(url('/js/app.js')) ?>" charset="utf-8"></script>
    </body>
</html>

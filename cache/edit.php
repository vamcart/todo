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
            <?php if ($todo->id): ?>
                <h1>Редактировать <q><?php echo htmlentities($todo->name) ?></q></h1>
            <?php else: ?>
                <h1>Добавить задачу</q></h1>
            <?php endif; ?>
            
            <div class="panel">
                <a class="btn" href="<?php echo htmlentities(url('/')) ?>">Вернуться к списку задач</a>
            </div>

            <?php if (request()->query('saved')): ?>
                <p class="msg msg-success">Успешно сохранено!</p>
            <?php endif; ?>

            <?php if (session()->hasFlash('errors')): ?>
            <ul class="msg msg-error">
                <?php foreach (session()->flash('errors') as $error): ?>
                    <li><?php echo htmlentities($error) ?></li>
                <?php endforeach; ?>
            </ul>
            <?php endif; ?>

            <?php if ($todo->id): ?>
            <form action="<?php echo htmlentities(route('todo.save', ['id' => $todo->id])) ?>" method="post">
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="edited" value="1">
            <?php else: ?>
            <form action="<?php echo htmlentities(route('todo.create')) ?>" method="post">
            <?php endif; ?>
                <div class="form-group">
                    <label>Имя</label>
                    <input type="text" name="name" value="<?php echo htmlentities($todo->name) ?>" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" value="<?php echo htmlentities($todo->email) ?>" required>
                </div>
                <div class="form-group">
                    <label>Описание</label>
                    <input type="text" name="description" value="<?php echo htmlentities($todo->description) ?>" required>
                </div>
            <?php if ($todo->id): ?>
                <div class="form-group">
                    <label>Статус</label>
                    <select name="status">
                        <?php foreach (['Ожидает проверки', 'Выполняется', 'Выполнено'] as $status): ?>
                        <option value="<?php echo htmlentities($status) ?>" <?php echo htmlentities($status == $todo->status ? 'selected' : '') ?>><?php echo htmlentities($status) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            <?php endif; ?>
                <button class="btn primary" type="submit">Сохранить</button>
                <button class="btn" type="reset">Сбросить</button>
            </form>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
        <script src="<?php echo htmlentities(url('/js/app.js')) ?>" charset="utf-8"></script>        
    </body>
</html>

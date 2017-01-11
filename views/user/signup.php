<?php

$this->pageTitle = 'Signup';

?>
<div class="row">
    <h1 class="page-header"><?= $this->pageTitle ?></h1>
</div>
<div class="row">
    <div class="col-xs-6 col-xs-offset-3">
        <?php if (!empty($validationErrors)): ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                Please, fix the following errors:
                <ul>
                    <?php foreach ($validationErrors as $error): ?>
                        <li><?= $error ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        <form action="" method="post">
            <div class="form-group">
                <label for="login">Username</label>
                <input type="text" name="SignupForm[login]" id="login" required class="form-control" placeholder="Username" value="<?= $model->login ?>">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="SignupForm[password]" id="password" required class="form-control">
            </div>
            <div class="form-group">
                <label for="passwordConfirm">Confirm your password</label>
                <input type="password" name="SignupForm[passwordConfirm]" id="passwordConfirm" required class="form-control">
            </div>
            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" name="SignupForm[email]" id="email" required placeholder="E-mail address" class="form-control" value="<?= $model->email ?>">
            </div>
            <div class="form-group">
                <label for="firstName">First name</label>
                <input type="text" name="SignupForm[firstName]" id="firstName" placeholder="First name" class="form-control" value="<?= $model->firstName ?>">
            </div>
            <div class="form-group">
                <label for="lastName">Last name</label>
                <input type="text" name="SignupForm[lastName]" id="lastName" placeholder="Last name" class="form-control" value="<?= $model->lastName ?>">
            </div>
            <div class="form-group">
                <button class="btn btn-success">Create account</button>
            </div>
        </form>
    </div>
</div>

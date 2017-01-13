<?php
$this->pageTitle = 'Sign in.';

use Academy\Helpers\Url;
?>
<div class="row">
    <div class="col-xs-6 col-xs-offset-3">
        <h1 class="page-header"><?= $this->pageTitle ?></h1>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">Sign in</h4>
            </div>
            <div class="panel-body">
                <?php if (!empty($_SESSION['loginError'])): ?>
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <?= $_SESSION['loginError'] ?>
                    </div>
                <?php endif; ?>
                <form action="" method="post">
                    <div class="form-group">
                        <label for="loginInput">Login</label>
                        <input type="text" name="SigninForm[login]" id="loginInput" class="form-control" placeholder="Username">
                    </div>
                    <div class="form-group">
                        <label for="passwordInput">Password</label>
                        <input type="password" name="SigninForm[password]" id="passwordInput" class="form-control">
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary">Sign in</button>
                        <a href="<?= Url::to('user/signup') ?>" class="btn btn-success pull-right">
                            Create an account
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="form-box" id="login-box">
    <div class="header">Sign In</div>
    <form method="post" action="<?php echo $app->urlFor('login'); ?>">
        <div class="body bg-gray">
            <div class="form-group">
                <input type="text" name="login[username]" class="form-control" placeholder="<?php echo Localization::fetch('username'); ?>"/>
            </div>
            <div class="form-group">
                <input type="password" name="login[password]" class="form-control" placeholder="<?php echo Localization::fetch('password'); ?>"/>
            </div>
            <div class="form-group">
                <input type="checkbox" name="remember_me"/> Remember me
            </div>
        </div>
        <div class="footer">
            <button type="submit" class="btn bg-olive btn-block"><?php echo Localization::fetch('login'); ?></button>

            <p><a href="#">I forgot my password</a></p>

            <a href="register.html" class="text-center">Register a new membership</a>
        </div>
    </form>
</div>

<?php if ((isset($errors) && sizeof($errors) > 0)): ?>
    <script type="text/javascript">

        <?php if (isset($errors['error'])): ?>

        $("#login-box").delay(50).effect( "shake" );

        <?php elseif (isset($errors['encrypted'])): ?>

        alertify.log("<?php echo $errors['encrypted']; ?>");

        <?php endif ?>

    </script>
<?php endif ?>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Genicine</title>
</head>
<body>
    <h1>REGISTER</h1>
    <a href="<?php echo base_url()?>auth/login">Go To Login</a>
    <?php echo form_open('auth/register'); ?>
    <div>
		<label for="name">Name</label>
		<input id="name" type="text" name="name" class="form-control" required>
    </div>
    <div>
		<label for="password">Password</label>
		<input id="password" type="password" name="password" class="form-control" required>
    </div>
    <div>
		<label for="repeat-password">Repeat Password</label>
		<input id="repeat-password" type="password" name="confirmation_password" class="form-control" required>
    </div>
    <div>
        <input type="submit" value="Register">
    </div>

    </form>
</body>
</html>
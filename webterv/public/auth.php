<!DOCTYPE html>
<html lang="en">
<head>
    <?php require "parts/head.php"; ?>
    <title>Document</title>
    <link rel="stylesheet" href="public/css/header.css">
    <link rel="stylesheet" href="public/css/login.css">
</head>
<body>
    <?php require "parts/header.php"; ?>
    <div class="sides">
        <div id="left" class="side">
            <h1>Login</h1>
            <form id="login">
                <input type="text" name="username" placeholder="username/email" required>
                <input type="password" name="password" placeholder="password" required>
                <input type="reset" class="btn-hover">
                <input type="submit" class="btn-hover">
            </form>
            <h2>Change to Sign Up >></h2>
        </div>
        <div id="right" class="side">
            <h1>Sign up</h1>
            <form id="signup">
                <div class="tooltip">
                    <input type="text" name="username" placeholder="username" maxlength="32" required>
                    <span class="tooltiptext">
                        Min 4 es Max 32 karakter hosszu lehet
                    </span>
                </div>
                <div class="tooltip">
                    <input type="email" name="email" placeholder="email" maxlength="64" required>
                    <span class="tooltiptext">
                        Legyen szabvanyos email<br>
                        Max 64 karakter hosszu lehet
                    </span>
                </div>
                <div class="tooltip">
                    <input type="password" name="password" placeholder="password" maxlength="32" required>
                    <span class="tooltiptext">
                        Min 8 es Max 32 karakter hosszu lehet<br>
                        Egyezen meg a 2 jelszo
                    </span>
                </div>
                <div class="tooltip">
                    <input type="password" name="repassword" placeholder="password again" maxlength="32" required>
                    <span class="tooltiptext">
                        Egyezen meg a 2 jelszo<br>
                    </span>
                </div>
                
                <span class="d-flex justify-center align-items-center">
                    <input type="checkbox" name="aszf" id="aszf" class="fit-content"  required> <label for="aszf">elfogadom az <strong>ASZF</strong>-et</label>
                </span>
                <input type="reset" class="btn-hover">
                <input type="submit" class="btn-hover">
            </form>
            <h2><< Change to Login</h2>
        </div>
    </div>

    <form id="logout">
        <input type="submit" value="Fake Login">
    </form>

    
    <script src="<?php echo $ROOT_DIR; ?>/public/js/auth.js"></script>
</body>
</html>
<header>
    <script>
        const basePath = "<?php echo $ROOT_DIR; ?>"
    </script>
    <ul>
        <li class="flex-start w-fit-content">
            <div class="leftNavOpenBtn" id="swiperOpenButton"> 
                ☰
            </div>

            <a href="<?php echo $ROOT_DIR; ?>/">
                <img src="<?php echo $ROOT_DIR; ?>/public/img/logo.png" alt="logo" class="logo highlight">
            </a>
        </li>
        <li>
            <div class="w-100">
                <form method="GET" class="position-relative w-80 m-auto" >
                    <img src="<?php echo $ROOT_DIR; ?>/public/svg/search.svg" alt="" id="search-button">
                    <div class="round-10">
                        <input type="text" name="search" class="round-10 border-0 highlight" id="search-bar">
                    </div>
                </form>
            </div>
            
        </li>
        <li class="flex-end w-fit-content">
            <?php if( !isset($_SESSION['user']) ):?> 
                <input type="button" value="Sign in" class="btn round-10 border-0 btn-hover" onclick="redirect('<?php echo $ROOT_DIR; ?>/auth')">
            <?php else:?>
                <div class="position-relative" id="account-container">
                    <img src="<?php echo $ROOT_DIR; ?>/public/svg/person-fill-black.svg" alt="" id="account-btn" onClick="showAccountOptions()">
                    <div class="position-absolute hidden" id="account-dropdown">
                        <div><a href="<?php echo $ROOT_DIR; ?>/user/<?php echo $_SESSION['user']['id']; ?>">Profil</a></div>
                        <div><a href="<?php echo $ROOT_DIR; ?>/settings">Settings</a></div>
                        <div><a href="<?php echo $ROOT_DIR; ?>/logout">Logout</a></div>
                    </div>
                </div>
            <?php endif ?>
            <!--<img src="/public/img/logo.png" alt="" srcset="" class="logo">-->
        </li>
    </ul>
    <script src="<?php echo $ROOT_DIR; ?>/public/js/header.js"></script>
</header>
<?php require "notification.php"; ?>
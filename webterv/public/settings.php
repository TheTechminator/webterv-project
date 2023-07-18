<?php

    if(!isset($_SESSION["user"]))
        header("Location: $ROOT_DIR/");

    $uth = new UsersTableHandler($_SESSION["user"]["id"]);

    $uth->updateData();
    $uth->deleteUser();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php require "parts/head.php"; ?>
    <link rel="stylesheet" href="<?php echo $ROOT_DIR; ?>/public/css/header.css">
    <link rel="stylesheet" href="<?php echo $ROOT_DIR; ?>/public/css/settings.css">
    <title>Document</title>
</head>
<body>
    <?php require "parts/header.php"; ?>

    <main class="user-settings-main">
        <div class="settings-intro">
            <h3>Ezen az oldalon lehetősége van önnek módosítani az adatait.</h3>
            <p>
                Egyes adatok mellet, mint pl.: Teljes név, található egy jelölőnégyzet melynek bejelölésével az ön adott adatát
                mások is megtekinthetik. Ha nem szeretné, hogy mások is láthassák az adatait, vegye ki a pipákat az egyes jelölő négyzetekből.
            </p>

            <i>
                A felhasználónév és jelszó módosítására jelenleg nincs lehetőség.
            </i>
        </div>

        <div class="user-settings-container">
            <div class="user-profile-preview">
                <div id="user-profile-img">
                    <img src="<?php echo $ROOT_DIR; ?>/public/svg/person-fill-white.svg" alt="User image" title="User image">
                </div>
                
                <?php 
                    if($uth->isPublic("name")) {
                        echo "<div id='user-fullname'><strong>{$uth->getData('name')}</strong></div>";
                    }

                    if($uth->isPublic("username")) {
                        echo "<div id='user-email'>Felhasználónév: {$uth->getData('username')}</div>";
                    }

                    if($uth->isPublic("email")) {
                        echo "<div id='user-email'>Email: {$uth->getData('email')}</div>";
                    }

                    if($uth->isPublic("mobile")) {
                        echo "<div id='user-email'>Telefon: {$uth->getData('mobile')}</div>";
                    }

                    if($uth->isPublic("description")) {
                        echo "<div id='user-info-title'>Rólam</div>";
                        echo "<div id='user-info'><q>{$uth->getData('description')}</q></div>";
                    }
                ?>
            </div>

            <div class="user-profile-settings">
                <form id="settings" method="POST">
                    <fieldset>
                        <legend>Személyes adatok</legend>

                        <div class="input-container input-left-col">
                            <label for="name_public">
                                Teljes név: 
                                <input type="checkbox" class="data-public-indicator" name="name_public" id="name_public" <?php $uth->writePublicIndicator('name_public'); ?>>
                            </label>
                            <input type="text" id="fullName" name="name" placeholder="Teljes név" value="<?php echo $uth->getData("name"); ?>">
                        </div>

                        <div class="input-container input-right-col">
                            <label for="mobile_public">
                                Telefonszám:
                                <input type="checkbox" class="data-public-indicator" name="mobile_public" id="mobile_public" <?php $uth->writePublicIndicator('mobile_public'); ?>>
                            </label>
                            <input type="tel" id="phone" name="mobile" placeholder="Telefonszám" value="<?php echo $uth->getData("mobile"); ?>">
                        </div>

                        <!--div class="input-container input-profile-pic">
                            <label for="profile-pic">Profilkép:</label>
                            <input type="file" id="profile-pic" name="profile-pic" title="Alma">
                        </-div-->
                    </fieldset>

                    <fieldset>
                        <legend>Bemutatkozás</legend>
                        <div class="textarea-container">
                            <label for="description_public">
                                Bemutatkozó szöveg:
                                <input type="checkbox" class="data-public-indicator" name="description_public" id="description_public" <?php $uth->writePublicIndicator('description_public'); ?>>
                            </label>
                            <textarea name="description" id="description" rows="10" placeholder="Néhány mondatban foglald össze mit érdemes tudni rólad"><?php echo $uth->getData("description"); ?></textarea>
                        </div>
                    </fieldset>

                    <fieldset>
                        <legend>Belépési adatok</legend>
                        <div class="input-container input-left-col">
                            <label for="email_public">
                                Email:
                                <input type="checkbox" class="data-public-indicator" name="email_public" id="email_public" <?php $uth->writePublicIndicator('email_public'); ?>>
                            </label>
                            <input type="email" id="email" name="email" placeholder="Email" value="<?php echo $uth->getData("email"); ?>">
                        </div>

                        <div class="input-container input-right-col">
                            <label for="username_public">
                                Felhasználónév:
                                <input type="checkbox" class="data-public-indicator" name="username_public" id="username_public" <?php $uth->writePublicIndicator('username_public'); ?>>
                            </label>
                            <input type="text" id="user-name" name="username" placeholder="Felhasználónév" value="<?php echo $uth->getData("username"); ?>" disabled>
                        </div>

                        <div class="input-container input-left-col">
                            <label for="password">Jelszó:</label>
                            <input type="password" id="password" name="password" placeholder="Jelszó" disabled>
                        </div>

                        <div class="input-container input-right-col">
                            <label for="password2">Jelszó újra:</label>
                            <input type="password" id="password2" name="password2" placeholder="Jelszó újra" disabled>
                        </div>
                    </fieldset>

                    <fieldset class="newsletter-container">
                        <legend>Hírlevél</legend>
                        <label>Szeretnél kapni hírleveleket?</label>
                        <div>
                            <input type="radio" id="newsletter-yes" name="newsletter" <?php echo $uth->getData("newsletter") ? "checked" : ""; ?> value="1"> <label for="newsletter-yes">Igen, ki nem hagynám</label>
                        </div>

                        <div>
                            <input type="radio" id="newsletter-no" name="newsletter" <?php echo $uth->getData("newsletter") ? "" : "checked"; ?> value="0"> <label for="newsletter-no">Nem, szeretek lemaradni mindenről</label>
                        </div>
                    </fieldset>

                    <div class="action-buttons">
                        <input type="hidden" name="update_data" value="1">
                        <input type="reset" class="btn-hover" value="Mégsem">
                        <input type="submit" class="btn-hover" value="Mentés">
                    </div>
                </form>

                <form id="delete_user" method="POST">
                    <fieldset class="delete-user-fieldset">
                        <legend>Profil törlése</legend>
                        <p class="warning">
                            Ha törli a profilját, tudjon róla, hogy később nem lehet vissza állítani!
                        </p>

                        <span>
                            Azonban bármikor létrehozhat egy új profilt.
                        </span>
                        
                        <div class="action-buttons">
                            <input type="submit" class="btn-hover btn-delete" name="user_delete" value="Profil törlése">
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </main>

    <?php require "parts/footer.php"; ?>
</body>
</html>
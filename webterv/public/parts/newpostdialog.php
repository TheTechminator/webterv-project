<div class="dialog-container" id="newPostDialog">
    <div class="dialog">
        <span class="dialog-close-btn" id="closeNewPostDialog">✕</span>

        <p class="dialog-title">
            Írjon egy új posztot egy ön által kiválasztott fórumhoz.
        </p>

        <p class="dialog-info">
            Amennyiben egy teljesen új fórumra lenne szüksége létrehozhat egyet 
            a főoldalon található <b>Fórum létrehozás</b> gomb segítségével.
        </p>

        <form class="dialog-form" id="newPostForm">
            <fieldset>
                <legend>Poszt létrehozása</legend>
                <label for="postTitle">Poszt címe:</label>
                <input type="text" name="postTitle" id="postTitle" maxlength="64" placeholder="Poszt címe (max 64 karakter hosszu)" required>

                <label for="postDescription">Poszt leírása:</label>
                <textarea name="postDescription" id="postDescription" cols="30" rows="10" maxlength="2048" placeholder="Írja meg a post szövegét. (max 2048 karakter hosszu)" required></textarea>

                <label for="forumIDs">Válassza ki melyik fórumhoz kíván posztot írni.</label>
                <select name="forumIDs" id="forumIDs">
                    <?php
                        $stmt = $pdo->prepare("SELECT forums.id, forums.name FROM `forums`");
                        $stmt->execute();
                        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                    ?>
                        <option value="<?php echo $row['id'];?>"><?php echo $row['name'];?></option>
                    <?php } ?>
                </select>
            </fieldset>

            <input class="dialog-submit-btn" type="submit" value="Létrehozás">
        </form>
    </div>
</div>

<script>
    window.addEventListener("load", (e) => {
        let newForumDialog = new PopupDialog({
            openBtId: "newPostButton",
            closeBtId: "closeNewPostDialog",
            containerId: "newPostDialog",
            formId: "newPostForm",
            submitEventCallback: (event) => {
                event.preventDefault();
                //console.log("post submit");
                let t = event.target
                console.log(t);
                let json = new URLSearchParams({
                    type: "post",
                    userID: <?php echo $_SESSION['user']['id'];?>,
                    forumID: t.forumIDs.value,
                    title: encodeURIComponent(t.postTitle.value),
                    description: encodeURIComponent(t.postDescription.value)
                })
                console.log(json);
                handleRequest(e, `${basePath}/api/addData`, json, ()=>redirect(basePath+"/"), (p)=>{
                    setNotification(p.msg[0])
                    showNotification()
                })
            }
        })
    });
</script>
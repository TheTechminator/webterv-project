<div class="dialog-container" id="newForumDialog">
    <div class="dialog">
        <span class="dialog-close-btn" id="closeNewForumDialog">✕</span>

        <p class="dialog-title">
            Hozzon létre egy teljesen új fórumot.
        </p>

        <p class="dialog-info">
            Amennyiben csak egy posztot szeretne létrehozni egy már meglévő fórumhoz
            válassza a <b>Post létrehozása</b> gombot a főoldalon.
        </p>

        <form method="POST" class="dialog-form" id="newForumForm">
            <fieldset>
                <legend>Fórum létrehozása</legend>
                <label for="forumName">Fórum neve:</label>
                <input type="text" name="forumName" id="forumName" maxlength="64" placeholder="Fórum neve (max 64 karakter hosszu)" required>

                <label for="forumDescription">Fórum leírása:</label>
                <textarea name="forumDescription" id="forumDescription" cols="30" rows="10" maxlength="2048" placeholder="Miről lenne szó az adott fórumon? (max 2048 karakter hosszu)" required></textarea>
            </fieldset>

            <input class="dialog-submit-btn" type="submit" value="Létrehozás">
        </form>
    </div>
</div>

<script>
    window.addEventListener("load", (e) => {
        let newForumDialog = new PopupDialog({
            openBtId: "newForumButton",
            closeBtId: "closeNewForumDialog",
            containerId: "newForumDialog",
            formId: "newForumForm",
            submitEventCallback: (event) => {
                event.preventDefault();                
                let t = event.target
                let json = new URLSearchParams({
                    type: "forum",
                    userID: <?php echo $_SESSION['user']['id'];?>,
                    title: encodeURIComponent(t.forumName.value),
                    description: encodeURIComponent(t.forumDescription.value)
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
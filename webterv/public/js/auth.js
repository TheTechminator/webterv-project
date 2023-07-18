        const $ = (param) => document.querySelector(param)
        const $$ = (param) => document.querySelectorAll(param)

        let state = false;
        let isMobil = document.body.offsetWidth <= 620;
        const changeMenu = () => {
            if(!isMobil){
                $(".sides").style = ""
                state = false
                return;
            } 
            //$("#logo").style = `transform: translateX(${!state ? "-125%":"75%"})`;
            $(".sides").style = `transform: translateX(${state ? "-50%":"50%"})`;
        }
        window.addEventListener("resize", (e)=>{
            isMobil = document.body.offsetWidth <= 620
            changeMenu()
        })
        $$("h2").forEach((elem)=>{
            elem.style = "color: red";
            elem.addEventListener("click", (e)=>{
                state = !state
                changeMenu()
            })
        })

        $("#signup").addEventListener("submit", (e) => {
            e.preventDefault()
            t= e.target
            let json = new URLSearchParams({
                form_name: "signup",
                username: t.username.value,
                email: t.email.value,
                password: t.password.value,
                repassword: t.repassword.value
            })
            
            handleRequest(e, "user_auth", json, ()=> redirect(basePath+"/"),
            (p)=>{
                setNotification(p.msg[0])
                showNotification()
            })
        })
        $("#login").addEventListener("submit", (e) => {
            e.preventDefault()
            t = e.target
            let json = new URLSearchParams({
                form_name: "login",
                username: t.username.value,
                password: t.password.value
            })

            handleRequest(e, "user_auth", json, ()=> redirect(basePath+"/"),
            (p)=>{
                setNotification(p.msg[0])
                showNotification()
            })
        })
        logout.addEventListener("submit", (e) => {
            e.preventDefault()
            let json = new URLSearchParams({
                value: e.target.value
            })
            fetch("logout",{
                method: 'POST',
                mode: 'cors',
                body: json
            })
            .then(res => res.text())
            .then(res => {
                //if(res.is)
                console.log(res)
            })
            
        })


        
        changeMenu()
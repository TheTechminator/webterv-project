const redirect = (param) => window.location.href = param
$ = (param) => document.querySelector(param)
$$ = (param) => document.querySelectorAll(param)

const notificationKeyframe = [
    { top: "-10px" },
    { top: "80px" },
]
  
const notificationOptions = (length) => {
length*=1000
    return {    
        duration: length,
        iterations: 1,
    }
}

function showAccountOptions(){
    let ad = $("#account-dropdown")
    let ac = $("#account-container");
    let length = 1

    ac.style = `animation: forog ${length}s linear 0s 1`;
    setTimeout(() => {
        if(ad.classList.contains("hidden")){
        ad.classList.remove("hidden")
        }else{
            ad.classList.add("hidden")
        }
    }, length*500);
    setTimeout(() => {
        ac.style = ""
    }, length*1000);
}
async function handleRequest (source, target, data, succesFN=()=>{}, failFN=()=>{}) {
    fetch(target ,{
        method: 'POST',
        mode: 'cors',
        body: data
    })
    .then(res => res.text())
    .then(res => {
        let r
        try{
            r = JSON.parse(res)
        } catch(e){
            r = res
        }
        return r
    })
    .then(res => {
        console.log(res)
        if(res.constructor.name == "Object")  
            if(res.type == "success"){
                succesFN()
            }else{
                failFN(res)
            }
        else
            console.log(res)
    })
}
function showNotification(){
    let id = 0
    activeNotification = id = Date.now()

    noti = $(".notification")
    animLength = 0.5
    showLength = 4
    noti.classList.remove("hidden")
    noti.style = ""
    noti.animate(notificationKeyframe, notificationOptions(animLength))
    startTime = Date.now()
    interval = setInterval(()=>{
        $(".notification-body progress").value = (Date.now()-startTime)/showLength/10
    }, 10)
    setTimeout(()=>{
        clearInterval(interval)
        if(id == activeNotification){
            noti.animate(notificationKeyframe, notificationOptions(animLength)).reverse()
            setTimeout(()=>{
                if(id == activeNotification) noti.classList.add("hidden")
            },(animLength)*1000-10)
        }
    },showLength*1000)
}
function setNotification(message){
    noti = $(".notification-message")
    noti.innerText = message
}
console.log("Header loaded")
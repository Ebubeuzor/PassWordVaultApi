
let social_name = document.getElementById("social_name");
let user_name = document.getElementById("user_name");
let userPassword = document.getElementById("userPassword");
let userID = document.getElementById("userID");
let btn2 = document.getElementById("btn2");


document.addEventListener('DOMContentLoaded', requestUserSocialsInfo);

async function requestUserSocialsInfo() {

    try {
        let resource = getQueryStringParam('userSoicalID');

        function getQueryStringParam(name) {
            let url = window.location.search;
            name = name.replace(/[\[\]]/g, '\\$&');
            let regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)');
            let results = regex.exec(url);
            if (!results) return null;
            if (!results[2]) return '';
            return decodeURIComponent(results[2].replace(/\+/g, ' '));
        }
        
        
        let res3 = await fetch(`http://localhost/PassWordGenerator/zbackend/userSocialsInfo.php?userSoicalID=${resource}`,{
            credentials:'include',
            method:"GET",
        });

        let sttus3 = res3.status;

        const data = await res3.json();

        if (sttus3 == 200) {
            social_name.value = data.social_media;
            user_name.value = data.username;
            userPassword.value = data.password;
            userID.value = data.id;
        }

        
        ///////////////////////////// to auth a user
        
        let res2 = await fetch("http://localhost/PassWordGenerator/zbackend/authenticate.php",{
            credentials:'include',
            method:"POST",
        });

        const sttus4 = res2.status;

        const data2 = await res2.json();

        if (sttus4 != 200) {
            location.href = data2.location;
        }
    }catch(error){
        console.log(error);
    }
}

btn2.addEventListener('click', async function() {
    
    const formData = new FormData(document.querySelector('form'));
    
    let res = await fetch("http://localhost/PassWordGenerator/zbackend/userSocialsInfo.php",{
        method:"POST",
        body:formData,
        credentials: 'include'
        });

    sttus = res.status;

    let data = await res.text();

    server_error.innerText = data;
    
    if (sttus == 200) {
        location.href = "PasswordVault.html";
    }

})
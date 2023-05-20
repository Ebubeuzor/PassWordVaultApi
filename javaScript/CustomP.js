
const btn2 = document.getElementById("btn2");
const userPassword = document.getElementById("userPassword");
const server_error = document.getElementById("server_error");

let sttus;

btn2.addEventListener('click', async function() {
    
    const formData = new FormData(document.querySelector('form'));
    
    let res = await fetch("http://localhost/PassWordGenerator/zbackend/Models.php",{
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

});

document.addEventListener('DOMContentLoaded', requestUserInfo);

async function requestUserInfo() {

    try {
        let res = await fetch("http://localhost/PassWordGenerator/zbackend/userinfo.php",{
        method:"POST",
        credentials: 'include'
        });

        let sttus2 = res.status;

        let data = await res.json();
        userPassword.value = data.user_social_password;

        ///////////////////////////////////////////////// to auth a user

        let res2 = await fetch("http://localhost/PassWordGenerator/zbackend/authenticate.php",{
            credentials:'include',
            method:"POST",
        });

        let sttus3 = res2.status;

        const data2 = await res2.json();

        if (sttus3 != 200) {
            location.href = data2.location;
        }

    }catch(error){
        console.log(error);
    }
}
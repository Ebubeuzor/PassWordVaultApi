const output = document.getElementById("output");
const firstname = document.getElementById("firstname");
const lastname = document.getElementById("lastname");
const email = document.getElementById("email");
const btn2 = document.getElementById("btn2");
const server_error = document.getElementById("server_error");

let sttus;
document.addEventListener('DOMContentLoaded', requestUserInfo);

async function requestUserInfo() {

    try {
        let res = await fetch("http://localhost/PassWordGenerator/zbackend/userinfo.php",{
        method:"POST",
        credentials: 'include'
        });

        sttus = res.status;

        let data = await res.json();

        output.src = 'zbackend/' + data.image
        firstname.value = data.firstname 
        lastname.value = data.lastname 
        email.value = data.email 

        ///////////////////////////// to auth a user

        let res2 = await fetch("http://localhost/PassWordGenerator/zbackend/authenticate.php",{
            credentials:'include',
            method:"POST",
        });

        const sttus3 = res2.status;

        const data2 = await res2.json();

        if (sttus3 != 200) {
            location.href = data2.location;
        }
        
    } catch (error) {
        console.log(error);
    }
}

btn2.addEventListener('click', async function() {
    try {
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
    } catch (error) {
        console.log(error);
    }
    

})
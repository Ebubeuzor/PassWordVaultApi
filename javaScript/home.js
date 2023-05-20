let getStarted = document.querySelector(".getStarted");
let sttus;

getStarted.addEventListener('click', async function(){
    try {
        let res = await fetch("http://localhost/PassWordGenerator/zbackend/authenticate.php",{
            credentials:'include',
            method:"POST",
        });

        sttus = res.status;

        const data = await res.json();

        if (sttus == 200) {
            location.href = "PasswordVault.html";
        }else{
            location.href = data.location;
        }
    } catch (error) {
        console.log(error);
    }
    

});
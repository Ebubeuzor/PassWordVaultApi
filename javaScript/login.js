const submitBTN = document.getElementById('submitBTN');
let server_error = document.getElementById('server_error');

submitBTN.addEventListener('click', async function(){
    try {
        const formData = new FormData(document.querySelector('form'));

        const res = await fetch("http://localhost/PassWordGenerator/zbackend/Models.php",{
            method:'POST',
            body:formData,
            credentials:'include',
        });

        sttus = res.status;

        const data = await res.text();

        server_error.innerHTML = data;

        if (sttus == 200) {
            location.href = "PasswordVault.html";
        }
    } catch (error) {
        console.log(error);
    }
    

});








let sttus;

document.addEventListener('DOMContentLoaded', authenticateUser);

async function authenticateUser() {
    try {
        let res = await fetch("http://localhost/PassWordGenerator/zbackend/authenticate.php",{
            credentials:'include',
            method:"POST",
        });

        sttus = res.status;

        const data = await res.json();

        if (sttus != 200) {
            location.href = data.location;
        }
    } catch (error) {
        console.log(error);
    }
        
    
};

class work{
    constructor(){

    }

   async copyM(){
        
        var text=document.getElementById("password").value;
        
            try{
                await navigator.clipboard.writeText(text);
                alert('copied to clipboard 👌')

            }catch(err){
                console.log('Failed to copy:',err)
            }
        
      
      

    }

    outFunc(){
        // var tooltip=document.getElementById('myTooltip').innerHTML='Copy to clipboard';
    
    }
    
   


}


const pass_btn = document.getElementById('pass_btn');

pass_btn.addEventListener('click', async function () { 
    const formData = new FormData(document.querySelector('form'));

    let res = await fetch("http://localhost/PassWordGenerator/zbackend/userSocials.php",{
        method:"POST",
        body:formData,
        credentials: 'include'
    });

    let sttus2 = res.status;

    const data = await res.text();

    if (sttus2 == 200) {
        location.href = "CustomP.html";
    }
});

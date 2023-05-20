let output = document.getElementById('output');
let username = document.getElementById('username');
let authenticate = document.getElementById('authenticate');
let userSoical_Con = document.getElementById('userSoical_Con');
let logout_btn = document.getElementById('logout_btn');
let user_social_form_class = document.querySelector('.user_social_form_class');



logout_btn.addEventListener('click', async function(){
    try {
        const res = await fetch("http://localhost/PassWordGenerator/zbackend/Models.php",{
            method:'POST',
            credentials:'include',
        });

        const sttus1 = res.status;

        const data = await res.text();

        authenticate.innerText = data;

        if (sttus1 == 200) {
            location.href = "SignIn.html";
        }

    } catch (error) {
        console.log(error);
    }
    

});

document.addEventListener('DOMContentLoaded', requestUserInfo);

async function requestUserInfo() {

    try {

        
        let res3 = await fetch("http://localhost/PassWordGenerator/zbackend/authenticate.php",{
            credentials:'include',
            method:"POST",
        });

        const sttus3 = res3.status;

        const data3 = await res3.json();

        if (sttus3 != 200) {
            location.href = data3.location;
        }
        
        ///////////////////////////////////////////////////////////////////

        let res = await fetch("http://localhost/PassWordGenerator/zbackend/userinfo.php",{
        method:"POST",
        credentials: 'include'
        });

        const sttus4 = res.status;

        let data = await res.json();

        output.src = 'zbackend/'+data.image
        username.innerText = data.firstname + " " + data.lastname 

        ///////////////////////////////////////////////////////////////////

        let res2 = await fetch("http://localhost/PassWordGenerator/zbackend/userSocials.php",{
            method:"POST",
            credentials: 'include'
        });

        const sttus5 = res2.status;
        
        let data2 = await res2.json();
        
        let all_user_socials_data = data2.values;

        let main_div = document.createElement('div');
        main_div.className = "all_user_socials_info";

        all_user_socials_data.forEach((userData) => {
            userSocialsHTML(userData,main_div);
        });    
        userSoical_Con.appendChild(main_div)


        
        ///////////////////////////// to auth a user
        
        let res4 = await fetch("http://localhost/PassWordGenerator/zbackend/authenticate.php",{
            credentials:'include',
            method:"POST",
        });

        const userSttus = res4.status;

        const data4 = await res4.json();

        if (userSttus != 200) {
            location.href = data4.location;
        }
        
        var td4=document.querySelector('.copy_image_con');
        td4.addEventListener('click',function(){
        let text= td4.previousElementSibling.innerHTML;
        copyM(text);
        



    });

        
    } catch (error) {
        console.log(error);
    }


}


const userSocialsHTML = function (user,main_div) { 
    let tr1 = document.createElement('div');
    tr1.className = "div_class";


    let form = document.createElement('form');
    form.className = "user_social_form_class";
    form.method = 'POST';
    
    let input2 = document.createElement('input');
    input2.className = "deleteSocials";
    input2.type = "hidden";
    input2.value = user.id;
    input2.name = "social_id";

    let td1 = document.createElement('div');
    td1.className = "socialname";
    td1.innerText = user.social_media
    
    
    let td2 = document.createElement('div');
    td2.className = "social_user_name";
    td2.innerText = user.user_name
    
    
    let td3 = document.createElement('div');
    td3.className = "social_password";
    td3.innerText = user.password


    let td4 = document.createElement('div');
    td4.className = "copy_image_con";
    
    let img1 = document.createElement('img');
    img1.className = "copy_image";
    img1.src = "images/OIP.png"
    td4.appendChild(img1);
   

    
   
    

    let td5 = document.createElement('div');
    td5.className = "edit_data_con";

    let a = document.createElement('a');
    a.href = `EditUserSocials.html?userSoicalID=${input2.value}`;

    let img2 = document.createElement('img');
    img2.className = "edit_data";
    img2.src = "images/pencil-removebg-preview.png"
    a.appendChild(img2);
    td5.appendChild(a);
    
    let td6 = document.createElement('div');
    td5.className = "delete_btn_con";
    
    let button = document.createElement('button');
    button.className = "delete_btn";
    button.type = "submit";
    
    let img3 = document.createElement('img');
    img3.className = "delete_btn_img";
    img3.src = "images/trash-removebg-preview.png";
    button.appendChild(img3);
    td6.appendChild(button);
    
    form.appendChild(input2);
    form.appendChild(td1);
    form.appendChild(td2);
    form.appendChild(td3);
    form.appendChild(td4);
    form.appendChild(td5);
    form.appendChild(td6);
    form.addEventListener('submit', (e) => { 
        e.preventDefault();
        let formData = new FormData(form);
        deleteFunction(formData);
    });
    tr1.appendChild(form);
    main_div.appendChild(tr1);
    td4.addEventListener('click',function(){
        let text= td4.previousElementSibling.innerHTML;
        copyM(text);

      

    })
}

let deleteFunction = async function(formData){
    try {
        
        // const formData = new FormData(document.querySelector('form'));
        const res = await fetch("http://localhost/PassWordGenerator/zbackend/deleteSocials.php",{
            method:'POST',
            body:formData,
            credentials:'include',
        });

        let sttus7 = res.status;

        if (sttus7 == 200) {
            location.href = "PasswordVault.html";
        }

    } catch (error) {
        console.log(error);
    }
    
}

async function copyM(text){
        
        try{
            await navigator.clipboard.writeText(text);
            alert('copied to clipboard 👌')

        }catch(err){
            console.log('Failed to copy:',err)
        }
        console.log("copied")
  
  

}


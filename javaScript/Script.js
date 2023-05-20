function gen(){
	var Plength=document.getElementById('Plen').value;
	var upp=document.getElementById("num").checked==true;
	var Num2=document.getElementById("aNum").checked==true;
	var low=document.getElementById("aChar").checked==true;
	var symb=document.getElementById("aNumchar").checked==true;
	c_olor(Plength);
	



		if (upp&&!low&&!Num2&&!symb) {
			
		   Printer(U_case(Plength));
		
		}else if (low&&!upp&&!Num2&&!symb){

			Printer(L_case(Plength));	

		}else if(Num2&&!low&&!upp&&!symb){

			 Printer(Num(Plength));

		}else if(symb&&!low&&!Num2&&!upp){

			 Printer(Sybmol(Plength));

		}else if(upp&&low&&Num2&&symb){

			ALL_P(Plength);

		}else if(upp&&low){
		   if (symb&&!Num2) {
			   Triple(Sybmol(Plength),U_case(Plength),L_case(Plength));

		   }else if(Num2&&!symb){
				 Triple(Num(Plength),U_case(Plength),L_case(Plength));

		   }else{
			   low_Upp(U_case(Plength),L_case(Plength));
		   }
		
		
		}else if(Num2&&symb){
			 if (upp&&!low) {
			   Triple(U_case(Plength),Num(Plength),Sybmol(Plength));

		   }else if(low&&!upp){
				 Triple(Num(Plength),Sybmol(Plength),L_case(Plength));

		   }else{
			   low_Upp(Num(Plength),Sybmol(Plength));
		   }
	   }else if(low&&Num2&&!upp&&!symb){
		   low_Upp(L_case(Plength),Num(Plength));

	   }else if(symb&&upp&&!Num2&&!low){
   
		   low_Upp(U_case(Plength),Sybmol(Plength));

	   }else if(upp&&Num2&&!low&&!symb){
		   low_Upp(U_case(Plength),Num(Plength));


	   }else if (low&&symb&&!Num2&&!upp) {
		   low_Upp(L_case(Plength),Sybmol(Plength));

	   }

	


}

function U_case(Len){
	
	var result="";

	var bet="ABCDEFGHIJKLMNOPQRSTUVWXYZ";

		for (var i=0;i<Len;i++){
	   result += bet.charAt(Math.floor(Math.random()*bet.length));

	}

	// document.getElementById("password").innerHTML=result;
	return result;
}

 function L_case(Len){
	
	var result="";
	var et="abcdefghijklmnopqrstuvwxyz";


		for (var i=0;i<Len;i++){
	   result += et.charAt(Math.floor(Math.random()*et.length));

	
	}
	// document.getElementById("password").innerHTML=result;
	return result;
}

 function Num(Len){
	
	var result="";

	var bet="0123456789";

		for (var i=0;i<Len;i++){
	   result += bet.charAt(Math.floor(Math.random()*bet.length));

	
	}
	// document.getElementById("password").innerHTML=result;
   return result
}

function Sybmol(Len){

	var result="";

	var bet="@#_-?/|!><~$:";

		for (var i=0;i<Len;i++){
	   result += bet.charAt(Math.floor(Math.random()*bet.length));

	
	}
	// document.getElementById("password").innerHTML=result;
   return result;

}

function ALL_P(len){
	var result="";

	var general="ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz@#_-?/|!";
   
   for (var i=0;i<len;i++){
	   result += general.charAt(Math.floor(Math.random()*general.length));

	
	}
		document.getElementById("password").value=result;
}


function low_Upp(typ1,typ2){
	var result = '';
	var mix=typ1.concat(typ2);
	var size=mix.length/2;


   for (var i=0;i<size;i++){

	
	   result+=mix.charAt(Math.floor(Math.random()*mix.length));
	}
		
	
	document.getElementById("password").value=result;
}



function Printer(val){

   document.getElementById("password").value=val;

}

function c_olor(output){
	   if (output<=6) {
				   document.getElementById("password").style.color="red";
			   }else if (output>=7&&output<=10) {
				   document.getElementById("password").style.color="orange";
			   }else{
				   document.getElementById("password").style.color="Green";
			   }
}


function Triple(typ1,typ2,typ3){
   var result = '';

   var mix=(typ1).concat(typ2,typ3);
   var size=mix.length/3;


   for (var i=0;i<size;i++){

   
	   result+=mix.charAt(Math.floor(Math.random()*mix.length));
	}
	   
   
   document.getElementById("password").value=result;}




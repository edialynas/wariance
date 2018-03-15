

var httpConn = new XMLHttpRequest(); // klish me http kai pairnei ena xml
httpConn.open("GET","php/Stats.php",false);
httpConn.send(null);
var text = httpConn.responseText;
text2 = text.split("_");
var Users = text2[0];
var Insti = text2[1];

//  ====================== ACTIVATION =================================


var nameHash = "";
var nameHash = location.hash.replace("#","");

if (nameHash!=""){
    var ac = "";
    // alert(nameHash);
    httpConn.open("GET","php/Activation.php?code="+nameHash,false);
    httpConn.send(null);
    ac = httpConn.responseText;
    // alert(ac);
    if(ac=="Activated"){
    alert("Activation Successful !!");}
    if(ac=="NO"){
    // alert("There is not such Activation key");
    }
}



function validateEmail(email) {
  var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return re.test(email);
}

function validate(mailid,BtnName,BtnName2) {
  var email = document.getElementById(mailid).value;
  if (validateEmail(email)) {
    document.getElementById(mailid).style.color = "green"
    document.getElementById(BtnName).disabled = false;
    document.getElementById(BtnName2).disabled = false;
  } else {
    document.getElementById(mailid).style.color = "red"
    document.getElementById(BtnName).disabled = true;
    document.getElementById(BtnName2).disabled = true;
  }
  return false;
}



//  ===================================================================


// ==================== REGISTRATION FUNCTION =========================

function RegSQL(){
    var c = "";
    var z = "";
    var Email = document.getElementById("email").value;

    var Fname = document.getElementById("FNameid").value;
    var Lname = document.getElementById("LNameid").value;
    var Insti = document.getElementById("Inst").value;
    var Cntr =  document.getElementById("Count").value;
  
    if (Email=="" || Fname=="" || Lname==""){
        document.getElementById("Ale1").style.display='none';
        document.getElementById("Ale2").style.display='none';
        document.getElementById("Ale3").style.display='block';
        return;
    }

    httpConn.open("GET","php/dbRequest1.php?FName="+Fname+"&LName="+Lname+"&email="+Email+"&Inst="+Insti+"&Count="+Cntr,false); // Me get pare to url pou sou lew
    httpConn.send(null);
    c = httpConn.responseText;
    z = c.charAt(0);
    if ( z=="0" ){
        document.getElementById("Ale1").style.display='none';
        document.getElementById("Ale2").style.display='block';
        document.getElementById("Ale3").style.display='none';}
    else{
        document.getElementById("Ale1").style.display='block';
        document.getElementById("Ale2").style.display='none';
        document.getElementById("Ale3").style.display='none';}
}
//  ===================================================================

//  ===================================================================

function LogSQL(){
    var lgres = "";
    var Email = document.getElementById("emaillg").value;
    var passw = document.getElementById("pwd").value;
    if (Email=="" || passw==""){
        document.getElementById("Ale4").style.display='none';
        document.getElementById("Ale5").style.display='none';
        document.getElementById("Ale6").style.display='block';
        document.getElementById("Ale7").style.display='none';
        document.getElementById("Ale8").style.display='none';
        return;
    }

    httpConn.open("GET","php/Login.php?email="+Email+"&pass="+passw,false);
    httpConn.send(null);
    lgres = httpConn.responseText;
    // alert(lgres);
    if (lgres=="error"){
        document.getElementById("Ale4").style.display='block';
        document.getElementById("Ale5").style.display='none';
        document.getElementById("Ale6").style.display='none';
        document.getElementById("Ale7").style.display='none';
        document.getElementById("Ale8").style.display='none';
        return;
    }
    if (lgres=="wrong"){
        document.getElementById("Ale4").style.display='none';
        document.getElementById("Ale5").style.display='block';
        document.getElementById("Ale6").style.display='none';
        document.getElementById("Ale7").style.display='none';
        document.getElementById("Ale8").style.display='none';
        return;
    }
    if (lgres=="no"){
        document.getElementById("Ale4").style.display='none';
        document.getElementById("Ale5").style.display='none';
        document.getElementById("Ale6").style.display='none';
        document.getElementById("Ale7").style.display='block';
        document.getElementById("Ale8").style.display='none';
        return;
    }
    else {
        window.location.pathname = "../Dashboard/dashboard.html";
        return;
    }
}
//  ===================================================================


function myClick(p00,p01,p10,p11,p20,p21,p30,p31) {
    document.getElementById(p00).style.display='block';
    document.getElementById(p01).style.display='block';
    document.getElementById(p10).style.display='none';
    document.getElementById(p11).style.display='none';
	document.getElementById(p20).style.display='none';
	document.getElementById(p21).style.display='none';
	document.getElementById(p30).style.display='none';
	document.getElementById(p31).style.display='none';
    document.getElementById("Ale1").style.display='none';
    document.getElementById("Ale2").style.display='none';
    document.getElementById("Ale3").style.display='none';
    document.getElementById("Ale4").style.display='none';
    document.getElementById("Ale5").style.display='none';
    document.getElementById("Ale6").style.display='none';
    document.getElementById("Ale7").style.display='none';
    document.getElementById("Ale8").style.display='none';
}

$('#changed').click(function(){$('#col-sm-3').show()})



// ======================= Scrollup Button ======================
// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        document.getElementById("myScrollUpBtn").style.display = "block";
    } else {
        document.getElementById("myScrollUpBtn").style.display = "none";
    }
}

// When the user clicks on the button, scroll to the top of the document
function topFunction() {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
}


function Forget(){
    var Frgres = "";
    var Email = document.getElementById("emaillg").value;
    if (Email==""){
        document.getElementById("Ale4").style.display='none';
        document.getElementById("Ale5").style.display='none';
        document.getElementById("Ale6").style.display='block';
        document.getElementById("Ale7").style.display='none';
        document.getElementById("Ale8").style.display='none';
        return;
    }

    httpConn.open("GET","php/Forget.php?email="+Email,false);
    httpConn.send(null);
    Frgres = httpConn.responseText;
    // alert(Frgres);
    if (Frgres=="error"){
        document.getElementById("Ale4").style.display='block';
        document.getElementById("Ale5").style.display='none';
        document.getElementById("Ale6").style.display='none';
        document.getElementById("Ale7").style.display='none';
        document.getElementById("Ale8").style.display='none';
        return;
    }
    if (Frgres=="ok"){
        document.getElementById("Ale4").style.display='none';
        document.getElementById("Ale5").style.display='none';
        document.getElementById("Ale6").style.display='none';
        document.getElementById("Ale7").style.display='none';
        document.getElementById("Ale8").style.display='block';
        return;
    }
}
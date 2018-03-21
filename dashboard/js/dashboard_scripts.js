
// AUTHOR: Zacharias Papadovasilakis
// EMAIL:  zpapadov@hotmail.com

// ================== Global Dashboard Variables ================
// // Used to initialize a session without an actual login
// var httpConn = new XMLHttpRequest();
// httpConn.open("GET","php/start_session.php",false);
// httpConn.send(null);

var httpConn = new XMLHttpRequest();
httpConn.open("GET","php/welcome_user.php",false);
httpConn.send(null);
var username = httpConn.responseText;

// Some global variables
var fileID = "";
var destination="";

var analysisFID1 = "";
var analysisFID2 = "";
var analysisType = "";
// ==============================================================


// ======================= Welcome User =========================
window.onload = function dispUser() {
    document.getElementById("username").innerHTML = username;
}
// ==============================================================


// ========================= Logout User ========================
// ****** Check line 61 of dashboard.html for the valid homepage.html path ******
function logOut(link) {
	var httpConn = new XMLHttpRequest();
	httpConn.open("GET","php/logout.php",false);
	httpConn.send(null);

	window.location.replace(link);

}
// ==============================================================


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
// ==============================================================

// ========================= List Files =========================
function listFiles() {
	var httpConn = new XMLHttpRequest();
	httpConn.open("GET","php/list_files.php",false);
	httpConn.send(null);
	var fileTable = httpConn.responseText;

    document.getElementById("fileTable").innerHTML = fileTable;
}
// ==============================================================

// ======================= Preview Files ========================
function previewFile(fid) {
	var httpConn = new XMLHttpRequest();
	httpConn.open("GET","php/view_file.php?fileID="+fid,false);
	httpConn.send(null);
	var prevF = httpConn.responseText;

	document.getElementById("previewFile").innerHTML = prevF;
}

function reshowFile() {
	document.getElementById('reshow').style.display = 'block';
	document.getElementById('reshow').style.alignItems = 'flex-end';
}
// ==============================================================

// ======================= Delete Files =========================
function deleteFile(fid) {
	// Get the modal
	var modalFile = document.getElementById('myModalDeleteFile');

	// Get the element that deletes the file
	var proceed = document.getElementById("modalDelFileBtn");
	// Get the element that closes the modal
	var cancel = document.getElementById("cancelModalDelFileBtn");

	// When the user clicks the button, open the modal 
	modalFile.style.display = "block";

	fileID = fid;
}

function proceedDelFile() {
	
	var httpConn = new XMLHttpRequest();
	httpConn.open("GET","php/delete_file.php?fileID="+fileID,false);
	httpConn.send(null);	
	fileID = "";

	listFiles();

	content = document.getElementById("fileModalContent");

	// content.style.float = "center";
	content.innerHTML = "<h5>- DELETED -</h5>";
	content.style.color = "#009900";
	content.style.display = "flex";
	content.style.justifyContent = "center";

	setTimeout(function() {
		content.innerHTML = "<span><p style='color:black;'>Are you sure?</p>"+
							"<button type='button' class='btn btn-primary btn-xs' onclick='proceedDelFile()' style='background-color: #009900'>"+
          					"<span style='vertical-align: middle; display: inline-flex;' class='material-icons' id='modalDelFileBtn'>delete</span>&nbsp;&nbsp;Delete</span>"+
          					"</button>"+
							" <button type='button' class='btn btn-primary btn-xs' onclick='cancelDelFile()' style='background-color: #D3D3D3;color: black'>"+
          					"<span style='vertical-align: middle; display: inline-flex;' class='material-icons' id='cancelModalDelFileBtn'></span>Cancel</span>"+
          					"</button></span>";
		document.getElementById('myModalDeleteFile').style.display = "none";
	}, 1300);
}

function cancelDelFile() {
	document.getElementById("myModalDeleteFile").style.display = "none";
}

window.onclick = function(event) {
    if (event.target == document.getElementById('myModalDeleteFile')) {
        document.getElementById('myModalDeleteFile').style.display = "none";
    }
}
// ==============================================================

// ====================== Delete Account ========================
// ****** Check line 62 of dashboard.html for the valid homepage.html path ******
function deleteAccount(link) {
	// Get the modal
	var modalAccount = document.getElementById('myModalDeleteAccount');

	// Get the element that deletes the file
	var proceed = document.getElementById("modalDelAccountBtn");
	// Get the element that closes the modal
	var cancel = document.getElementById("cancelModalDelAccountBtn");

	// When the user clicks the button, open the modal 
	modalAccount.style.display = "block";


	destination = link;
}

function proceedDelAccount() {
	
	var httpConn = new XMLHttpRequest();
	httpConn.open("GET","php/delete_account.php",false);
	httpConn.send(null);


	content = document.getElementById("accountModalContent");
	content.innerHTML = "<h5>- DELETED -</h5>";
	content.style.color = "#009900";
	content.style.display = "flex";
	content.style.justifyContent = "center";	

	var path = document.location.pathname;
	// alert(path);

	setTimeout(function() {
		window.location.replace(destination);
		document.getElementById('myModalDeleteAccount').style.display = "none";

	}, 1500);
}

function cancelDelAccount() {
	document.getElementById("myModalDeleteAccount").style.display = "none";
}

window.onclick = function(event) {
    if (event.target == document.getElementById('myModalDeleteAccount')) {
        document.getElementById('myModalDeleteAccount').style.display = "none";
    } else if (event.target == document.getElementById('myModalDeleteFile')) {
    	document.getElementById('myModalDeleteFile').style.display = "none";
    } else if (event.target == document.getElementById('myModalSubmitSuccess')) {
    	document.getElementById('myModalSubmitSuccess').style.display = "none";
    } else if (event.target == document.getElementById('myModalSubmitWarn')) {
    	document.getElementById('myModalSubmitWarn').style.display = "none";
    }
}
// ==============================================================

// ========================= Set Height =========================
function setHeight(divID) {
	alert("mpla")
	alert(divID);
	myDiv = document.getElementById(divID);
	alert(this.style.height);
	this.style.height = myDiv.style.height;
	alert(this.style.height);
}
// ==============================================================

// ==================== Check Files-Analysis ====================
function checkFiles() {
	var httpConn = new XMLHttpRequest();
	httpConn.open("GET","php/check_files.php",false);
	httpConn.send(null);
	var analysisFileTable = httpConn.responseText;

    document.getElementById("analysisFileTable").innerHTML = analysisFileTable;
}

function disableCheckBox() {
	var allboxes = document.getElementsByName("analcheck");
	var ticked = [];
	// var analysisFID1;
	// var analysisFID2;

	for (i=0; i<allboxes.length; i++) {
		if (allboxes[i].checked == true) {
			ticked.push(i);
		}
	}

	for (i=0; i<allboxes.length; i++) {
		if (!ticked.includes(i) && ticked.length>=2) {
			allboxes[i].disabled = true;
			allboxes[i].style.cursor = "not-allowed";
		} else {
			allboxes[i].disabled = false;
			allboxes[i].style.color = "pointer";
		}
	}

	if (ticked.length == 2) {
		analysisFID1 = allboxes[ticked[0]].value;
		analysisFID2 = allboxes[ticked[1]].value;
	} else {
		analysisFID1 = "";
		analysisFID2 = "";		
	}	
}

// Get radio analysis
function getAnalysis() {
	var allradios = document.getElementsByName("analradio");
	// var analysisType;

	for (i=0; i<allradios.length; i++) {
		if (allradios[i].checked) {
			// alert(allradios[i].value);
			analysisType = allradios[i].value;
			break;
		} else {
			analysisType = "";
		}
	}


}

function submitAnalysis() {

	disableCheckBox();
	getAnalysis();

	if (analysisFID1 == "" || analysisFID2 == "" || analysisType == "") {
		document.getElementById('myModalSubmitWarn').style.display = "block";
		return;
	} else {
		document.getElementById('myModalSubmitSuccess').style.display = "block";
	}
}
// ==============================================================


// ========================= Upload File =========================
function uploadFile() {
	// var httpConn = new XMLHttpRequest();
	// httpConn.open("GET","php/check_files.php",false);
	// httpConn.send(null);
	// var analysisFileTable = httpConn.responseText;

 //    document.getElementById("analysisFileTable").innerHTML = analysisFileTable;
 	var file = document.getElementById("myFileUpload");

 	alert(file.value);
 	alert(file.files[0]);

 	alert(window.getComputedStyle( document.getElementById('uploadbtn') ,null).getPropertyValue('background-color'));

 	listFiles();
}
// ==============================================================

// ========================= Clear File =========================
function clearFile() {

 	document.getElementById("upFileContainer").innerHTML = document.getElementById("upFileContainer").innerHTML;

}
// ==============================================================
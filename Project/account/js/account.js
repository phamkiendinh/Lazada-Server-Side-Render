function logOut() {
    
}


function showSubmit() {
    document.getElementById("change-profile").style.display = 'inline';
    document.getElementById("file-label").innerHTML = 'Choose New Image';
}

function hideSubmit() {
    document.getElementById("change-profile").style.display = 'none';
    document.getElementById("file-label").innerHTML = 'Change Profile';
    document.getElementById("file-label").className = 'btn btn-info btn-sm fw-bold';
}

function changeLabelButton() {
   var target = document.getElementById('new-profile');
   var change = document.getElementById('file-label');
   change.innerHTML = "Uploaded " + target.files[0].name;
   change.className = 'btn btn-success btn-sm fw-bold';
}
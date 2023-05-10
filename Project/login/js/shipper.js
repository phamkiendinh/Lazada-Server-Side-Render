// Fetching data from the text file
fetch('../hub/hub.txt')
  .then((response) => response.json())
  .then((data) => {
    var temp_array = [];
    for (key of data) {
        temp_array.push(key);
    }
    //If data is duplicated, discard the latest added data
    for (let i = 0; i < data.length; i++) {
      for (let j = i + 1; j < temp_array.length; j++) {
        if (data[i].name == temp_array[j].name && data[i].address == temp_array[j].address) {
          console.log("Duplicated Data, please check the source file!");
          data.splice(j, 1);
        }
      }
    }
    console.log(data);

    //Display data to selection html tag
    for (key of data) {
        var target = document.getElementById("hub");
        target.innerHTML += '<option value="' + key.name +'" class="bg-light fw-bold ms">' + key.name + ": " + key.address + '</option>';
    }
});
// Hide and Show PassWord for testing purposes

function showPassWord() {
  var pass = document.getElementById("s-password");
  if (pass.type === "password") {
      pass.type = "text";
      document.getElementById("showPass").innerHTML = "Hide Password";
  } 
  else {
      pass.type = "password";
      document.getElementById("showPass").innerHTML = "Show Password";
  }
}


function verifyData() {
  var username = document.getElementById('s-username').value;
  var password = document.getElementById('s-password').value;

  var usernameReg = /[A-Z a-z 0-9]{8,15}/;
  var passwordReg =  /(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[!@#$%^&*]).{8,20}/;
  if (!usernameReg.test(username)) {
      alert("Wrong format for UserName, please enter 8-15 letters and digits only.");
      return false;
  }

  if (!passwordReg.test(password)) {
      alert("Wrong format for Password, please enter 8-20 letters with at least 1 upper and 1 lower case, and at least one special letter in the set !@#$%^&*.");
      return false;        
  }
}


function directToCustomerPage() {
  window.location.href = "./customer.html";
}

function directToVendorPage() {
  window.location.href = "./vendor.html";
}
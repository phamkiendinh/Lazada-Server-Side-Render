// Hide and Show PassWord for testing purposes
function showPassWord() {
    var pass = document.getElementById("v-password");
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
    var username = document.getElementById('v-username').value;
    var password = document.getElementById('v-password').value;
    var name = document.getElementById('v-name').value;
    var address = document.getElementById('v-address').value;

    var usernameReg = /^[A-Z a-z 0-9]{8,15}$/;
    var passwordReg =  /^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[!@#$%^&*]).{8,20}$/;
    if (!usernameReg.test(username)) {
        alert("Wrong format for UserName, please enter 8-15 letters and digits only.");
        return false;
    }

    if (!passwordReg.test(password)) {
        alert("Wrong format for Password, please enter 8-20 letters with at least 1 upper and 1 lower case, and at least one special letter in the set !@#$%^&*.");
        return false;        
    }

    if (name.length < 5) {
        alert("Minimum length for name is 5.");
        return false;
    }

    if (address.length < 5) {
        alert("Minimum length for name is 5.");
        return false;
    }
}  

function directToShipperPage() {
    window.location.href = "./shipper.html";
}

function directToCustomerPage() {
    window.location.href = "./customer.html";
}
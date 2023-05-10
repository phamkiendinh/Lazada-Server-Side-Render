// Hide and Show PassWord for testing purposes

function showPassWord() {
    var pass = document.getElementById("password");
    if (pass.type === "password") {
        pass.type = "text";
        document.getElementById("showPass").innerHTML = "Hide Password";
    } 
    else {
        pass.type = "password";
        document.getElementById("showPass").innerHTML = "Show Password";
    }
}

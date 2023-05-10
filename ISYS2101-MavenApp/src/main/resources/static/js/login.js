// Get the form element
const loginForm = document.getElementById("login");

// Add 'submit' event handler
loginForm.addEventListener("submit", (event) => {
    event.preventDefault();

    //Handle form data
    const prePayload = new FormData(formOrder)

    //Format API
    var user = {};

    prePayload.forEach((value, key) => user[key] = value);

    var json = JSON.stringify(user);
    const payload = new URLSearchParams(prePayload);
    // console.log([...payload])
    // console.log(prePayload)
    // console.log(user)
    // console.log(user.email)

    if(user.email === "admin" && user.password === "admin") {
        //Return to admin page
        window.location = "/admin/user";
        window.location.href = "/admin/user";
        window.location.assign("/admin/user");
    }

    
});
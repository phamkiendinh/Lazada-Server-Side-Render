window.onload = function () {
    document.getElementById('badge').innerHTML = localStorage.getItem('badge');

}


function addToCart() {
    if (document.getElementById("message").className == "h1 text-success d-none") {
        document.getElementById("message").className = "h1 text-success d-block mt-5";
        //Update Badge
        document.getElementById("message").innerHTML = "Successfully Added Item!!!";
        document.getElementById("badge").innerHTML = Number(document.getElementById("badge").innerHTML) + Number(1);
        localStorage.setItem('badge', document.getElementById('badge').innerHTML);
        // localStorage.setItem('items') = localStorage.getItem('items');

        //Store Data
        var name = document.getElementById("name").innerHTML;
        var price = document.getElementById("price").innerHTML;
        var description = document.getElementById("description").innerHTML;
        var productProfile = document.getElementById("productProfile").src;
        let pos = productProfile.search('vendor');
        productProfile = productProfile.substring(pos,productProfile.length);
        productProfile = productProfile.replace("vendor.", "../vendor");
        var data = localStorage.getItem('data');
        
        if (data) {
            var items = JSON.parse(data);
            var newItem = {
                "name" : name,
                "price" : price, 
                "description" : description,
                "profile" : productProfile
            };
            items.push(newItem);
            localStorage.setItem('data', JSON.stringify(items));
        }
        else {
            var items = [
                {
                    "name" : name,
                    "price" : price, 
                    "description" : description,
                    "profile" : productProfile
                }
            ];
            localStorage.setItem('data', JSON.stringify(items));
        }
        //Direct User Back to Customer Page
        setTimeout(directUser, 1000);
    }
}

function directUser() {
    location.href = "../customer/customer.php";
}
window.onload = function () {
    document.getElementById('badge').innerHTML = localStorage.getItem('badge');
    makeOrder();
}



function makeOrder() {
    var target = document.getElementById("added-items");
    var data = JSON.parse(localStorage.getItem('data'));
    if (data) {
        if (data.length == 0) {
            alert("Your Cart is empty, please add items first before checking out!");
            window.location.href = "../customer/customer.php";
        }
        var index = 1;
        for (key of data) {
            target.innerHTML += 
            '<hr>' + 
            '<div class="container-fluid d-flex justify-content-center" id="product' + (index - 1) + '">' + 
            '<h2 class="h2 w-75 text-primary">Product ' + index +'<br>' + "Product's Name: " + key.name + '<br>' + "Product's Price: "  + key.price + "<br>" + "Product's Description: " + key.description + "<br>" + '</h4>' +
            '<img alt="Profile" class="border border-2 border-primary product-profile" id="productProfile" src="' + '../vendor/' + key.profile + '">' +
            '<button class="btn btn-danger remove-item w-25 m-auto" type="button" onclick="removeItem(' + (index - 1) + ');">Remove This Item</button>' +
            '</div>' + '<hr>';
            index++;
        }
    }
    else {

    }
}

function removeItem(x) {
    var data = JSON.parse(localStorage.getItem('data'));
    if (data) {
        let temp = [];
        let index = 0;
        for (key of data) {
            if (index == x) {
                index++;
                continue;
            }
            else {
                temp.push(key);
                index++;
            }
        }
        data = temp;
        localStorage.setItem('data', JSON.stringify(data));
        localStorage.setItem('badge', localStorage.getItem('badge') - 1);
        let target = document.getElementById('product' + x);
        target.remove();
        window.location.reload();
    }
    else {

    }
}

function completeOrder() {
    let data = JSON.parse(localStorage.getItem('data'));
    var string = '';
    string += 'start\n';
    if (data) {
        for (key of data) {
            string += key.name + ',' + key.price + ',' + key.description + "\n";
        }
    }
    string += 'end\n';

    document.getElementById('product-list').value = string;
    console.log(document.getElementById('product-list').value);
    document.getElementById('addToCart').click();
    localStorage.clear();
}
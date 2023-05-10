//Retrieve From Order Page
var list = []
var jsonList = JSON.parse(sessionStorage.getItem('list'));
const badge = document.getElementById("badge");
// badge.innerHTML = jsonList.length;


function start() {
    if (jsonList == null) {
        addItem()
    }
    else {
        list = jsonList;
        addItem();
    }
}
start();


function decrease(x) {
    let amount = document.getElementById("amount" + x);
    if ((amount.innerHTML - 1) == 0) {
        removeItem(x);
        return;
    }
    let target = document.getElementById("amount" + x);
    let price = document.getElementById("price" + x);
    for (data of list) {
        if (data.id == x) {
            data.amount = parseInt(target.innerHTML) + 1;
        }
    }
    let quantity = target.innerHTML;
    let pos = price.innerHTML.indexOf(':');
    let subString = price.innerHTML.substring(pos + 2, price.innerHTML.length - 1);


    let single_price = parseFloat(subString) / parseInt(target.innerHTML);
    // price.innerHTML = "Price: " + toString(parseInt(target.innerHTML + 1) * parseFloat(single_price));
    // target.innerHTML = parseInt(target.innerHTML + 1);
    
    let total = document.getElementById("total-money").innerHTML;
    total = total.substring(total.indexOf(':') +2, total.length - 1);
    
    target.innerHTML = parseInt(quantity) - 1;
    price.innerHTML = "Price: " + (parseInt(target.innerHTML) * single_price) + "$";
    document.getElementById("total-money").innerHTML = "Total Price: " + (parseFloat(total) - single_price) + "$";
}

function increase(x) {
    let target = document.getElementById("amount" + x);
    let price = document.getElementById("price" + x);
    for (data of list) {
        if (data.id == x) {
            data.amount = parseInt(target.innerHTML) + 1;
        }
    }
    let quantity = target.innerHTML;
    let pos = price.innerHTML.indexOf(':');
    let subString = price.innerHTML.substring(pos + 2, price.innerHTML.length - 1);


    let single_price = parseFloat(subString) / parseInt(target.innerHTML);
    // price.innerHTML = "Price: " + toString(parseInt(target.innerHTML + 1) * parseFloat(single_price));
    // target.innerHTML = parseInt(target.innerHTML + 1);
    
    let total = document.getElementById("total-money").innerHTML;
    total = total.substring(total.indexOf(':') +2, total.length - 1);
    
    target.innerHTML = parseInt(quantity) + 1;
    price.innerHTML = "Price: " + (parseInt(target.innerHTML) * single_price) + "$";
    document.getElementById("total-money").innerHTML = "Total Price: " + (parseFloat(total) + single_price) + "$";
}

function removeItem(x) {
    var target = document.getElementById("item" + x);
    var temp = [];
    for (data of list) { 
        if (data.id == x) {
            continue;
        }
        else {
            temp.push(data);
        }
    }
    list = temp;
    target.remove();

    let total = 0;
    var target = document.getElementById("cart");
    for (item of list) {
        total += item.price * item.amount;
    }
    document.getElementById("total-money").innerHTML = "Total Price: " + total + "$";
}

function addItem() {

    fetch("/food/all")
        .then(response => response.json())
        .then(data => {
            adder(data);
        })
        .catch((error) => {
          console.error(error);
        })
  }

function adder(data) {
    var target = document.getElementById("cart");
    let total = 0;
    for (key of data.content) {
        for (item of list) {
            if (key.id == item.id) {
                target.innerHTML +=
                '<div class="shoppingCart__item row bg-light position-relative rounded-3 m-2 p-2 shadow" id="item' + key.id + '">' + 
                '<h4>Description: </h4>' +
                '<h6>' + key.description + '</h6>' + 
                '<img class="img-fluid col-md-3 rounded-3" src="/'+ key.imgPath + '">' + 
                '<div class="col">' + 
                '<h4>' + key.name + '</h4>' +
                '<p>Tax: 10%</p>' +
                '<div class="adding__icon d-flex align-items-center">' +
                    '<i class="btn fa-regular fa-square-minus" onclick="decrease(' + key.id + ');"></i>' + 
                        '<span id="amount' + key.id + '">' + item.amount + '</span>' + 
                    '<i class="btn fa-regular fa-square-plus" onclick="increase(' + key.id + ');"></i>' +
                    '</div>' + 
                '</div>' +
                    '<i class="fa-regular fa-circle-xmark" id="close_btn" onclick="removeItem(' + key.id + ');"></i>' + 
                '<p class="price__item position-absolute bottom-0 w-50 text-end end-0 fw-bold" id="price' + key.id + '">' + 'Price: ' + (item.price * item.amount) + '$</p>' + 
                '</div>';
                total += item.price * item.amount;
            }
        }
    }
    document.getElementById("total-money").innerHTML = "Total Price: " + total + "$";
}


//generates random id;
let guid = () => {
    let s4 = () => {
        return Math.floor((1 + Math.random()) * 0x10000)
            .toString(16)
            .substring(1);
    }
    //return id of format 'aaaaaaaa'-'aaaa'-'aaaa'-'aaaa'-'aaaaaaaaaaaa'
    return s4() + s4() + '-' + s4() + '-' + s4() + '-' + s4() + '-' + s4() + s4() + s4();
}

console.log(guid());

// Get the form element
const formOrder = document.getElementById("cart_form");

// Add 'submit' event handler
formOrder.addEventListener("submit", (event) => {
    event.preventDefault();

    //Handle form data
    const prePayload = new FormData(formOrder)
    const itemArray = [] //array of item ids
    for (let k in jsonList) {
        for (let i = 0; i < jsonList[k].amount; i++) {
            itemArray.push(jsonList[k].id)
        }
    }
    //Format API
    var cart = {};
    cart['itemList'] = itemArray;
    // cart['id'] = guid();
    prePayload.forEach((value, key) => cart[key] = value);
    
    prePayload.append("itemList", itemArray)
    
    if (cart.spoon === "spoon") {
        cart.spoon = true;
    } else {
        cart.spoon = false;
    }
    if (cart.ketchup === "ketchup") {
        cart.ketchup = true;
    } else {cart.ketchup = false;}
    if (cart.silverPaper === "silverPaper") {
        cart.silverPaper = true;
    } else {cart.silverPaper = false;}
    if (cart.chiliSauce === "chiliSauce") {
        cart.chiliSauce = true;
    } else {cart.chiliSauce = false;}

    var json = JSON.stringify(cart);
    const payload = new URLSearchParams(prePayload);
    // console.log([...payload])
    // console.log(prePayload)
    // console.log(cart)
    // console.log(cart.spoon)

    //POST new order to API
    fetch('/order/cart', {
        method: "POST",
        headers: {
            'Content-Type': 'application/json',
          },
        body: json,
    })
    .then(res => res.json())
    .then(data => alert("Successfull order items!"))
    .catch(err => console.log('error', err))

    //Return to menu page
    window.location = "/menu";
    window.location.href = "/menu";
    window.location.assign("/menu");

    sessionStorage.setItem('list', "")
});
// const data = { username: 'example' };

// fetch('https://example.com/profile', {
//   method: 'POST', // or 'PUT'
//   headers: {
//     'Content-Type': 'application/json',
//   },
//   body: JSON.stringify(data),
// })
//   .then((response) => response.json())
//   .then((data) => {
//     console.log('Success:', data);
//   })
//   .catch((error) => {
//     console.error('Error:', error);
//   });
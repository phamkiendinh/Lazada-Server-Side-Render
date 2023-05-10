var list = [];
// list = JSON.parse(sessionStorage.getItem("list"))
// console.log(list)
var totalPrice = 0;
var transfer = false;
var jsonList = JSON.parse(sessionStorage.getItem('list'));

//Check if customer ordered from the menu
function start() {
    if (jsonList.length != 0 && list.length == 0) {
        transfer = true;
        for (key of jsonList) {
            addItem(key.id);
        }
    }
}

start();


function subtractCartItem(x) {
    var target = document.getElementById("amount" + x);
    var total = document.getElementById("total-item-price");
    if ((target.innerHTML - 1) == 0) {
        removeCartItem(x);
        return;
    }

    for (data of list) {
        if (data.id == x) {
            data.amount = target.innerHTML - 1;
        }
    }


    var price = document.getElementById("price" + x);
    var single_price = parseFloat(price.innerHTML) / parseInt(target.innerHTML);
    price.innerHTML = (parseInt(target.innerHTML) - 1) * single_price;
    target.innerHTML = parseInt(target.innerHTML) - 1;
    total.innerHTML = Number(total.innerHTML) - Number(single_price);
    totalPrice = Number(total.innerHTML);
    cartUpdate();
}

function addCartItem(x) {
    var target = document.getElementById("amount" + x);
    var price = document.getElementById("price" + x);
    var total = document.getElementById("total-item-price");
    
    for (data of list) {
        if (data.id == x) {
            data.amount = parseInt(target.innerHTML) + 1;
        }
    }

    var single_price = parseFloat(price.innerHTML) / parseInt(target.innerHTML);
    price.innerHTML = (parseInt(target.innerHTML) + 1) * single_price;
    target.innerHTML = parseInt(target.innerHTML) + 1;
    total.innerHTML = Number(total.innerHTML) + Number(single_price);
    totalPrice = Number(total.innerHTML);
    cartUpdate();
}

function removeCartItem(x) {
    var target = document.getElementById("c-item" + x);
    console.log(list);
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
    console.log(list);
    target.remove();
    if (list.length == 0) {
        var element = document.getElementById("totalPrice");
        element.remove();
    }
    cartUpdate();
}


//This function updates the badge number every time user clicks
function cartUpdate() {
    if(list.length !== 0) {
        document.getElementById("badge").innerHTML = list.length;
        document.getElementById("badge2").innerHTML = list.length;
        document.getElementById("badge").style.display = "grid";
        document.getElementById("badge2").style.display = "grid";
    } else {
        document.getElementById("badge").style.display = "none";
        document.getElementById("badge2").style.display = "none";
    }
}

function checkOut() {
    sessionStorage.setItem('list', JSON.stringify(list));
    window.location.href = "/cart";
    // window.open("../../cart/cart.html", "_self");
}

function addItem(x) {
    let url = '/food/all';
  fetch(url)
      .then(response => response.json())
      .then(data => {
        adder(data,x);
      })
      .catch((error) => {
        console.error(error);
      })
}

function adder(data, x) {
    var exist = false;
    if (list.length != 0) {
        list.forEach(element => {
            if (element.id == x) {
                exist = true;
                let amount_id = "amount" + element.id;
                let price_id = "price" + element.id;
                let amount = element.amount + 1;
                let price = element.price * amount;
                document.getElementById(amount_id).innerHTML = amount;
                document.getElementById(price_id).innerHTML  = price;
                element.amount += 1;
                totalPrice += element.price;
            }
        });
    }

    let index = 1;
    for (key of data.content) {
        if(index == x) {
            if (!exist) {
                let id = index;
                index++;
                let amount = Number(1);
                if (transfer == true) {
                    for (item of jsonList) {
                        if (item.id == key.id) {
                            amount = item.amount;
                            console.log("Amount: " + amount);
                            console.log("Updated Amount");
                        }
                    }
                }
                let price = Number(key.price);
                console.log("ID: " + id );
                let json = {
                    "id":id,
                    "amount": amount, 
                    "price": price
                }
                totalPrice += price;
                list.push(json);
                document.getElementById("cart-list").innerHTML += 
                '<li class="list-group-item cart-item d-flex mt-2 mb-2" id="c-item' + id + '">'+
                '<div class="d-block">'+
                '<div class="cart-item-name justify-content-center text-center p-2 mb-2">'+
                '<h4 class="h4">' + key.name + '</h4>' +
                        '</div>'+
                        '<div class="d-flex w-100 gap-2">'+
                        '<div class="cart-item-image w-50">'+
                        '<img class="img-fluid" alt="item_image" src="/' + key.imgPath + '">'+
                        '</div>'+ 
                        '<div class="w-50 d-block m-auto gap-4 justify-content-center cart-item-button" id="cart-item-button">'+
                        '<div class="d-flex gap-4 h-50 justify-content-center trade-info">'+
                        '<div class="subtract-item">'+
                        '<button type="button" class="btn btn-dark btn-sm item-button overflow-hidden" id="subtract' + id + '" onclick="subtractCartItem(' + id + ')">'+
                        '<i class="bi bi-dash-lg overflow-auto">'+'</i>'+
                        '</button>'+
                        '</div>'+
                        
                        '<div class="cart-item-amount">'+
                        '<h2 class="h2" id="amount' + id + '">'+ amount + '</h2>'+
                        '</div>'+
                        
                        '<div class="add-item">'+
                        '<button type="button" class="btn btn-dark btn-sm item-button" id="add' + id + '" onclick="addCartItem(' + id + ')">'+ 
                        '<i class="bi bi-plus-lg"></i>'+
                        '</button>'+
                        '</div>'+
                        '</div>'+
                        
                        '<div class="d-flex h-50 justify-content-center mt-3">'+
                        '<h4 class="h4">'+ 'Price: ' + '</h4>'+
                        '<h4 class="h4" id="price' + id + '"> ' + key.price + '</h4>'+
                        '<h4 class="h4"> $ </h4>' +
                        '</div>'+
                        '</div>'+ 
                        '</div>'+
                        '</div>'+
                        '</li>';
                        break;
                    }
                }
                else {
                    index++;
                }
            }
            
            console.log(list);
            

    if (document.getElementById("totalPrice") !== null) {
        document.getElementById("totalPrice").remove();
        document.getElementById("cart-list").innerHTML += 
        '<li class="list-group-item cart-item d-flex mt-2 mb-2 bg-warning" id="totalPrice">'+
            
                '<div class="d-flex justify-content-between align-items-center w-100">'+
                    '<div class="d-flex">'+
                        '<h4 class="h4">'+ 'Total Price: ' + '</h4>'+
                        '<h4 class="h4" id="total-item-price">' + totalPrice + '</h4>'+
                        '<h4 class="h4"> $ </h4>' +
                    '</div>'+ 
                    '<button class="btn btn_primary justify-content-end" onclick="checkOut();">Check Out</button>'+
                '</div>'+
            
        '</li>';
        // document.getElementById("total-item-price").innerHTML = totalPrice;
    }
    else {
        document.getElementById("cart-list").innerHTML += 
        '<li class="list-group-item cart-item d-flex mt-2 mb-2 bg-warning" id="totalPrice">'+
            
            '<div class="d-flex justify-content-between align-items-center w-100">'+
                '<div class="d-flex">'+
                    '<h4 class="h4">'+ 'Total Price: ' + '</h4>'+
                    '<h4 class="h4" id="total-item-price">' + totalPrice + '</h4>'+
                    '<h4 class="h4"> $ </h4>' +
                '</div>'+
            '<button class="btn btn_primary" onclick="checkOut();">Check Out</button>' +
            
            '</div>'+ 
        '</li>';
    }
    cartUpdate();
}
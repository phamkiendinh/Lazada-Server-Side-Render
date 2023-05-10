
//UPLOAD IMAGE FORM
const post_btn = document.getElementById("post_address_btn");
const overlay = document.getElementById("overlay");
const close_btn = document.querySelector("#close_btn");

post_btn.onclick = function ()  {
    overlay.style.display = "grid";
}

close_btn.onclick = function() {
    overlay.style.display = "none";
}

overlay.addEventListener('click', function(e) {
    if (e.target.id == 'overlay') {
        overlay.style.display = "none";
    }
})

function goToVoucher() {
    window.location = "/voucher";
    window.location.href = "/voucher";
    window.location.assign("/voucher");
}

//ORDER PART
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

function checkOut() {
    sessionStorage.setItem('list', JSON.stringify(list));
    window.location.href = "/cart";
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


//   function adder(data, x) {
//     var exist = false;
//     var target = document.getElementById("cart-quantity");
//     target.innerHTML = Number(target.innerHTML) + 1;
//     document.getElementById("badge").innerHTML = Number(document.getElementById("badge").innerHTML) + 1;
//     if (list.length != 0) {
//         list.forEach(element => {
//             if (element.id == x) {
//                 exist = true;
//                 let amount_id = "amount" + element.id;
//                 let price_id = "price" + element.id;
//                 let amount = element.amount + 1;
//                 let price = element.price * amount;
//                 element.amount += 1;
//             }
//         });
//     }

//     for (key of data.content) {
//         if(key.id == x) {
//             if (!exist) {
//                 let id = key.id;
//                 let amount = Number(1);
//                 let price = Number(key.price);
//                 let json = {
//                     "id":id,
//                     "amount": amount, 
//                     "price": price
//                 }
//                 list.push(json);
//                 break;
//             }
//         }
//     }
//     sessionStorage.setItem('list', JSON.stringify(list));
//     cartUpdate();
// }  

function adder(data, x) {
    var exist = false;
    let index = 1;
    var target = document.getElementById("cart-quantity");
    target.innerHTML = Number(target.innerHTML) + 1;
    document.getElementById("badge").innerHTML = Number(document.getElementById("badge").innerHTML) + 1;

    if (list.length != 0) {
        list.forEach(element => {
            if (element.id == x) {
                exist = true;
                let amount = element.amount + 1;
                element.amount += 1;
                totalPrice += element.price;
            }
        });
    }

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
            }
        }
        else {
            index++;
        }
    }
            
    console.log(list);
    cartUpdate();
}

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
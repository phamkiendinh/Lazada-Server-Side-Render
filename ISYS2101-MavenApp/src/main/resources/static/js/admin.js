
//pagination parts
const foodElements = document.getElementById("dishes_info");
const userElements = document.getElementById("user_info");
const orderElements = document.getElementById("order_info");
const reserElements = document.getElementById("reser_info");
const pageUserElement = document.getElementById("user_pagination");
const pageOrderElement = document.getElementById("order_pagination");
const pageFoodElement = document.getElementById("food_pagination");
const pageReserElement = document.getElementById("reser_pagination");

let currentPage = 1;
let rows = 5;

//Fetch food api
let url_food = '/food/all';
fetch(url_food)
.then(responseFood => responseFood.json())
.then(dataFood => {

let foods = displayList(dataFood.content, foodElements, rows, currentPage)
write_food(foods);
setupPagination(dataFood.content, pageFoodElement, rows);

})
.catch((errorFood) => {
console.error(errorFood);
})

//Function to write all food to page
function write_food(dataFood) {
    for (key of dataFood) {
        foodElements.innerHTML += 
        '<tr class="oneFood">' +
            '<!--Assign data for each element of the row -->'+
            '<td class="foodName">' + key.name + '</td>'+
            '<td>'+ key.category +'</td>'+
            '<td>'+ key.description +'</td>'+
            '<td>'+ key.price +'</td>'+
            '<td class="profile_picture" ><img src="' + key.imgPath + '" alt=""></td>'+
            '<td>'+ key.id +'</td>'+
            '<td>'+
                // '<button class="btn btn_primary">Edit</button>'+
                '<button class="btn btn_primary" onclick="deleteFood(' + key.id + ')">Delete</button>'+
            '</td>'+
        '</tr>';
    }
}

//Fetch user api
let url_user = '/userEs';
fetch(url_user)
.then(response => response.json())
.then(dataUser => {

let users = displayList(dataUser._embedded.userEs, userElements, rows, currentPage)
write_user(users);
setupPagination(dataUser._embedded.userEs, pageUserElement, rows);

})
.catch((error) => {
console.error(error);
})

function write_user(data) {
    for (key of data) {
        userElements.innerHTML += 
        '<tr class="rowUser">' +
            '<!--Assign data for each element of the row -->'+
            '<td class="uFname">' + key.firstName + '</td>'+
            '<td class="uLname">'+ key.lastName +'</td>'+
            '<td>'+ key.email +'</td>'+
            '<td>'+ key.password +'</td>'+
            '<td class="profile_picture" ><img src="' + key.imgPath + '" alt=""></td>'+
            '<td class="uName">'+ key.userName +'</td>'+
            '<td>'+
                // '<button class="btn btn_primary">Edit</button>'+
                '<button class="btn btn_primary">Delete</button>'+
            '</td>'+
        '</tr>';
    }
}

//Fetch order api
let url_Order = '/orderEntities/all';
fetch(url_Order)
.then(response => response.json())
.then(dataOrder => {

let orders = displayList(dataOrder.content, orderElements, rows, currentPage)
write_order(orders);
setupPagination(dataOrder.content, pageOrderElement, rows);

})
.catch((error) => {
console.error(error);
})

function write_order(data) {
    for (key of data) {
        let moreS = [];
        if(key.spoon === true) {
            moreS.push("Spoon")
        }
        if(key.silverPaper === true) {
            moreS.push("Silver Paper")
        }
        if(key.ketchup === true) {
            moreS.push("Ketchup")
        }
        if(key.chiliSauce === true) {
            moreS.push("Chili Sauce")
        }
        orderElements.innerHTML += 
        '<tr class="rowOrder">' +
            '<!--Assign data for each element of the row -->'+
            '<td>' + key.id + '</td>'+
            '<td class="orderUser">' + key.user + '</td>'+
            '<td class="itemList">'+ key.foodItems[0].name + ', ' + key.foodItems[1].name +'</td>'+
            '<td>'+ key.address +'</td>'+
            '<td>'+ key.voucher +'</td>'+
            '<td>' + key.requirement + '</td>'+
            '<td>'+ moreS +'</td>'+
            '<td>' + key.totalCost + '</td>'+
            '<td>'+
                // '<button class="btn btn_primary">Edit</button>'+
                '<button class="btn btn_primary" onclick="deleteOrder(' +key.id+ ')">Delete</button>'+
            '</td>'+
        '</tr>';
    }
}


//Fetch reservation api
let url_Reser = '/reservations';
fetch(url_Reser)
.then(response => response.json())
.then(dataReser => {

let resers = displayList(dataReser._embedded.reservations, reserElements, rows, currentPage)
write_reser(resers);
setupPagination(dataReser._embedded.reservations, pageReserElement, rows);

})
.catch((error) => {
console.error(error);
})

function write_reser(data) {
    for (key of data) {
        console.log(key)
        reserElements.innerHTML += 
        '<tr class="rowReser">' +
            '<!--Assign data for each element of the row -->'+
            '<td>' + key.timeSlot + '</td>'+
            '<td class="emailReser">' + key.email + '</td>'+
            '<td>'+ key.phoneNumber +'</td>'+
            '<td>'+
                // '<button class="btn btn_primary">Edit</button>'+
                '<button class="btn btn_primary">Delete</button>'+
            '</td>'+
        '</tr>';
    }
}


//Delete order part
function deleteOrder(id) {
    if (!window.confirm("Do you want to delete this order??")) {
        return;
    }
    let url = '/orderEntities/' + id;
    fetch(url,{
    method:'DELETE'
    }).then(response=>{
        return response.json()
    }).then(data=> 
    // this is the data we get after putting our data,
    console.log(data)
    );
}

//Delete food part
function deleteFood(id) {
    if (!window.confirm("Do you want to delete this order??")) {
        return;
    }
    let url = '/foodItems/' + id;
    fetch(url,{
    method:'DELETE'
    }).then(response=>{
        return response.json()
    }).then(data=> 
    // this is the data we get after putting our data,
    console.log(data)
    );
}

// Pagination part
function displayList(items, wrapper, rowperpage, page) {
    wrapper.innerHTML = "";
    page--;

    let start = rowperpage *page;
    let end = start + rowperpage;
    let paginatedItems = items.slice(start, end);

    console.log(paginatedItems)
    return paginatedItems;
}

function setupPagination (items, wrapper, rowperpage) {
    wrapper.innerHTML = "";
    let pageCount = Math.ceil(items.length / rowperpage);
    console.log(items.length)
    for (let i = 1; i < pageCount + 1; i++) {
        let btn = paginationButton(i, items);
        wrapper.appendChild(btn);
    }
}

function paginationButton (page, items) {
    let button = document.createElement('button');
    button.innerText = page;

    // if (currentPage === page) button.classList.add("active");

    button.addEventListener('click', function () {
        currentPage = page;
        if (document.getElementById("order").classList.contains("active")) {
            write_order(displayList(items, orderElements, rows, currentPage));
        }

        if (document.getElementById("food").classList.contains("active")) {
            write_food(displayList(items, foodElements, rows, currentPage));
        }

        if (document.getElementById("user").classList.contains("active")) {
            write_user(displayList(items, userElements, rows, currentPage));
        }

        if (document.getElementById("table").classList.contains("active")) {
            write_reser(displayList(items, userElements, rows, currentPage));
        }
    })
    return button;
}

//Search part

const search = () => {
    const searchBox = document.getElementById('searchBox').value.toUpperCase();
    //pagination for food
    if (document.getElementById("food").classList.contains("active")) {
        const dishesInfo = document.getElementById('dishes_info');
        const rowFood = document.querySelectorAll('.oneFood');
        const fName = document.querySelectorAll('.foodName');
        console.log(rowFood.values)
        console.log(fName)
        for (var i = 0; i < fName.length; i++) {
            let match = rowFood[i].getElementsByTagName('td')[0];
            console.log(match)
            if(match) {
                let textValue = match.textContent || match.innerHTML;

                if(textValue.toUpperCase().indexOf(searchBox) > -1) {
                    rowFood[i].style.display = "";
                } else {
                    rowFood[i].style.display = "none";
                }
            }
        }
    }

    //pagination for user
    if (document.getElementById("user").classList.contains("active")) {
        const userInfo = document.getElementById('user_info');
        const rowUser = document.querySelectorAll('.rowUser');
        const uFname = document.querySelectorAll('.uFname');
        const uLname = document.querySelectorAll('.uLname');
        const uName = document.querySelectorAll('.uName');
        console.log(rowUser.values)
        console.log(uName)
        for (var i = 0; i < uName.length; i++) {
            let match = rowUser[i].getElementsByTagName('td')[5];
            console.log(match)
            if(match) {
                let textValue = match.textContent || match.innerHTML;

                if(textValue.toUpperCase().indexOf(searchBox) > -1) {
                    rowUser[i].style.display = "";
                } else {
                    rowUser[i].style.display = "none";
                }
            }
        }
    }

    //pagination fo rorder
    if (document.getElementById("order").classList.contains("active")) {
        const dishesInfo = document.getElementById('dishes_info');
        const rowFood = document.querySelectorAll('.oneFood');
        const fName = document.querySelectorAll('.foodName');
        console.log(rowFood.values)
        console.log(fName)
        for (var i = 0; i < fName.length; i++) {
            let match = rowFood[i].getElementsByTagName('td')[0];
            console.log(match)
            if(match) {
                let textValue = match.textContent || match.innerHTML;

                if(textValue.toUpperCase().indexOf(searchBox) > -1) {
                    rowFood[i].style.display = "";
                } else {
                    rowFood[i].style.display = "none";
                }
            }
        }
    }

    //pagination for table
    if (document.getElementById("table").classList.contains("active")) {
        const dishesInfo = document.getElementById('reser_info');
        const rowReser = document.querySelectorAll('.rowReser');
        const emailReser = document.querySelectorAll('.emailReser');
        console.log(rowReser.values)
        console.log(emailReser)
        for (var i = 0; i < emailReser.length; i++) {
            let match = rowReser[i].getElementsByTagName('td')[1];
            console.log(match)
            if(match) {
                let textValue = match.textContent || match.innerHTML;

                if(textValue.toUpperCase().indexOf(searchBox) > -1) {
                    rowReser[i].style.display = "";
                } else {
                    rowReser[i].style.display = "none";
                }
            }
        }
    }
}
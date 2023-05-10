// Switch Map Location Display
function showMap(data) {
    if (data == 'HCM') {
        document.getElementById('map').src = "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.897549572912!2d106.62903071532963!3d10.742378862757418!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x317529e94594adcd%3A0x35cd5ec9e929d87c!2sMM%20Mega%20Market%20B%C3%ACnh%20Ph%C3%BA!5e0!3m2!1sen!2s!4v1659362001559!5m2!1sen!2s";
        document.getElementById('branch').innerHTML = 'Ho Chi Minh City';  
    }

    if (data == 'HN') {
        document.getElementById('map').src = "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3317.976584219373!2d105.82975670890245!3d21.02057435817134!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135ab9d33f5f6c1%3A0xabe31a39ff332353!2sSupermarket%20Electric%20Pico!5e0!3m2!1sen!2s!4v1661013526398!5m2!1sen!2s";
        document.getElementById('branch').innerHTML = 'Ha Noi City';  
    }

    if (data == 'NT') {
        document.getElementById('map').src = "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d6947.363027702921!2d109.18432798136888!3d12.243168555523603!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31705d5440d0021d%3A0xdf15c9f3343a3847!2sSi%C3%AAu%20th%E1%BB%8B%20Co.opmart%20Nha%20Trang!5e0!3m2!1sen!2s!4v1661013680229!5m2!1sen!2s";
        document.getElementById('branch').innerHTML = 'Nha Trang City';  
    }
}

//Show Reservation Form
function showForm(id) {
    document.getElementById("form-column").style.display = 'block';
    var table = document.getElementById('table-reservation');
    table.innerHTML = 'Table ' + id + ' Reservation';
    if (sessionStorage['table']) {
        sessionStorage.removeItem('table');
        sessionStorage.setItem('table', id);
    }
    else {
        sessionStorage.setItem('table', id);
    }
}

function getData() {
    let id = sessionStorage.getItem('table');
    $('#form').submit(function(e) {
        e.preventDefault();
        $.ajax({
             type: 'POST',
             url: '/booking/makeBooking',
             data: $(this).serialize(),
             beforeSend: function() {

             },
             complete: function() {

             }, //do something
             success: function(data) {
                if (data) {
                    let target = document.getElementById('table-image-' + id);
                    target.style.backgroundColor = 'lightgreen';
                    alert("Submission Received");
                }
                else {
                    let target = document.getElementById('table-image-' + id);
                    target.style.backgroundColor = 'red';
                    alert("Table is reserved! Please Try Again");
                    setTimeout(reloadPage, 2000);
                }
             } //do something for example if the request response is success play your animation...
        });
     
     })
}

function reloadPage() {
    window.location.reload();
}
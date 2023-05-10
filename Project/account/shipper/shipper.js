function showInformation(x) {
    let button = document.getElementById('button' + x);
    if (button.innerHTML == 'Show This Order Information') {
        let target = document.getElementById('order-info-' + x);
        target.className = "container w-50 d-block";
        button.innerHTML = 'Hide This Order Information';
        // window.location.reload();
    }
    else {
        let target = document.getElementById('order-info-' + x);
        target.className = "d-none";
        button.innerHTML = 'Show This Order Information';
        // window.location.reload();
    }
}
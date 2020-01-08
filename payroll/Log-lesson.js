function InsertTime() {

    let CurrentTime = new Date();
    document.getElementById("Ctime").value = CurrentTime.toLocaleTimeString();
}

function reset() {

    document.getElementsById("texts").value = " ";
}
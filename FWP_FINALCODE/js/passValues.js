function passValues(){
    var quantity = document.getElementById("quantity").value;
    var calorie = document.getElementById("calorie").value;
    var category = document.getElementById("category").value;
    var bestbeforeDate = document.getElementById("bestbeforeDate").value;
    var description = document.getElementById("description").value;
    return "quantity="+quantity+"&calorie="+calorie+"&category="+category+"&bestbeforeDate="+bestbeforeDate+"&description="+description;
}
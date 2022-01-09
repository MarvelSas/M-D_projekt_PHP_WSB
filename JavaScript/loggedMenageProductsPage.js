
function openMenuPage() {

    
    
    window.open("../src/loggedMenuPage.php","_self");
   
    
}


function modifyItem(modyfiName,modyfiPrice,photoName){



    let addItemForm = document.getElementById("addItemForm");
    addItemForm.style.display = "none"

    let modyfiItemForm = document.getElementById("modyfiItemForm");
    modyfiItemForm.style.display = "inline"
    
    let name = document.getElementById("itemNameInputModify");
    name.value =modyfiName;

    let price = document.getElementById("itemPriceInputModify");
    price.value = modyfiPrice;

    
    
}



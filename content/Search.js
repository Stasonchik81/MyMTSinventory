let input = document.getElementById('searchEquipment');
async function clickSearch(){
    let value = input.value;
    let url = `http://mtsmyadmin.loc/Admin/vendor/search.php`;
    let response = await fetch(url, {
        method: 'POST',
        headers: {
        'Content-Type': 'application/json;charset=utf-8'
        },
        body: value,
    });
    let equipment_search = await response.json();
    equipment_search = Object.values(equipment_search);
    equipment_search = equipment_search.slice(0, 5);
    insertOptions(equipment_search);
}
let button = document.getElementById('buttonsearch');
button.onclick = clickSearch;

function insertOptions(equpment){
    let inputs = document.querySelectorAll('form .form-control:not(#count)');
    for(let i=0; i<inputs.length; i++){
        inputs[i].value = equpment[i];
    }
}
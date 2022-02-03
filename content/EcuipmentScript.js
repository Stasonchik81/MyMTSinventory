// Функция добавления разметки поля ввода серийника
function addequipment(parent, i){
    let item = document.createElement('div'); 
    item.innerHTML = `<div class="col-10"><input class="form-control" type="text" name="number${num_count+i}" placeholder="serial number">`;
    item.className = 'row';
    item.style = "justify-content: flex-end; margin-bottom: 10px";
    parent.insertBefore(item, parent.lastChild.previousSibling);
}

// Функция обработчик события нажатия кнопки "+"
function add(){
    let container = document.querySelector('form');
    let count = document.getElementById('count');
    let countValue = +count.value; //  количество добавляемых полей ввода серийника
    num_count = add_count;
    add_count+=countValue; // общее количество полей ввода серийника
    for(let i=1; i<=countValue; i++){
        addequipment(container, i);
    }
    console.log(add_count);
}
let add_count = 1; // установка внешнего счётчика нажатий кнопки "+"
let num_count; // счётчик, хранящий последнее значение атрибута name "number_"
let buttonAdd = document.getElementById('+');
buttonAdd.onclick = add;


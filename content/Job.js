
    // установка даты
    let today = new Date();
    let inputDate = document.getElementById('date');
    inputDate.value = today.toLocaleDateString();
    
    // доступ к полям "disabled"
    let checkboxes = document.querySelectorAll(".checkbox input");
    for (let i=0; i<checkboxes.length; i++){
        checkboxes[i].onclick = checker;
    }
            
    function checker(eventObj){
        let checkInput = eventObj.target;
        let targetInput_id = checkInput.id+"Count";
        if (document.getElementById(targetInput_id)){
            let targetInput = document.getElementById(targetInput_id);
            toCheck(checkInput, targetInput);
        }
    }
    
    function toCheck(checkInput, targetInput){
        if(checkInput.hasAttribute("checked")){
            checkInput.removeAttribute("checked");
            if(!targetInput.hasAttribute("disabled")){
                targetInput.setAttribute('disabled', '');
            }
        }
        else{
            checkInput.setAttribute("checked",'');
            targetInput.removeAttribute('disabled');
        }
    }
    // Без оборудования
    let input_no = document.getElementById('no_equipment');
    input_no.onclick = setNoEqupment;
    function setNoEqupment(){
        if(!input_no.hasAttribute("checked")){
            input_no.setAttribute("checked",'');
            names.forEach(function(el){
                let input = document.querySelector(`select[name='${el}1'`);
                setDisabled(input);
            })
            setDisabled(buttonAdd);
        }
        else{
            input_no.removeAttribute("checked");
            names.forEach(function(el){
                let input = document.querySelector(`select[name='${el}1'`);
                setDisabled(input);
            })
            setDisabled(buttonAdd);
        }

    }

    function setDisabled(targetInput){
        if(targetInput.hasAttribute("disabled")){
                targetInput.removeAttribute('disabled');
            }
        else{
            targetInput.setAttribute('disabled', '');
        }
    }


    // Возврат
    let input_services = document.querySelectorAll('input[type="radio"]');
    let hide = document.querySelector('.hide');
    
    for (let input of input_services){
        input.addEventListener('click', function(eventObj){
            if(eventObj.target.value == 'Service'){
                hide.setAttribute("class", "form-check");
            }
            else{
                hide.setAttribute("class", "hide");
            }
        })
    }

    let div_return = document.querySelector('#end+div');
    let hiddenList = div_return.children;
    let input_return = document.querySelector('#return input');
    input_return.addEventListener("click", function(){
        if(input_return.hasAttribute("checked")){
            setHidden(hiddenList);
            input_return.removeAttribute("checked");
        }
        else{
            setVisible(hiddenList);
            input_return.setAttribute("checked",'');
        }
    })
    function setVisible(hiddenList){
        for(var i=0; i<hiddenList.length; i++){
            hiddenList[i].setAttribute("class", "incol");
        }
    }
    function setHidden(hiddenList){
        for(var i=0; i<hiddenList.length; i++){
            hiddenList[i].setAttribute("class", "hide");
        }
    }


    
    // Генерация списков оборудования
    
    // функция удаления списка
     function remove_options(select){
        while(select.firstChild){
            select.removeChild(select.firstChild);
        }
    }
    
    // Генерируем списки опций для первой единицы оборудования
    let names = ['type', 'make', 'model', 'number'];
    let names_r = ['make_r', 'model_r', 'number_r'];
    let count = 1;
    let count_r = 1;
    genericOptions(names, count);

    async function genericOptions(names, count) {
        for (var i=0; i<names.length-1; i++) {
          await setOptions(i, count);
        }
        console.log('Done!');
      }

    // функция первоначальной установки опций в следующем селекте
    async function setOptions(i, count){
        let select = document.querySelector(`select[name='${names[i]}${count}']`);
        let parent = select.parentElement;
        let next = parent.nextElementSibling;
        let next_select = next.firstElementChild;
        let fullAttr = next_select.getAttribute("name");
        let attr = fullAttr.substring(0, fullAttr.length-1);
        let value = select.value;
        let url = `http://MTSMyAdmin.loc/Admin/vendor/set_${attr}.php`;
        let response = await fetch(url, {
            method: 'POST',
            headers: {
            'Content-Type': 'application/json;charset=utf-8'
            },
            body: value,
            mode: 'no-cors'
        });
        let list = await response.text();
        next_select.innerHTML = list;
        select.onchange = getAllOptions;
    }

    // функция - обработчик события выбора опции - генерирует списки опций во всех следующих селектах
    async function getAllOptions(eventObj){
        let option = eventObj.target;
        let full_attribute = option.getAttribute("name");
        let attribute = full_attribute.substring(0, full_attribute.length-1);
        let name_index = names.indexOf(attribute);
        for(let i = name_index; i < names.length-1; i++){
             option = await setNextSelect(option);
        }
        console.log("Done!");
    }
    

    // Функция установки опций в следующем селекте
    async function setNextSelect(select){
        let select_value = select.value;
        let parent = select.parentElement;
        let next = parent.nextElementSibling;
        let next_select = next.firstElementChild;
        let fullAttr = next_select.getAttribute("name");
        let attr = fullAttr.substring(0, fullAttr.length-1);
        let url = `http://mtsmyadmin.loc/Admin/vendor/set_${attr}.php`;
        let response = await fetch(url, {
            method: 'POST',
            headers: {
            'Content-Type': 'application/json;charset=utf-8'
            },
            body: select_value,
            mode: 'no-cors'
        });
        let list_options = await response.text(); 
        remove_options(next_select);
        next_select.innerHTML = list_options;
        return next_select;
    }
    
    // добавление полей ввода оборудования

    // функция генерации строки
    function genString(){
        let stringX = '';
        for(let i=0; i<names.length; i++){
            let col = `<div class="incol"><select class="form-select" name="${names[i]}${count}"></select></div>`;
            stringX+=col;
        }
        return stringX;
    }
    
let form = document.querySelector("form");
    function addEquipment(){
        let End = document.getElementById('end');
        let bigDiv = document.createElement('div');
        bigDiv.className='col-md-10 inrow spaceBetween';
        count++;
        bigDiv.innerHTML = genString();
        form.insertBefore(bigDiv, End);
        let miniDiv = document.createElement('div');
        miniDiv.classList='col-md-2';
        form.insertBefore(miniDiv, End);
        let select = document.querySelector(`select[name="type${count}"]`);
        getTypes(select);
        genericOptions(names, count);
    }

    // функция генерации списка типов для сгенерированного селекта type
    async function getTypes(select){
        let url = "http://mtsmyadmin.loc/Admin/vendor/get_type.php";
        let response = await fetch(url);
        let type_options = await response.text(); 
        select.innerHTML = type_options;
    }    

    let buttonAdd = document.getElementById('+');
    buttonAdd.onclick = addEquipment;

    
    // функция генерации строки R
    function genRString(i){
        let stringR = '';
        stringR+=genSelect(i);
        for(let j=0; j<names_r.length; j++){
            let col = `<div class="incol"><input class="form-control-sm" type="text" name="${names_r[j]}${i}"></div>`;
            stringR+=col;
        }
        return stringR;
    }
    
    function genSelect(i){
        let rSelect = `<div class="incol"><select class="form-select" name="type_r${i}"></select></div>`;
        return rSelect;
    }
    

    function addREquipment(){
        let end = document.getElementById('end_return');
        let bigDiv = document.createElement('div');
        bigDiv.className='col-md-10 inrow spaceBetween';
        count_r++;
        bigDiv.innerHTML = genRString(count_r);
        form.insertBefore(bigDiv, end);
        let select = document.querySelector(`select[name="type_r${count_r}"]`);
        getTypes(select);
    }

    let buttonAddR = document.getElementById('+return');
    buttonAddR.onclick = addREquipment;


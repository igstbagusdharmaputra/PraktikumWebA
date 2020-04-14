let exp = '', number, decimal, equal, operator, allowSR=true;
let tampil = document.forms['form-nilai']['text-nilai'];
function buatangka(angka){
    if(equal){ 
        exp = angka;
        tampil.value = exp;
        number = true;
        equal = false;
    }else{
       exp = tampil.value + angka;
       tampil.value = exp;
       number = true; 
    }
    if(operator){
        decimal = false;  
        SR('a')
    }
}
function buatoperator(op){
    tampil.value = exp + op;
    operator = true;
    equal = false;
    allowSR = false;
    SR('a');
}
function buatdecimal(){
    if(number && !decimal){
        tampil.value = exp + '.';
        decimal = true;
        operator = false;
    }
}
function equalto(){
    if(exp){
        exp = eval(exp);
        tampil.value = exp;
        equal = true;
        decimal = false;
        number = false;
        allowSR = true;
        SR('a');
    }
}
function clean(){
    exp ='';
    tampil.value = exp;
    decimal = false;
}
function back(){
    exp = tampil.value;
    exp = exp.substring(0,exp.length-1);
    tampil.value = exp;
}

function SR(x){
    if(x == 'r'){
        exp = Math.sqrt(exp);
        tampil.value = exp;
    }
    else if (x == 's'){
        exp = exp * exp;
        tampil.value = exp;
    }
    else if (x=='a' && allowSR){
        document.getElementById('r').disabled=false;
        document.getElementById('s').disabled=false;
    }
    else if (!allowSR){
        document.getElementById('r').disabled=true;
        document.getElementById('s').disabled=true;
    }
}
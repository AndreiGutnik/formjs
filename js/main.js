var loginStat;

$(document).ready(function(){
    $("#login").blur(runajax);
}); //конец ready


function runajax(){
    var inp = $("#login").val();
    $.ajax({
        type: "POST",
        data: "login="+inp,
        url: "\ajax.php",
        //dataType: "json",
        error: function(){
            alert("Запрос завершился ошибкой!");
        },
        beforeSend: function(){
            $('#login').next().html('Проверка ...');
        },
        success: function(data){
            if(data == "no"){
                $("#login").next().hide().text("Логин занят").css("color", "red").fadeIn(1000);
                //скрыть следующий блок после селектора, изменить текст, а потом плавно вывести
                $("#login").removeClass().addClass("inputRed");
                //очистка имеющихся классов и присвоение другого
                loginStat = 0;
                buttonOnAndOff();
            } else {
                $("#login").removeClass().addClass("inputGreen")
                $("#login").next().text("");
                loginStat = 1;
                buttonOnAndOff();
            }
        }
    });
}

function buttonOnAndOff() {
    if(loginStat == 1) {
        $("#submit").removeAttr("disabled");
    }
}
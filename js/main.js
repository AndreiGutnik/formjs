$(document).ready(function(){
    $("#login").blur(runajax);
}); //конец ready


function runajax(){
    var inp = $("#login").val();
    $.ajax({
        type: "POST",
        data: "ter="+inp,
        url: "\ajax.php",
        dataType: "json",
        error: function(){
            alert("Запрос завершился ошибкой!");
        },
        beforeSend: function(){
            $('#text').html('Проверка ...');
        },
        success: function(data){
            //alert("vvv");
            //$("#inp2").val(data.id);
            $("#text").text(data.password);
        }
    });
}
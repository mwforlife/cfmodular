window.onload= function(){
    $(".preloader").fadeOut(1000);
}

$(document).ready(function() {
    $("#ContactForm").on("submit", function(e) {
        e.preventDefault();
        
        $(".preloader").fadeIn(1000);
        $nombre = $("#nombre").val().trim();
        $email = $("#email").val().trim();
        $phone = $("#phone").val().trim();
        $asunto = $("#asunto").val().trim();
        $mensaje = $("#mensaje").val().trim();

        if(validarcampos($nombre) && validarcampos($email) && validarcampos($phone) && validarcampos($asunto) && validarcampos($mensaje)){

        var formData = $("#ContactForm").serialize();
        $.ajax({
            type: "POST",
            url: "php/contact.php",
            data: formData,
            success: function(data) {
                if(data==1){
                    swal.fire("¡Felicidades!","Mensaje enviado correctamente","success");
                    $("#ContactForm")[0].reset();
                    $(".preloader").fadeOut(1000);
                }else{
                    swal.fire("¡Error!","Error al enviar el mensaje \n "+data,"error");
                    $(".preloader").fadeOut(1000);
                }
            }
        });
        }else{
            Toast("Todos los campos son obligatorios");
                    $(".preloader").fadeOut(1000);
        }
    }
    );
}
);

function validarcampos(valor){
    if(valor.length == 0){
        return false;
    }else{
        return true;
    }
}

function Toast(mensaje){
    Toastify({
        text: mensaje,
        duration: 3000,
        close: true,
        gravity: "bottom", // `top` or `bottom`
        position: "right", // `left`, `center` or `right`
        backgroundColor: "linear-gradient(to right, #f6d365 0%, #fda085 100%)",
        stopOnFocus: true // Prevents dismissing of toast on hover
    }).showToast();
}
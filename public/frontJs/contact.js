$(function () {
    $(".saveContactInformation").click(function(){
        var contactName = $('#contactName').val();
        var contactEmail = $('#contactEmail').val();
        var contactText = $('#contactText').val();
        $.ajax({
            url: Routing.generate('contactus_save'),
            method: 'POST',
            data : {
                'contactName' : contactName,
                'contactEmail' : contactEmail,
                'contactText' : contactText,
            },
            success: function (result) {
                $('#contactName').val('')
                $('#contactEmail').val('')
                $('#contactText').val('');
                Toastify({
                    text: "Merci! Nous avons bien recu votre message.",
                    duration: 5000,
                    newWindow: true,
                    close: true,
                    gravity: "top", // `top` or `bottom`
                    position: "center", // `left`, `center` or `right`
                    stopOnFocus: true, // Prevents dismissing of toast on hover
                    style: {
                        background: "linear-gradient(to right, #98D8CA, #98D8CA)",
                        color: "black"
                    },
                    onClick: function(){} // Callback after click
                }).showToast();
            }
        });
    });
});
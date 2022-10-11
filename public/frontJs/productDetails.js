$(function(){
    $.ajax({
        url: Routing.generate('product_details_reviews'),
        method: 'POST',
        data : {
            'id' : $('#productId').val(),
        },
        success: function (result) {
            var html1 = '';
            $.each(result['reviews'], function (index, item) {

                html1+= '<li>'+
                    '<div class="product-review">'+
                    '<div class="thumb"><img src="assets/images/review/review-3.webp" alt=""></div>'+
                    '<div class="content">'+
                    '<div class="ratings">'+
                    '<span class="star-rating">'+
                    '<span class="rating-active" style="width: '+item.stars * 20+'%;">ratings</span>'+
                    '</span>'+
                    '</div>'+
                    '<div class="meta">'+
                    '<h5 class="title">'+item.userPrenom+' '+item.userNom+'</h5>'+
                    '<span class="date">'+item.dateReview+'</span>'+
                    '</div>'+
                    '<p>'+item.texteReview+'</p>'+
                    '</div>'+
                    '</div>'+
                    '</li>';
            });
            $('.reviewsList').html(html1);
            $('.totalReview').html(result.totalReview);
            $('.ratingProduct').css( "width", result.moyReview * 20+'%' )
        }


    });
})

$(function(){
    $('#sendReview').click(function(){
        $.ajax({
            url: Routing.generate('product_details_reviews_save'),
            method: 'POST',
            data : {
                'id' :$('#productId').val(),
                'reviewRating' :$("input[type='radio']:checked").val(),
                'reviewTexte' :$('.reviewTexte').val(),
            },
            success: function (result) {
                $.ajax({
                    url: Routing.generate('product_details_reviews'),
                    method: 'POST',
                    data : {
                        'id' : $('#productId').val(),
                    },
                    success: function (result) {
                        var html1 = '';
                        $.each(result['reviews'], function (index, item) {

                            html1+= '<li>'+
                                '<div class="product-review">'+
                                '<div class="thumb"><img src="assets/images/review/review-3.webp" alt=""></div>'+
                                '<div class="content">'+
                                '<div class="ratings">'+
                                '<span class="star-rating">'+
                                '<span class="rating-active" style="width: '+item.stars * 20+'%;">ratings</span>'+
                                '</span>'+
                                '</div>'+
                                '<div class="meta">'+
                                '<h5 class="title">'+item.userPrenom+' '+item.userNom+'</h5>'+
                                '<span class="date">'+item.dateReview+'</span>'+
                                '</div>'+
                                '<p>'+item.texteReview+'</p>'+
                                '</div>'+
                                '</div>'+
                                '</li>';
                        });
                        $('.reviewsList').html(html1);
                        $('.totalReview').html(result.totalReview);
                        $('.ratingProduct').css( "width", result.moyReview * 20+'%' )
                    }


                });

                $("#star5").attr('checked', true);


                $('.reviewTexte').val("")
                Toastify({
                    text: "Merci pour votre avis ! votre commentaire est en phase de verfication par notre administration",
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
    })
})



function removeFromCartDetails(id){
    $.ajax({
        url: Routing.generate('product_details_reviews'),
        method: 'POST',
        data : {
            'id' :id
        },
        success: function (result) {
            console.log(result.showCart);
            if(result.showCart){
                $('#addCartBtn').show();
                $('#removeCartBtn').hide()
            }else{
                $('#removeCartBtn').show()
                $('#addCartBtn').hide();
            }


            $.ajax({
                url: Routing.generate('cart_remove'),
                method: 'POST',
                data : {
                    'id' :id
                },
                success: function (result) {
                    $.ajax({
                        url: Routing.generate('cart_get'),
                        method: 'GET',
                        success: function (result) {
                            $('.blocCart'+id).hide(100);
                            if(result['countProduct'] == 0){
                                $('.cartCoupon').hide();
                                $('.cartTable').hide();
                                $('.totalCart').hide();
                                $('.msgEmptyCart').show();
                                $('.showCartInfo').hide();
                                $('#messageCartHours').hide();
                                $('#messagePanier').show();
                            }

                            var html1 = '';
                            $.each(result['products'], function (index, item) {
                                html1+= '<li class="blocCart'+item.product.id+'">'+
                                    '<a href="" class="image"><img src="'+item.product.image+'" alt="Cart product Image" height="70px" width="100px"></a>'+
                                    '<div class="content">'+
                                    '<a href="" class="title">'+item.product.title+'</a>'+
                                    '<span class="quantity-price"><span class="amount">'+item.product.price+' €</span></span>'+
                                    '<span class="remove" onclick="removeFromCart('+item.product.id+')">×</span>'+
                                    '</div>'+
                                    '</li>';
                            });
                            $('.panierList').html(html1);
                            $('.totalCartAmount').html(result['total'] + ' €');
                            $('.countProduct').html(result['countProduct']);

                            Toastify({
                                text: "vous avez supprimé un produit de votre panier !",
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
                }
            });
        }
    });
}

$(function(){
    var pId = $('#productId').val();
    $.ajax({
        url: Routing.generate('product_details_reviews'),
        method: 'POST',
        data : {
            'id' :pId
        },
        success: function (result) {
            if(result.showCart){
                $('#addCartBtn').hide();
                $('#removeCartBtn').show()
            }else{
                $('#removeCartBtn').hide()
                $('#addCartBtn').show();
            }
        }
    });
})





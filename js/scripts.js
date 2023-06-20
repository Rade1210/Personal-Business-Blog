
$(document).ready(function () {


    function validateEmail(email) {
        const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(String(email).toLowerCase());
    }

    $("#contactForm").submit(function(e){
        e.preventDefault();
        var form = $(this),
            formData = form.serialize();

        if($("#contactEmail").val().length==0) {
            alert("You need to enter your email address.")
            return false;
        }

        if(!validateEmail($("#contactEmail").val())){
            alert("Wrong email address format.")
            return false;
        }

        if($("#contactMessage").val().length==0) {
            alert("You need to enter message.")
            return false;
        }

        $("#contactSendBtn").html("Sending....").attr("disabled" , true);

        $.ajax({
            type:'POST',
            url:'send_contact_message.php',
            data:formData
        }).done(function(response){
            console.log(response);
            $("#contactSendBtn").html("Send").attr("disabled" , false);
            if(response=='sent'){
                alert("Message sent successfully");
                form[0].reset()
            }else{
                alert("Something went wrong, please try again.")
            }
        })

    })

    $(document).on("click" , '#searchIcon' , function(e){
        e.preventDefault();
        $(".search-div").slideToggle();
    })


    $('.menu-toggle').click(function () {
        $('.menu-toggle').toggleClass('activated');
        $('nav').toggleClass('activated');
        $('nav ul').toggleClass('showing');
    });

    var IMAGE_PATH = base_url(window.location.href);

    function base_url(segment){
        pathArray = window.location.pathname.split( '/' );
        indexOfSegment = pathArray.indexOf(segment);
        return window.location.origin + pathArray.slice(0,indexOfSegment).join('/') + '/';
    }

    function uploadImage(image) {
        var data = new FormData();
        data.append("image",image);
        $.ajax ({
            data: data,
            type: "POST",
            url: 'uploads.php',
            cache: false,
            contentType: false,
            processData: false,
            success: function(url) {
                var image = IMAGE_PATH + url;
                $('#body').summernote('insertImage', image);
            },
            error: function(data) {
                console.log(data);
            }
        });
    }

});

// ClassicEditor.create(document.querySelector('#body')).then(editor=>{}).catch(error=>{});


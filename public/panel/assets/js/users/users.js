$(document).ready(function(){
    $('#users_create').on('submit',function(e){
        e.preventDefault();

        $('.preloader').show();
        var form = new FormData(this);
        $.ajaxSetup({

            headers: {

                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

            }

        });
        $.ajax({

            type: 'POST',

            url: $(this).attr('action'),

            data : form,
            contentType: false,
            processData: false,
            success: function (data) {
                if(data.type == "success"){
                    $('.preloader').hide();
                    $.each(data.success_message_array, function (i, data){
                        Toastify({
                            title:"success",
                            text: data,
                            style: {
                                background: "green",
                            },
                            offset: {
                                x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                                y: 10 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                            },
                        }).showToast();

                    })

                    window.location.href = data.route_url;
                }else{
                    $.each(data.error, function (i, data){
                        Toastify({
                            title:"error",
                            text: data,
                            style: {
                                background: "red",
                            },
                            offset: {
                                x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                                y: 10 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                            },
                        }).showToast();

                        $('.preloader').hide();
                    })
                }
            },
            error: function(data)
            {
                Toastify({
                    title:"Error",
                    text: "An Error Occurred, please try again later.",
                    style: {
                        background: "red",
                    },
                    offset: {
                        x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                        y: 10 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                    },
                }).showToast();

                $('.preloader').hide();
            }

        });
    });

    $('#users_edit').on('submit',function(e){

        e.preventDefault();

        $('.preloader').show();
        var form = new FormData(this);
        $.ajaxSetup({

            headers: {

                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

            }

        });
        $.ajax({

            type: 'POST',

            url: $(this).attr('action'),

            data : form,
            contentType: false,
            processData: false,
            success: function (data) {

                if(data.type === "success"){
                    $.each(data.success_message_array, function (i, data){
                        Toastify({
                            title:"success",
                            text: data,
                            style: {
                                background: "green",
                            },
                            offset: {
                                x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                                y: 10 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                            },
                        }).showToast();
                    })

                    $('.preloader').hide();
                    location.reload()
                }else{
                    $.each(data.error, function (i, data){
                        Toastify({
                            title:"error",
                            text: data,
                            style: {
                                background: "red",
                            },
                            offset: {
                                x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                                y: 10 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                            },
                        }).showToast();

                        $('.preloader').hide();
                    })
                }
            },
            error: function(data)
            {
                Toastify({
                    title:"Error",
                    text: "An Error Occurred, please try again later.",
                    style: {
                        background: "red",
                    },
                    offset: {
                        x: 50, // horizontal axis - can be a number or a string indicating unity. eg: '2em'
                        y: 10 // vertical axis - can be a number or a string indicating unity. eg: '2em'
                    },
                }).showToast();

                $('.preloader').hide();
            }

        });
    });
});

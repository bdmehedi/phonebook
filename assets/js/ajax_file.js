$(document).ready(function () {

    //for user name unique.....
    $('#user_name').on('keyup', function () {
        var user_name = $('#user_name').val();

        $.ajax({
            'url': 'ajax_action.php',
            dataType: 'json',
            'data': {'user': 'true' ,'user_name': user_name},
            'type': 'post',
            'success': function (data) {
                console.log(data.result);
                if (data.success){
                    $('#user_name_valid').fadeOut();
                    $('#error_user_name').fadeIn();
                    $('#error_user_name').text('Opps, User name already added !');
                }else {
                    $('#error_user_name').fadeOut();
                    $('#user_name_valid').fadeIn();
                    if (user_name == ''){
                        $('#user_name_valid').fadeOut();
                    }
                }
            }
        });
    });


    $('#mobile').on('keyup', function () {
        var mobile = $('#mobile').val();

        $.ajax({
            'url': 'ajax_action.php',
            dataType: 'json',
            'data': {'phone': 'true' ,'mobile': mobile},
            'type': 'post',
            'success': function (data) {
                if (validate_form()){
                    $('#mobile_not_valid').fadeOut();
                    if (data.success){
                        $('#mobile_valid').fadeOut();
                        $('#error_mobile').fadeIn();
                        $('#error_mobile').text('Opps, Mobile number already added !');
                    }else {
                        $('#error_mobile').fadeOut();
                        $('#mobile_valid').fadeIn();
                        $('#submit_btn').prop('disabled', false);
                        if (mobile == ''){
                            $('#mobile_valid').fadeOut();
                            $('#mobile_not_valid').fadeOut();
                            $('#submit_btn').prop('disabled', true);
                        }
                    }
                }else {
                    $('#error_mobile').fadeOut();
                    $('#mobile_valid').fadeOut();
                    $('#mobile_not_valid').fadeIn();
                    $('#submit_btn').prop('disabled', true);
                    if (mobile == ''){
                        $('#mobile_not_valid').fadeOut();
                        $('#submit_btn').prop('disabled', true);
                    }
                }
            }
        });
    });

    // for Mobile add as category wise ............

    $('#add_mobile').on('keyup', function () {
        var mobile = $('#add_mobile').val();
        $.ajax({
            'url': 'ajax_action.php',
            dataType: 'json',
            'data': {'add_mobile': 'true' ,'mobile': mobile},
            'type': 'post',
            'success': function (data) {
                if (add_mobile_validation()){
                    console.log(data.success);
                    $('#mobile_not_valid').fadeOut();
                    if (data.success){
                        $('#mobile_valid').fadeOut();
                        $('#mobile_not_valid').fadeOut();
                        $('#error_mobile').fadeIn();
                        $('#error_mobile').text('Opps, Mobile number already added !');
                    }else {
                        $('#error_mobile').fadeOut();
                        $('#mobile_valid').fadeIn();
                        $('#submit_btn').prop('disabled', false);
                        if (mobile == ''){
                            $('#mobile_valid').fadeOut();
                            $('#mobile_not_valid').fadeOut();
                            $('#submit_btn').prop('disabled', true);
                        }
                    }
                }else {
                    $('#error_mobile').fadeOut();
                    $('#mobile_valid').fadeOut();
                    $('#mobile_not_valid').fadeIn();
                    $('#submit_btn').prop('disabled', true);
                    if (mobile == ''){
                        $('#mobile_not_valid').fadeOut();
                        $('#submit_btn').prop('disabled', true);
                    }
                }
            }
        });
    });

    // for Category selecting .............

    $('#category_btn').on('click', function () {
        $('#success_div').fadeOut();
        $('#error_div').fadeOut();
        var category_id = $('#category').val();
        var category = $('#category').html();

        // $.ajax({
        //     url: 'get/subjects',
        //     type: 'get',
        //     data: {'class_id': Class},
        //     success: function (data) {
        //         //console.log(data);
        //         for (var i = 0; i < data.length; i ++){
        //             subjects = subjects + '<option value="'+data[i].id+'">'+data[i].name+' ('+data[i].code+')</option>'
        //         }
        //         $('#subject_code').html(subjects);
        //     }
        // });

        $('#category_block').fadeIn(300);
        $('#show_category').html(category);
        $('#category').val(category_id);
        $('#submit').prop('disabled', false);

    });
});

function validate_form()
{
    if( document.validate.mobile.value == "" )
    {
        return false;
    }

    var mobileNumber = document.getElementById("mobile").value;
    var pattern =/^[0]{1}[1]{1}[1,5-9]{1}[0-9]{8}$/;
    if (!pattern.test(mobileNumber))
    {
        return false;
    }
    return( true );
}

// for add mobile.......
function add_mobile_validation()
{
    if( document.validate.mobile.value == "" )
    {
        return false;
    }

    var mobileNumber = document.getElementById("add_mobile").value;
    var pattern =/^[0]{1}[1]{1}[1,5-9]{1}[0-9]{8}$/;
    if (!pattern.test(mobileNumber))
    {
        return false;
    }
    return( true );
}
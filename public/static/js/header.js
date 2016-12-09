$(".public-header .login").click(function () {
    $(".login-mask").removeClass('hid');
});

$('.login-box .login').click(function () {
    $(".login-box .login-form").removeClass('hid');
    $(".login-box .register-form").addClass('hid');
});
$('.login-box .register').click(function () {
    $(".login-box .register-form").removeClass('hid')
    $(".login-box .login-form").addClass('hid');
});

$(".login-mask").click(function () {
    $(".login-mask").addClass('hid');
});
$(".login-box").click(function () {
    event.stopPropagation();

});
//登陆
$("#login").click(function () {
    var account = $(".l-account").val(),
        password = $(".l-password").val(),
        v = {
            account : account,
            password : password
        };
    console.log(v);

    $.get('index/login',v,
        function (data,status) {
            if(data.ret == 1){
                // $(".login-mask").addClass('hid');
                window.location.reload();
            }else{
                alert('密码错误');
            }
        },'json')

});

//注册
$("#register").click(function () {
    var account = $(".r-account").val(),
        password = $(".r-password").val(),
        v = {
            account : account,
            password : password
        };
    console.log(v);

    $.post('index/user/register',v,
        function (data,status) {
            console.log(data);
        },'json'
    );
});
const currentTheme = localStorage.getItem("theme");

if (currentTheme == "dark") {
  var allElement = document.getElementsByClassName("dual-theme");
    for(var i=0; i<allElement.length; i++) {
        allElement[i].classList.add("dark-mode");
    }

  document.getElementById("btn-dark").classList.add("active");
} else {
    document.getElementById("btn-light").classList.add("active");
}

function setDarkMode(isDark) {
    var allElement = document.getElementsByClassName("dual-theme");
    for(var i=0; i<allElement.length; i++) {
        if (isDark) {
            allElement[i].classList.add("dark-mode");
            localStorage.setItem("theme", "dark");
           
        } else 
        {
            allElement[i].classList.remove("dark-mode");
            localStorage.setItem("theme", "light");
        }
    }
 }

function analyticLog(label,attr = {}) {
    attr.from = document.referrer;
    // console.log(label+": ",attr);
    firebase.analytics().logEvent(label, attr);
}

$(document).ready(function(){

    $('#btn-recommendation').click(function(){
        $('.bgblack').fadeIn();
        $('#content-recommendation').fadeIn();
        $('.btn-close').fadeIn();
        console.log('qweqwe');
    });

    $('.bgblack').click(function(){
        $('.recommendation-mobile').fadeOut();
        $('.bgblack').fadeOut();
        $('.btn-close').fadeOut();
        $('.popup-kurs').fadeOut();
        console.log('asdasd');
    });

    $('#btn-kurs').click(function(){
        $('.bgblack').fadeIn();
        $('.popup-kurs').fadeIn();
        $('.btn-close').fadeIn();
        console.log('zxczxc');
    });

    $("#subscribe-checkbox").on("click", function() {

        var value = $('#subscribe-checkbox').prop("checked");
        var checked = value ? 1 : 0;

        $.ajax({
            type : 'get',
            url : baseurl+'ajax/subscribe/'+checked,
            dataType : 'json',
            success : function(d) {
                if (d.code == 200) {
                    swal('Success',d.message,'warning');
                } else {
                    swal('Failed',d.message,'error');
                }
            },
            error : function(e) {
                console.log(e);
            } 
        });
    });

    $('.toggle-mobile').click(function (e) {
        e.preventDefault();
        $('header ul.menu-top').animate({
            width: "toggle"
        });
        $('html, body').toggleClass('toggle-active');
    });

    $(window).resize(function(){
        var width = $(window).width();
        if(width < 768){
            $('ul.menu-top').click(function(){
                $('header ul.menu-top').animate({
                    width: "toggle"
                });
                $('html, body').toggleClass('toggle-active');
            });
        }
     })
     .resize();
      
    $('.count-like').click(function (){
        var nid = $(this).data("nid");
        var identifier = $(this).data("identifier");
        var type = $(this).data("type");
        $.ajax({
            type : 'get',
            url : baseurl+'ajax/like/'+identifier+'/'+nid+'/'+type,
            dataType : 'json',
            success : function(d) {
                if (d.code == 200) {
                    document.getElementById("like-count").innerHTML = d.result;
                } else {
                    swal('Ups','Please login first','warning');
                }
            },
            error : function(e) {
                console.log(e);
            } 
        });
    });

    $("#form-login").submit(function(){      
        $.ajax({
            type : 'post',
            url : $("#form-login").attr('action'),
            data : $("#form-login").serialize(),
            dataType : 'json',
            success : function(d) {
                if(d.code == 200) {
                    swal('Selesai','Login success.','success');
                    setTimeout(function(e){
                        var prev = document.referrer;
                        if (prev.includes("register") || prev.includes("forgot")) {
                            window.location.replace('home');
                        } else {
                            window.location.replace(prev);
                        }
                    },2000);
                } else {
                    swal('Failed','Wrong email or password.','error');
                }
            },
            error : function(e) {
                console.log(e);
            } 
        });
        return false;        
    });

    $("#form-forgot").submit(function(){      
        $.ajax({
            type : 'post',
            url : $("#form-forgot").attr('action'),
            data : $("#form-forgot").serialize(),
            dataType : 'json',
            success : function(d) {
                if(d.code == 200) {
                    swal('Success','Please check your email.','success');
                    setTimeout(function(e){
                        window.location.replace('login');
                    },2000);
                } else {
                    swal('Failed','Email not found.','error');
                }
            },
            error : function(e) {
                console.log(e);
            } 
        });
        return false;        
    });

    $("#form-reset").submit(function(){      
        $.ajax({
            type : 'post',
            url : $("#form-reset").attr('action'),
            data : $("#form-reset").serialize(),
            dataType : 'json',
            success : function(d) {
                if(d.code == 200) {
                    swal('Success','Reset password success.','success');
                    setTimeout(function(e){
                        window.location.replace('login');
                    },2000);
                } else {
                    swal('Failed',d.message,'error');
                }
            },
            error : function(e) {
                console.log(e);
            } 
        });
        return false;        
    });

    $("#form-reset-password").submit(function(){      
        $.ajax({
            type : 'post',
            url : $("#form-reset-password").attr('action'),
            data : $("#form-reset-password").serialize(),
            dataType : 'json',
            success : function(d) {
                if(d.code == 200) {
                    swal('Success','Reset password success.','success');
                    setTimeout(function(e){
                        location.reload();
                    },2000);
                } else {
                    console.log(d);
                    var regex = /(<([^>]+)>)/ig
                    ,   body = d.message
                    ,   result = body.replace(regex, "");
                    swal('Failed',result,'error');
                }
            },
            error : function(e) {
                console.log(e);
            } 
        });
        return false;        
    });

    $(".form-search").submit(function(){   
        var keyword = encodeURIComponent(this.keyword.value);
        var url = baseurl+'search/'+keyword;
        window.location.replace(url);
        // console.log(url);
        return false;
    });

    $("#form-comment").submit(function(){      
        $.ajax({
            type : 'post',
            url : $("#form-comment").attr('action'),
            data : $("#form-comment").serialize(),
            dataType : 'json',
            success : function(d) {
                if(d.code == 200) {
                    location.reload();
                    // swal('Selesai', d.message, 'success');
                    // setTimeout(function(e){
                    //     location.reload();
                    // },3000);
                } else {
                    swal('Ups', d.message, 'warning');
                }
            },
            error : function(e) {
                console.log(e);
            } 
        });
        return false;        
    });

    var $formRegister = $("#form-register");
    if($formRegister.length){
        $formRegister.validate({
            focusInvalid: false,
            onfocusout:false,
            rules: {
                name:{
                    required: true
                },
                email:{
                    required: true,
                    email: true
                },
                password:{
                    required: true
                },
                confirmpassword:{
                    required: true
                }
            },
            messages:{
                name:{
                    required: 'Please insert your name'
                },
                email:{
                    required: 'Please insert your email'
                },
                password:{
                    required: 'Please insert your password'
                },
                confirmpassword:{
                    required: 'Make sure confirm password matchs with yout password'
                },
            },
            errorPlacement: function(error, element){
                if(element.is(":radio")){
                    error.appendTo('#error');
                }else{
                    error.insertAfter(element);
                }
            },
            submitHandler: function(form) {
                $.ajax({
                    type : 'post',
                    url : $("#form-register").attr('action'),
                    data : $("#form-register").serialize(),
                    dataType : 'json',
                    success : function(d) {
                        if(d.code == 200) {
                            swal('Selesai','Terimakasih sudah bergabung dengan kami.','success');
                            setTimeout(function(e){
                                window.location.replace('login');
                            },5000);
                        } else {
                            swal('Failed','Email has been registered.','error');
                        }
                    },
                    error : function(e) {
                        console.log(e);
                    } 
                });
            }
        });
    }

    $(".analytic-listener").click(function(){
        var label = $(this).data('label'),
            attr = {};
        
        attr = $(this).data('attr');
        if (attr != null) {
            attr = attr.replaceAll("'", "\"");
            attr = JSON.parse(attr);
        }

        analyticLog(label,attr);
    });

    $(".copy-link").click(function(){
        var copyText = document.getElementById("Url");
        copyText.select();
        copyText.setSelectionRange(0, 99999);
        document.execCommand("copy");
        alert("Copied url: " + copyText.value);
    });

    $(".sharer.twitter").click(function(){
    	var url = document.location.href;
    	window.open('http://twitter.com/share?&url='+encodeURI(url));
    });

    $(".sharer.facebook").click(function(){
		var url = document.location.href;
		window.open('https://www.facebook.com/sharer/sharer.php?u='+encodeURI(url));
    });

    $(".sharer.whatsapp").click(function(){
    	var url = document.location.href;
    	window.open('whatsapp://send?text='+encodeURI(url));
    });

    return false;
});

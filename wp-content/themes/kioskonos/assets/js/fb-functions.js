window.fbAsyncInit = function() {
    FB.init({
        appId      : '742882742916520',
        xfbml      : true,
        version    : 'v7.0'
    });
    init();
};

(function(d, s, id){
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) {return;}
    js = d.createElement(s); js.id = id;
    js.src = "https://connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));



function init(){
    FB.getLoginStatus(function(response) {
        console.log(response);
    });
}

function fbLogin(){
    FB.login(function(response){
        console.log(response);
    });
};
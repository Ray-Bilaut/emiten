
// Initialize Firebase
firebase.initializeApp(firebaseConfig);
firebase.analytics();

const messaging = firebase.messaging();

messaging
  .requestPermission()
  .then(function () {
    // console.log("Notification permission granted.");
    // get the token in the form of promise
    return messaging.getToken()
  })
  .then(function(token) {
    // console.log('token', token);
    var oldToken = localStorage.getItem("fcm_token");

    var data = {token: token, old_token: oldToken};

    if (oldToken != token) {
      $.ajax({
        type : 'post',
        url : baseurl+'ajax/addFcmToken',
        data : data,
        dataType : 'json',
        success : function(d) {
            console.log('response', d);
            if(d.code == 200) {
              localStorage.setItem("fcm_token", token);
            }
        },
        error : function(e) {
            console.log('error', e);
        } 
      });
    }
  })
  .catch(function (err) {
  console.log("Unable to get permission to notify.", err);
});

messaging.onMessage(function(payload){
  if (!Notification) {
    console.log('This browser doesn\'t support Desktop Notification');
    return;
   }
  
  if (Notification.permission !== 'granted') {
    Notification.requestPermission();
  }
    
  var json = JSON.parse(payload.data.notification);

  var notification = new Notification(json.title, {
    icon: json.icon,
    body: json.body,
  });

   notification.onclick = function (event) {
    event.preventDefault();
    notification.close();
    window.open(json.url);
  } 

   console.log('onMessage',json);
})

$(document).ready(function(){
  
});
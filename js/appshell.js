//Globals
var currentUser = null;
var currentUserId = null;
var token = 1;
var changeIt = false;
var usernameChange = null;

//set up the doc, setup menus,look for cookie, login if exists
$(document).ready(function() {
    //toogle menus for logged off state
    toggleLoginLogoffItems(false);
    $("#loginPageSignUpLink").on("click", function() {
        $("#signupNavItem").click();
    });
    //grab auto cookie if applicable
    //store token
    if($.cookie('appshell')) {
        token = $.cookie('appshell');
        //alert (token);
        //$("#ajaxContent").text("");   //debug

        //send ajax request using cookie data for autologin
        $.ajax({ 
            url: 'autoLogin.php',
            type: 'GET',
            data:	{ 
                        token:      token
                    },
    
            dataType: 'HTML', 
            success:	function(data){
                            console.log("Setting result");
                            //$("#ajaxContent").append(data); //debug
            
                            try {
                                data = JSON.parse(data);
    
                                alert("Welcome Back to Sonya!");
                                    $(data.user).each(function(index,value) {
                                            //grab name and id for display  
                                            var loadName = value.name;
                                            currentUserId = value.id;
                                            $("#loggedInName").text(loadName);
                                            $("#pId").text(loadName);
                                        }); 
                               
                                //load current user into global variable        
                                currentUser = data.user; // set the currentUser to the global variable
                                
                                //turn on logged in menu items
                                toggleLoginLogoffItems(true); 
                                                      
                            } catch (ex) {
                                alert(ex);
                            }
                        },
            error: 	    function (xhr, ajaxOptions, thrownError) {
                            alert("-ERROR:" + xhr.responseText + " - " + 
                            thrownError + " - Options" + ajaxOptions);
                        },
            complete:   function(xhr, status) {
                console.log("The request is complete!");
            }
        });
    }
});

//function to turn classes on and off throughout system for menus if logged in or out
function toggleLoginLogoffItems(loggedin) {
    if(loggedin == true){
        $('.loggedOn').show();
        $('.loggedOff').hide();
  
    } else {// login = false 
        $('.loggedOn').hide();
        $('.loggedOff').show();
    }
}
//if logout is clicked, do the following
$('#logoutNavItem').on("click", function() {
    //clear globals, toggle menus, remove auto cookie, go back to main window
    currentUser = null;
    var currentUserId = null;
    toggleLoginLogoffItems(false);
    $.removeCookie('appshell'); 
    window.location = 'main.php';
    //$("#ajaxContent").text(""); // debug
});
//if remember me clicked on login screen
$("#rememberMe" ).on("click", function() {
    //create rand number for use as token
    var rand = function() {
        return Math.random().toString(36).substr(2); // remove `0.`
    };  
    var createToken = function() {
        return rand() + rand(); // to make it longer
    };
    //create the token, store in var
    token = createToken();
    //create the autologin cookie
    var CookieSet = $.cookie("appshell", token, { expires: 7 });
});
//is email validate
function validate_Email(sender_email) {
    var expression = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
    if (expression.test(sender_email)) {
        return true;
    }
    else {
        return false;
    }
}
//menu item sign up is clicked
$('#signUpButton').on('click', function() {
    //grab email value
    var sender_email = $('#signUpEmail').val();

    //$("#ajaxContent").text(""); //debug
    
    //  check all fields - they are mandatory
    if ($.trim(sender_email).length == 0 || $("#signUpUsername").val()=="" || $("#signUpName").val()=="" || $("#signUpPassword").val()=="" || $("#signUpConfirmPassword").val()=="") {
        alert('All fields are Mandatory! Try again');
        return;
    }
    
    //using function check email - if not, alert
    if (!validate_Email(sender_email)) {
        alert('Invalid Email Address');
        return false;
    }

    if($('#signUpPassword').val() != $('#signUpConfirmPassword').val()) {
        alert("Passwords Must Match");
        return ; 
    }

    $.ajax({ //
        url: 'signup.php',
        type: 'POST',
        data:	{ 
                    username:   $("#signUpUsername").val(), 
                    name:       $("#signUpName").val(),
                    email:      $("#signUpEmail").val(),
                    password:   $("#signUpPassword").val()
                },

        dataType: 'HTML', // json return
        success:	function(data){
                        console.log("Setting result"); //debug tracking
                        //$("#ajaxContent").append(data);
                        
                        try {
                            data = JSON.parse(data);

                            alert("Success - User was Added to Sonya");

                            //parse data to get the login name and set user id
                                $(data.user).each(function(index,value) {
                                    var loadName = value.name;
                                    currentUserId = value.id;
                                    $("#loggedInName").text(loadName);
                                    $("#pId").text(loadName);
                                    }); 

                            //sets this user as the current as global
                            currentUser = data.user; 
                            //turn on the logged in menu items
                            toggleLoginLogoffItems(true);
                            //load front page
                            $("#homeNavItem").click();
                            //clear the fields in the sign up form
                            username:   $("#signUpUsername").val("");
                            name:       $("#signUpName").val("");
                            email:      $("#signUpEmail").val("");
                            password:   $("#signUpPassword").val("");
                            password:   $("#signUpConfirmPassword").val("");
                                                  
                        } catch (ex) {
                            alert(ex);
                        }
                    },
        error: 	    function (xhr, ajaxOptions, thrownError) {
                        alert("-ERROR:" + xhr.responseText + " - " + 
                        thrownError + " - Options" + ajaxOptions);
                    },
        complete:   function(xhr, status) {
            console.log("The request is complete!"); //debug if round trip
        }
    }); 	
});
//menu item login is clicked
$('#loginButton').on('click', function() {
       //$("#ajaxContent").text(""); // debug
    
       //Both required to continue
    if ($("#loginUsername").val()=="" || $("#loginPassword").val()=="") {
        alert('Both fields are mandatory! Try again');
        return ; 
    };

    //set up ajax call
    $.ajax({ 
        url: 'login.php',
        type: 'POST',
        data:	{ 
                    username:   $("#loginUsername").val(), 
                    password:   $("#loginPassword").val(),
                    token:      token // load this to bypass login
                },

        dataType: 'HTML', 
        success:	function(data){
                        console.log("Setting result");
                        //$("#ajaxContent").append(data);
        
                        try {
                            data = JSON.parse(data);

                            alert("Welcome to Sonya");
                                $(data.user).each(function(index,value) {
                                        //console.log(value.name);  
                                        var loadName = value.name;
                                        currentUserId = value.id;
                                        $("#loggedInName").text(loadName);
                                        $("#pId").text(loadName);
                                    }); 
                            //set current user to global
                            currentUser = data.user; // set the currentUser to the global variable
                            //turn on menu items
                            toggleLoginLogoffItems(true);
                            //go to main page and clear the fields
                            $("#homeNavItem").click();
                            $("#loginUsername").val("");
                            $("#loginPassword").val("");
                            $('#rememberMe').prop('checked', false);
                         
                        } catch (ex) {
                            alert(ex);
                        }
                    },
        error: 	    function (xhr, ajaxOptions, thrownError) {
                        alert("-ERROR:" + xhr.responseText + " - " + 
                        thrownError + " - Options" + ajaxOptions);
                    },
        complete:   function(xhr, status) {
            console.log("The request is complete!");
        }
    }); 	
});
//menu item manage account it clicked
$('#manageAccountNavItem').on('click', function() {
    //check the current form value with the initial load from db
        $.ajax({ 
            url:  'manage.php',
            type: 'POST',
            data: {
                username:   $("#manageUsername").val(), 
                name:       $("#manageName").val(),
                email:      $("#manageEmail").val(),
                id:         currentUserId,
                changeIt:   changeIt
            },
            dataType: 'html', 
            success:	function(data){
                            console.log("Setting result");
                            //$("#ajaxContent").append(data); //debug
                            try {
                                data = JSON.parse(data);
                                    
                                    $(data.user).each(function(index,value) {
                                        //fill window with db values  
                                        $("#manageName").val(value.name);   
                                        $("#manageEmail").val(value.email);
                                        $("#manageUsername").val(value.username);       
                                        usernameChange = value.username;     
                                    });               
                                 } catch (ex) {
                                alert(ex);
                            }
                        },
            error: 	    function (xhr, ajaxOptions, thrownError) {
                            alert("-ERROR:" + xhr.responseText + " - " + 
                            thrownError + " - Options" + ajaxOptions);
                        },
            complete:   function(xhr, status) {
                    console.log("The request is complete!");
            }
        }); 	
    });

// when submit is clicked on manage account
$('#manageSubmitButton').on('click', function() {
    //check the current form value with the initial load from db
    if ((usernameChange != null) && usernameChange != $("#manageUsername").val()) {
        changeIt = true; 
        };

        $.ajax({ 
            url:  'manageUpdate.php',
            type: 'POST',
            data: {
                username:   $("#manageUsername").val(), 
                name:       $("#manageName").val(),
                email:      $("#manageEmail").val(),
                id:         currentUserId,
                changeIt:   changeIt
            },
            dataType: 'html', 
            success:	function(data){
                            console.log("Setting result");
                            //$("#ajaxContent").append(data); //debug
                            alert("Successful update");
                            try {
                                data = JSON.parse(data);
                                    //parse data to get the login name and set user id
                                    $(data.user).each(function(index,value) {
                                        var loadName = value.name;
                                        currentUserId = value.id;
                                        $("#loggedInName").text(loadName);
                                        $("#pId").text(loadName);
                                    }); 
                                    //sets this user as the current as global
                                    currentUser = data.user; 
                                    //turn on the logged in menu items
                                    toggleLoginLogoffItems(true);
                                    //load front page
                                    $("#homeNavItem").click();
                                    $("#manageName").val("");   
                                    $("#manageEmail").val("");
                                    $("#manageUsername").val("");       
                                    $("#homeNavItem").click();    
                                                   
                                 } catch (ex) {
                                alert(ex);
                            }
                        },
            error: 	    function (xhr, ajaxOptions, thrownError) {
                            alert("-ERROR:" + xhr.responseText + " - " + 
                            thrownError + " - Options" + ajaxOptions);
                        },
            complete:   function(xhr, status) {
                    console.log("The request is complete!");
            }
        }); 	
    });

//when password reset button is clicked on password modal, manage account
$('#passwordUpdateButton').on('click',function(){
    //check for mandatory fields
    if ($("#currentPassword").val()=="" || $("#newPassword").val()=="" || $("#confirmNewPassword").val()=="") {
        alert('All fields are mandatory! Try again');
        return ; 
    };
    //ensure passwords match
    if($('#newPassword').val() != $('#confirmNewPassword').val()) {
        alert("passwords must match");
         // evt.preventDefault(); {
        return ; 
    }
    $.ajax({ 
        url: 'passwordUpdate.php',
        type: 'POST',
        data:	{ //name value pair
                    id:         currentUserId,
                    currentPassword:     $("#currentPassword").val(),
                    newPassword:   $("#newPassword").val()    
                },

        dataType: 'html', //expecting html back from this call
        success:	function(data){
                        console.log("Setting result");
                        //$("#ajaxContent").append(data);
                        alert("success");

                        try {
                            data = JSON.parse(data);
                            currentPassword:    $("#currentPassword").val("");
                            newPassword:        $("#newPassword").val("");
                            confirmNewPassword:  $("#confirmNewPassword").val("");
                            $("#resetModal").modal('hide');
                            $("#manageAccount").hide();
                            $("#homeNavItem").click();


                             } catch (ex) {
                            alert(ex);
                        }
                    },
        error: 	    function (xhr, ajaxOptions, thrownError) {
                        alert("-ERROR:" + xhr.responseText + " - " + 
                        thrownError + " - Options" + ajaxOptions);
                    },
        complete:   function(xhr, status) {
            console.log("The request is complete!");
        }
    }); 	

});


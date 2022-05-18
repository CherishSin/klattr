var klattr_recipient = "";
var klattr_parent_id = "";
var oldest_klattr;
var loading_content = 0;
var profile_id;
var search_term;



  function validateEmailAddr(email) {
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
  }

  function validateNameString(name) {
    var re = /^[a-zA-Z]+[a-zA-Z ]+$/;
    return re.test(name);
  }

  function validateUnameString(uname) {
    var re = /^[a-zA-Z0-9_]+$/;
    return re.test(uname);
  }

  function validateForm(Exist)
  {
    a = validateName();
    b = validateEmail(Exist);
    c = validatePassword();
    d = validateUsername(Exist);
    if (a + b + c + d == 0) {
      document.getElementById("sub_div").innerHTML = "<input type=\"submit\" class=\"submit_signup\" style=\"width:200px;\" value=\"Sign Up!\">";
    } else {
      document.getElementById("sub_div").innerHTML = "<input type=\"button\" class=\"button_inactive\" style=\"width:200px;\" value=\"Form Incomplete!\">";
    }
    Exists = 0;
  }

  function validatePasswordReset(Exists)
  {
    a = validatePassword();
    b = validatePassword2();
    if (a + b == 0) {
      document.getElementById("sub_div").innerHTML = "<input type=\"submit\" class=\"submit_signup\" style=\"width:200px;\" value=\"Reset Password!\">";
    } else {
      document.getElementById("sub_div").innerHTML = "<input type=\"button\" class=\"button_inactive\" style=\"width:200px;\" value=\"Form Incomplete!\">";
    }
    Exists = 0;
  }

  function validateName()
  {
    var nameString=document.forms["SignUp"]["name"].value;
    if (nameString==null || nameString==""){
      document.getElementById("val_name").innerHTML = "<font color=\"red\"> &#8678; You'll need a name.</font>";
      return 1;
    } else {
      if (validateNameString(nameString)) {
        document.getElementById("val_name").innerHTML = "<font color=\"green\"> &#10004; That name is fine.</font>";
        return 0;
      } else {
        document.getElementById("val_name").innerHTML = "<font color=\"red\"> &#8678; Letters only please.</font>";
        return 1;
      }
    }
  }

  function validateEmail(Exist)
  {
    if (Exist == 20 || Exist == 22) {
      document.getElementById("val_email").innerHTML = "<font color=\"red\"> &#8678; That address has been used.</font>";
      return 1;
    } else {
      var emailString=document.forms["SignUp"]["email"].value;
      if (emailString==null || emailString==""){
        document.getElementById("val_email").innerHTML = "<font color=\"red\"> &#8678; You'll need an eMail address.</font>";
        return 1;
      } else {
        if (validateEmailAddr(emailString)){
          document.getElementById("val_email").innerHTML = "<font color=\"green\"> &#10004; eMail address looks good.</font>";
          return 0;
        } else {
          document.getElementById("val_email").innerHTML = "<font color=\"red\"> &#8678; Are you sure?.</font>";
          return 1;
        }
      }
    }
  }

  function validatePassword()
  {
    var passString=document.forms["SignUp"]["password"].value;
    if (passString==null || passString==""){
      document.getElementById("val_pass").innerHTML = "<font color=\"red\"> &#8678; You'll want a password.</font>";
      return 1;
    } else {
      if (passString.length < 6){
        document.getElementById("val_pass").innerHTML = "<font color=\"red\"> &#8678; Six characters or more please.</font>";
        return 1;
      } else {
        document.getElementById("val_pass").innerHTML = "<font color=\"green\"> &#10004; Password is alright.</font>";
        return 0;
      }
    }
  }

  function validatePassword2()
  {
    var pass2String=document.forms["SignUp"]["password2"].value;
    var passString=document.forms["SignUp"]["password"].value;
    if (pass2String==null || pass2String==""){
      document.getElementById("val_pass2").innerHTML = "<font color=\"red\"> &#8678; Please retype Password.</font>";
      return 1;
    } else {
      if (pass2String == passString) {
        document.getElementById("val_pass2").innerHTML = "<font color=\"green\"> &#10004; Looks good.</font>";
        return 0;
      } else {
        document.getElementById("val_pass2").innerHTML = "<font color=\"red\"> &#8678; Passwords must match.</font>";
        return 1;
      }
    }
  }

  function validateUsername(Exist)
  {
    if (Exist == 2 || Exist == 22) {
      document.getElementById("val_uname").innerHTML = "<font color=\"red\"> &#8678;That username's gone. Sorry.</font>";
      return 1;
    } else {
      var unameString=document.forms["SignUp"]["username"].value;
      if (!validateUnameString(unameString)){
        if ( unameString == "") {
          document.getElementById("val_uname").innerHTML = "<font color=\"red\"> &#8678; A username is a must.</font>";
        } else {
          document.getElementById("val_uname").innerHTML = "<font color=\"red\"> &#8678; Letters and numbers only.</font>";
        }
        return 1;
      } else {
        if (unameString.length < 3) {
          document.getElementById("val_uname").innerHTML = "<font color=\"red\"> &#8678; At least three characters.</font>";
          return 1;
        } else {
          document.getElementById("val_uname").innerHTML = "<font color=\"green\"> &#10004; Looks good!";
          return 0;
        }
      }
    }  
  }

  function editstyle(Element)
  {
    El = document.getElementById(Element);
    El.style.boxShadow = '0px 0px 1px 2px #44ff44';
    El.style.cursor = 'url(/gfx/edit_cur.cur),auto';
  }

  function normalstyle(Element)
  {
    El = document.getElementById(Element);
    El.style.boxShadow = 'none';
    El.style.cursor = 'auto';

  }

  function showeditor(EditItem)
  {
    fade_in('dim', 0, 0.7);
    fade_in(EditItem, 0, 1);
    slide_in(EditItem, 100);
    document.getElementsByTagName("body")[0].style.overflow = "hidden";
    get_mic();
    
  }

  function showAlert(EditItem)
  { 
    fade_in(EditItem, 0, 1);
    slide_in(EditItem, 20);
    
  }

  function hideeditor(EditItem)
  {
    document.getElementById('dim').style.opacity = '0';
    document.getElementById('dim').style.filter = 'alpha(opacity=0)';

    document.getElementById(EditItem).style.opacity = '0';
    document.getElementById(EditItem).style.filter = 'alpha(opacity=0)';

    document.getElementById('dim').style.visibility = 'hidden';
    document.getElementById(EditItem).style.visibility = 'hidden';
    document.getElementsByTagName("body")[0].style.overflow = "auto";
  }

  function hideAlert(EditItem)
  {
    fade_out(EditItem, 1, 0);
    //document.getElementById(EditItem).style.opacity = '0';
    //document.getElementById(EditItem).style.filter = 'alpha(opacity=0)';
    //document.getElementById(EditItem).style.visibility = 'hidden';

  }

  function readURL(input)
  {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
     
      reader.onload = function (e) {
        $('#image_upload').attr('src', e.target.result);
      }
            
      reader.readAsDataURL(input.files[0]);
    }
  }
    
  $("#imgInp").change(function(){
    readURL(this);
  });

  function slide_in(element, terminus) {
    top_modifier = document.documentElement.scrollTop || document.body.scrollTop;
    etop = top_modifier -400; 
    terminus += top_modifier;
    var timer = setInterval(function() {
//      console.log(etop)
      if (etop >= terminus){
        clearInterval(timer);
      }
      document.getElementById(element).style.top = '' + etop + 'px';
//console.log(document.getElementById(element).style.top)
      etop += 16;
    }, 1);
  }

  function fade_in(element, start, end) {
    op = start;  // initial opacity
    document.getElementById(element).style.visibility = 'visible';
    var timer = setInterval(function () {
      if (op >= end ){
        clearInterval(timer);
      }
      document.getElementById(element).style.opacity = parseFloat(op);
      document.getElementById(element).style.filter = 'alpha(opacity=' + parseFloat(op * 100) + ")";
      op += 0.1;
    }, 20);
  }

  function fade_out(element, start, end) {
    op = start;  // initial opacity
    var timer = setInterval(function () {
      if (op <= end ){
        clearInterval(timer);
      }
      document.getElementById(element).style.opacity = parseFloat(op);
      document.getElementById(element).style.filter = 'alpha(opacity=' + parseFloat(op * 100) + ")";
      op -= 0.1;
    }, 20);
    document.getElementById(element).style.visibility = 'hidden';
  }


  function make_submit_form() {
    document.getElementById("Add_title").innerHTML = "<div class=\"form_line\" style=\"margin-right:0px\"><div class=\"form_text\">Add a title:</div><input type=\"text\" class=\"gen_input\" maxlength=\"20\" style=\"width:300px;\" name=\"klattr_title\"></div><div class=\"form_line\" style=\"margin-right:0px\"><div class=\"form_text\">Add recipients (Max 5):</div><input type=\"text\" class=\"gen_input\" style=\"width:300px;\" name=\"klattr_recipients\" id=\"klattr_recipients\"></div>"; 
    document.getElementById("Add_tags").innerHTML = "<div id=\"output\"></div><div class=\"form_line\" style=\"margin-right:0px\"><div class=\"form_text\">Add some tags:</div><input type=\"text\" class=\"gen_input\" style=\"width:300px;\" name=\"klattr_tags\"></div>";
    document.getElementById("button_line").innerHTML = "<input type=\"button\" class=\"submit_login\" style=\"width:100px;\" value=\"Send It\" onclick=\"save_recording()\"><input type=\"button\" onclick=\"hideeditor('record_popup');reset_recording();destroy_submit_form();\" class=\"cancel_login\" style=\"width:100px;\" value=\"Cancel\">";
    
    document.getElementById("klattr_recipients").value = klattr_recipient;
    
  }

  function destroy_submit_form() {
    document.getElementById("Add_title").innerHTML = "";
    document.getElementById("Add_tags").innerHTML = "";
    document.getElementById("button_line").innerHTML = "<input type=\"button\" onclick=\"hideeditor('record_popup');reset_recording();destroy_submit_form();\" class=\"cancel_login\" style=\"width:100px;margin-right:0px\" value=\"Cancel\">";
    document.getElementById('record_div').className = "record_div";
    document.getElementById('record_div').style.width = "470px";
    document.getElementById('record_div').innerHTML = "<div class=\"progress\" id=\"progress\"><div id=\"instructions\" style=\"position:relative;top:18px;left:30px;float:left;width:300px\"><-- Click to start recording</div></div>";
    document.getElementById('klattr_wrapper').innerHTML = "<input type=\"button\" id=\"do_record\" class=\"rec_button\" onclick=\"record(19500);toggle_recording()\" style=\"z-index:100;top:1px;left:0px;\">";
    klattr_parent_id = "";
  }

  function send_klattr_form(Kblob) {
    document.getElementById('record_div').className = "blank"
    document.getElementById('record_div').innerHTML = "<img src=\"/gfx/wait.gif\" class=\"centred\">"; 
    document.getElementById('record_div').style.width = "500px";   
    document.getElementById('klattr_wrapper').innerHTML = ""; 
    var
      oOutput = document.getElementById("output"),
      oData = new FormData(document.forms.namedItem("SubmitKlattr"));
    if (klattr_parent_id != "") {
      oData.append("parent_id", klattr_parent_id);
    }
    oData.append("klattr_audio", Kblob);

    var oReq = new XMLHttpRequest();
    oReq.open("POST", "/process_klattr.php", true);
    oReq.onload = function(oEvent) {
      hideeditor('record_popup');
      destroy_submit_form();
      reset_recording();
      if (oReq.status == 200) {
        popAlert("Uploaded!");
        location.reload();
      } else {
        popAlert("Error " + oReq.status + " occurred uploading your file.<br \/>");
      }
    };

  oReq.send(oData);
  }


  function popAlert(message) {
    document.getElementById('popAlert_message').innerHTML = message;
    showAlert('popAlert'); 
    setTimeout(function(){hideAlert('popAlert')}, 2000); 
  }

  function delete_klattr(klattr) {
    console.log(document.forms.namedItem("delete"))
    console.log("here")
    var
      oOutput = document.getElementById("output"),
      oData = new FormData(document.forms.namedItem("delete"));

    oData.append("klattr", klattr);

    var oReq = new XMLHttpRequest();
    oReq.open("POST", "/delete_klattr.php", true);
    oReq.onload = function(oEvent) {
      if (oReq.status == 200) {
//console.log("success")
        popAlert("Klattr Deleted!");
        var element = document.getElementById(klattr);
        element.parentNode.removeChild(element);
//console.log('done')
      } else {
//console.log("failure")
        popAlert("Error " + oReq.status);
      }
    };
  oReq.send(oData); 
  }

  function subscribe_to() {
    var 
      oOutput = document.getElementById("output"),
      oData = new FormData(document.forms.namedItem("Subscribe"));

    var oReq = new XMLHttpRequest();
    oReq.open("POST", "/do_subscribe.php", true);
    oReq.onload = function(oEvent) {
      if (oReq.status == 200) {
//console.log("success")
        state = document.getElementById('sub_button').value;
        if (state == "Subscribe!") {
          document.getElementById('sub_button').value = "Unsubscribe!";
          document.getElementById('sub_button').className = "cancel_signup";
          popAlert("Subscribed!");
        } else {
          document.getElementById('sub_button').value = "Subscribe!";
          document.getElementById('sub_button').className = "submit_signup";
          popAlert("Unsubscribed!");
        }

      } else {
//console.log("failure")
        popAlert("Error " + oReq.status);
      } 
    };
  oReq.send(oData);
  }

function set_recipient(recipient, parent_id) {
//console.log(recipient)
  klattr_recipient = recipient;
  klattr_parent_id = parent_id;
//console.log(klattr_recipient)
}

function set_oldest(klattr_id) {
  if (klattr_id == "no_more") {
    loading_content = 1;
  } else {
    oldest_klattr = klattr_id;
//    console.log(oldest_klattr)
  }
}

function set_profile_id(id) {
  profile_id = id;
//  console.log(profile_id)
}

function retrieve_more(page) {

  $container = $('#klattr_parent');
  
  if (loading_content == 0) {
    var
      oData = new FormData();
    var retrieved_content = "<div id=\"feed_wait\"><center><img src=\"gfx/wait.gif\"></center></div>"
//    document.getElementById('klattr_parent').innerHTML += retrieved_content;
    $container.append(retrieved_content);
    loading_content = 1;
    oData.append("oldest", oldest_klattr);
    oData.append("page", page);
    oData.append("profile_id", profile_id);
    oData.append("search", search_term);
//console.log(search_term)

    var oReq = new XMLHttpRequest();
    oReq.open("POST", "/get_more.php", true);
    oReq.onload = function(oEvent) {
      if (oReq.status == 200) {
        var element = document.getElementById("feed_wait");
        element.parentNode.removeChild(element);
        retrieved_content = oReq.responseText;
//        document.getElementById('klattr_parent').innerHTML = document.getElementById('klattr_parent').innerHTML + retrieved_content;
        $container.append(retrieved_content);
        loading_content = 0;
      } else {
        popAlert("Error" + oReq.status);
//console.log("failed to retrieve more")
      }
    };
  oReq.send(oData);
  }
}

function get_replies(parent_id, nest_level) {
  var container_id = "Parent" + parent_id + "_" + nest_level;
  var up_down = "up_down" + parent_id + "_" + nest_level;
  var devider_id = "devider" + parent_id + "_" + nest_level;

  if (document.getElementById(up_down).src == "https://klattr.com/gfx/down.png") {
    document.getElementById(up_down).src = "https://klattr.com/gfx/up.png";
        
    nest_level += 1;

    var container = $('#' + container_id);
    var oData = new FormData();
    var retrieved_content = "<div id=\"replies_wait\"><center><img src=\"gfx/wait.gif\"></center></div>";
    document.getElementById(container_id).className = "inLineReplies";
    document.getElementById(devider_id).style.visibility = "hidden";
    container.append(retrieved_content);
    oData.append("parent_id", parent_id);
    oData.append("nest_level", nest_level);

    var oReq = new XMLHttpRequest();
    oReq.open("POST", "/get_replies.php", true);
    oReq.onload = function(oEvent) {
      if (oReq.status == 200) {
        var element = document.getElementById("replies_wait");
        element.parentNode.removeChild(element);
        retrieved_content = oReq.responseText;
        container.append(retrieved_content);
      } else {
        popAlert("Error" + oReq.status);
      }
    };
    oReq.send(oData);
  } else {
     
    document.getElementById(up_down).src = "https://klattr.com/gfx/down.png";
    document.getElementById(container_id).innerHTML = "";
    document.getElementById(container_id).className = "";
    document.getElementById(devider_id).style.visibility = "visible";

  }
}

function send_email() {
  var oData = new FormData();
  var oReq = new XMLHttpRequest();
  oReq.open("POST", "/send_email.php", true);
  oReq.onload = function(oEvent) {
    if (oReq.status == 200) {
      popAlert("eMail Sent");
    } else {
      popAlert("Error" + oReq.status);
    }
  };
  oReq.send(oData);
}

function reset_password() {
  var oData = new FormData(document.forms.namedItem("SignUp"));
  var oReq = new XMLHttpRequest();
  oReq.open("POST", "/reset_password.php", true);
  oReq.onload = function(oEvent) {
    if (oReq.status == 200) {
      retrieved_content = oReq.responseText;
      popAlert(retrieved_content);
    } else {
      popAlert("Error" + oReq.status);
    }
  };
  oReq.send(oData);
}








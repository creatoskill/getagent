jQuery(".btn-status-filter",css_class_wrap).on("click",function(e){
  e.preventDefault();
  var status=jQuery(this).data("value");
  jQuery(this).parent().find("input").val(status);
  jQuery(this).parent().find("button").removeClass("active");
  jQuery(this).addClass("active");

});
function search_agent_cs(){

	var url = window.location.href;
 var newurl = new URL("http://localhost/newme/agent");
 var s_text = jQuery("#agent-search-zip").val();
  	// newurl = url.substr(1, url.lastIndexOf("\\"));
  	// alert(newurl);

  // If your expected result is "http://foo.bar/?x=1&y=2&x=42"
  // url.searchParams.append('x', 42);

  // If your expected result is "http://foo.bar/?x=42&y=2"
  newurl.searchParams.set("agent_zip", s_text);

  if (s_text) {

    window.location.href = newurl;

  }
  else{
    alert("Please Enter Valid Postcode.");
  }
}

var getUrlParameterr = function getUrlParameterr(sParam) {
  var sPageURL = window.location.search.substring(1),
  sURLVariables = sPageURL.split('&'),
  sParameterName,
  i;

  for (i = 0; i < sURLVariables.length; i++) {
    sParameterName = sURLVariables[i].split('=');

    if (sParameterName[0] === sParam) {
      return typeof sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
    }
  }
  return false;
};
// jQuery(document).ready(function () {
  // Your code
  function save_agents(agent_id){
  // alert("");
  // var values = jQuery("input[name='inputname[]']")
              // .map(function(){return $(this).val();}).get();
  // console.log(values);
  var name = jQuery("#inputName").val();
  var email = jQuery("#inputEmail").val();
  var phone = jQuery("#inputPhone").val();
  var desc = jQuery("#inputdesc").val();
  var insta = jQuery("#inputInsta").val();
  var twitter = jQuery("#inputTwitter").val();
  var linkedin = jQuery("#inputLinkedin").val();
  var facebook = jQuery("#inputFacebook").val();
  // validation
  if (name === '' && email === "" && phone === "") {

    alert("Please enter required fields.");

  } 
  else{

  if( !validateEmail(email)) { 
    /* do stuff here */

    alert("Email not corrent.");


  }else{

    jQuery.ajax({

      type: "GET",
      url: "http://localhost/newme/wp-admin/admin-ajax.php",
      data: {
        'action': 'add_agent',
        'agency_id': agent_id,
        'name': name,
        'email': email,
        'phone': phone,
        'description': desc,
        'instagram': insta,
        'twitter': twitter,
        'facebook': facebook,
        'linkedin': linkedin, 
      },
      success:function(data){

        console.log(data);
     },
     error: function(errorThrown){
      console.log(errorThrown);
    }

  });

  }//else
  
  }//not empty
  // console.log(name,email,phone,desc,insta,twitter,linkedin,facebook);
}

function validateEmail($email) {
  var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
  return emailReg.test( $email );
}
function update_featured_status(id){

    // console.log(id,linkn);

    jQuery('.ajax-loader').css("visibility", "visible");
    
    jQuery.ajax({

      type: "GET",
      url: ajaxURL,
      data: {
        'action': 'update_user_feature_status',
        'u_id': id,
      },
      success:function(data){
        // jQuery('.ajax-loader').css("visibility", "hidden");

        let jdata = data.data.response;
        let btnid = "#btnfeatured_"+id;

        // doitnow(jdata,btnid);

        if(jdata.status == "no"){

          jQuery(btnid).text("Active");
          jQuery(btnid).removeClass("Inactive").addClass('Active');
        }
        else{

          jQuery(btnid).text("Inactive");
          jQuery(btnid).removeClass("Active").addClass('Inactive');
        }

      }//success
      
    });
  }
// });
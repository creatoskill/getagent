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
        let rowid = "#csrow-"+id;

        // doitnow(jdata,btnid);

        if(jdata.status == "no"){

          jQuery(btnid).text("Active");
          jQuery(btnid).removeClass("Inactive").addClass('Active');
          jQuery(rowid).removeClass("row-Inactive").addClass('row-Active');
        }
        else{

          jQuery(btnid).text("Inactive");
          jQuery(btnid).removeClass("Active").addClass('Inactive');
          jQuery(rowid).removeClass("row-Active").addClass('row-Inactive');
        }

      }//success
      
    });
  }
// });
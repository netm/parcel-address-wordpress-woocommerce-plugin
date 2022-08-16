/* 
Ajax call to get address data
*/

jQuery(document).ready(function() {
  var imgurl = gatJsVars.imageURL;
  var accessToken = gatJsVars.getToken;
  var apiDomain = gatJsVars.getApiDomain;

  /*
  * input#billing_address_1
  */ 
  jQuery("input#billing_address_1").autocomplete({
    autoFocus: true,
    source: function(request, response) {
      jQuery('input#billing_address_1').css("background","white url("+imgurl+") right center no-repeat");
      // Above to this.css ? of $(this.element).prop("id"); .css
      // To DRY this this.element[0].id should give id https://stackoverflow.com/questions/12869221/jquery-autocomplete-on-class-how-to-get-id
      var accesData =[]; 
      jQuery.ajax({
        url: apiDomain+"?count=8",
        dataType:'json',
        async:true,
        data: {
          q: request.term
        },
        beforeSend: function (xhr) {
          xhr.setRequestHeader('authorization', 'Bearer ' + accessToken);
        },
        success: function(data) {
          if(data.addresses.length == 0){
            jQuery('input#billing_address_1').css('background','');
          } 
          else {
            jQuery.each(data.addresses, function(idx, obj) {
              accesData.push(obj.full_address);
              response(accesData);
              jQuery('input#billing_address_1').css('background','');
            });
          }
        }
      });
    },
    minLength: 3,
    select: function(event, ui) {
      var getValue = ui.item.value;
      console.log(getValue);
      var last_comma = getValue.lastIndexOf(",");
      var getCityAddress = getValue.substring(0, last_comma);
      var getCityAndPostCode = getValue.substring(last_comma+2, getValue.length) ;
      var lastSpace = getCityAndPostCode.lastIndexOf(" ");
      var lastSpaceCity = getCityAddress.lastIndexOf(" ");
      var getCity = getCityAndPostCode.substring(0, lastSpace);
      var last_comma_address = getCityAddress.lastIndexOf(",");
      var getstate = getCityAddress.substring(last_comma_address+2, getCityAddress.length);
      var getCityAddress = getCityAddress.substring(0, last_comma_address);
      var getPostCode = getCityAndPostCode.substring(lastSpace+1, getCityAndPostCode.length);
      
      jQuery('input#billing_address_1').val(getCityAddress);
      jQuery('input#billing_city').val(getCity);
      jQuery('input#billing_address_2').val(getstate);
      jQuery('input#billing_postcode').val(getPostCode);
      return false;
    }
  });

  /* Onchange of select2 country select */
  
  //Page load
  initCountry = jQuery("#billing_country").val();
  if(initCountry != 'NZ') {
    jQuery("input#billing_address_1").autocomplete( "disable" );
  }
  else {
    jQuery("input#shipping_state_field").hide();
  }

  // Onchange
  jQuery('#billing_country').on('select2:select', function (e) {
    var countryCode = e.params.data.id;
    if(countryCode === 'NZ') {
      jQuery("input#billing_address_1").autocomplete( "enable" );
      jQuery("input#shipping_state_field").hide();
      //console.log(countryCode, 'enable');
    }
    else {
      jQuery("input#billing_address_1").autocomplete( "disable" );
      jQuery("input#shipping_state_field").show();
      //console.log(countryCode, 'disable');
    }
  });

  /*
  * input#shipping_address_1
  */ 
  jQuery("input#shipping_address_1").autocomplete({
    autoFocus: true,
    source: function(request, response) {
      jQuery('input#shipping_address_1').css("background","white url("+imgurl+") right center no-repeat");
      var accesData =[]; 
      jQuery.ajax({
        url: apiDomain+"?count=8",
        dataType:'json',
        async:true,
        data: {
          q: request.term
        },
        beforeSend: function (xhr) {
          xhr.setRequestHeader('authorization', 'Bearer ' + accessToken);
        },
        success: function(data) {
          if(data.addresses.length == 0){
            jQuery('input#shipping_address_1').css('background','');
          } 
          else {
            jQuery.each(data.addresses, function(idx, obj) {
              accesData.push(obj.full_address);
              response(accesData);
              jQuery('input#shipping_address_1').css('background','');
            });
          }
        }
      });
    },
    minLength: 3,
    select: function(event, ui) {
      var getValue = ui.item.value;
      var last_comma = getValue.lastIndexOf(",");
      var getCityAddress = getValue.substring(0, last_comma);
      var getCityAndPostCode = getValue.substring(last_comma+2, getValue.length) ;
      var lastSpace = getCityAndPostCode.lastIndexOf(" ");
      var lastSpaceCity = getCityAddress.lastIndexOf(" ");
      var getCity = getCityAndPostCode.substring(0, lastSpace);
      var last_comma_address = getCityAddress.lastIndexOf(",");
      var getstate = getCityAddress.substring(last_comma_address+2, getCityAddress.length);
      var getCityAddress = getCityAddress.substring(0, last_comma_address);
      var getPostCode = getCityAndPostCode.substring(lastSpace+1, getCityAndPostCode.length);
      
      jQuery('input#shipping_address_1').val(getCityAddress);
      jQuery('input#shipping_city').val(getCity);
      jQuery('input#shipping_address_2').val(getstate);
      jQuery('input#shipping_postcode').val(getPostCode);
      return false;
    }
  });

  //Onchange of select2 country box including init
  initCountry = jQuery("#shipping_country").val();
  if(initCountry != 'NZ') {
    jQuery("input#shipping_address_1").autocomplete( "disable" );
  }
  else {
    jQuery("input#shipping_state_field").hide();
  }

  jQuery('#shipping_country').on('select2:select', function (e) {
    var countryCode = e.params.data.id;
    if(countryCode === 'NZ') {
      jQuery("input#shipping_address_1").autocomplete( "enable" );
      jQuery("input#shipping_state_field").hide();
      //console.log(countryCode, 'enable');
    }
    else {
      jQuery("input#shipping_address_1").autocomplete( "disable" );
      jQuery("input#shipping_state_field").show();
      //console.log(countryCode, 'disable');
    }
  });

});
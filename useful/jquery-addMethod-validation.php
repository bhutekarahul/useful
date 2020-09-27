<script>
function getWordCount(wordString) {
        var words = wordString.split(" ");
        words = words.filter(function(words) { 
          return words.length > 0
        }).length;
        return words;
    }

    //add the custom validation method
    jQuery.validator.addMethod("wordCount",
        function(value, element, params) {
           var count = getWordCount(value);
           if(count <= params[0]) {
              return true;
           }
        },
        jQuery.validator.format("A maximum of {0} words is required here.")
    );
    
    jQuery.validator.addMethod("acceptNumber", function(value, element, param) {
            return value.match(new RegExp("." + param + "$"));
    });
    jQuery.validator.addMethod("acceptAplha", function(value, element, param) {
        return value.match(new RegExp("." + param + "$"));
    });
    jQuery.validator.addMethod("validEmail", function(value, element) {
      // allow any non-whitespace characters as the host part
      return this.optional( element ) || /^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$/.test( value );
    }, 'Please enter a valid email address.');
    
    $("#job_application").validate({
        rules:{
            first_name : {
                required:true,
                acceptAplha: "[A-Za-z ]+"
            },
            last_name : {
                required:true,
                acceptAplha: "[A-Za-z ]+"
            },
            date_of_birth : "required",
            mobile_number : {
                required:true,
                acceptNumber: "[0-9+]+"
            },
            gender : "required",
            email : {
                required:"Please Enter Email",
                validEmail:"Please Enter Valid Email",
            },
            license : "required",
            crime_conviction : "required",
            qualification : "required",
            qualification_level : "required",
            address_one : {
                required: true,
                wordCount: [100]
            },
            address_two : {
                required: true,
                wordCount: [100]
            },
            city : {
                required:true,
                acceptAplha: "[A-Za-z ]+"
            },
            country : "required",
            position_name : "required",
            childcare : "required",
            childcare_work : "required",
            employeed : "required",
            current_employer : "required",
            start_time : "required",
            finish_time : "required",
            your_desc :{
                    required: true,
                    wordCount: [500]
            },
            choicekids_desc : {
                    required: true,
                    wordCount: [500]
            },
            choicekids_referral : "required",
            choicekids_referral_desc:{
                    required: true,
                    wordCount: [500]
            },
            file1 : "required"
        },
        messages:{
            first_name:{
                required:"Please Enter First Name",
                acceptAplha: "Only Alphabets are allowed"
            },
            last_name : {
                required:"Please Enter Last Name",
                acceptAplha: "Only Alphabets are allowed"
            },
            date_of_birth : "Please Select Date Of Birth",
            mobile_number : {
                required:'Please Enter Phone',
                acceptNumber:"Only digits are allowed"
            },
            gender : "Please Enter Gender",
            email : {
                required:"Please Enter Email",
                validEmail:"Please Enter Valid Email",
            },
            license : "Please Select License",
            crime_conviction : "Please Select Crime Conviction",
            qualification : "Please Select Qualification",
            qualification_level : "Please Select Qualification Level",
            city : {
                required:"Please Enter City",
                acceptAplha: "Only Alphabets are allowed"
            },
            country : "Please Enter Center",
            position_name : "Please Enter Position",
            childcare : "Please Select Childcare",
            childcare_work : "Please Enter Childcare work Experience",
            employeed : "Please Select Employed Status",
            current_employer : "Please Enter Current Employer",
            start_time : "Please Select Start Time",
            finish_time : "Please Select Finish Time",
            file1 : "Please Select a File"
        },
        submitHandler:function(form){
            $(".loader").show();
            var data = new FormData(form);
            
            $.ajax({
                url:"<?= AJAX_URL ?>career-position-submit.php",
                type:"post",
                data:data,
                contentType: false,
		cache: false,
		processData:false,
                success:function(response){
                    $(".loader").fadeOut("slow");
                    var result = $.trim(response);
                    if(result === "1"){
                        swal({
                           title:'Done' ,
                           text:'Application form submitted Successfully',
                           type:'success'
                        },function(){
                            $("#job_application")[0].reset();
                            window.open('<?= SERVER_URL ?>generate-applicant-jobPDF.php','_self');
                        });
                    }else if(result === "0"){
                        swal({
                           title:'Ooops...',
                           text:'Something Went Wrong',
                           type:'error'
                        });
                    }else{
                        swal({
                           title:'NOT ALLOWED',
                           text:result,
                           type:'info'
                        });
                    }
                }
            });
        }
    });
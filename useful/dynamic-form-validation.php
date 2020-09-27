<button type="button" class="btn btn-warning add"><i class="fa fa-plus"></i> Add Question</button>
<form id="pre_employement_form">
                                <div class="question-block clearfix">
                                    <div class="que-item">
                                        <label>Q</label>
                                        <input type="text" class="form-control" name="question" placeholder="">
                                    </div>
                                    <div class="que-item">
                                        <label>1</label> <input type="text" name="option_one" class="form-control" placeholder="">
                                    </div>
                                    <div class="que-item">
                                        <label>2</label> <input type="text" name="option_two" class="form-control" placeholder="">
                                    </div>
                                    <div class="que-item">
                                        <label>3</label> <input type="text" name="option_three" class="form-control" placeholder="">
                                    </div>
                                    <div class="que-item">
                                        <label>4</label> <input type="text" name="option_four" class="form-control" placeholder="">
                                    </div>
                                    <!--<button type="button" class="btn btn-inline pull-right">Save</button>-->
                                    <input type="submit" value="Save" class="btn btn-inline pull-right" />
                                </div> <span class=" remove"><i class="fa fa-close"></i></span>
                                </form>
<script>
var i = 0;
    var myValidateObj = {
        rules: {
            question: 'required',
            option_one:'required',
            option_two:'required',
            option_three:'required',
            option_four:'required'
        },
        message:{
            
        },
        submitHandler:function(form){
            var data = $(form).serialize();
            $.ajax({
                url:'<?=ADMIN_URL?>ajax/careers-position.php',
                type:'post',
                data:data,
                success:function(response){
                    var result = $.trim(response);
//                    $(form).parent('.block').remove();
                    if(result === "1"){
                        swal({
                            title: 'Done',
                            text: 'Pre Employment Questions Added Successfully',
                            type: 'success'
                        });
                    }else{
                        swal({
                            title: 'Oopss..',
                            text: 'Something went wrong',
                            type: 'info'
                        });
                    }
                }
            });
        }
    };

// INITIALIZE plugin on the traditional form
    var validate = $('#pre_employement_form').validate(myValidateObj);
    
    $('.add').click(function () {
        $('.block:eq(1)').before(' \n\
            <div class="block"><form id="pre_employement_form_'+i+'">\n\
                <div class="question-block clearfix">\n\
                <div class="que-item">\n\
                    <label>Q</label><input type="text" name="question" class="form-control" placeholder="">\n\
                </div>\n\
                <div class="que-item">\n\
                    <label>1</label> <input type="text" name="option_one" class="form-control" placeholder="">\n\
                </div>\n\
                <div class="que-item">\n\
                    <label>2</label> <input type="text" name="option_two" class="form-control" placeholder="">\n\
                </div>\n\
                <div class="que-item">\n\
                    <label>3</label> <input type="text" name="option_three" class="form-control" placeholder="">\n\
                </div>\n\
                <div class="que-item">\n\
                    <label>4</label> <input type="text" name="option_four" class="form-control" placeholder="">\n\
                </div> \n\
                <input type="submit" value="Save" class="btn btn-inline pull-right" /> \n\
            </div> <span class="remove"><i class="fa fa-close"></i></span></div></form>\n\
            ');
            var validate_i = $("#pre_employement_form_"+i).validate(myValidateObj);
            i++;
    });
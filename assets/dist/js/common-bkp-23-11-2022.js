$(document).ready(function(e){
    if($('.date_filter').length > 0){
        var picker_type = $('.type_filter').val();
        if(picker_type == 'day'){
            $('.end_date_filter').parent().remove();
            $('.date_filter').datepicker({
                format: "yyyy-mm-dd",
                endDate: "today", 
                maxDate: "today"
            });
        }else if(picker_type == 'month'){
            $('.end_date_filter').parent().remove();
            $('.date_filter').datepicker({
                format: "yyyy-mm",
                viewMode: "months", 
                minViewMode: "months",
                endDate: '+0m'
            });
        }else if(picker_type == 'year'){
            $('.end_date_filter').parent().remove();
            $('.date_filter').datepicker({
                format: "yyyy",
                viewMode: "years", 
                minViewMode: "years",
                endDate: "today", 
                maxDate: "today"
            });
        }else if(picker_type == 'custom'){
            $('.date_filter').datepicker({
                format: "yyyy-mm-dd",
                endDate: "today", 
                maxDate: "today"
            });
            if($('.end_date_filter').length > 0){
                $('.end_date_filter').datepicker({
                    format: "yyyy-mm-dd",
                    endDate: "today", 
                    maxDate: "today"
                });
            }
        }
    }
});


$(document).on('change', '.type_filter', function(e){
    $('.date_filter').datepicker('remove');
    var picker_type = $(this).val();
    console.log('picker_type', picker_type);
    if(picker_type == 'day'){
        $('.end_date_filter').parent().remove();
        $('.date_filter').datepicker({
            format: "yyyy-mm-dd",
        });
    }else if(picker_type == 'month'){
        $('.end_date_filter').parent().remove();
        $('.date_filter').val('');
        $('.date_filter').datepicker({
            format: "yyyy-mm",
            viewMode: "months", 
            minViewMode: "months",
            endDate: '+0m'
        });
    }else if(picker_type == 'year'){
        $('.end_date_filter').parent().remove();
        $('.date_filter').val('');
        $('.date_filter').datepicker({
            format: "yyyy",
            viewMode: "years", 
            minViewMode: "years",
            endDate: '+0y'
        });
    }else if(picker_type == 'custom'){
        $('.date_filter').datepicker({
            format: "yyyy-mm-dd",
            endDate: "today", 
            maxDate: "today"
        });
        var end_date_input = '<div class="col-md-2 form-group"><input type="text" name="end_date_filter" id="end_date_filter" class="form-control end_date_filter"></div>';
        $('.date_filter').parent().after(end_date_input);
        $('.end_date_filter').datepicker({
            format: "yyyy-mm-dd",
            endDate: "today", 
            maxDate: "today"
        });
    }
});


$(document).on('click', '.change_status', function(e){
    var cnf = confirm('Are you sure want to convert this inquiry to lead?');
    if(cnf){
        var status = 2;
        if($(this).hasClass('make_project')){
            status = 3;
        }
        var me = $(this);
        var bid_id = $(this).attr('data-bidid');
        if(bid_id > 0){
            $.ajax({
                url: "bids/update_status",
                type: 'POST',
                data:{
                    bid_id: bid_id,
                    status: status
                },
                success: function(res){
                    if(res == 'success'){
                        me.removeClass('make_lead');
                        me.addClass('make_project');
                        me.text('Project');
                        location.reload();
                    }else{
                        alert('Something went wrong. Bid was not updated!');
                    }
                    
                }
            });
        }
    }
});

$(document).on('click', '.delete_bid', function(e){
    var cnf = confirm('Are you sure want to delete this row?');
    if(cnf){
        var status = 0;
        var me = $(this);
        var bid_id = $(this).attr('data-bidid');
        if(bid_id > 0){
            $.ajax({
                url: "bids/update_status",
                type: 'POST',
                data:{
                    bid_id: bid_id,
                    status: status
                },
                success: function(res){
                    if(res == 'success'){
                        location.reload();
                    }else{
                        alert('Something went wrong. Bid was not deleted!');
                    }
                }
            });
        }
    }
});

$(document).on('click', '.delete-user', function(e){
    var cnf = confirm('Are you sure want to delete this user?');
    if(cnf){
        var me = $(this);
        var user_id = $(this).attr('data-userid');
        if(user_id > 0){
            $.ajax({
                url: "delete_user",
                type: 'POST',
                data:{
                    user_id: user_id,
                },
                success: function(res){
                    if(res == 'success'){
                        location.reload();
                    }else{
                        alert('Something went wrong. User was not deleted!');
                    }
                }
            });
        }
    }
});

$('.search_from_date').datepicker({
    format: 'dd-mm-yyyy',
});
$('.search_to_date').datepicker({
    format: 'dd-mm-yyyy',
});

$(document).on('click', '.tl_cb', function(e){
    if($(this).is(':checked')){
        $('#tl').val(0);
        $('#tl').attr('readonly', 'readonly');
    }else{
        $('#tl').removeAttr('readonly');
    }
    
});
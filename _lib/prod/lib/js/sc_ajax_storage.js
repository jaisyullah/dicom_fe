function ajax_search_check_file() {
    $("[id^=txt_ajax_img_]").each(function (i, t) {
        ajax_check_file( $(t).text(), $(t).attr('id').split('txt_ajax_img_')[1]);
    });
}

function ajax_check_file(img_name, field ){
    $.post('index.php','rs=ajax_check_file&AjaxCheckImg=' + img_name +'&rsargs='+ field, function (rs) {
        if (rs == 1) {
            $(t).attr('src', $(t).val().split('?')[0] + '?' + new Date().getTime());
        }
    });
}

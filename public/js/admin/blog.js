// 管理画面・ブログスクリプト
$(function(){

    $('#day, #day_st, #day_ed').datepicker({
        //showButtonPanel: true,
    });

    // 作業日 今日をセットボタン
    $(".day_today_btn").click(function() {
        var now = new Date();
        var yyyymmdd = now.getFullYear() + '/' + ( "0"+( now.getMonth()+1 ) ).slice(-2) + '/' + ( "0"+now.getDate() ).slice(-2);
        $(this).parent().prevAll("input[type='text']").eq(0).val(yyyymmdd);
    });

    // 本文に対してsummernote適用
    $('#body').summernote()

    $('#edit_form').validate({
        rules: {
            day: {
                required: true,
                date: true,
            },
            title: {
                required: true,
            },
        },
        messages: {
            day: {
                required: "必須項目です。",
                date: "有効な日付を入力して下さい。",
            },
            title: {
                required: "必須項目です。",
            },
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        },
        submitHandler: function (form) {
            Swal.fire({
                title: '保存します。<br>よろしいでしょうか?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'OK',
            }).then((result) => {
                if (result.isConfirmed) {
                    // ボタン無効 二重送信防止
                    $("#commit_btn").prop("disabled", true);
                    form.submit();
                } else {
                    return false;
                }
            });
        }
    });


    // 一覧での削除ボタン action先を指定
    function deleteData(param) {
        $('#delete_form').attr('action', param);
        $('#delete_form').submit();
    }
    $('#delete_form').validate({
        submitHandler: function (form) {
            Swal.fire({
                title: '削除します。<br>よろしいでしょうか?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'OK',
            }).then((result) => {
                if (result.isConfirmed) {
                    // ボタン無効 二重送信防止
                    $(".delete_btn").prop("disabled", true);
                    form.submit();
                } else {
                    return false;
                }
            });
        }
    });

})

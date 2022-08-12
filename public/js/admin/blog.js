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
    $('#body').summernote({
        height: 400,
        lang: "ja-JP",
        toolbar: [
    // [groupName, [list of button]]
            ['style', ['bold', 'italic', 'underline', 'strikethrough', 'clear']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'video']],
            ['view', ['fullscreen', 'codeview', 'help']],
        ],

        callbacks: {
            //画像がアップロードされた時の動作
            onImageUpload: function(files) {
                sendFile(files[0]);
            }
        }
    });
    function sendFile(file){
        data = new FormData();
        data.append("image", file);
        data.append("_token", CSRF_TOKEN);
        data.append("dir", $('#dir').val());
        $.ajax({
            data: data,
            type: "POST",
            url: '/admin/upload_image',
            cache: false,
            contentType: false,
            processData: false,
            success: function(data) {
                //アップロードが成功した後の画像を書き込む処理
                $('#body').summernote('insertImage',data.image_url);
            }
        });
    }

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

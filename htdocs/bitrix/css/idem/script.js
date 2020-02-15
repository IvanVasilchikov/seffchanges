$(document).ready(function(){
    initmce();
    $('.dd').each(function(i,e){
        $(e).find('.dd-item:first').hide();
    });
    $('.dd').nestable({maxDepth: 1});
    $('body').on('change','.dropzone input', function (e) {
        var file = this.files[0];

        if (this.accept && $.inArray(file.type, this.accept.split(/, ?/)) == -1) {
            return alert('File type not allowed.');
        }

        $(this).parent().addClass('dropped');
        $(this).parent().find('img').remove();
        var dropzone = $(this).parent();
        if ((/^image\/(gif|png|jpeg)$/i).test(file.type)) {
            var reader = new FileReader(file);

            reader.readAsDataURL(file);

            reader.onload = function (e) {
                var data = e.target.result,
                    $img = $('<img />').attr('src', data).fadeIn();
                dropzone.find('div').html($img);
            };
        } else {
            var ext = file.name.split('.').pop();
            dropzone.find('div').html(ext);
        }
    });

    // Edit block
    $('body').on('click','.edit-block',function(){
        var block = activeBlock = $(this).parents('.dd-item');
        var fields = $(this).parents('.dd-item').find('.item-fields .form-group').clone();

        fields.each(function(i,e){
            if($(e).find('textarea').length > 0){
                $(e).find('textarea').addClass('richTextBoxBlock').removeAttr('id').removeAttr('aria-hidden').removeAttr('style');
            }
        });

        $('#modal-edit-object-item .modal-body').html('');
        $('#modal-edit-object-item .modal-body').append(fields);
        initmce();
    });

    $('#modal-edit-object-item').on('hide.bs.modal',function(){
        $(this).find('.modal-body').html('');
    });

    $('.save-edit-modal').click(function(){
        var fields = $(this).parents('#modal-edit-object-item').find('.modal-body .form-group');
        var resFields = activeBlock.find('.item-fields');

        fields.each(function(i,e){
            if($(e).find('textarea').length > 0){
                var content = tinyMCE.activeEditor.getContent({format : 'raw'});
                $(e).find('.mce-tinymce').remove();
                $(e).find('textarea').removeClass('richTextBoxBlock').removeAttr('id').removeAttr('aria-hidden').removeAttr('style').val(content);
            }
        });

        resFields.html('');
        resFields.append(fields);
        activeBlock.find('.dd-handle span').html($(fields[0]).find('input').val());
        $('#modal-edit-object-item').modal('hide');
    });
    // End edit block


    //AddBlock
    $('.block-add').click(function(){
        container = $(this).parents('fieldset');
        var name = container.find('.default-fields').attr('name');
        var fields = container.find('.default-fields').attr('value');
        $.post(window.location.href,{
            name: name,
            fields: fields,
            last_index: container.find('.dd-item').length,
            "_token" : token,
            action: 'get_fields'
        }).done(function(data){
            $('#add-block-dialog .modal-body').html(data);
            initmce();
        });
        $('#add-block-dialog').modal('show');
    });

    $('.add-block').click(function(){
        var val = $('#add-block-dialog .modal-body input:eq(0)').val();
        var html = $('#add-block-dialog .modal-body .form-group');
        var item = $('<li/>',{class:"dd-item"});
        var right = $('<div/>',{class:"pull-right item_actions"}).html('<div class="btn btn-sm btn-danger pull-right delete-block"><i class="voyager-trash"></i> Удалить</div><div class="btn btn-sm btn-primary pull-right edit-block js-projects-block" data-toggle="modal" data-target="#modal-edit-object-item"><i class="voyager-edit"></i>Редактирование</div>');
        var panel = $('<div/>',{class:"dd-handle"}).html('<span>'+val+'</span>');
        var fieldsContainer = $('<div/>',{class:"item-fields"}).css('display','none');
        fieldsContainer.append(html);
        item.append(right);
        item.append(panel);
        item.append(fieldsContainer);
        container.find('.dd').append(item);
        $('#add-block-dialog').modal('hide');
    });
    //End AddBlock

    //Delete Block
    $('.delete-block').click(function () {
        if(confirm('Вы действительно хотите удалить элемент')){
            $(this).parents('li').remove();
        }
    });
    //End Delete Block

    function initmce() {
        tinymce.remove();
        var editor = tinymce.init({
            menubar: !1,
            selector: "textarea.richTextBoxBlock:not(.item-fields textarea.richTextBoxBlock)",
            min_height: 300,
            resize: "vertical",
            plugins: "link, image, code, table, textcolor, lists",
            //extended_valid_elements: "input[id|name|value|type|class|style|required|placeholder|autocomplete|onclick]",
            file_browser_callback: function (e, t, n, i) {
                "image" == n && $("#upload_file").trigger("click")
            },
            toolbar: "styleselect bold italic underline | forecolor backcolor | alignleft aligncenter alignright | bullist numlist outdent indent | link image table youtube giphy | code",
            convert_urls: !1,
            image_caption: !0,
            image_title: !0
        });
    }
});
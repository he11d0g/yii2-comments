var hdComments = {
    add : function(body){
        console.log(hdComments.convertLinks(body));
        $.ajax({
            url: hdCommentsConfig.requestUrl,
            method: 'post',
            data : {
                action: 'add',
                page_id:hdCommentsConfig.pageId,
                body : hdComments.convertLinks(body),
                captcha : $("#g-recaptcha-response").val(),
            },
            success : function(){
                hdComments.reload();
                if (typeof grecaptcha != "undefined") {
                    grecaptcha.reset();
                }
            }
        });
    },
    update : function(comment){
        var id = $(comment).data('id');
        var body = $(comment).find('.edit-form .comment-body').val();
        $(comment).find('.view-form .comment-body').html(body);
        $.ajax({
            url: hdCommentsConfig.requestUrl,
            method: 'post',
            data : {
                id : id,
                action: 'update',
                body : hdComments.convertLinks(body)
            },
            success : function(data){
                hdComments.showMessage(data,comment)
                hdComments.reload()
            }
        });

    },
    delete : function(comment){
        var id = $(comment).data('id');
        $.ajax({
            url: hdCommentsConfig.requestUrl,
            method: 'post',
            data : {
                id : id,
                action: 'delete'
            },
            success : function(){
                $(comment).fadeOut(1200, function(){
                    $(comment).remove()
                });
            }
        });
    },
    reload : function() {
        $.ajax({
            url: hdCommentsConfig.requestUrl,
            method: 'post',
            data : {
                action: 'reload',
                page_id: hdCommentsConfig.pageId,
            },
            success : function(data){
                $(".hd-comment-list").css('display','none').fadeIn(700, function(){
                    $(".hd-comment-list").html(data);
                });
            }
        });
    },
    showMessage : function(message,comment) {
        $(comment).find('.message').text(message).css('display','inline').fadeOut(700)
    },
    showEditForm: function(comment) {
        $(comment).find(".view-form").addClass("hidden");
        $(comment).find(".edit-form").removeClass("hidden");
    },
    hideEditForm: function(comment) {
        $(comment).find(".edit-form").addClass("hidden");
        $(comment).find(".view-form").removeClass("hidden");
    },
    convertLinks : function(text){
        return text.replace(/(htt(p|ps):\/\/[.\w/=&?-]+)(\s|$)/gi, "<a href=\"$1\" target=\"_blank\">$1</a>")
    }
};

$(".comments").on("click",".edit",function(){
    var comment = $(this).closest(".comment-block");
    hdComments.showEditForm(comment);
});
$(".comments").on("click",".update",function(){
    var comment = $(this).closest(".comment-block");
    hdComments.update(comment);
    hdComments.hideEditForm(comment);
});
$(".comments").on("click",".delete",function(){
    var comment = $(this).closest(".comment-block");
    hdComments.delete(comment);
});
$(".hd-comments").on("click",".add-comment",function(){
    var body = $(".hd-comments #new-comment-form").val();
    if(body.length > 1){ //по одному символу в комменте - както не айс
        hdComments.add(body);
        $(".hd-comments #new-comment-form").val('');
    }
});

$(".hd-comments").on("keyup",'#new-comment-form',function(){
    hdComments.convertLinks($(this).val());
});
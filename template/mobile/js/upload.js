var tempPicUrls = [];

function ajaxPost(b) {
    var a = "";
    $.each(b, function(d, b) {
        a = a + "&pics[]=" + encodeURI(b)
    });
    $.post(window.sysinfo.siteroot + "app/index.php?c=entry&do=save&m=xiaof_toupiao&logout=1&i=" + window.sysinfo.uniacid, $("#join-form").serialize() + a, function(a) {
        a = (new Function("return" + a))();
        0 == a.errno ? (xfdialog(a.message, !0), setTimeout(function() {
            reloadurl ? window.location.href = reloadurl : location.reload()
        }, 3E3)) : (xfdialog(a.message, !0), tempPicUrls = b)
    })
}
wx.ready(function() {
    function b(a) {
        var c = a.pop();
        setTimeout(function() {
            wx.uploadImage({
                localId: c,
                isShowProgressTips: 1,
                success: function(c) {
                    $.get(window.sysinfo.siteroot + "app/index.php?c=entry&do=uploadImg&m=xiaof_toupiao&logout=1&i=" + window.sysinfo.uniacid, {
                        serverid: encodeURI(c.serverId)
                    }, function(c) {
                        c = (new Function("return" + c))();
                        if (0 == c.errno) d.push(c.message);
                        else return xfdialog(c.message, !0), !1;
                        0 < a.length ? b(a) : ajaxPost(d)
                    })
                }
            });
            e++
        }, 200)
    }
    var a = [],
        d = [];
    $("#filepicker").on("click", function() {
        wx.chooseImage({
            success: function(b) {
                $.each(b.localIds, function(a, b) {
                    $("#pic-container").append("<span class='picid new-picid' data-id='" + a + "'><div class='pic-close'>x</div><img src='" + b + "'/></span>")
                });
                a = a.concat(b.localIds);
                $(".new-picid").click(function() {
                    var b = $(this).attr("data-id");
                    a.splice(b, 1);
                    tempPicUrls.splice(b, 1);
                    $(this).remove()
                })
            }
        })
    });
    $("#form-submit").click(function() {
        localNum = $("#pic-container .picid").length;
        if (0 >= localNum) xfdialog("没有选择照片，不能为空", !0);
        else {
            var d = /^1([38]\d|4[57]|5[0-35-9]|7[06-8]|8[89])\d{8}$/;
            "" == $("#name").val() ? xfdialog("名称不能为空", !0) : "" == $("#phone").val() ? xfdialog("手机号不能为空", !0) : d.test($("#phone").val()) ? localNum > limitpic ? xfdialog("照片最多不超过" + limitpic + "张", !0) : (xfdialog("正在上传，请等待完成，不要关闭本页面"), "" == a || void 0 == a || null == a || 0 >= a.length ? ajaxPost(tempPicUrls) : b(a)) : xfdialog("不是正确手机号", !0)
        }
    });
    var e = 0
});
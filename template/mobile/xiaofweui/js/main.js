define(["jquery", "xiaof"], function(a) {
    return {
        indexLoad: function(d, b, c) {
            function e(q) {
                0 == n && (n = !0, setTimeout(function() {
                    n = !1
                }, 1E3), g++, a("#pagination").html("正在努力加载中..."), a.get(d, {
                    page: g,
                    type: b,
                    groups: h
                }, function(b) {
                    "" == b ? (!0 === q && (k.find(".grid").html(""), f.destroy()), a("#pagination").unbind(), a("#pagination").html("没有更多内容了")) : (result = a(b), !0 === q ? (a("#pagination").click(function() {
                        e(!1)
                    }), k.find(".grid").html(result), f.destroy(), k.imagesLoaded(function() {
                        f = new c(".grid", {
                            itemSelector: ".grid-item",
                            percentPosition: !0
                        })
                    })) : (k.find(".grid").append(result), newElems = result.css({
                        opacity: 0
                    }), newElems.imagesLoaded(function() {
                        f.appended(newElems, !0);
                        newElems.animate({
                            opacity: 1
                        })
                    })), a("#pagination").html("点击加载更多..."));
                    n = !1
                }))
            }
            var h, f, k = a("#container");
            k.imagesLoaded(function() {
                f = new c(".grid", {
                    itemSelector: ".grid-item",
                    percentPosition: !0
                })
            });
            var g = 1,
                n = !1;
            a("#dataload .nav").click(function() {
                a(this).addClass("cur").siblings(".cur").removeClass("cur");
                b = a(this).attr("data-type");
                g = 0;
                e(!0)
            });
            a("#groupload .nav").click(function() {
                if (h == a(this).attr("data-type")) return a(this).removeClass("cur"), h = "", g = 0, e(!0), !1;
                a("#groupload").find(".cur").removeClass("cur");
                a(this).addClass("cur");
                h = a(this).attr("data-type");
                g = 0;
                e(!0)
            });
            a("#pagination").click(function() {
                e(!1)
            })
        },
        registerVote: function(d, b) {
            function c(a) {
                0 == g ? (a.html("获取验证码"), a.css("background", a.attr("bgcolor")), f = !0, g = 60) : (a.attr("bgcolor", a.css("background-color")), a.css("background", "#ccc"), a.html("重新发送(" + g + ")"), g--, setTimeout(function() {
                    c(a)
                }, 1E3))
            }
            function e(d, g, m) {
                m || (m = "");
                a.get(window.sysinfo.siteroot + "app/index.php?c=entry&do=vote&m=xiaof_toupiao&i=" + window.sysinfo.uniacid + "&type=good&id=" + d + m, function(l) {
                    l = (new Function("return" + l))();
                    if (0 == l.errno) {
                        var m = l.message.match(/投了([0-9])票/i),
                            m = parseInt(m[1]);
                        g.html(parseInt(g.html()) + m)
                    } else {
                        if (104 == l.errno) {
                            a.xiaof.alert("提示", "活动仅限本地区参与投票");
                            return
                        }
                        if (115 == l.errno) {
                            a.xiaof.confirm("GPS地区验证", '<div class="gpsmsg"><span class="gpsmsg-title">未进行GPS定位，定位后点确定继续</span><br/><span class="xiaof-button-small getlocation">点击定位</span></div>', function(a) {
                                "success" == a && e(d, g)
                            });
                            a(".getlocation").click(function() {
                                k.getLocation()
                            });
                            return
                        }
                        if (111 == l.errno) {
                            var p, r = !1;
                            a.xiaof.confirm("手机号验证", '\t\t<div class="xiaof-form-group">\t\t\t<div class="xiaof-input-group xiaof-box">\t\t\t\t<div class="xiaof-form-label"><label>手机号</label></div>\t\t\t\t<div class="xiaof-form-control xiaof-box-item">\t\t\t\t\t<input class="xiaof-form-input" type="tel" id="xphone" name="phone" placeholder="请输入您的手机号"/>\t\t\t\t</div>\t\t\t</div>\t\t\t</div>\t\t\t<div class="xiaof-form-group">\t\t\t<div class="xiaof-input-group xiaof-box">\t\t\t\t<div class="xiaof-form-label"><label>验证码</label></div>\t\t\t\t<div class="xiaof-form-control xiaof-box-item">\t\t\t\t\t<input class="xiaof-form-input" id="xverifycode" type="number" name="code" placeholder="请输入您收到的验证码"/>\t\t\t\t</div>\t\t\t</div>\t\t\t</div>\t\t\t<span class="xiaof-button-small getcode">获取验证码</span>', function() {
                                if (r) {
                                    var b = a("#xverifycode").val();
                                    4 != b.length ? alert("验证码格式错误") : e(d, g, "&verifycode=" + b + "&phone=" + p)
                                } else alert("请先获取验证码")
                            });
                            a(".getcode").click(function() {
                                p = a("#xphone").val();
                                h.test(p) ? 1 == f && (f = !1, c(a(this)), a.get(window.sysinfo.siteroot + "app/index.php?c=entry&do=getsms&m=xiaof_toupiao&i=" + window.sysinfo.uniacid + "&phone=" + p, function(a) {
                                    a = (new Function("return" + a))();
                                    0 != a.errno ? alert(a.message) : r = !0
                                })) : alert("不是正确手机号")
                            });
                            return
                        }
                    }
                    a.xiaof.alert("提示", l.message);
                    l.message.indexOf("acid-lists") && new b(".acid-lists", {
                        scrollbar: ".swiper-scrollbar",
                        autoplay: 3E3,
                        scrollbarHide: !0,
                        slidesPerView: 1
                    })
                })
            }
            var h = /^1([38]\d|4[57]|5[0-35-9]|7[06-8]|8[89])\d{8}$/,
                f = !0,
                k = this,
                g = 60;
            a(document).on("click", ".vote", function(b) {
                b.preventDefault();
                b = a(this).attr("data-id");
                var c = d ? d : a(this).siblings(".ballot").find(".goods");
                e(b, c)
            })
        },
        upload: function(d, b) {
            function c(b) {
                var c = "";
                a.each(b, function(a, b) {
                    c = c + "&pics[]=" + encodeURI(b)
                });
                a.post(window.sysinfo.siteroot + "app/index.php?c=entry&do=save&m=xiaof_toupiao&logout=1&i=" + window.sysinfo.uniacid, a("#join-form").serialize() + c, function(c) {
                    c = (new Function("return" + c))();
                    0 == c.errno ? (a(".xiaof-tips-loader").hide(), a.xiaof.alert("提示", c.message, function() {
                        d ? window.location.href = d : location.reload()
                    })) : (a(".xiaof-tips-loader").hide(), a.xiaof.alert("提示", c.message), e = b)
                })
            }
            var e = [];
            wx.ready(function() {
                function d(b) {
                    var e = b.pop();
                    setTimeout(function() {
                        wx.uploadImage({
                            localId: e,
                            isShowProgressTips: 1,
                            success: function(e) {
                                a.get(window.sysinfo.siteroot + "app/index.php?c=entry&do=uploadImg&m=xiaof_toupiao&logout=1&i=" + window.sysinfo.uniacid, {
                                    serverid: encodeURI(e.serverId)
                                }, function(e) {
                                    e = (new Function("return" + e))();
                                    if (0 == e.errno) k.push(e.message);
                                    else return a.xiaof.alert("提示", e.message), !1;
                                    0 < b.length ? d(b) : c(k)
                                })
                            }
                        });
                        g++
                    }, 200)
                }
                var f = [],
                    k = [];
                a("#filepicker").on("click", function() {
                    wx.chooseImage({
                        success: function(b) {
                            a.each(b.localIds, function(b, c) {
                                a("#pic-container").append("<span class='picid new-picid' data-id='" + b + "'><div class='pic-close'>x</div><img src='" + c + "'/></span>")
                            });
                            f = f.concat(b.localIds);
                            a(".new-picid").click(function() {
                                var b = a(this).attr("data-id");
                                f.splice(b, 1);
                                e.splice(b, 1);
                                a(this).remove()
                            })
                        }
                    })
                });
                a("#form-submit").click(function() {
                    localNum = a("#pic-container .picid").length;
                    if (0 >= localNum) a.xiaof.alert("提示", "没有选择照片，不能为空");
                    else {
                        var g = /^1([38]\d|4[57]|5[0-35-9]|7[036-8]|8[89])\d{8}$/;
                        "" == a("#name").val() ? a.xiaof.alert("提示", "名称不能为空") : "" == a("#phone").val() ? a.xiaof.alert("提示", "手机号不能为空") : g.test(a("#phone").val()) ? localNum > b ? a.xiaof.alert("提示", "照片最多不超过" + b + "张") : (a.xiaof.loader("正在报名..."), "" == f || void 0 == f || null == f || 0 >= f.length ? c(e) : d(f)) : a.xiaof.alert("提示", "不是正确手机号")
                    }
                });
                var g = 0
            })
        },
        soundUpload: function() {
            wx.ready(function() {
                var d, b, c, e = !1;
                a("#sound").click(function() {
                    e ? (e = !1, b = (new Date).getTime(), 300 > b - d ? (d = b = 0, clearTimeout(recordTimer)) : wx.stopRecord({
                        success: function(b) {
                            a("#sound").html("录制成功，点击重录");
                            c = b.localId;
                            a("#sound-container").html("<span class='sound-play'><i class='fa fa-volume-up'></i></span>");
                            a(".sound-play").click(function() {
                                wx.playVoice({
                                    localId: c
                                })
                            });
                            wx.uploadVoice({
                                localId: c,
                                isShowProgressTips: 1,
                                success: function(b) {
                                    a.get(window.sysinfo.siteroot + "app/index.php?c=entry&do=uploadImg&type=voice&m=xiaof_toupiao&logout=1&i=" + window.sysinfo.uniacid, {
                                        serverid: encodeURI(b.serverId)
                                    }, function(b) {
                                        b = (new Function("return" + b))();
                                        0 == b.errno ? a("#sound-container").append("<input type='hidden' name='sound' value='" + b.message + "'/>") : a.xiaof.alert("提示", b.message)
                                    })
                                }
                            })
                        },
                        fail: function(a) {
                            alert(JSON.stringify(a))
                        }
                    })) : (e = !0, d = (new Date).getTime(), recordTimer = setTimeout(function() {
                        wx.startRecord({
                            success: function() {
                                localStorage.rainAllowRecord = "true";
                                a("#sound").html("录音中，点击完成")
                            },
                            cancel: function() {
                                alert("授权录音被拒绝")
                            }
                        })
                    }, 300))
                });
                localStorage.rainAllowRecord && "true" === localStorage.rainAllowRecord || wx.startRecord({
                    success: function() {
                        localStorage.rainAllowRecord = "true";
                        wx.stopRecord({})
                    },
                    cancel: function() {
                        alert("授权录音被拒绝")
                    }
                })
            })
        },
        draw: function(d) {
            var b = 1;
            a(".start").click(function() {
                if (1 == b) {
                    var c;
                    a.get(d, function(e) {
                        var d = (new Function("return" + e))();
                        if (999 == d.errno) a.xiaof.alert("提示", d.message);
                        else {
                            c = d.errno;
                            b = 0;
                            a(".draw-box .cur-shade").css({
                                opacity: "0"
                            });
                            a(".draw-cur").removeClass("draw-cur");
                            var f = 1,
                                k = 1,
                                g = setInterval(function() {
                                    f++;
                                    10 < f && (f = 1, k++);
                                    1 == f && a("#draw10 .cur-shade").css({
                                        opacity: "0"
                                    });
                                    a("#draw" + f + " .cur-shade").css({
                                        opacity: "1"
                                    });
                                    a("#draw" + (1 * f - 1) + " .cur-shade").css({
                                        opacity: "0"
                                    });
                                    3 == k && f == parseInt(c) + 1 && (a("#draw" + f + " .cur-shade").addClass("draw-cur"), clearInterval(g), b = 1, a.xiaof.alert("提示", d.message))
                                }, 200)
                        }
                    })
                }
            })
        },
        showSwiper: function(d) {
            var b = new d("#show-container", {
                pagination: ".swiper-pagination",
                paginationClickable: !0,
                onImagesReady: function() {
                    var b = a(".slide-img").eq(0).height();
                    a(".show-lists").height(b)
                },
                onSlideChangeStart: function() {
                    var c = a(".slide-img").eq(b.activeIndex).height();
                    a(".show-lists").height(c)
                }
            })
        },
        showSound: function(d) {
            a("body").append('<audio id="sound-play" controls="controls" preload="auto" style="position:absolute; visibility:hidden;" loop></audio>');
            var b = a("#sound-play"),
                c = 0,
                e = a(".sound-off"),
                h = a(".sound-on");
            a(".show-sound").click(function() {
                0 == c ? (b.attr("src", d), b[0].play(), h.hide(), e.show(), c = 1) : 1 == c ? (b[0].pause(), h.show(), e.hide(), c = 2) : 2 == c && (b[0].play(), h.hide(), e.show(), c = 1)
            })
        },
        playVoice: function(d) {
            a("body").append('<audio id="voice-play" controls="controls" preload="auto" style="position:absolute; visibility:hidden;" loop></audio>');
            var b = a("#voice-play"),
                c = 0,
                e = a(".voice-off"),
                h = a(".voice-on");
            a(".play-voice").click(function() {
                0 == c ? (b.attr("src", d), b[0].play(), h.hide(), e.show(), c = 1) : 1 == c ? (b[0].pause(), h.show(), e.hide(), c = 2) : 2 == c && (b[0].play(), h.hide(), e.show(), c = 1)
            })
        },
        indexSound: function() {
            a("body").append('<audio id="sound-play" onended="$(\'.sound-on\').show();$(\'.sound-off\').hide();soundStatus=0;" controls="controls" preload="auto" style="position:absolute; visibility:hidden;"></audio>');
            var d = a("#sound-play");
            a("#container").on("click", ".index-show-sound", function(b) {
                b.preventDefault();
                b = a(this).attr("data-src");
                var c = a(this).find(".sound-off"),
                    e = a(this).find(".sound-on");
                a(".sound-off").hide();
                0 == soundStatus ? (d.attr("src", b), d[0].play(), e.hide(), c.show(), soundStatus = 1) : 1 == soundStatus && (d[0].pause(), a(".sound-on").show(), a(".sound-off").hide(), soundStatus = 0)
            })
        },
        indexBgsound: function(d) {
            a("body").append('<div class="video_exist play_yinfu" id="audio_btn" style="display: block;"><div id="yinfu" class="rotate"></div><audio preload="auto" autoplay="autoplay" id="media" src="' + d + '" loop></audio></div>');
            a("#media")[0].play();
            a("#audio_btn").click(function() {
                a(this).hasClass("off") ? (a(this).addClass("play_yinfu").removeClass("off"), a("#yinfu").addClass("rotate"), a("#media")[0].play()) : (a(this).addClass("off").removeClass("play_yinfu"), a("#yinfu").removeClass("rotate"), a("#media")[0].pause())
            })
        },
        getLocation: function() {
            wx.ready(function() {
                wx.getLocation({
                    success: function(d) {
                        a.post(window.sysinfo.siteroot + "app/index.php?c=entry&do=verifyLocation&m=xiaof_toupiao&i=" + window.sysinfo.uniacid, {
                            latitude: d.latitude,
                            longitude: d.longitude
                        }, function(b) {
                            b = (new Function("return" + b))();
                            0 == b.errno ? a(".gpsmsg").html("定位成功，点击确定继续") : a(".gpsmsg-title").html(b.message)
                        })
                    },
                    fail: function() {
                        a.xiaof.alert("提示", "地理位置获取失败")
                    },
                    cancel: function() {
                        a.xiaof.alert("提示", "放弃定位")
                    }
                })
            })
        }
    }
});
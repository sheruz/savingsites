
var base_url =  $("input[name='base_url']").val();
/*alert($("#quick_access_userid").val());*/
function view_all_with_popup_load() {
    /*alert("hiii");*/
    fn_view_user_category(), fn_all_state_select()
}
view_all_with_popup_load();
function fn_view_user_category() {
    var a = {
        zoneid: $("#get_zoneid").val(),
        userid : $("#get_user_id").val()
    };
    $.ajax({
        type: "POST",
        async: !1,
        url: base_url + "directory_ss/view_user_category/",
        cache: !1,
        data: a,
        dataType: "json",
        success: function(a) {
            var b = "<option>Select Category</option><option value='-1'>SS Zone</option>";
            "" != a && $.each(a, function(a, c) {
                b += "<option value='" + c.id + "'>" + c.name + "</option>"
            }),$("#site_category").html(b)
        }
    }), $("#qlerr").empty(), $("#quick_site_category").append("<li><a href='javascript:void(0);' data-id='ss-zone' data-userid='" + $("#get_user_id").val() + "' data-zoneid='" + $("#get_zoneid").val() + "'>SS Zone</a></li>"), view_ss_category($("#get_user_id").val(), $("#get_zoneid").val(), 0)
}

function fn_all_state_select() {
    $.ajax({
        type: "POST",
        url: base_url + "sampleLayout/get_all_state",
        cache: !1,
        dataType: "json",
        success: function(a) {
            $("#search_zone_loader").hide();
            var b = '<select id="dir_state" name="dir_state"><option value="" selected="selected">Select...</option>';
            $(a).each(function(a, c) {
                b += '<option value="' + c.state_id + '">' + c.state_name + "</option>"
            }), b += "</select>", $(".showstate").show(), $(".showstate").html(b)
        }
    })
}

function view_ss_category(a, b, c) {
    
    var zoneid = $("#get_zoneid").val();
    var userid = $("#get_user_id").val();

    var a = {
        zoneid: $("#get_zoneid").val(),
        userid : $("#get_user_id").val()
    };

    $.ajax({
        type: "POST",
        async: !1,
        url: base_url + "directory_ss/view_user_category",
        cache: !1,
        data: a,
        dataType: "json",
        success: function(a) {
            $("#quick_site_category").empty(),$("#quick_site_category").append("<li class='text-left d-flex'>SS Zone(Default)</li>"), "" != a &&
            $.each(a, function(a, c) {
                $("#quick_site_category").append("<li class='text-left d-flex' id='cat_id_" + c.id + "'><p id='categoryid_"+ c.id+"' contenteditable='true'>" + c.name + "</p><input type='submit' style='display:none !important;' onclick='updatecategory("+c.id+","+userid+","+zoneid+")' class='ml-2 btn btn-primary btn-sm' id='update_sub_"+c.id+"' value='Save'><a class='ml-auto' href='javascript:void(0);' onclick='del_catid("+c.id+","+userid+","+zoneid+")'>Delete</a> | <a href='javascript:void(0);' onclick='edit_catid("+c.id+","+userid+","+zoneid+")'>Edit</a></li>")
            }), view_ss_cat(a, b, c),
            //$("#add_more_view").html("<p id='category_add' style='display:none'><input class='w-100' type='text' id='add_new_cat'><input type='submit'  class='mt-2 d-inline-block' id='add_new_sub' value='Add'></br></p><a id='add_new_category' href='javascript:void(0)'>Add New</a>"))
            $("#add_more_view").html()
        }
    })
}

function updatecategory(user_category_id,userid,zoneid)
{
    var cat_text = $("#cat_text_"+user_category_id).val();
    $.ajax({
        type: "POST",
        url: base_url + "directory_ss/update_category/",
        datType:'json',
        data: {
            zoneid:zoneid,
            userid:userid,
            user_category_id:user_category_id,
            cat_text:cat_text
        },
        dataType: "json",
        success: function(result) {
            //$("#favourite_list_show").html(result);
            $("#cat_text_"+user_category_id).hide();
            $("#update_sub_"+user_category_id).hide();
            $("#cat_id_"+user_category_id).html("<p id='categoryid_"+user_category_id+"'>"+cat_text+"</p><input style='display:none !important;' type='submit' onclick='updatecategory("+user_category_id+","+userid+","+zoneid+")' class='ml-2 btn btn-primary btn-sm' id='update_sub_"+user_category_id+"' value='Save'><a class='ml-auto' href='javascript:void(0);' onclick='del_catid("+user_category_id+","+userid+","+zoneid+")'>Delete</a> | <a href='javascript:void(0);' onclick='edit_catid("+user_category_id+","+userid+","+zoneid+")'>Edit</a>");
        },
    });
}

function edit_catid(user_category_id,userid,zoneid) {
    //alert(user_category_id);
    var divHtml = $("#categoryid_"+user_category_id).html();
    var editableText = $("<input id='cat_text_"+user_category_id+"' class='form-control' style='width: 42%;'/>");
    $("#update_sub_"+user_category_id).show();
    editableText.val(divHtml);
    $("#categoryid_"+user_category_id).replaceWith(editableText);
    editableText.focus();
    // setup the blur event for this new textarea
    editableText.blur(editableTextBlurred(user_category_id));
    
}
function editableTextBlurred(user_category_id) {
    var html = $("#categoryid_"+user_category_id).val();
    var viewableText = $("<div>");
    viewableText.html(html);
    $("#categoryid_"+user_category_id).replaceWith(viewableText);
    // setup the click event for this new div
    viewableText.click(edit_catid);
    $("div").click(edit_catid);
}



$(document).ready(function(){
    $("#add_new_category").on("click",function(){
        $("#category_add").show();
    });

    $("#add_new_sub").on("click",function(){
        var add_new_cat = $("#add_new_cat").val();
        var zoneid = $("#get_zoneid").val();
        var userid = $("#get_user_id").val();

        if(add_new_cat == '')
        {
            $("#add_new_cat").css({"border":"1px solid red"});
        }else{
            //$("#category_add").show();
            $.ajax({
                type:"POST",
                async: !1,
                url:base_url+"directory_ss/category_add",
                datType:'json',
                cache: !1,
                data:
                {
                    cat_name:add_new_cat,
                    userid:userid,
                    zoneid:zoneid,
                },
                success:function(response)
                {
                    //alert(response);
                    //alert(response.cat_id);
                    if(response != '')
                    {
                        //alert(response);
                        var cat_id = response.trim();
                        $("#category_add").hide();
                        $("#add_new_cat").val("");
                        $("#quick_site_category").append("<li class='text-left d-flex' class='ml-auto' id='cat_id_"+cat_id+"'><p id='categoryid_"+cat_id+"'>"+add_new_cat+"</p><input style='display:none !important;' type='submit' onclick='updatecategory("+cat_id+","+userid+","+zoneid+")' class='ml-2 btn btn-primary btn-sm' id='update_sub_"+cat_id+"' value='Save'><a class='ml-auto' href='javascript:void(0);' onclick='del_catid("+cat_id+","+userid+","+zoneid+")'>Delete</a> | <a href='javascript:void(0);' onclick='edit_catid("+cat_id+","+userid+","+zoneid+")'>Edit</a></li>");
                    }
                },
            })
        }
    });

    $("#qlssave").on("click",function(){
        var site_name = $("#site_name").val();
        var site_category = $("#site_category").val();
        var site_link = $("#site_link").val();
        var site_comments = $("#site_comments").val();
        var zoneid = $("#get_zoneid").val();
        var userid = $("#get_user_id").val();
        
        if(site_name == '')
        {
            $("#site_name").css({"border":"1px solid red"});
            return false;
        }
        else if(site_category == 'Select Category')
        {
            $("#site_category").css({"border":"1px solid red"});
            return false;
        }
        else if(site_link == '')
        {
            $("#site_link").css({"border":"1px solid red"});
            return false;
        } 
        else{
            //$("#category_add").show();
            $.ajax({
                type:"POST",
                url:base_url+"directory_ss/userfav_add",
                datType:'json',
                data:
                {
                    site_name:site_name,
                    site_category:site_category,
                    site_link:site_link,
                    site_comments:site_comments,
                    userid:userid,
                    zoneid:zoneid,
                },
                success:function(response)
                {
                    if(response.cat_id != '')
                    {
                        $("#site_name").removeAttr("required");
                        $("#site_name").removeAttr("style");
                        $("#site_category").removeAttr("required");
                        $("#site_category").removeAttr("style");
                        $("#site_link").removeAttr("required");
                        $("#site_link").removeAttr("style");
                        $("#site_comments").removeAttr("required");
                        $("#site_comments").removeAttr("style");

                        $("#site_name").val("");
                        $("#site_category").val("");
                        $("#site_link").val("");
                        $("#site_comments").val("");
                        $(".fav_submit").html("Added To Favourite Successfully");
                    }
                },
                
            });

            return false;
        }
    });

    $("#tab_1").on("click",function(){
            var a = {
                zoneid: $("#get_zoneid").val(),
                userid: $("#get_user_id").val()
            };
            $.ajax({
                type: "POST",
                async: !1,
                url: base_url + "directory_ss/view_user_category/",
                cache: !1,
                data: a,
                dataType: "json",
                success: function(a) {
                    var b = "<option>Select Category</option><option value='-1'>SS Zone</option>";
                    "" != a && $.each(a, function(a, c) {
                        b += "<option value='" + c.id + "'>" + c.name + "</option>"
                    }),$("#site_category").html(b)
                }
            });
        });

        $("#tab_2").on("click",function(){
            zoneid = $("#get_zoneid").val();
             userid = $("#get_user_id").val();
    
            $.ajax({
                type: "POST",
                url: base_url + "directory_ss/view_all_favourite/",
                datType:'json',
                data: {
                    zoneid:zoneid,
                    userid:userid
                },
                dataType: "json",
                success: function(result) {
                    $("#favourite_list_show").html(result);
                },
            });
        });

        $(".fav_delete").on("click",function(){
            alert('dfhfg');
            zoneid = $("#get_zoneid").val();
             userid = $("#get_user_id").val();
             curr_id = $(this).attr('id');
    
            $.ajax({
                type: "POST",
                url: base_url + "directory_ss/delete_favourite/",
                datType:'json',
                data: {
                    zoneid:zoneid,
                    userid:userid,
                    fav_id:curr_id
                },
                dataType: "json",
                success: function(result) {
                    //$("#favourite_list_show").html(result);
                    $("#fav_list_"+curr_id).hide();
                },
            });
        });

    });

 

function del_catid(user_category_id,userid,zoneid){
    zoneid = $("#quick_access_userid").val();
        userid = $("#quick_access_zoneid").val();
        //curr_id = $(this).attr('id');
        var result = confirm("Want to delete?");
        if(result)
        {
            $.ajax({
                type: "POST",
                url: base_url + "directory_ss/delete_category/",
                datType:'json',
                data: {
                    zoneid:zoneid,
                    userid:userid,
                    cat_id:user_category_id
                },
                dataType: "json",
                success: function(result) {
                    //$("#favourite_list_show").html(result);
                    //$("ul #cat_id_"+user_category_id).css({"display":"none !important"});
                    //$("#cat_id_"+user_category_id).attr("style", "display:red");
                    $("#cat_id_"+user_category_id).attr("style", "display:none !important");
                    //$("#site_link").css({"border":"1px solid red"});
                    //$("#add_new_cat").css({"border":"1px solid red"});
                },
            });
        }
}
function view_ss_cat(a, b, c) {
    $(".infos").hide();
    var d = {
        userid: a,
        zoneid: b,
        catid: c
    };
    $.ajax({
        type: "POST",
        async: !1,
        url: base_url + "directory_ss/fetch_user_fav_cat",
        cache: !1,
        data: d,
        dataType: "json",
        success: function(a) {
            $("#quick_site_links").empty(), $("#site_category_txt").val(""), "Already exist!!!" == a ? $("#qlerr").html(a) : $.each(a, function(a, b) {
                $("#qlerr").empty(), $("#quick_site_links").append("<li><a href='" + b.sitelink + "' target='_blank' data-id='" + b.id + "' cat_id='" + b.zone_id + "'>" + b.sitename + "</a><a href='javascript:void(0);' class='ql_info' data-arrpos='" + b.id + "'><img src='../../assets/images/info.png' width='16' /></a><a href='javascript:void(0);' class='ql_remove ss-link' data-id='" + b.id + "' data-catid='" + b.catid + "'><img src='../../assets/images/remove.png' width='16' /></a></li>")
            })
        }
    })
}

function show_main_cat_dropdown(a, b, c) {
    var d = {
        userid: $("#get_zoneid").val(),
        zoneid: $("#get_user_id").val()
    };
    $.ajax({
        type: "POST",
        async: !1,
        url: base_url + "directory_ss/view_user_category/",
        cache: !1,
        data: d,
        dataType: "json",
        success: function(d) {
            var e = '<label for="site_category" class="label">Category:</label><select name="site_category" id="site_category" style="margin-left:12px;" required>';
            e += '<option value="-1">Select Category</option>', "" != d && $.each(d, function(a, b) {
                e += '<option value="' + b.id + '">' + b.name + "</option>"
            }), e += '<option value="new">Add New Category</option>', e += "</select>", $(".fright").html(e), view_ss_category(a, b, c)
        }
    })
}

function view_ss_zone(a, b, c) {
    $("#quick_site_links").empty();
    var d = {
        userid: b,
        zoneid: 0,
        id: a
    };
    $.ajax({
        type: "POST",
        async: !1,
        url: base_url + "directory_ss/fetch_user_fav_zone",
        cache: !1,
        data: d,
        dataType: "json",
        success: function(a) {
            "Already exist!!!" == a ? $("#qlerr").html(a) : $.each(a, function(a, b) {
                $("#qlerr").empty(), $("#quick_site_links").append("<li><a href='" + base_url + "zone/" + b.seo_zone_name + "' target='_blank' data-id='" + b.id + "'>" + b.zone_name + "</a><a href='javascript:void(0);' class='ql_remove ss_zone' data-id='" + b.id + "'><img src='../../assets/images/remove.png' width='16' /></a></li>")
            })
        }
    })
}
$(document).on("click", "a.accesslogin", function() {
    $("#directory-search").fadeOut(300), $("#create-links").fadeOut(300);
    var a = $(this).attr("href");
    $(a).fadeIn(300);
    var b = ($(a).height() + 24) / 2,
        c = ($(a).width() + 24) / 2;
    return $(a).css({
        "margin-top": -b,
        "margin-left": -c
    }), $("body").append('<div id="mask"></div>'), $("#mask").fadeIn(300), !1
}), $(document).on("change", "#site_category", function() {
    $("#qlerr").empty(), "new" == $(this).val() && ($("#site_category_txt").show(), $("#site_category_txt").focus(), $(this).hide(), addnew = !0)
}), $(document).on("change", "#dir_state", function() {
    var a = $(this).val();
    if ("" != a) {
        var b = {
            state: a
        };
        $.ajax({
            type: "POST",
            url: base_url + "sampleLayout/get_zone",
            cache: !1,
            data: b,
            dataType: "json",
            beforeSend: function() {},
            success: function(a) {
                var b = "";
                $("#ss_site_name").show(), "" != a ? ($(a).each(function(a, c) {
                    b += '<option value="' + c.id + '">' + c.name + "</option>"
                }), $("#ss_site_name").html(b)) : $("#ss_site_name").html('<option value="-1">No Zone found in this State.</option>')
            }
        })
    } else $("#ss_site_name").html('<option value="-1">No Zone found in this State.</option>')
}), $(document).on("click", "#quick_site_category a", function() {
    var a = $(this).attr("data-id"),
        b = $(this).attr("data-userid"),
        c = $(this).attr("data-zoneid");
    $("#qlerr").empty(), $("#quick_site_category a").each(function(a) {
        //$(this).removeClass("curr")
    }), /*$(this).addClass("curr"),*/ "ss-zone" == a ? view_ss_zone(a, b, c) : "ss-zone" != a && view_ss_cat(b, c, a)
}), $(document).on("click", ".ss-link", function() {
    var a = $(this).attr("data-id"),
        b = $(this).attr("data-catid"),
        c = {
            id: a
        };
    $.ajax({
        url: base_url + "directory_ss/user_delete_sites",
        data: c,
        dataType: "json",
        success: function(a) {
            1 == a && view_ss_cat($("#quick_access_userid").val(), $("#quick_access_zoneid").val(), b)
        }
    })
}), $(document).on("click", ".add_ss_link", function(event) {
/*    var a = $("#create-links-form").validate({
        submitHandler: function() {*/
            if (""==$("#quick_access_userid").val()){
                var getuserid = $("input[name='user_id']").val();
            }else{
                var getuserid = $("input[name='quick_access_userid']").val();
            }
            if (""==$("#quick_access_zoneid").val()){
                var getuserid = $("input[name='zoneid']").val();
            }else{
                var getuserid = $("input[name='quick_access_zoneid']").val();
            }
            $("#qlerr").empty();
            var b = 0,
                c = 0;
            if ("-1" == $("#site_category").val()) return alert("Please Select Category..."), !1;
            if ("new" == $("#site_category").val()) {
                //alert("1st if");
                var d = $("#site_category_txt").val(),
                    e = {
                        userid: $("#quick_access_userid").val(),
                        zoneid: $("#quick_access_zoneid").val(),
                        catname: d,
                        category_id: $("#quick_access_id").val()
                    };
                $.ajax({
                    type: "POST",
                    async: !1,
                    url: base_url + "directory_ss/insert_user_category",
                    cache: !1,
                    data: e,
                    success: function(a) {
                        "" != a.trim() && (b = a.trim(), c = 1, fn_view_user_category(), $("#site_category").show(), $("#site_category_txt").hide())
                    }
                })
            } else b = $("#site_category").val();
            if ("0" != b) {
                var e = {
                    userid: /*$("#quick_access_userid").val()*/$("input[name='user_id']").val(),
                    cat_id: b,
                    zoneid: /*$("#quick_access_zoneid").val()*/$("input[name='zoneid']").val(),
                    sitename: $("#site_name").val(),
                    sitelink: $("#site_link").val(),
                    sitecomments: $("#site_comments").val(),
                    quick_access_id: $("#quick_access_id").val(),
                    create: c
                };
                alert(base_url);
                $.ajax({
                    type: "POST",
                    async: !1,
                    url: base_url+"directory_ss/user_quick_access",
                    cache: !1,
                    data: e,
                    success: function(c) {
                       /* a.resetForm(), $("#create-links-form")[0].reset(), $("#qlerr").empty(), "0" == c.trim() ? $("#qlerr").html("Error! Site name exists!") : ($("#qlerr").html("Successfully Inserted..."), view_ss_category($("#quick_access_userid").val(), $("#quick_access_zoneid").val(), b))
                   */ }
                })
            } else $("#qlerr").html("Error! Site name exists!")
/*        }
    })*/
}), $(document).on("click", "#quick_site_links a.ql_info", function() {
    var a = $(this).attr("data-arrpos"),
        b = $("#create-links .infos");
    b.hide("fast"), $("#create-links #quick_site_links").animate({
        height: "200px"
    }, 300), $("#create-links #quick_site_category").animate({
        height: "200px"
    }, 300), glpos = $(this).attr("data-arrpos"), b.empty(), $("#create-links #quick_site_links").animate({
        height: "120px"
    }, 300), $("#create-links #quick_site_category").animate({
        height: "120px"
    }, 300), $("#create-links .infos1").hide("slow"), b.show("slow", function() {
        var c = {
            id: a
        };
        $.ajax({
            url: base_url + "directory_ss/view_specific_links",
            data: c,
            dataType: "json",
            success: function(c) {
                "" != c && (b.show(), $.each(c, function(c, d) {
                    var e = new Date(1e3 * d.timestamp);
                    b.append("<h4>" + d.sitename + "<a href='javascript:void(0);' id='ql_edit' data-id='" + a + "' style='text-decoration:none;font-weight:normal;font-size:14px;float:right;display:inline-block;'><img src='../../assets/images/edit.png' width='22' style='vertical-align:middle;'/>Edit</a></h4>"), b.append("<p><span>Site Url: </span>" + d.sitelink + "</p>"), b.append("<p><span>Notes: </span>" + d.sitecomments + "</p>"), b.append("<p><span>Bookmarked on: </span>" + e + "</p>")
                }))
            }
        })
    })
}), $(document).on("click", "#ql_edit", function() {
    var a = $(this).attr("data-id"),
        b = $(this).attr("cat-id"),
        c = {
            id: a
        };
    $.ajax({
        url: base_url + "directory_ss/view_specific_links",
        data: c,
        dataType: "json",
        success: function(c) {
            "" != c && ($.each(c, function(c, d) {
                $("#quick_access_id").val(a), $("#quick_access_catid").val(b), $("#site_name").val(d.sitename), $("#site_link").val(d.sitelink), $("#site_comments").val(d.sitecomments), $("#site_category").find("option").each(function(a, b) {
                    b.value == d.catid && $(b).attr("selected", "selected")
                })
            }), $("#qlssave").val("Update"))
        }
    })
}), $(document).on("click", ".ss_zone", function() {
    var a = $("#quick_access_userid").val(),
        b = $(this).attr("data-id"),
        c = {
            id: b
        };
    $.ajax({
        url: base_url + "directory_ss/user_delete_zone/",
        data: c,
        dataType: "json",
        success: function(b) {
            1 == b && view_ss_zone(0, a, 0)
        }
    })
}), $(document).on("click", ".add_ss_zone", function() {
    var a = $("#create-links-form1").validate({
        submitHandler: function() {
            var b = "ss-zone";
            $("#qlerr").empty();
            var c = $("#quick_access_userid").val(),
                d = $("#ss_site_name").val(),
                e = {
                    userid: c,
                    zoneid: d
                }; - 1 != d && null != d ? $.ajax({
                type: "POST",
                async: !1,
                url: base_url + "directory_ss/user_fav_zone/",
                cache: !1,
                data: e,
                dataType: "json",
                success: function(a) {
                    $("#qlerr").html(a), view_ss_zone(0, c, 0)
                }
            }) : alert("Must select a Zone!!"), $("#quick_site_category a").each(function(a) {
                //$(this).removeClass("curr"), b == $(this).attr("data-id") && $(this).addClass("curr")
            }), a.resetForm(), $("#create-links-form1")[0].reset()
        }
    })
});
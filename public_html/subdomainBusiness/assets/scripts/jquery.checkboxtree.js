$.widget("daredevel.checkboxTree",{_allDescendantChecked:function(a){return 0==a.find("li input:checkbox:not(:checked)").length},_create:function(){var a=this;this.options.collapsable&&(this.options.collapseAnchor=this.options.collapseImage.length>0?'<img src="'+this.options.collapseImage+'" />':"",this.options.expandAnchor=this.options.expandImage.length>0?'<img src="'+this.options.expandImage+'" />':"",this.options.leafAnchor=this.options.leafImage.length>0?'<img src="'+this.options.leafImage+'" />':"",this.element.find("li:not(:has(ul))").each(function(){$(this).prepend($("<span />")),a._markAsLeaf($(this))}),this.element.find("li:has(ul):has(input:checkbox:checked)").each(function(){$(this).prepend($("<span />")),"collapsed"==a.options.initializeChecked?a.collapse($(this)):a.expand($(this))}),this.element.find("li:has(ul):not(:has(input:checkbox:checked))").each(function(){$(this).prepend($("<span />")),"collapsed"==a.options.initializeUnchecked?a.collapse($(this)):a.expand($(this))}),this.element.find("li span").live("click",function(){var b=$(this).parents("li:first");b.hasClass("collapsed")?a.expand(b):b.hasClass("expanded")&&a.collapse(b)}),$(this.options.collapseAllElement).bind("click",function(){a.collapseAll()}),$(this.options.expandAllElement).bind("click",function(){a.expandAll()}),"collapse"==this.options.onUncheck.node?this.element.find("input:checkbox:not(:checked)").live("click",function(){a.collapse($(this).parents("li:first"))}):"expand"==this.options.onUncheck.node&&this.element.find("input:checkbox:not(:checked)").live("click",function(){a.expand($(this).parents("li:first"))}),"collapse"==this.options.onCheck.node?this.element.find("input:checkbox:checked").live("click",function(){a.collapse($(this).parents("li:first"))}):"expand"==this.options.onCheck.node&&this.element.find("input:checkbox:checked").live("click",function(){a.expand($(this).parents("li:first"))})),this.element.find("input:checkbox:not(:checked)").live("click",function(){var b=$(this).parents("li:first");a.uncheck(b)}),this.element.find("input:checkbox:checked").live("click",function(){var b=$(this).parents("li:first");a.check(b)}),this.element.addClass("ui-widget-daredevel-checkboxTree"),this.element.addClass("ui-widget ui-widget-content")},_checkAncestors:function(a){a.parentsUntil(".ui-widget").filter("li").find("input:checkbox:first:not(:checked)").attr("checked",!0).change()},_checkDescendants:function(a){a.find("li input:checkbox:not(:checked)").attr("checked",!0).change()},_checkOthers:function(a){a.addClass("exclude"),a.parents("li").addClass("exclude"),a.find("li").addClass("exclude"),$(this.element).find("li").each(function(){$(this).hasClass("exclude")||$(this).find("input:checkbox:first:not(:checked)").attr("checked",!0).change()}),$(this.element).find("li").removeClass("exclude")},_destroy:function(){this.element.removeClass(this.options.cssClass),$.Widget.prototype.destroy.call(this)},_isRoot:function(a){return 0==a.parentsUntil(".ui-widget-daredevel-checkboxTree").length},_markAsCollapsed:function(a){this.options.expandAnchor.length>0?a.children("span").html(this.options.expandAnchor):this.options.collapseUiIcon.length>0&&a.children("span").removeClass(this.options.expandUiIcon).addClass("ui-icon "+this.options.collapseUiIcon),a.removeClass("expanded").addClass("collapsed")},_markAsExpanded:function(a){this.options.collapseAnchor.length>0?a.children("span").html(this.options.collapseAnchor):this.options.expandUiIcon.length>0&&a.children("span").removeClass(this.options.collapseUiIcon).addClass("ui-icon "+this.options.expandUiIcon),a.removeClass("collapsed").addClass("expanded")},_markAsLeaf:function(a){this.options.leafAnchor.length>0?a.children("span").html(this.options.leafAnchor):this.options.leafUiIcon.length>0&&a.children("span").addClass("ui-icon "+this.options.leafUiIcon),a.addClass("leaf")},_parentNode:function(a){return a.parents("li:first")},_uncheckAncestors:function(a){a.parentsUntil(".ui-widget").filter("li").find("input:checkbox:first:checked").attr("checked",!1).change()},_uncheckDescendants:function(a){a.find("li input:checkbox:checked").attr("checked",!1).change()},_uncheckOthers:function(a){a.addClass("exclude"),a.parents("li").addClass("exclude"),a.find("li").addClass("exclude"),$(this.element).find("li").each(function(){$(this).hasClass("exclude")||$(this).find("input:checkbox:first:checked").attr("checked",!1).change()}),$(this.element).find("li").removeClass("exclude")},check:function(a){a.find("input:checkbox:first:not(:checked)").attr("checked",!0).change(),"check"==this.options.onCheck.others?this._checkOthers(a):"uncheck"==this.options.onCheck.others&&this._uncheckOthers(a),"check"==this.options.onCheck.descendants?this._checkDescendants(a):"uncheck"==this.options.onCheck.descendants&&this._uncheckDescendants(a),"check"==this.options.onCheck.ancestors?this._checkAncestors(a):"uncheck"==this.options.onCheck.ancestors?this._uncheckAncestors(a):"checkIfFull"==this.options.onCheck.ancestors&&!this._isRoot(a)&&this._allDescendantChecked(this._parentNode(a))&&this.check(this._parentNode(a))},checkAll:function(){$(this.element).find("input:checkbox:not(:checked)").attr("checked",!0).change()},collapse:function(a){if(!a.hasClass("collapsed")&&!a.hasClass("leaf")){var b=this;a.children("ul").hide(this.options.collapseEffect,{},this.options.collapseDuration),setTimeout(function(){b._markAsCollapsed(a,b.options)},b.options.collapseDuration),b._trigger("collapse",a)}},collapseAll:function(){var a=this;$(this.element).find("li.expanded").each(function(){a.collapse($(this))})},expand:function(a){if(!a.hasClass("expanded")&&!a.hasClass("leaf")){var b=this;a.children("ul").show(b.options.expandEffect,{},b.options.expandDuration),setTimeout(function(){b._markAsExpanded(a,b.options)},b.options.expandDuration),b._trigger("expand",a)}},expandAll:function(){var a=this;$(this.element).find("li.collapsed").each(function(){a.expand($(this))})},uncheck:function(a){a.find("input:checkbox:first:checked").attr("checked",!1).change(),"check"==this.options.onUncheck.others?this._checkOthers(a):"uncheck"==this.options.onUncheck.others&&this._uncheckOthers(a),"check"==this.options.onUncheck.descendants?this._checkDescendants(a):"uncheck"==this.options.onUncheck.descendants&&this._uncheckDescendants(a),"check"==this.options.onUncheck.ancestors?this._checkAncestors(a):"uncheck"==this.options.onUncheck.ancestors&&this._uncheckAncestors(a)},uncheckAll:function(){$(this.element).find("input:checkbox:checked").attr("checked",!1).change()},options:{collapsable:!0,collapseAllElement:"",collapseDuration:500,collapseEffect:"blind",collapseImage:"",collapseUiIcon:"ui-icon-triangle-1-e",expandAllElement:"",expandDuration:500,expandEffect:"blind",expandImage:"",expandUiIcon:"ui-icon-triangle-1-se",initializeChecked:"expanded",initializeUnchecked:"expanded",leafImage:"",leafUiIcon:"",onCheck:{ancestors:"check",descendants:"check",node:"",others:""},onUncheck:{ancestors:"",descendants:"uncheck",node:"",others:""}}});
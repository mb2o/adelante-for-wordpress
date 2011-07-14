(function () {
    tinymce.create("tinymce.plugins.ShortcodeNinjaPlugin", {
        init: function (d, e) {
            d.addCommand("scnOpenDialog", function (a, c) {
                scnSelectedShortcodeType = c.identifier;
                jQuery.get(e + "/dialog.php", function (b) {
                    jQuery("#scn-dialog").remove();
                    jQuery("body").append(b);
                    jQuery("#scn-dialog").hide();
                    var f = jQuery(window).width();
                    b = jQuery(window).height();
                    f = 720 < f ? 720 : f;
                    f -= 80;
                    b -= 84;
                    tb_show("Insert Shortcode", "#TB_inline?width=" + f + "&height=" + b + "&inlineId=scn-dialog");
                    jQuery("#scn-options h3:first").text("Customize your " + c.title + " shortcode")
                })
            });
            d.onNodeChange.add(function (a, c) {
                c.setDisabled("scn_button", a.selection.getContent().length > 0)
            })
        },
        createControl: function (d, e) {
            if (d == "scn_button") {
                d = e.createMenuButton("scn_button", {
                    title: "Insert Shortcode",
                    image: adelante_globals.plugin_path + "tinymce/img/icon.png",
                    icons: false
                });
                var a = this;
                d.onRenderMenu.add(function (c, b) {                    
                    
                    a.addWithDialog(b, "Blog", "blog");
                    
                    c = b.addMenu({
                        title: "Boxes"
                    });                    
                    a.addWithDialog(c, "Iconbox", "iconbox");
                    a.addWithDialog(c, "Imagebox", "imagebox");                    
                    a.addWithDialog(c, "Infobox", "infobox");
                    a.addWithDialog(c, "Lightbox", "lightbox");
                    a.addWithDialog(c, "Sproutebox", "sproutebox");
                    a.addWithDialog(c, "Togglebox", "togglebox");
                    a.addWithDialog(c, "Widgetbox", "widgetbox");

                    a.addWithDialog(b, "Button", "button");
                    
                    a.addWithDialog(b, "Code Snippet", "code");
                    
                    a.addWithDialog(b, "Column Layout", "column");                
                    
                    c = b.addMenu({
                        title: "Dividers"
                    });
                    a.addImmediate(c, "Horizontal Rule", "<br>[hr] <br>");
                    a.addImmediate(c, "Horizontal Rule with top link", "<br>[hr top] <br>");
                    
                    c = b.addMenu({
                        title: "Dropcaps"
                    });                    
                    a.addImmediate(c, "Dropcap Style #1 (Letter)", "[dropcap1]A[/dropcap1]");
                    a.addImmediate(c, "Dropcap Style #2 (Colored Background)", "[dropcap2]A[/dropcap2]");
                                        
                    c = b.addMenu({
                        title: "Google"
                    });
                    a.addWithDialog(c, "Google Map", "map");
                                        
                    a.addWithDialog(b, "Icon Link", "iconlink");
                    
                    a.addWithDialog(b, "Lorem", "lorem");

                    a.addWithDialog(b, "Private Content", "private");
                    
                    a.addWithDialog(b, "Quote", "quote");

					a.addWithDialog(b, "Tooltip", "tooltip"); 
                    
                    a.addWithDialog(b, "Video", "video");
                         
                });
                return d
            }
            return null
        },
        addImmediate: function (d, e, a) {
            d.add({
                title: e,
                onclick: function () {
                    tinyMCE.activeEditor.execCommand("mceInsertContent", false, a)
                }
            })
        },
        addWithDialog: function (d, e, a) {
            d.add({
                title: e,
                onclick: function () {
                    tinyMCE.activeEditor.execCommand("scnOpenDialog", false, {
                        title: e,
                        identifier: a
                    })
                }
            })
        },
        getInfo: function () {
            return {
                longname: "Shortcode Ninja plugin",
                author: "VisualShortcodes.com",
                authorurl: "http://visualshortcodes.com",
                infourl: "http://visualshortcodes.com/shortcode-ninja",
                version: "1.0"
            }
        }
    });
    tinymce.PluginManager.add("ShortcodeNinjaPlugin", tinymce.plugins.ShortcodeNinjaPlugin)
})();

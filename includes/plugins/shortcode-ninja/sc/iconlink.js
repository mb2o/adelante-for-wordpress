scnShortcodeMeta = {
    attributes: [
        {
            label: "Title",
            id: "content",
            isRequired: true,
            help: "The link text."
        }, 
        {
            label: "Link",
            id: "url",
            help: "The Url for your icon link.",
            validateLink: true
        },
        {
            label: "Style",
            id: "style",
            help: "Values: &lt;empty&gt;, info, alert, tick, download, note, help, error",
            controlType:"select-control", 
            selectValues: adelante_globals['icons'],
            defaultValue: '', 
            defaultText: 'none (default)'
	    },
        {
            label: "Icon",
            id: "icon",
            help: "Optional. Url to a custom icon."
        }
    ],
    defaultContent: "Replace with content of your own",
    shortcode: "iconlink"
};
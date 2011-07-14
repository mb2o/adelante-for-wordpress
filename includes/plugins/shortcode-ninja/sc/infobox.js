scnShortcodeMeta={
	attributes:[
		{
			label: "Type",
			id: "type",
			help: "Select an image for the info box", 
			controlType: "select-control", 
			selectValues: adelante_globals['icons'],
			defaultValue: '', 
			defaultText: 'none (default)'
		},
		{
			label: "Size",
			id: "size",
			help: "Values: &lt;empty&gt;, medium, large.", 
			controlType: "select-control", 
			selectValues: ['', 'medium', 'large'],
			defaultValue: 'medium', 
			defaultText: 'medium (default)'
		},
        {
            label: "Font Color",
            id: "color",
            help: "Optional. Specify a font color for the info box",
            controlType: "color-control" 
        },
        {
            label: "Background Color",
            id: "bgcolor",
            help: "Optional. Specify a background color for the info box",
            controlType: "color-control"   
        },
        {
            label: "Border Color",
            id: "bordercolor",
            help: "Optional. Specify a border color for the info box",
            controlType: "color-control"   
        },
        {
            label: "Border",
            id: "border",
            help: "Values: &lt;empty&gt;, none, full.", 
            controlType: "select-control", 
            selectValues: ['', 'top and bottom'],
            defaultValue: '', 
            defaultText: 'all (default)'
        },
		{
			label: "Style",
			id: "style",
			help: "Values: &lt;empty&gt; or rounded.", 
			controlType: "select-control", 
			selectValues: ['', 'rounded'],
			defaultValue: '', 
			defaultText: 'normal (default)'
		}
	],
    //disablePreview: true,
	defaultContent: "Replace this with your own content",
	shortcode: "infobox"
};

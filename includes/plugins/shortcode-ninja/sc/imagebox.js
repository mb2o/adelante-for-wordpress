scnShortcodeMeta={
	attributes:[
		{
			label: "Image Title",
			id: "image_title",
			help: "Specify a title for the image", 
		},
		{
            label: "Image Source",
            id: "image_src",
            help: "Specify an image source",
            isRequired: true 
		},
        {
            label: "Header",
            id: "header",
            help: "Specify a text for the header",
            isRequired: true
        },
        {
            label: "Button Caption",
            id: "button_caption",
            help: "Specify a caption for the button",
            isRequired: true  
        },
        {
            label: "Button Source",
            id: "button_href",
            help: "Where do you want your button to point to", 
            isRequired: true
        },
        {
            label: "Class",
            id: "button_class",
            help: "Optional. Specify an extra class for your button.", 
        },
        {
            label: "Target",
            id: "target",
            help: "Specify how the link should be opened.",
            controlType: "select-control", 
            selectValues: ['_blank','_self','_parent','_top'],
            defaultValue: '_blank', 
            defaultText: '_blank (default)' 
        }
	],
	defaultContent: "Replace this with your own content",
	shortcode: "imagebox"
};

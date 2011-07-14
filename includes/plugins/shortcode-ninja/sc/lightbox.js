scnShortcodeMeta={
	attributes:[
		{
			label: "Type",
			id: "type",
			help: "What do you want to include?", 
			controlType: "select-control", 
			selectValues: ['ajax','external','flash','image','inline','quicktime','vimeo','youtube'],
			defaultValue: 'image', 
			defaultText: 'image (default)'
		},
        {
            label: "Theme",
            id: "theme",
            help: "What theme do you want to use?", 
            controlType: "select-control", 
            selectValues: ['pp_default','light_rounded','dark_rounded','light_square','dark_square','facebook'],
            defaultValue: 'dark_rounded', 
            defaultText: 'dark_rounded (default)'
        },
        {
            label: "Link",
            id: "link",
            isRequired: true,
            help: "Specify the href to the link"
        },
        {
            label: "Title",
            id: "title",
            help: "Optional. Specify a title to display"
        },
        {
            label: "Desciption",
            id: "description",
            help: "Optional. Specify a description to display"
        },
        {
            label: "Height",
            id: "height",
            help: "Optional. Specify a description to display"
        },
        {
            label: "Width",
            id: "width",
            help: "Optional. Specify a description to display"
        },
        {
            label: "Flashvars",
            id: "flashvars",
            help: "Optional. Specify flash required parameters"
        }
	],
    defaultContent: "Replace this with an image or just some text",
	shortcode: "lightbox"
};

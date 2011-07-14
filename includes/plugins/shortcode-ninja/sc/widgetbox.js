scnShortcodeMeta={
	attributes: [
		{
			label: "Title",
			id: "title",
			help: 'The title of your widgetbox',
			isRequired: true
		},
		{
			label: "Icon",
			id: "icon",
			help: "Select one of the icons", 
			controlType: "select-control", 
			selectValues: adelante_globals['iconbox_icons'],
			defaultValue: '', 
			defaultText: 'Please choose an icon'
		}
	],
	defaultContent: "Replace this with your own content",
	shortcode: "widgetbox"
};

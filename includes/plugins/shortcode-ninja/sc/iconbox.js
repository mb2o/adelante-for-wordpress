scnShortcodeMeta={
	attributes: [
		{
			label: "Title",
			id: "title",
			help: 'The title of your iconbox',
			isRequired: true
		},
		{
			label: "Content",
			id: "content",
			help: 'The content of your infobox',
			isRequired: true
		},
		{
			label: "Icon",
			id: "icon",
			help: "Select one of the icons. You can add icons to this list by uploading new ones to your themes image folder (images/icons/iconbox)", 
			controlType: "select-control", 
			selectValues: adelante_globals['iconbox_icons'],
			defaultValue: '', 
			defaultText: 'Please choose an icon'
		}
	],
	defaultContent: "Replace this with your own content",
	shortcode: "iconbox"
};

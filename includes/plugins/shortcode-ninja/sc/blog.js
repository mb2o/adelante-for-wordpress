scnShortcodeMeta={
	attributes:[
		{
			label: "Count",
			id: "count",
			help: "Number of posts to retrieve", 
			controlType: "select-control", 
			selectValues: [1,2,3,4,5,6,7,8,9,10,15,20,25,50,100],
			defaultValue: '3', 
			defaultText: '3 (default)'
		},
		{
			label: "Categories",
			id: "cat",
			help: "Values: Comma separated list of category ID's.", 
		},
		{
			label: "Image",
			id: "image",
			help: "Values: Should the featured image be shown?", 
			controlType: "select-control", 
			selectValues: ['false','true'],
			defaultValue: 'false', 
			defaultText: 'false (default)'
		},
        {
            label: 'width',
            id: 'width',
            help: 'Optional: width of the featured image',
        },
        {
            label: 'height',
            id: 'height',
            help: 'Optional: height of the featured image',
        },
        {
            label: "Meta",
            id: "meta",
            help: "Values: Should meta information be fetched?", 
            controlType: "select-control", 
            selectValues: ['false','true'],
            defaultValue: 'false', 
            defaultText: 'false (default)'
        },
        {
            label: "Full",
            id: "full",
            help: "Values: Should full post details be fetched?", 
            controlType: "select-control", 
            selectValues: ['false','true'],
            defaultValue: 'false', 
            defaultText: 'false (default)'
        },
        {
            label: "Post Type",
            id: "posttype",
            help: "Values: Specify the post type.", 
            controlType: "select-control", 
            selectValues: ['post','portfolio','movie','album'],
            defaultValue: 'post', 
            defaultText: 'post (default)'
        }
	],
	shortcode: "blog"
};

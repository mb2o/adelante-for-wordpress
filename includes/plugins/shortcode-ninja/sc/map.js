scnShortcodeMeta={
	attributes:[
		{
			label: "Center",
			id: "center",
			help: "Specify the location that should be centered on your map.",
            isRequired: true 
		},
		{
			label: "Size",
			id: "size",
			help: "Optional. Specify the size of your map (e.g. 590x400)"
		},
		{
			label: "Type",
			id: "type",
			help: "Optional. Specify your maptype.", 
			controlType: "select-control", 
			selectValues: ['', 'roadmap', 'satellite', 'terrain'],
			defaultValue: '', 
            defaultText: 'hybrid'
		},
		{
			label: "Sensor",
			id: "sensor",
			help: "Optional.", 
			controlType: "select-control", 
			selectValues: ['', 'true'],
			defaultValue: '', 
            defaultText: 'false'
		},
        {
            label: "Zoom",
            id: "zoom",
            help: "Optional.", 
            controlType: "select-control", 
            selectValues: ['', 1,2,3,4,5,6,7,8,9,10,11,12,13,15,16],
            defaultValue: '', 
            defaultText: '15'
        }
	],
	defaultContent: "",
	shortcode: "map"
};

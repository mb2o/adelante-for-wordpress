scnShortcodeMeta={
	attributes:[
		{
			label: "Type",
			id: "type",
			help: "Values: html5, flash, youtube, vimeo, dailymotion.", 
			controlType: "select-control", 
			selectValues: ['html5', 'flash', 'youtube', 'vimeo', 'dailymotion', 'hulu', 'viddler'],
			defaultValue: 'youtube', 
			defaultText: 'youtube (default)'
		},
        {
            label: "MP4 video source",
            id: "mp4",
            help: "Optional. Specify a MP4 video source for Html5."    
        },
        {
            label: "WebM video source",
            id: "webm",
            help: "Optional. Specify a WebM video source for Html5."    
        },
        {
            label: "Ogg video source",
            id: "ogg",
            help: "Optional. Specify an Ogg video source for Html5."    
        },
        {
            label: "Flash video source",
            id: "src",
            help: "Optional. Specify a video source for Flash."    
        },
		{
			label: "Clip ID",
			id: "clip_id",
			help: "Specify a clip ID for Vimeo, YouTube, DailyMotion, Hulu and Viddler"
		},
        {
            label: "Width",
            id: "width",
            help: "Optional. Specify a width for the video."    
        },
        {
            label: "Height",
            id: "height",
            help: "Optional. Specify a height for the video."    
        }
	],
	shortcode: "video"
};

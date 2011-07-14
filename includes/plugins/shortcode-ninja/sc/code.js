scnShortcodeMeta={
	attributes:[
		{
			label: "Language",
			id: "lang",
			help: "Select a language", 
			controlType: "select-control", 
			selectValues: ['actionscript3','c','csharp','cpp','css','delphi','html','java','javascript','perl','php','python','ror','ruby','rails','sql','vb','vbnet','xhtml','xml','xslt'],
			defaultValue: 'php', 
			defaultText: 'php (default)'
		},
        {
            label: "SyntaxHighlighter Version",
            id: "version",
            help: "Select what version of SyntaxHighlighter to use", 
            controlType: "select-control", 
            selectValues: ['2','3'],
            defaultValue: '3', 
            defaultText: '3 (default)'
        },
        {
            label: "Collapse",
            id: "collapse",
            help: "Should the code be collapsed on initial view?", 
            controlType: "select-control", 
            selectValues: ['0','1'],
            defaultValue: '0', 
            defaultText: '0 (default)'
        },
        {
            label: "Class",
            id: "classname",
            help: "Optional. Specify an extra class for the codeblock"
        },
        {
            label: "Title",
            id: "title",
            help: "Specify a title for the codeblock"
        },
        {
            label: "Toolbar",
            id: "toolbar",
            help: "Show a toolbar?", 
            controlType: "select-control", 
            selectValues: ['0','1'],
            defaultValue: '0', 
            defaultText: '0 (default)'
        },
        {
            label: "Wrap Lines",
            id: "collapse",
            help: "Should codelines be wrapped?", 
            controlType: "select-control", 
            selectValues: ['0','1'],
            defaultValue: '1', 
            defaultText: '1 (default)'
        }
	],
    defaultContent: "Place your code here",
	shortcode: "code"
};

scnShortcodeMeta = {
    attributes: [
        {
            label: 'Capability',
            id: "capability",
            help: 'Specify capability required for viewing content', 
            controlType: "select-control", 
            selectValues: ['manage_sites', 'create_users', 'edit_pages', 'publish_posts', 'edit_posts', 'read'],
            defaultValue: 'edit_posts', 
            defaultText: 'edit_posts'            
        },
        {
            label: "Wrapper",
            id: "elem",
            help: "Optional. Specify the type of element that should wrap the lipsum text. When left blank, it defaults to &lt;p&gt;"
        },
        {
            label: "Class",
            id: "class",
            help: "Optional. Specify an extra class to append to the private element"
        }
    ],
    defaultContent: "Replace with your custom content",
    shortcode: "private"
};
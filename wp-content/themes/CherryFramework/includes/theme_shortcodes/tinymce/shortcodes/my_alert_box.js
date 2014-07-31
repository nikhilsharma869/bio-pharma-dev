frameworkShortcodeAtts={
	attributes:[
			{
				label:"Style",
				id:"style",
				controlType:"select-control",
				selectValues:['message', 'info', 'success', 'danger'],
				defaultValue: 'message', 
				defaultText: 'message',
				help:"Alert Box style."
			},
			{
				label:"Close button",
				id:"close",
				controlType:"select-control",
				selectValues:['yes', 'no'],
				defaultValue: 'yes', 
				defaultText: 'yes',
				help:"Show close button or not - yes, no."
			}
	],
	defaultContent:"Hello, World!",
	shortcode:"alert_box"
};
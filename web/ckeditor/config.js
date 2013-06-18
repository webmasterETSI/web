/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	
	// %REMOVE_START%
	// The configuration options below are needed when running CKEditor from source files.
	config.plugins = 'dialogui,dialog,about,a11yhelp,dialogadvtab,basicstyles,bidi,blockquote,clipboard,button,panelbutton,panel,floatpanel,colorbutton,colordialog,templates,menu,contextmenu,resize,toolbar,elementspath,list,indent,enterkey,entities,popup,filebrowser,find,fakeobjects,floatingspace,listblock,richcombo,format,htmlwriter,horizontalrule,wysiwygarea,image,justify,link,liststyle,magicline,maximize,pastetext,preview,print,removeformat,save,selectall,showblocks,sourcearea,menubutton,scayt,tab,table,tabletools,undo,wsc';
	config.skin = 'moono';
	// %REMOVE_END%

	config.toolbarGroups = [
		//{ name: 'document',    groups: [ 'mode', 'document', 'doctools' ] },
		{ name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },
		{ name: 'editing',     groups: [ 'find', 'selection'] },
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: 'paragraph',   groups: [ 'list', 'indent', 'blocks', 'align' ] },
		{ name: 'links' },
		{ name: 'insert' },
		{ name: 'styles' },
	];

	config.removeButtons = 'Underline,Subscript,Superscript,Strike,Anchor,Blockquote';
	config.format_tags = 'p;h1;h2;h3;h4';
	config.removeDialogTabs = 'image:advanced;link:advanced;link:target;table:advanced';
	config.removePlugins = 'PasteFromWord';
	config.forcePasteAsPlainText = true;
};

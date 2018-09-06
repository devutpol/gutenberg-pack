( function (wp) {
    var el = wp.element.createElement,
        __ = wp.i18n.__,
        registerBlockType = wp.blocks.registerBlockType,
        RichText = wp.editor.RichText;

    registerBlockType( 'gutenberg-pack/hello', {
           title: __('Hello Block'),
           icon: 'universal-access-alt',
           category: 'gutenberg-block',
           attributes: {
               content : {
                   type : 'array',
                   source: 'children',
                   selector: 'p',
               }
           },
           edit: function ( props ) {
               var content = props.attributes.content;

               function onChangeContent( newContent ){
                   props.setAttributes({ content: newContent });   
               }

               return el(
                   RichText,
                   {
                       tagName : 'p',
                       onChange : onChangeContent,
                       className: props.className,
                       value: content
                   }
               )
           },
           save: function( props ) {
                   var content = props.attributes.content;
                   return el( RichText.Content, {
                       tagName: 'p',
                       className: props.className,
                       value: content
                   });
           }
       });
       
})(window.wp);
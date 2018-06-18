$(function () {
   $('.control-group').each(function (index) {
       var helpBlock = $(this).find('.sonata-ba-field-widget-help');
       var fieldShortDesc = $(this).find('.field-short-description');
       
       if (helpBlock.length && fieldShortDesc.length) {
           fieldShortDesc.css({ display: "none" });
       }
   })
});

const observer = new MutationObserver((mutations, observer) => {
    //console.log(mutations, observer);
    //console.log(mutations[0].target.className);
    //console.log(mutations[0].target.className.includes("intercom-tour-frame"));
      
      var iframe_name = "intercom-tour-frame";
      
      if(mutations[0].target.className.includes(iframe_name))
      {     
        if($('iframe[name=intercom-tour-frame]').contents().find("style[data-style='custom-emb']").length == 0){
            //console.log('mutations if in');
            var head_append = $('iframe[name='+iframe_name+']').contents().find("head");
            var css_append = '<style data-style="custom-emb"> *{font-family:"Poppins",sans-serif !important;} .intercom-block-paragraph{font-size:1rem !important;font-family:"Poppins",sans-serif;color: #232633;font-weight:500;}button{background-color: #3F16AE!important;font-weight:500!important;border-radius: 0.5rem!important;text-transform: uppercase;font-family:"Poppins",sans-serif;}[aria-label="Snooze"] button{background-color:transparent !important;} h2{color: #232633 !important;font-weight:600;}</style>';
            $(head_append).append(css_append);
        }   
           
      } 
  });
  
observer.observe(document, {
subtree: true,
attributes: true
});
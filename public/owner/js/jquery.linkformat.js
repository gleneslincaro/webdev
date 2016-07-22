;(function($) {
  var mailRegex = /([A-Za-z0-9]([A-Za-z0-9]+[_.-])*[A-Za-z0-9]+)@([A-Za-z0-9]([A-Za-z0-9-.]*[A-Za-z0-9])?\.(com|org|net|edu|gov|mil|biz|info|mobi|name|aero|asia|jobs|[A-Za-z]{2}|museum))/ig;
  var linkexp = /(((https?|s?ftp):\/\/[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,6}(:[0-9]{1,5})?(\/.*)?)|(file:\/\/[-A-Z0-9+&@#\/%?=~_|!:,.;]*[-A-Z0-9+&@#\/%=~_|]))/ig;
  var telRegex = /\b(0([\-]?[0-9][\-]?){9,10})\b/g;
  /**
   * SLOW: but can format when have html tag in text
   * Function to format text to mail format,tel format, and url format
   * @param text: text need format
   * using: $(element).format() : format content in this element
   * 
   * using: $.fn.format(text):   format text
   * @return text formated, element formated.
   */
  $.fn.formatHTML = function(text) {
    if(!text && arguments.length > 0){
      return text;
    }
    
    if (text) {
      var temp = $("<p>" + text + "</p>");
      return temp.formatHTML().html();
    }
    
    switch ($(this).prop("tagName")) {
    case 'a':
    case 'A':
      return $(this).formatTagA();

    default:
      return $(this).formatDefault();
    }

  };
  /**
   * FAST: but ONLY USE WHEN TEXT NOT HAVE HTML TAG
   * Function to format text none HTML to mail format,tel format, and url format
   * @param text: text need format
   * using: $(element).format() : format content in this element
   * 
   * using: $.fn.format(text):   format text
   * @return text formated, element formated
   */
  $.fn.format = function(text) {
    if(!text && arguments.length > 0){
      return text;
    }
    
    if (text) {
      var text1 =  $.fn.formatText(text);
      return text1;
    }
    
      return $(this).html($.fn.formatText($(this).text()));
  };
  
  /**
   * Format text to tel link
   */
  $.fn.formatTel = function(text) {
    if (text) {
      var results = text.match(telRegex);
      if(!results){
        return text;
      }
      text =  text.replace(telRegex, "<a href='tel:$1'>$1</a>");
      
      $.each(results, function(index, value){
        text = text.replace('tel:' + value, 'tel:' + value.replace(/\-/g,''));
      });
    }
    return text;
  };
  
  /**
   * Format text to URL
   */
  $.fn.formatURL = function(text) {
    if (text) {
      return text.replace(linkexp, "<a href='$1' target='_blank' >$1</a>");
    }
    return text;
  };
  
  /**
   * Format text to Mail
   */
  $.fn.formatMailText = function(text) {
    if (text) {
      return text.replace(mailRegex,
        "<a href='mailto:$1@$3'>$1@$3</a>");
    }
    return text;
  };
  
  /**
   * Format text to mail,url,tel
   */
  $.fn.formatText = function(text) {
	  text = $.fn.formatSymbol(text);
	  text = $.fn.formatBlank(text);
    text = $.fn.formatURL(text);
    text = $.fn.formatTel(text);
    text = $.fn.formatMailText(text);
    text = $.fn.formatLine(text);
    return text;
  };
  
  /**
   * Format blank to html code
   */
  $.fn.formatBlank = function(text){
    
    if(!text){
      return text;
    }
    
    var blank = '(  )';
    blank = new RegExp(blank, "g");
    return text.replace(blank,
        "&nbsp; ");
	  
  };
  
  /**
   * Format new line and break line to <br />
   */
  $.fn.formatLine = function(text){
    
    if(!text){
      return text;
    }
    
	  if(text.indexOf('\n')==0){
		  text = text.replace('\n','');
	  }
	  
	  text = text.split('\r\n');
	  text = text.join('\n');
		
	  text = text.split('\n');
	  text = text.join('<br />');
	  
	  return text;
  };
  
  var htmlEscapeChar = {
          '<': '&lt;',
            '>': '&gt;',
            '&': '&amp;',
            '"': '&quot;',
            "'": '&#039;'
       };
  /**
   * Format special symbol to html code
   */
  $.fn.formatSymbol = function(text){
    if(!text){
      return text;
    }
    
    text = text.replace(/[<>'"&]/g, function(char) {
            return htmlEscapeChar[char];
          });
    
    return text;
  };
  /**
   * Function format of every Tag except <a></a> tag
   * 
   */
  $.fn.formatDefault = function() {

    if (!$(this).html())
      return;

    if ($(this).children().length) {

      $(this).contents().filter(function() {
        return this.nodeType === 3;
      }).wrap("<formatM />");
      
      $(this).children().each(function() {
        $(this).formatHTML();
      });

      $(this).contents("formatM").each(function() {
        $(this).contents().unwrap();
      });
    } else {
      var clone = $(this);

      html = clone[0].innerHTML;
      html = $.trim(html);
      if (html) {

        var html2 = html;
        html2 = $.fn.formatText(clone[0].innerHTML);
        clone[0].innerHTML = html2;
      }
    }
    return this;
  };
  
  /**
   * Funtion format of <a></a> tag
   */
  $.fn.formatTagA = function() {
    var href = $(this).attr('href');
    if (!href) {
      return this;
    }

    if (href.indexOf("mailto") == 0) {
      return this;
    }

    if (href.indexOf("tel") == 0) {
      return this;
    }

    if (href.match(mailRegex)) {
      href = "mailto:" + href;
      $(this).attr('href', href);
      return this;
    }

    if (href.match(telRegex)) {
      href = "tel:" + href;
      $(this).attr('href', href);
      return this;
    }
    return this;
    
  };

}(jQuery));

// RialBids Google Translate
(function() {
  var supportedLangs = ['es', 'pt', 'de', 'en', 'it', 'fr'];
  var defaultLang = 'es';
  
  function getBrowserLang() {
    var lang = navigator.language || navigator.userLanguage || defaultLang;
    lang = lang.substring(0, 2).toLowerCase();
    return supportedLangs.includes(lang) ? lang : defaultLang;
  }
  
  function translatePage(targetLang) {
    if (targetLang === 'es') return;
    var apiKey = document.querySelector('meta[name="google-translate-key"]').getAttribute('content');
    var elements = document.querySelectorAll('p, h1, h2, h3, h4, h5, span, a, button, label, th, td, li');
    var texts = [];
    var nodes = [];
    elements.forEach(function(el) {
      if (el.childElementCount === 0 && el.textContent.trim()) {
        texts.push(el.textContent.trim());
        nodes.push(el);
      }
    });
    var batchSize = 100;
    for (var i = 0; i < texts.length; i += batchSize) {
      (function(batch, batchNodes) {
        var url = 'https://translation.googleapis.com/language/translate/v2?key=' + apiKey;
        fetch(url, {
          method: 'POST',
          headers: {'Content-Type': 'application/json'},
          body: JSON.stringify({q: batch, source: 'es', target: targetLang, format: 'text'})
        })
        .then(function(r) { return r.json(); })
        .then(function(data) {
          if (data.data && data.data.translations) {
            data.data.translations.forEach(function(t, idx) {
              batchNodes[idx].textContent = t.translatedText;
            });
          }
        });
      })(texts.slice(i, i + batchSize), nodes.slice(i, i + batchSize));
    }
  }

  document.addEventListener('DOMContentLoaded', function() {
    var lang = localStorage.getItem('rialbids_lang') || getBrowserLang();
    translatePage(lang);
  });

  window.rialbidsSetLang = function(lang) {
    localStorage.setItem('rialbids_lang', lang);
    location.reload();
  };
})();

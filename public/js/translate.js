
// RialBids Google Translate v2
(function() {
  var supportedLangs = ['es', 'pt', 'de', 'en', 'it', 'fr'];
  var defaultLang = 'es';

  function getBrowserLang() {
    var lang = navigator.language || navigator.userLanguage || defaultLang;
    lang = lang.substring(0, 2).toLowerCase();
    return supportedLangs.includes(lang) ? lang : defaultLang;
  }

  function getTextNodes(root) {
    var walker = document.createTreeWalker(
      root,
      NodeFilter.SHOW_TEXT,
      {
        acceptNode: function(node) {
          var parent = node.parentElement;
          if (!parent) return NodeFilter.FILTER_REJECT;
          var tag = parent.tagName.toLowerCase();
          var skip = ['script','style','noscript','code','pre','input','textarea','select'];
          if (skip.includes(tag)) return NodeFilter.FILTER_REJECT;
          if (!node.textContent.trim()) return NodeFilter.FILTER_REJECT;
          return NodeFilter.FILTER_ACCEPT;
        }
      }
    );
    var nodes = [];
    var node;
    while (node = walker.nextNode()) nodes.push(node);
    return nodes;
  }

  function translatePage(targetLang) {
    if (targetLang === 'es') return;
    var apiKey = document.querySelector('meta[name="google-translate-key"]').getAttribute('content');
    var textNodes = getTextNodes(document.body);
    var texts = textNodes.map(function(n) { return n.textContent.trim(); });

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
      })(texts.slice(i, i + batchSize), textNodes.slice(i, i + batchSize));
    }

    var inputs = document.querySelectorAll('input[placeholder], textarea[placeholder]');
    var placeholders = Array.from(inputs).map(function(el) { return el.getAttribute('placeholder'); });
    if (placeholders.length) {
      fetch('https://translation.googleapis.com/language/translate/v2?key=' + apiKey, {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({q: placeholders, source: 'es', target: targetLang, format: 'text'})
      })
      .then(function(r) { return r.json(); })
      .then(function(data) {
        if (data.data && data.data.translations) {
          data.data.translations.forEach(function(t, idx) {
            inputs[idx].setAttribute('placeholder', t.translatedText);
          });
        }
      });
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

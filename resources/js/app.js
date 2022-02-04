import 'alpinejs'

import Prism from 'prismjs'

Prism.manual = true

;[...document.querySelectorAll('pre code')]
    .forEach((el) => {
      Prism.highlightElement(el)
    })

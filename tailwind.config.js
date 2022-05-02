const plugin = require('tailwindcss/plugin')

module.exports = {
  content: [
    'app/CommonMark/Block/Renderer/**/*.php',
    'app/View/**/*.php',
    'resources/views/**/*.blade.php',
    'resources/docs/laravel/build/**/*.md',
  ],
  theme: {
    fontFamily: {
      sans: [
        'ui-sans-serif',
        'system-ui',
        '-apple-system',
        'BlinkMacSystemFont',
        '"Source Han Sans CT"',
        '"PingFang TC"',
        '"WenQuanYi Micro Hei"',
        '"Microsoft JhengHei"',
        '"Microsoft Ya Hei"',
        '"Segoe UI"',
        'Roboto',
        '"Helvetica Neue"',
        'Arial',
        '"Noto Sans"',
        'sans-serif',
        '"Apple Color Emoji"',
        '"Segoe UI Emoji"',
        '"Segoe UI Symbol"',
        '"Noto Color Emoji"',
      ],
      serif: ['ui-serif', 'Georgia', 'Cambria', '"Times New Roman"', 'Times', 'serif'],
      mono: [
        '"Iosevka Cornch Web"',
        'ui-monospace',
        'SFMono-Regular',
        'Menlo',
        'Monaco',
        'Consolas',
        '"Liberation Mono"',
        '"Courier New"',
        'monospace',
      ],
    },
    extend: {
        backgroundImage: {
            'list-dot': 'url("data:image/svg+xml;utf8,%3Csvg%20width%3D%2210%22%20height%3D%2211%22%20viewBox%3D%220%200%2010%2011%22%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%3E%3Ctitle%3EPolygon%3C/title%3E%3Cpath%20d%3D%22M5.036%201.965l-3.492%201.94v3.88l3.492%201.94%203.492-1.94v-3.88l-3.492-1.94zm0-1.12l4.5%202.5v5l-4.5%202.5-4.5-2.5v-5l4.5-2.5z%22%20fill%3D%22%23FF2D20%22%20fill-rule%3D%22nonzero%22/%3E%3C/svg%3E")',
            'list-solid': 'url("data:image/svg+xml;utf8,%3Csvg%20width%3D%228%22%20height%3D%228%22%20viewBox%3D%220%200%208%208%22%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%3E%3Ctitle%3Eactive_marker%3C/title%3E%3Cpath%20d%3D%22M4%200l3.464%202v4L4%208%20.536%206V2z%22%20fill%3D%22%23FF2D20%22%20fill-rule%3D%22nonzero%22/%3E%3C/svg%3E")'
        }
    },
  },
  plugins: [
      plugin(({ addUtilities }) => addUtilities({
          '.writing-tb': {
              'writing-mode': 'horizontal-tb',
          },
          '.writing-rl': {
              'writing-mode': 'vertical-rl',
          },
          '.writing-lr': {
              'writing-mode': 'vertical-lr',
          },
      }))
  ],
}

const colors = require('tailwindcss/colors')

module.exports = {
  purge: [
    'app/CommonMark/Block/Renderer/**/*.php',
    'resources/views/**/*.blade.php',
  ],
  mode: 'jit',
  darkMode: false, // or 'media' or 'class'
  theme: {
    colors,
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
    extend: {},
  },
  variants: {
    extend: {},
  },
  plugins: [],
}

module.exports = {
  purge: [
    './resources/**/*.blade.php',
    './resources/**/*.js',
    './resources/**/*.vue',
  ],
  darkMode: false, // or 'media' or 'class'
  theme: {
    extend: {
      fontSize: {
        '0': '0',
      },
    },
    colors: {
      red: 'red',
      green: 'green',
      blue: 'blue',
      purple: 'purple',
      grey: 'grey',
    },
  },
  variants: {
    extend: {},
  },
  plugins: [],
}

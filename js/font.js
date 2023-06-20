var fonts = ['Candal', 'Arial'];

function getFontName(font) {
    return font.toLowerCase().replace(/\s/g, "-");
}
var fontNames = fonts.map(font => getFontName(font));
var fontStyles = "";
fonts.forEach(function(font) {
    var fontName = getFontName(font);
    fontStyles +=
        ".ql-font-" + fontName + "{" +
        " font-family: '" + font + "', sans-serif !important;" +
        "}";
});
var node = document.createElement('style');
node.innerHTML = fontStyles;

document.body.appendChild(node);
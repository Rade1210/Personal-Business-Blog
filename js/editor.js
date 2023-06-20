var fonts = ['Candal', 'Arial'];

function getFontName(font) {
    return font.toLowerCase().replace(/\s/g, "-");
}
var fontNames = fonts.map(font => getFontName(font));
var fontStyles = "";
fonts.forEach(function(font) {
    var fontName = getFontName(font);
    fontStyles += ".ql-snow .ql-picker.ql-font .ql-picker-label[data-value=" + fontName + "]::before, .ql-snow .ql-picker.ql-font .ql-picker-item[data-value=" + fontName + "]::before {" +
        "content: '" + font + "';" +
        "font-family: '" + font + "', sans-serif;" +
        "}" +
        ".ql-font-" + fontName + "{" +
        " font-family: '" + font + "', sans-serif;" +
        "}";
});
var node = document.createElement('style');
node.innerHTML = fontStyles;
document.body.appendChild(node);

var toolbarOptions = [
    ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
    ['blockquote', 'code-block'],

    [{ 'header': 1 }, { 'header': 2 }],               // custom button values
    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
    [{ 'script': 'sub'}, { 'script': 'super' }],      // superscript/subscript
    [{ 'indent': '-1'}, { 'indent': '+1' }],          // outdent/indent
    [{ 'direction': 'rtl' }],                         // text direction

    [{ 'size': ['small', false, 'large', 'huge'] }],  // custom dropdown
    [{ 'header': [1, 2, 3, 4, 5, 6, false] }],

    [{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
    [{ 'font': fontNames }],
    [{ 'align': [] }],
    ['link', 'image'],

    ['clean']                                         // remove formatting button
];

var options = {
    modules: {
        toolbar: toolbarOptions
    },
    placeholder: "Start typing something",
    theme: "snow"
};

var Font = Quill.import('formats/font');
Font.whitelist = fontNames;
Quill.register(Font, true);

var quill = new Quill("#editor", options);

$(document).ready(function () {
    $(".ql-editor").html($("#content").html());


    $(".btn").click(function (){
        $("#post-body").val(quill.root.innerHTML);
        console.log($("#post-body").val())
    })

})
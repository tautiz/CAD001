document.addEventListener('DOMContentLoaded', function() {
    var tooltippedElems = document.querySelectorAll('.tooltipped');
    M.Tooltip.init(tooltippedElems);
});

var elems = document.querySelectorAll('.message');

for (var i = 0; i < elems.length; i++) {
    if (elems.length > 0 && elems[i].innerHTML != '') {
        M.toast({html: elems[i].innerHTML, classes: 'rounded'});
    }
}

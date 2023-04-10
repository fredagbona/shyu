var btncopy = document.querySelector('.copier'); 
if(btncopy) {
    btncopy.addEventListener('click', docopy);
}

function docopy() {

    
    // Cible de l'élément qui doit être copié
    var target = this.dataset.target;
    var fromElement = document.querySelector(target);
    if(!fromElement) return;

    // Sélection des caractères concernés
    var range = document.createRange();
    var selection = window.getSelection();
    range.selectNode(fromElement);
    selection.removeAllRanges();
    selection.addRange(range);

    try {
        // Exécution de la commande de copie
        var result = document.execCommand('copy');
        if (result) {
            // La copie a réussi
            toastr.options.toastClass = 'toastr';
            toastr.success('Lien Copié')
        }
    }
    catch(err) {
        // Une erreur est surevnue lors de la tentative de copie
        toastr.options.toastClass = 'toastr';
        toastr.error(err);
    }

    // Fin de l'opération
    selection = window.getSelection();
    if (typeof selection.removeRange === 'function') {
        selection.removeRange(range);
    } else if (typeof selection.removeAllRanges === 'function') {
        selection.removeAllRanges();
    }
}
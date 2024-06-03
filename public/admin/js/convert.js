// 1. Déterminer si un nombre est entier
function estEntier(nombre) {
    return nombre % 1 === 0;
}

// 2. Récupérer le nombre de chiffres après la virgule
function nombreDeChiffre(nombre) {
    const str = nombre.toString();
    if (str.includes('.')) {
        return str.split('.')[1].length;
    } else {
        return 0;
    }
}
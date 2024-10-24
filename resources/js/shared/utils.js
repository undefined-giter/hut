export function checkCharacterCount(text, maxLength) {
    const modifiedText = text.replace(/\r?\n/g, '  ');
    const actualLength = modifiedText.length;

    if (actualLength > maxLength) {
        return {
            valid: false,
            message: `Limite de ${actualLength}/${maxLength} caractères atteinte.`,
            remaining: 0,
        };
    }

    const remainingCharacters = maxLength - actualLength;

    return {
        valid: true,
        message: `${actualLength}/${maxLength} caractères utilisés.`,
        remaining: remainingCharacters,
    };
}
